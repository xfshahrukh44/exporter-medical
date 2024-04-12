<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\inquiry;
use Illuminate\Support\Facades\Redirect;
use App\newsletter;
use FedEx\OpenShipService\SimpleType;
use App\Program;
use App\Models\StatesTax;
use App\imagetable;
use App\Product;
use App\Banner;
use App\orders;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Illuminate\Support\Facades\Validator;
use App\orders_products;
use App\Http\Requests\OrderRequest;
use DB;
use View;
use Session;
use App\Http\Traits\HelperTrait;
use Auth;
use Omnipay\Omnipay;
use Hash;
use Carbon\Carbon;
use Mail;
use Stripe;
use Stripe\Customer;
use Stripe\Charge;

class OrderController extends Controller
{
    use HelperTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // use Helper;

    public function __construct()
    {
        // $this->middleware('guest');
        $logo = imagetable::select('img_path')
            ->where('table_name', '=', 'logo')
            ->first();

        $favicon = imagetable::select('img_path')
            ->where('table_name', '=', 'favicon')
            ->first();

        View()->share('logo', $logo);
        View()->share('favicon', $favicon);
    }
    

    public function checkout()
    {
      
        $language = Session::get('language');
        $product_detail = DB::table('products')->first();
        $token = $this->login_fedex();

        if (Session::get('cart') && count(Session::get('cart')) > 0) {
            $countries = DB::table('countries')->get();
            return view('shop.checkout', [
                'cart' => Session::get('cart'),
                'countries' => $countries,
                'language' => $language,
                'product_detail' => $product_detail,
                'fedex_token' => $token
            ]);
        } else {
            Session::flash('error', 'No Product found');
            return redirect('/');
        }
    }
    

    public function getStates(Request $request)
    {
        $states = DB::table('states')
            ->where('country_id', $request->country_id)
            ->get();
        echo json_encode(['states' => $states]);
    }
    

    public function getCities(Request $request)
    {
        $cities = DB::table('cities')
            ->where('state_id', $request->state_id)
            ->get();
        echo json_encode(['cities' => $cities]);
    }

    public function newOrder(Request $request)
    {
        define('ENV', 'demo'); //demo OR pro

        if (ENV == 'demo') {
            $endpoint = 'https://apidemo.myfatoorah.com';
            $username = 'apiaccount@myfatoorah.com';
            $password = 'api12345*';
        } else {
            $endpoint = 'https://apikw.myfatoorah.com/swagger/ui/index';
            $username = 'Ndeumens@ninolife.com';
            $password = 'Noah&0306';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "{$endpoint}/Token");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            http_build_query([
                'grant_type' => 'password',
                'username' => $username,
                'password' => $password,
            ])
        );
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $json = json_decode($result, true);

        if (isset($json['access_token']) && !empty($json['access_token'])) {
            $access_token = $json['access_token'];
        } else {
            $access_token = '';
        }

        $cart = Session::get('cart');
        $product_detail = DB::table('products')->first();

        if (Session::get('language') == 'ksa') {
            $price = $product_detail->sar_price;
        } elseif (Session::get('language') == 'uae') {
            $price = $product_detail->price;
        } elseif (Session::get('language') == 'qatar') {
            $price = $product_detail->qar_price;
        } elseif (Session::get('language') == 'bahrain') {
            $price = $product_detail->bhr_price;
        } elseif (Session::get('language') == 'oman') {
            $price = $product_detail->omr_price;
        } elseif (Session::get('language') == 'jordan') {
            $price = $product_detail->jod_price;
        } elseif (Session::get('language') == 'egypt') {
            $price = $product_detail->egp_price;
        } elseif (Session::get('language') == 'kuwait') {
            $price = $product_detail->kwd_price;
        } else {
            $price = $product_detail->price;
        }

        $t = time();

        if (Session::get('language') == 'ksa') {
            $currency = 'SAR';
        } elseif (Session::get('language') == 'uae') {
            $currency = 'AED';
        } elseif (Session::get('language') == 'qatar') {
            $currency = 'QAR';
        } elseif (Session::get('language') == 'bahrain') {
            $currency = 'BHD';
        } elseif (Session::get('language') == 'oman') {
            $currency = 'OMR';
        } elseif (Session::get('language') == 'jordan') {
            $currency = 'JOD';
        } elseif (Session::get('language') == 'egypt') {
            $currency = 'EGP';
        } elseif (Session::get('language') == 'kuwait') {
            $currency = 'KWD';
        } else {
            $currency = 'AED';
        }

        // dd($currency);

        //dd($price);
        //return;
        $name = $_POST['first_name'] . ' ' . $_POST['last_name'];
        $post_string = [];
        $post_string['InvoiceValue'] = 10;
        $post_string['CustomerName'] = $name;
        $post_string['CustomerBlock'] = $_POST['area'];
        $post_string['CustomerStreet'] = 'Street';
        $post_string['CustomerHouseBuildingNo'] = $_POST['building'];
        $post_string['CustomerCivilId'] = '123456789124';
        $post_string['CustomerAddress'] = $_POST['address_line_1'];
        $post_string['CustomerReference'] = $t;
        $post_string['DisplayCurrencyIsoAlpha'] = $currency;
        $post_string['CountryCodeId'] = $_POST['country_code'];
        $post_string['CustomerMobile'] = $_POST['phone_no'];
        $post_string['CustomerEmail'] = $_POST['email'];
        $post_string['DisplayCurrencyId'] = 3;
        $post_string['SendInvoiceOption'] = 1;
        $post_string['payment_method'] = $_POST['payment_method'];
        $post_string['company_name'] = $_POST['company_name'];
        $post_string['city'] = $_POST['city'];
        $post_string['landmark'] = $_POST['landmark'];
        $post_string['floor_num'] = $_POST['floor_num'];
        $post_string['InvoiceItemsCreate'][] = [
            'ProductId' => null,
            'ProductName' => $cart[1]['name'],
            'Quantity' => $cart[1]['qty'],
            'UnitPrice' => $price,
        ];
        $post_string['CallBackUrl'] = 'https://www.ninolife.com/payment';
        $post_string['Language'] = 2;
        $post_string['ExpireDate'] = '2022-12-31T13:30:17.812Z';
        $post_string['ApiCustomFileds'] = 'weight=10,size=L,lenght=170';
        $post_string['ErrorUrl'] = 'https://www.ninolife.com?error=payment';
        $post_string = json_encode($post_string);

        $soap_do = curl_init();
        curl_setopt(
            $soap_do,
            CURLOPT_URL,
            "{$endpoint}/ApiInvoices/CreateInvoiceIso"
        );
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($post_string),
            'Accept: application/json',
            'Authorization: Bearer ' . $access_token,
        ]);
        $result1 = curl_exec($soap_do);
        // echo "<pre>";print_r($result1);die;
        $err = curl_error($soap_do);
        $json1 = json_decode($result1, true);

        $RedirectUrl = $json1['RedirectUrl'];

        //echo $RedirectUrl;
        //return;

        //redirect::to($RedirectUrl);
        //dd($RedirectUrl);
        $ref_Ex = explode('/', $RedirectUrl);
        //echo "<pre>";
        //print_r($ref_Ex);
        //return;
        $referenceId = $ref_Ex[4];
        //echo $referenceId;
        //return;
        curl_close($soap_do);

        $orders = new orders();
        $orders->payment_method = $_POST['payment_method'];
        $orders->delivery_country = $_POST['country'];
        $orders->country_code = $_POST['country_code'];
        $orders->delivery_first_name = $_POST['first_name'];
        $orders->delivery_last_name = $_POST['last_name'];
        $orders->order_company = $_POST['company_name'];
        $orders->delivery_address_1 = $_POST['address_line_1'];
        $orders->delivery_city = $_POST['city'];
        $orders->area = $_POST['area'];
        $orders->landmark = $_POST['landmark'];
        $orders->floor_num = $_POST['floor_num'];
        $orders->building = $_POST['building'];
        $orders->order_email = $_POST['email'];
        $orders->delivery_phone_no = $_POST['phone_no'];
        $orders->payment_id = '';
        $orders->order_id = '';
        $orders->track_id = '';
        $orders->ref_id = $referenceId;
        $orders->order_items = count(Session::get('cart'));
        $orders->order_item_total = $_POST['subtotal'];
        $orders->order_total = $_POST['subtotal'];
        //dd($orders,$cart);

        if (
            isset($_POST['payment_method']) &&
            $_POST['payment_method'] == 'paypal'
        ) {
            $orders->transaction_id = $_POST['payment_id'];
            $orders->order_status = $_POST['payment_status'];
            $orders->card_token = $_POST['payer_id'];
        }

        $orders->save();

        $orders = orders::orderBy('id', 'desc')->first();

        foreach ($cart as $key => $value) {
            if ($value['name'] != '') {
                $order_products = new orders_products();
                $order_products->order_products_product_id = $value['id'];
                $order_products->order_products_name = $value['name'];
                $order_products->order_products_price = $value['baseprice'];
                $order_products->orders_id = $orders->id;
                $order_products->order_products_qty = $value['qty'];
                $order_products->mat_language = $value['mat_language'];
                $order_products->order_products_subtotal =
                    $value['baseprice'] * $value['qty'];
                $order_products->ref_id = $referenceId;
                $order_products->save();
            }
        }
        //$orders->user_id= $id;

        //echo '<br><a href="'.$RedirectUrl.'" id="paymentRedirect"  class="btn btn-success">Click here to Payment Link</a>';
        Session::forget('cart');
        return view('shop.checkout2', [
            'cart' => Session::get('cart'),
            'RedirectUrl' => $RedirectUrl,
        ]);
    }

    public function success()
    {
        return view('account.success');
    }

    public function fedex($array)
    {
        $shipping = Session::get('shipping');
		$cart = Session::get('cart');
		$requestedPackageLineItems = [];
		foreach ($cart as $key => $value) {
			$weightarray = [
				'weight' => [
					'units' => 'KG',
					'value' => Product::find($value['id'])->weight,
				],
			];
			for ($i = 0; $i < $value['qty']; $i++) {
				array_push($requestedPackageLineItems, $weightarray);
			}
		}
		if( $array['country'] == "US"){
		    $service = "FEDEX_2_DAY";
		}
		else{
		    $service = "INTERNATIONAL_ECONOMY";
		}

        $shippingArray = [
            "index" => \Str::random(10),
            "requestedShipment" => [
                "shipper" => [
                    "contact" => [
                        "personName" => "Richards",
                        "phoneNumber" => (string) HelperTrait::returnFlag(1984),
                    ],
                    "address" => [
                        "streetLines" => [(string) HelperTrait::returnFlag(1985)],
                        "city" => (string) HelperTrait::returnFlag(1981),
                        "stateOrProvinceCode" => "CA",
                        "postalCode" => "91754",
                        "countryCode" => "US",
                    ],
                ],
                "recipients" => [
                    [
                        "contact" => [
                            "personName" => $array['first_name'],
                            "phoneNumber" => $array['phone']
                        ],
                        "address" => [
                            "streetLines" => [$array['address_line_1']],
                            "city" => $array['city'],
                            "stateOrProvinceCode" => $array['state'],
                            "postalCode" => $array['postal_code'],
                            "countryCode" => $array['country'],
                        ],
                    ],
                ],
                "serviceType" => $service,
                "packagingType" => "YOUR_PACKAGING",
                "pickupType" => "CONTACT_FEDEX_TO_SCHEDULE",
                "shippingChargesPayment" => ["paymentType" => "SENDER"],
                "requestedPackageLineItems" => $requestedPackageLineItems
            ],
            "accountNumber" => ["value" => "740561073"],
        ];
		$token = $this->login_fedex();
		$ch = curl_init(
            'https://apis-sandbox.fedex.com/ship/v1/openshipments/create'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'authorization:Bearer ' . $token,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($shippingArray));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$apiResponse = json_decode(curl_exec($ch));

		if($apiResponse->output->transactionShipments){

				return ['tracking_number'=>$apiResponse->output->transactionShipments[0]->masterTrackingNumber,'status'=>true];

		}
		else{
			return ['tracking_no'=>$apiResponse->errors->message,'status'=>false];
		}

    }


	public function login_fedex(){
		$ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            'https://apis-sandbox.fedex.com/oauth/token'
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            'grant_type=client_credentials&client_id=l7f41d1ee84a2e4d26ac6b3aae6d069ff7&client_secret=738198f605a74a569b90bd9a7e228f41'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $token = json_decode(curl_exec($ch))->access_token;
        curl_close($ch);
		return $token;

	}


    public function dhlservices(Request $request)
    {
        
        //dd($request->all());
        
        if(Carbon::tomorrow()->setTimezone('America/New_York')->dayOfWeek == 0)
        {
            $shipDate = Carbon::tomorrow()->addDays(2)->setTimezone('America/New_York');
        }
        else if(Carbon::tomorrow()->setTimezone('America/New_York')->dayOfWeek == 6)
        {
            $shipDate = Carbon::now()->addDays(3)->setTimezone('America/New_York');
        }
        else{
            $shipDate = Carbon::tomorrow()->setTimezone('America/New_York');
        }
        
        $apiKey = "apP3qO9oK7yC6c";
        $secretKey = "T#9oT!5uL@8jN#1l";
        $curl = curl_init();
        
        $cart = Session::get('cart');
        $weightarray = [];
        foreach($cart as $key => $value)
        {
            $product = Product::find($value['id']);
            array_push($weightarray,[
                'weight'=> (float)number_format((float)$product->weight, 2, '.', ''),
                'dimensions'=>[
                    'length'=>(float)number_format((float)$product->length, 2, '.', ''),
                    'width'=>(float)number_format((float)$product->width, 2, '.', ''),
                    'height'=>(float)number_format((float)$product->height, 2, '.', '')
                    
                    ]
            ]);

        }
        
        $requestShip =  array (
              'customerDetails' => 
              array (
                'shipperDetails' => 
                array (
                  'postalCode' => '91754',
                  'addressLine1' => '880 S Atlantic Blvd, Ste 101A',
                  'cityName' => 'MONTEREY PARK',
                  'countryCode' => 'US',
                ),
                'receiverDetails' => 
                array (
                  'postalCode' => $request->input('postal'),
                  'cityName' => $request->input('city'),
                  'addressLine1' =>$request->input('address'),
                  'countryCode' => $request->input('country'),
                ),
              ),
              'accounts' => 
              array (
                0 => 
                array (
                  'typeCode' => 'shipper',
                  'number' => '921423586',
                ),
              ),
              'plannedShippingDateAndTime' => $shipDate->format('Y-m-d').'T'.'12:00:00',
              'payerCountryCode' => 'US',
              'unitOfMeasurement' => 'imperial',
              'isCustomsDeclarable' => true,
              'monetaryAmount' => 
              array (
                0 => 
                array (
                  'typeCode' => 'declaredValue',
                  'value' => 100,
                  'currency' => 'USD',
                ),
              ),
              'getAdditionalInformation' => 
              array (
                0 => 
                array (
                  'typeCode' => 'allValueAddedServices',
                  'isRequested' => true,
                ),
              ),
              'returnStandardProductsOnly' => false,
              'nextBusinessDay' => false,
              'productTypeCode' => 'all',
              'packages' => 
                $weightarray
            );
        
        curl_setopt_array($curl, [
        
        	CURLOPT_URL => "https://express.api.dhl.com/mydhlapi/rates",
        	CURLOPT_RETURNTRANSFER => true,
        	CURLOPT_ENCODING => "",
        	CURLOPT_MAXREDIRS => 10,
        	CURLOPT_TIMEOUT => 30,
        	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        	CURLOPT_CUSTOMREQUEST => "POST",
        	CURLOPT_POSTFIELDS =>json_encode($requestShip),
        	CURLOPT_HTTPHEADER => [
        		"Authorization: Basic ".base64_encode($apiKey.':'.$secretKey),
        		"content-type: application/json"
        	],
        
        ]);
        
        
        $response = curl_exec($curl);
    
        $err = curl_error($curl);
        
        curl_close($curl);
        
        $jsonArrayResponse = json_decode($response);

        //dd($jsonArrayResponse);
        
        //dd($jsonArrayResponse->products[0]->totalPrice[0]->price);


        if($jsonArrayResponse->products[0]->totalPrice[0]->price >= 0){
           
         
            return response()->json(['status'=>true,'message' => $jsonArrayResponse->products[0]->totalPrice[0]->price]);
        }
        else{
               return response()->json(['status'=>false,'message' => "Some Error Occurred"]);
            
        }
        
        
        
    }

    public function upsservices(Request $request){
        
       
        $tax = 10.25;
        if($request->input('country') == 'US')
        {
            if($request->input('postal')){
                 $ch = curl_init(
                  'https://api.api-ninjas.com/v1/salestax?zip_code='.$request->input('postal')
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-Api-Key:u9uJPdSpJl4pjoQvputyQg==Xp3H6aBKFpo5Zocj',
                    ]);
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $apiResponse = json_decode(curl_exec($ch));
            }
            else{
                $ch = curl_init(
                  'https://api.api-ninjas.com/v1/zipcode?city='.$request->input('city').'&state='.$request->input('state')
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-Api-Key:u9uJPdSpJl4pjoQvputyQg==Xp3H6aBKFpo5Zocj',
                    ]);
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $apiResponse = json_decode(curl_exec($ch));
                 
                $ch = curl_init(
                  'https://api.api-ninjas.com/v1/salestax?zip_code='.$apiResponse[0]->zip_code
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'X-Api-Key:u9uJPdSpJl4pjoQvputyQg==Xp3H6aBKFpo5Zocj',
                    ]);
                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $apiResponse = json_decode(curl_exec($ch));
                
            }
            
            $tax = (float) $apiResponse[0]->total_rate * 100;
        }
        else{
            $tax = ($tax == null) ? 10.25 : $tax;
            $description = "International Custom Tax";
        }


        //tax 10.25
        $tax = 10.25;


        $weight = 0;
        $cart = Session::get('cart');
        foreach($cart as $key => $value)
        {

            $proweight = Product::find($value['id'])->weight * $value['qty'];
            $weight = $weight + $proweight;

        }
        if($request->input('country') == 'US'){
            $service = "12";
        }
        else{
            $service = "65";
        }
        $arrayVar =  [
                "RateRequest" => [
                    "Request" => [
                        "SubVersion" => "1703",
                        "TransactionReference" => ["CustomerContext" => " "],
                    ],
                    "Shipment" => [
                        "ShipmentRatingOptions" => ["UserLevelDiscountIndicator" => "TRUE"],
                        "Shipper" => [
                            "Name" => "Richards",
                            "ShipperNumber" => "C60W34",
                            "Address" => [
                                "AddressLine" => (string) HelperTrait::returnFlag(1985),
                                "City" => (string) HelperTrait::returnFlag(1981),
                                "StateProvinceCode" => (string) HelperTrait::returnFlag(1983),
                                "PostalCode" => (string) HelperTrait::returnFlag(1973),
                                "CountryCode" => (string) HelperTrait::returnFlag(1974),
                            ],
                        ],
                        "ShipTo" => [
                            "Name" => $request->input('first_name').' '.$request->input('last_name'),
                            "Address" => [
                                "AddressLine" => $request->input('address'),
                                "City" => $request->input('city'),
                                "StateProvinceCode" => $request->input('state'),
                                "PostalCode" => $request->input('postal'),
                                "CountryCode" => $request->input('country'),
                            ],
                        ],
                        "ShipFrom" => [
                            "Name" => "Richards",
                            "ShipperNumber" => "C60W34",
                            "Address" => [
                                "AddressLine" => (string) HelperTrait::returnFlag(1985),
                                "City" => (string) HelperTrait::returnFlag(1981),
                                "StateProvinceCode" => (string) HelperTrait::returnFlag(1983),
                                "PostalCode" => (string) HelperTrait::returnFlag(1973),
                                "CountryCode" => (string) HelperTrait::returnFlag(1974),
                            ],
                        ],
                        "Service" => ["Code" => $service],
                        "ShipmentTotalWeight" => [
                            "UnitOfMeasurement" => [
                                "Code" => "LBS"
                            ],
                            "Weight" => (string) $weight,
                        ],
                        "Package" => [
                            "PackagingType" => ["Code" => "02", "Description" => "Package"],
                            "Dimensions" => [
                                "UnitOfMeasurement" => ["Code" => "IN"],
                                "Length" => "10",
                                "Width" => "7",
                                "Height" => "5",
                            ],
                            "PackageWeight" => [
                                "UnitOfMeasurement" => ["Code" => "LBS"],
                                "Weight" => number_format((float)$weight, 2, '.', ''),
                            ],
                        ],
                    ],
                ],
            ];
            
        
            
        $ch = curl_init(
            'https://onlinetools.ups.com/ship/v1/rating/Rate'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'transId:Trans123',
            'Content-Type:application/json',
            'transactionSrc:XOLT',
            'Username:Exportermedical',
            'Password:Exporter20!MP',
            'AccessLicenseNumber:9DC35B7910A57941'

        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayVar));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = json_decode(curl_exec($ch));


        if($apiResponse->RateResponse->Response->ResponseStatus->Description == "Success"){
            return response()->json([
                'upsamount' => $apiResponse->RateResponse->RatedShipment->TotalCharges->MonetaryValue,
                'tax' => $tax,
                'description' => $description,
                'status' => true,
            ]);
        }

        else if($apiResponse->response->errors[0]->message){
            return response()->json([
                'message' => $apiResponse->response->errors[0]->message,
            
                'status' => false,
            ]);
        }
        else{
            return response()->json([
                'message' => 'Could not verify your address or UPS service unavailable', 
                'status' => false,
            ]);
        }




    }

    public function services(Request $request)
    {
        if($request->input('country') == 'US')
        {
            $tax = StatesTax::where('code',$request->input('state'))->first()->tax;
        }
        else{
            $tax = ($tax == null) ? 17 : $tax;
            $description = "International Custom Tax";
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        //Postal code validator
        $arrayVar = [
            "addressesToValidate" => [
                [
                    "address" => [
                        "streetLines" => [$request->address],
                        "city" => $request->city,
                        "stateOrProvinceCode" => $request->state,
                        "postalCode" => $request->postal,
                        "countryCode" => $request->country,
                    ],
                ],
            ],
        ];

        $ch = curl_init(
            'https://apis-sandbox.fedex.com/address/v1/addresses/resolve'
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'authorization:Bearer ' . $request->token,
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayVar));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = json_decode(curl_exec($ch));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($apiResponse == null){
            return response()->json([
                'error' => "No Response",
                'status' => false,
            ]);
        }
        if ($httpcode != 200) {
            return response()->json([
                'error' => $apiResponse->errors->message,
                'status' => false,
            ]);
        } else {
            $postalcode = $request->postal;
            $country = $apiResponse->output->resolvedAddresses[0]->countryCode;
            $city = $apiResponse->output->resolvedAddresses[0]->city;
            $state = $apiResponse->output->resolvedAddresses[0]->stateOrProvinceCode;
            if($country != "US"){
                $service = "INTERNATIONAL_ECONOMY";
            }
            else{
                $service = "FEDEX_2_DAY";
            }

            $cart = Session::get('cart');

            $requestedPackageLineItems = [];
            foreach ($cart as $key => $value) {
                $weightarray = [
                    'weight' => [
                        'units' => 'LB',
                        'value' => Product::find($value['id'])->weight,
                    ],
                ];
                for ($i = 0; $i < $value['qty']; $i++) {
                    array_push($requestedPackageLineItems, $weightarray);
                }
            }
            $ratecalcalculate =  [
                "accountNumber" => ["value" => (string) HelperTrait::returnFlag(1975)],
                "requestedShipment" => [
                    "shipper" => [
                        "address" => ["postalCode" => (string) HelperTrait::returnFlag(1973),
                        "countryCode" => HelperTrait::returnFlag(1974)],
                    ],
                    "recipient" => [
                        "address" => ["postalCode" => (string) $postalcode, "countryCode" => $country],
                    ],
                    "shipDateStamp" => Carbon::now()->addDays(5)->format('Y-m-d'),
                    "pickupType" => "DROPOFF_AT_FEDEX_LOCATION",
                    "serviceType" => $service,
                    "rateRequestType" => ["LIST"],
                    "customsClearanceDetail" => [
                        "dutiesPayment" => [
                            "paymentType" => "SENDER",
                            "payor" => ["responsibleParty" => null],
                        ],
                    ],
                    "requestedPackageLineItems" => $requestedPackageLineItems
                ],
            ];

            $ch_rates = curl_init(
                'https://apis-sandbox.fedex.com/rate/v1/rates/quotes'
            );
            curl_setopt($ch_rates, CURLOPT_HTTPHEADER, [
                'Content-Type:application/json',
                'authorization:Bearer ' . $request->token,
            ]);
            curl_setopt(
                $ch_rates,
                CURLOPT_POSTFIELDS,
                json_encode($ratecalcalculate)
            );
            curl_setopt($ch_rates, CURLOPT_RETURNTRANSFER, true);
            $apiResponseRates = json_decode(curl_exec($ch_rates));
            $httpcoderates = curl_getinfo($ch_rates, CURLINFO_HTTP_CODE);
            curl_close($ch_rates);
            if($apiResponseRates == null){
                return response()->json([
                    'error' => "No Response",
                    'status' => false,
                ]);
            }
            if($httpcoderates != 200){
                return response()->json([
                    'error' => $apiResponseRates->errors->message,
                    'status' => false,
                ]);
            }else{
                if ($apiResponseRates->output->rateReplyDetails) {
                    return response()->json([
                        'tax' => $tax,
                        'description' =>$description, 
                        'services' => $apiResponseRates->output->rateReplyDetails,
                        'status' => true,
                    ]);
                } else {
                    return response()->json([
                        'services' => 'Internal Server Error',
                        'status' => false,
                    ]);
                }
            }
        }
    }

    public function dhlshipping($request,$invoice){
 
        
 
        $cart = Session::get('cart');
        $weightarray = [];
          $lineItems = [];
        foreach($cart as $key => $value)
        {
            $product = Product::find($value['id']);
            array_push($weightarray,[
                'weight'=>round($product->weight,2),
                'dimensions'=>[
                    'length'=>(float)$product->length,
                    'width'=>(float)$product->width,
                    'height'=>(float)$product->height
                    
                    ],
                'description'=>$product->product_title 
            ]);
            array_push($lineItems,[
                'number'=>$product->id,
                'description' => $product->product_title,
                'price' => (float)$product->list_price,
                'quantity'=>[
                     'value' => $value['qty'],
                     'unitOfMeasurement' => 'LBS'
                     ],
                'manufacturerCountry' => 'US',
                'weight' =>[
                      'netValue' => (float)$product->weight,
                        'grossValue' =>  (float) $product->weight,
                    ]
                ]);

        }
        $shippArray = array (
              'plannedShippingDateAndTime' => Carbon::tomorrow()->format('Y-m-d\TH:i:s').' GMT+04:00',
              'pickup' => 
              array (
                'isRequested' => false,
              ),
              'productCode' => 'P',
              'localProductCode' => 'P',
              'getRateEstimates' => false,
              'accounts' => 
              array (
                0 => 
                array (
                  'typeCode' => 'shipper',
                  'number' => '921423586',
                ),
              ),
              'customerDetails' => 
              array (
                'shipperDetails' => 
                array (
                  'postalAddress' => 
                  array (
                    'postalCode' => (string) HelperTrait::returnFlag(1973),
                    'cityName' => (string) HelperTrait::returnFlag(1981),
                    'countryCode' => (string) HelperTrait::returnFlag(1974),
                    'addressLine1' => '880 S. Atlantic Blvd., Suite 101A',
                  ),
                  'contactInformation' => 
                  array (
                    'email' => (string) HelperTrait::returnFlag(218),
                    'phone' => (string) HelperTrait::returnFlag(59),
                    'mobilePhone' => (string) HelperTrait::returnFlag(59),
                    'companyName' => 'Exporter Medical',
                    'fullName' => 'Richard',
                  ),
                ),
                'receiverDetails' => 
                array (
                  'postalAddress' => 
                  array (
                    'cityName' => $request['city'],
                    'countryCode' => $request['country'],
                    'postalCode' => $request['postal_code'],
                    'addressLine1' => $request['address_line_1'],
                  ),
                  'contactInformation' => 
                  array (
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'mobilePhone' => $request['phone'],
                    'companyName' => 'Exporter Customer',
                    'fullName' => $request['first_name'].' '.$request['last_name'],
                  ),
                ),
              ),
              'content' => 
              array (
                'packages' => 
                $weightarray,
                'isCustomsDeclarable' => true,
                'declaredValue' => (float) $request['amount'],
                'declaredValueCurrency' => 'USD',
                'exportDeclaration' => 
                array (
                  'lineItems' => 
                    $lineItems,
                  'invoice' => 
                  array (
                    'number' => (string) $invoice,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'instructions' => 
                    array (
                      0 => 'Handle with care',
                    ),
                  ),
                  'remarks' => 
                  array (
                    0 => 
                    array (
                      'value' => 'Right side up only',
                    ),
                  ),
                ),
                'description' => 'Shipment',
                'incoterm' => 'DAP',
                'unitOfMeasurement' => 'imperial',
              ),
            );
            
        // dd($shippArray);    
            
        $curl = curl_init();
        $apiKey = "apP3qO9oK7yC6c";
        $secretKey = "T#9oT!5uL@8jN#1l";
        curl_setopt_array($curl, [
        
        	CURLOPT_URL => "https://express.api.dhl.com/mydhlapi/shipments",
        
        	CURLOPT_RETURNTRANSFER => true,
        
        	CURLOPT_ENCODING => "",
        
        	CURLOPT_MAXREDIRS => 10,
        
        	CURLOPT_TIMEOUT => 30,
        
        	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        
        	CURLOPT_CUSTOMREQUEST => "POST",
        
        	CURLOPT_POSTFIELDS => json_encode($shippArray),
        
        	CURLOPT_HTTPHEADER => [
        		"Authorization: Basic ".base64_encode($apiKey.':'.$secretKey),
        		"content-type: application/json"
        	],
        
        ]);
        
        
        
        $response = curl_exec($curl);
        curl_close($curl);
        $jsonArray = json_decode($response);
        
        // dd($jsonArray);
        
        return $jsonArray->shipmentTrackingNumber;
        
    }
    
    
    public function upsshipping($request)
    {
        if( $request['country'] == "US"){
            $service = "12";

        }
        else{
            $service = "65";
        }
       
        $shipping = [
            "ShipmentRequest" => [
                "Shipment" => [
                    "Description" => "Order From Website",
                    "Shipper" => [
                        "Name" => "Richards",
                        "AttentionName" => "Richards",
                        "Phone" => ["Number" => (string) HelperTrait::returnFlag(1984)],
                        "ShipperNumber" => "C60W34",
                        "Address" => [
                            "AddressLine" => (string) HelperTrait::returnFlag(1985),
                            "City" => (string) HelperTrait::returnFlag(1981),
                            "StateProvinceCode" => (string) HelperTrait::returnFlag(1983),
                            "PostalCode" => (string) HelperTrait::returnFlag(1973),
                            "CountryCode" => (string) HelperTrait::returnFlag(1974),
                        ],
                    ],
                    "ShipTo" => [
                        "Name" => $request['first_name'],
                        "AttentionName" => $request['first_name'],
                        "Phone" => ["Number" => trim(str_replace(' ', '', $request['phone']))],
                        "Address" => [
                            "AddressLine" => $request['address_line_1'],
                            "City" => $request['city'],
                            "StateProvinceCode" => $request['state'],
                            "PostalCode" => $request['postal_code'],
                            "CountryCode" => $request['country'],
                        ],
                    ],
                    "ShipFrom" => [
                        "Name" => "Richards",
                        "AttentionName" => "Richards",
                        "Phone" => ["Number" => (string) HelperTrait::returnFlag(1984)],
                        "ShipperNumber" => "C60W34",
                        "Address" => [
                            "AddressLine" => (string) HelperTrait::returnFlag(1985),
                            "City" => (string) HelperTrait::returnFlag(1981),
                            "StateProvinceCode" => (string) HelperTrait::returnFlag(1983),
                            "PostalCode" => (string) HelperTrait::returnFlag(1973),
                            "CountryCode" => (string) HelperTrait::returnFlag(1974),
                        ],
                    ],
                    "PaymentInformation" => [
                        "ShipmentCharge" => [
                            "Type" => "01",
                            "BillShipper" => ["AccountNumber" => "C60W34"],
                        ],
                    ],
                    "InvoiceLineTotal" => [
                        "CurrencyCode"=>"USD",
                        "MonetaryValue"=> (string) $request['amount']
                    ],
                    "ItemizedChargesRequestedIndicator" => "",
                    "Service" => ["Code" => "12"],
                    "Package" => [
                        "SimpleRate" => ["Code" => "S"],
                        "Packaging" => ["Code" => "02"],
                    ],
                ],
                "LabelSpecification" => [
                    "LabelImageFormat" => ["Code" => "GIF"],
                    "HTTPUserAgent" => "Mozilla/4.5",
                ],
            ],
        ];
        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            'https://onlinetools.ups.com/ship/v1/shipments'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'transId:Trans123',
            'Content-Type:application/json',
            'transactionSrc:XOLT',
            'Username:Exportermedical',
            'Password:Exporter20!MP',
            'AccessLicenseNumber:9DC35B7910A57941'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($shipping));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = json_decode(curl_exec($ch));
      
         if($apiResponse->response->errors){
                Session::flash('error', $apiResponse->response->errors[0]->message);
                Session::flash('alert-class', 'alert-error');
              
         }
         else{
             
             return $apiResponse->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber;
         }

    }

    public function placeOrder(Request $request)
    {
        $shipping = Session::get('shipping');
        
        request()->validate([
                'first_name' => 'required',
                'country' => 'required',
                'address_line_1' => 'required',
                'city' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'postal_code' => 'required'
        ]);

        $cart = Session::get('cart');

        $requestedPackageLineItems = [];
        
        foreach ($cart as $key => $value) {
            $weightarray = [
                'weight' => [
                    'units' => 'KG',
                    'value' => Product::find($value['id'])->weight,
                ],
            ];
            for ($i = 0; $i < $value['qty']; $i++) {
                array_push($requestedPackageLineItems, $weightarray);
            }
        }
        $id = 0;
        if (isset($_POST['create_account'])) {
            if ($_POST['password'] == '') {
                $validateArr['password'] =
                    'min:6|required_with:confirm_password|same:confirm_password';
                $validateArr['confirm_password'] = 'min:6';
            } else {
                $validateArr['email'] = 'required|max:255|email|unique:users';
                $this->validate($request, $validateArr, $messageArr);

                $pw = Hash::make($_POST['password']);
                $fullName = $request->first_name . ' ' . $request->last_name;

                DB::insert(
                    "INSERT INTO users(email,name,password) values('" .
                        $_POST['email'] .
                        "','" .
                        $fullName .
                        "','" .
                        $pw .
                        "')"
                );

                $user = DB::table('users')
                    ->orderBy('id', 'desc')
                    ->first();
                $id = $user->id;
            }
        }

        if (Auth::check()) {
            $id = Auth::user()->id;
        }

        $cart = Session::get('cart');

        $subtotal = 0;
        foreach ($cart as $key => $value) {
            $subtotal += $value['baseprice'] * $value['qty'];
        }

        $order = new orders();

        $order->delivery_country = $request->country;
        $order->country_code = $request->country_code;
        $order->delivery_first_name = $request->first_name;
        $order->delivery_last_name = $request->last_name;
        $order->order_company = $request->company_name;
        $order->delivery_address_1 = $request->address;
        $order->serviceType = $request->services;
        $order->delivery_city = $request->city;
        $order->delivery_state = $request->state;
        $order->delivery_zip_code = $request->postal_code;
        $order->area = $request->area;
        $order->landmark = $request->landmark;
        $order->serviceType = $request->shipping;
        // $order->order_shipping = $request->shippingamount;
        $order->order_shipping = 0;
        $order->floor_num = $request->floor_num;
        $order->building = $request->building;
        $order->country_code = $request->country_code;
        $order->delivery_state = $shipping['state'];
        $order->order_email = $request->email;
        $order->delivery_phone_no = $request->phone;
        $order->order_notes = $request->order_notes;
        $order->order_company = $request->company_name;
        $order->payment_method = $request->payment_method;

        $order->delivery_zip_code = $shipping['postalcode'];

        $order->order_items = count(Session::get('cart'));

        $total = $request->amount;

        //5500
        if ($request->has('no_shipping')) {
            $total -= floatval($request->get('shippingamount'));
        }
        //5050
        if ($request->has('no_tax')) {
            $total -= floatval($request->get('subtotal')) * (10.25 / 100);
        }
        //1010
        if ($request->has('ten_off')) {
            $total -= floatval($request->get('subtotal')) * (10 / 100);
        }
        //2020
        if ($request->has('twenty_off')) {
            $total -= floatval($request->get('subtotal')) * (20 / 100);
        }
        
        // $total = 1; 
        
        // dd($total);

        $order->order_item_total = $total;

        $order->order_total = $total;

            $order->user_id = $id;
            //SUCCED


        if(isset($_POST['payment_method']) && $_POST['payment_method'] == 'AuthNet') {
                
            request()->validate([
                'cc' => 'required',
                'month' => 'required',
                'expr' => 'required',
                'cvv' => 'required',
            ]);

            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName(
                config('services.authorize.login')
            );
            $merchantAuthentication->setTransactionKey(
                config('services.authorize.key')
            );

            // Set the transaction's refId
            $refId = 'ref' . time();

            $cardNumber = preg_replace('/\s+/', '', $request->cc);

            $cardExpDate = $request->expr;
            $cardCVV = $request->cvv;

            $month = $request->month;
            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardNumber);
            $creditCard->setExpirationDate($cardExpDate . '-' . $month);
            $creditCard->setCardCode($cardCVV);
            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Create order information
            $invoice = rand(0, 9999);
            $neworder = new AnetAPI\OrderType();
            $neworder->setInvoiceNumber($invoice);
            $neworder->setDescription($request->order_notes);

            // Set the customer's identifying information
            $customerData = new AnetAPI\CustomerDataType();
            $customerData->setType('individual');
            $customerData->setEmail($request->input('email'));

            // Set the customer's Bill To address
            $customerAddress = new AnetAPI\CustomerAddressType();
            $customerAddress->setFirstName($request->input('first_name'));
            $customerAddress->setLastName($request->input('last_name'));
            $customerAddress->setAddress($request->input('address_line_1'));
            $customerAddress->setCity($request->input('city'));
            $customerAddress->setZip($request->input('postal_code'));
            $customerAddress->setState($request->input('state'));
            $customerAddress->setCountry($request->input('country-code'));

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType(
                'authCaptureTransaction'
            );
            $transactionRequestType->setAmount(
                number_format($total, 2, '.', '') . ''
            );  
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setBillTo($customerAddress);
            $transactionRequestType->setCustomer($customerData);
            $transactionRequestType->setOrder($neworder);
            // dd($transactionRequestType);
            // Assemble the complete transaction request
            $requests = new AnetAPI\CreateTransactionRequest();
            $requests->setMerchantAuthentication($merchantAuthentication);
            $requests->setRefId($refId);

            $requests->setTransactionRequest($transactionRequestType);
            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController(
                $requests
            );
           
                $response = $controller->executeWithApiResponse(
                            \net\authorize\api\constants\ANetEnvironment::PRODUCTION
                );
           
            if ($response != null) { 

                if ($response->getMessages()->getResultCode() == 'Ok') {
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getMessages() != null) {

                        $message_text =
                            $tresponse->getMessages()[0]->getDescription() .
                            ', Transaction ID: ' .
                            $tresponse->getTransId();
                        $msg_type = 'success_msg';

                        /* save payment status and other values to database */
                        $order->transaction_id = $tresponse->getTransId();
                        $order->invoice_number = $invoice;
                        $order->payment_method = 'AuthNet';
                        if($request->input('shipping') == 'DHL'){
                 
					    	$response_shipping = $this->dhlshipping($request->input(),$invoice);
                        }
                        else{
                 
                            $response_shipping = $this->upsshipping($request->input());
                            
                          

                        }
                          if($response_shipping){
                                
                                $order->track_id = $response_shipping;
                                
                                $data = [
                                
                                  'name' => $request->first_name .' '. $request->last_name,
                                  'address' => $request->googleaddress,
                                  'phone' => $request->phone,
                                  'email' => $request->email,
                                  'message' => $request->message,
                                  'invoice' => $invoice,
                                  'tracking' => $order->track_id,
                                  'transaction' => $tresponse->getTransId(),
                                  'shipping' => $request->input('shipping'),
                                  'ship_amount' => $request->has('no_shipping') ? 0.00 : $request->shippingamount,
                                  'tax_amount' => $request->has('no_tax') ? 0.00 : floatval($request->get('subtotal')) * (10.25 / 100),
                                  //'ship_amount' => 0,
                                  'cart' => Session::get('cart'),
                                  'amount' => $total,
                                  'shipping_amount' => $request->has('no_shipping') ? 0.00 : $request->shippingamount,
                                  //'shipping_amount' => 0,
                                  'shipping' => $request->shipping
                                
                                ];

                                $emails = [];
//                                Mail::send('order_invoice', $data, function($message) use ($emails){
                                Mail::send('order_invoice', $data, function($message) {
                                    $message->from(trim(config('services.mail.username')), 'New Order');
                                    $message->to([trim(HelperTrait::returnFlag(218)), 'inf.exportermedical@gmail.com'])->subject('New Order');
                                });
                                
                                $emails = $request->email;
                                
                                Mail::send('order_invoice', $data, function($message) use ($emails){
                                    $message->from(config('services.mail.username'), 'New Order');
                                    $message->to($emails)->subject('New Order');
                                });
           
                                
                            //   dd($order);
                              
                              $order->save();
                              
                        } 
                        else{
                             
                             return redirect()->back();
                             
                        }



                    } else {
                        $message_text =
                            'There were some issue with the payment. Please try again later.';
                        $msg_type = 'error_msg';

                        if ($tresponse->getErrors() != null) {
                            $message_text = $tresponse
                                ->getErrors()[0]
                                ->getErrorText();
                            $msg_type = 'error_msg';
                        }
                        /* send payment failed email to user or website admin */
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $message_text =
                        'There were some issue with the payment. Please try again later.';
                    $msg_type = 'error_msg';

                    $tresponse = $response->getTransactionResponse();
                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $message_text = $tresponse
                            ->getErrors()[0]
                            ->getErrorText();
                    } else {
                        $message_text = $response
                            ->getMessages()
                            ->getMessage()[0]
                            ->getText();
                        $msg_type = 'error_msg';

                    }

                }
                if ($msg_type == 'error_msg') {
                    Session::flash('error', $message_text);
                    Session::flash('alert-class', 'alert-error');
                    return redirect()->back();
                }
            }
        }

        $record = orders::latest()->first();
        $expNum = explode('-', $record->invoice_number);
        $order->invoice_number = rand(0, 999999999999999);

        if ($order->save()) {
            $orders = orders::orderBy('id', 'desc')->first();
            $subtotal = 0;
            foreach ($cart as $key => $value) {
                if ($value['name'] != '') {
                    $order_products = new orders_products();
                    $order_products->order_products_product_id = $value['id'];
                    $order_products->user_id = Auth::user()->id;
                    $order_products->order_products_name = $value['name'];
                    $order_products->order_products_price = $value['baseprice'];
                    $order_products->orders_id = $orders->id;
                    $order_products->order_products_qty = $value['qty'];
                    $order_products->mat_language = $value['mat_language'];
                    $order_products->shipping = $cart['shipping'];
                    $order_products->order_products_subtotal =
                        $value['baseprice'] * $value['qty'] +
                        $value['variant_price'];

                    $order_products->variants = json_encode(
                        $value['variation']
                    );
                    $order_products->save();
                }
            }

            Session::forget('cart');
            Session::forget('shipping');

            Session::flash(
                'message',
                'Your Order has been placed Successfully'
            );
            Session::flash('alert-class', 'alert-success');
            //echo "data saved";
            //return;
            if (Auth::check()) {
                return redirect('/');
            } else {
                return redirect('/');
            }
        }
    }

    public function payment()
    {
        if (isset($_GET['paymentId'])) {
            $curl = curl_init();
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://apidemo.myfatoorah.com/Token'
            );
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt(
                $curl,
                CURLOPT_POSTFIELDS,
                http_build_query([
                    'grant_type' => 'password',
                    'username' => 'apiaccount@myfatoorah.com',
                    'password' => 'api12345*',
                ])
            );
            $result = curl_exec($curl);
            $error = curl_error($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $json = json_decode($result, true);
            $access_token = $json['access_token'];
            $token_type = $json['token_type'];
            if (isset($_GET['paymentId'])) {
                $id = $_GET['paymentId'];
            }
            $password = 'api12345*';
            $url =
                'https://apidemo.myfatoorah.com/ApiInvoices/Transaction/' . $id;
            $soap_do1 = curl_init();
            curl_setopt($soap_do1, CURLOPT_URL, $url);
            curl_setopt($soap_do1, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($soap_do1, CURLOPT_TIMEOUT, 10);
            curl_setopt($soap_do1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($soap_do1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($soap_do1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($soap_do1, CURLOPT_POST, false);
            curl_setopt($soap_do1, CURLOPT_POST, 0);
            curl_setopt($soap_do1, CURLOPT_HTTPGET, 1);
            curl_setopt($soap_do1, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
                'Authorization: Bearer ' . $access_token,
            ]);
            $result_in = curl_exec($soap_do1);
            $err_in = curl_error($soap_do1);
            $file_contents = htmlspecialchars(curl_exec($soap_do1));
            curl_close($soap_do1);
            $getRecorById = json_decode($result_in, true);

            //dd($getRecorById,$getRecorById['InvoiceItems'][0]['ProductName']);

            DB::table('orders')
                ->where('ref_id', $getRecorById['InvoiceId'])
                ->update([
                    'transaction_id' => $getRecorById['TransactionId'],
                    'payment_id' => $getRecorById['PaymentId'],
                    'payment_method' => $getRecorById['PaymentGateway'],
                ]);
            DB::table('orders_products')
                ->where('ref_id', $getRecorById['InvoiceId'])
                ->update([
                    'order_products_name' =>
                        $getRecorById['InvoiceItems'][0]['ProductName'],
                    'order_products_price' =>
                        $getRecorById['InvoiceItems'][0]['UnitPrice'],
                    'order_products_qty' =>
                        $getRecorById['InvoiceItems'][0]['Quantity'],
                    'order_products_subtotal' =>
                        $getRecorById['InvoiceItems'][0]['ExtendedAmount'],
                ]);
        }
        return view('account.success');
    }
}
