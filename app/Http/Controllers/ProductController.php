<?php

namespace App\Http\Controllers;

use Request;
use App\inquiry;

use App\newsletter;
use App\Program;
use App\imagetable;
use SoapClient;
use App\Product;
use App\Category;
use App\Banner;
use App\ProductAttribute;

use DB;
use View;
use Session;
use App\Http\Traits\HelperTrait;
use App\orders;
use App\orders_products;


use Illuminate\Contracts\Session\Session as SessionSession;
use function Clue\StreamFilter\fun;

class ProductController extends Controller
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
		//$this->middleware('auth');
		$logo = imagetable::select('img_path')
			->where('table_name', '=', 'logo')
			->first();

		$favicon = imagetable::select('img_path')
			->where('table_name', '=', 'favicon')
			->first();

		View()->share('logo', $logo);
		View()->share('favicon', $favicon);
		//View()->share('config',$config);
	}

	public function index()
	{
		$products = new Product;
		if (isset($_GET['q']) && $_GET['q'] != '') {

			$keyword = $_GET['q'];

			$products = $products->where(function ($query)  use ($keyword) {
				$query->where('product_title', 'like', $keyword);
			});
		}
		$products = $products->orderBy('id', 'asc')->get();
		return view('products', ['products' => $products]);
	}

	public function productDetail($id)
	{

		$product = new Product;
		$product_detail = $product->where('id', $id)->first();
		$products = DB::table('products')->get()->take(10);
		return view('product_detail', ['product_detail' => $product_detail, 'products' => $products]);
	}

	public function categoryDetail($id)
	{
        $page = DB::table('pages')->where('id', 4)->first();

		$shops = Product::where('category', $id)->paginate(100);

        $categories =  Category::all();

		return view('shop.shop', compact('shops', 'page', 'categories'));
	}
    public function sort($method=null,$category=null,$id=null,$slug=null)
    {
	
		if($category == "subcat")
		{
			$category = "subcategory";
		}
        if($id == null || $slug == null || $category==null)
        {
            if($method == 'latest')
            {
                $shops = Product::orderBy('created_at', 'desc')->paginate(100);
            }
            else if($method == 'low-to-high'){
                $shops = Product::orderBy('list_price', 'asc')->paginate(100);
            }
            else if($method == 'high-to-low'){
                $shops = Product::orderBy('list_price', 'desc')->paginate(100);
            }
            else if($method == 'A-Z'){
                $shops = Product::orderBy('product_title', 'asc')->paginate(100);
            }
            else if($method == 'Z-A'){
                $shops = Product::orderBy('product_title', 'desc')->paginate(100);
            }
        }
        else{

            if($method == 'latest')
            {

                $shops = Product::where($category, $id)->orderBy('created_at', 'desc')->paginate(100);
            }
            else if($method == 'low-to-high'){
                $shops = Product::where($category, $id)->orderBy('list_price', 'asc')->paginate(100);
            }
            else if($method == 'high-to-low'){
                $shops = Product::where($category, $id)->orderBy('list_price', 'desc')->paginate(100);
            }
            else if($method == 'A-Z'){
                $shops = Product::where($category, $id)->orderBy('product_title', 'asc')->paginate(100);
            }
            else if($method == 'Z-A'){
                $shops = Product::where($category, $id)->orderBy('product_title', 'desc')->paginate(100);
            }
        }

        $categories =  Category::all();

		return view('shop.shop', compact('shops', 'page', 'categories'));




    }
	public function subcategoryDetail($id)
	{
        $page = DB::table('pages')->where('id', 4)->first();

		$shops = Product::where('subcategory', $id)->paginate(100);

        $categories =  Category::all();

		return view('shop.shop', compact('shops', 'page', 'categories'));
	}


	public function cart()
	{

		$page = DB::table('pages')->where('id', 2)->first();
		$cartCount = COUNT(Session::get('cart'));
		$language = Session::get('language');
		$product_detail = DB::table('products')->first();
		if (Session::get('cart') && count(Session::get('cart')) > 0) {
			return view('shop.cart', ['cart' => Session::get('cart'), 'language' => $language, 'product_detail' => $product_detail, 'page' => $page]);
		} else {
			Session::flash('error', 'No Product found');
			return redirect('/');
		}
	}

	public function saveCart(Request $request)
	{

		$var_item = $_POST['variation'];

		$result = array();


		$product_detail = DB::table('products')->where('id', $_POST['product_id'])->first();
		$id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
		$qty = isset($_POST['qty']) ? intval($_POST['qty']) : '1';


		$cart = array();
		$cartId = $id;
		if (Session::has('cart')) {

			$cart = Session::get('cart');
		}

		$price = $product_detail->list_price;


		if ($id != "" && intval($qty) > 0) {

			if (array_key_exists($cartId, $cart)) {
				unset($cart[$cartId]);
			}
			$productFirstrow = Product::where('id', $id)->first();


			$cart[$cartId]['id'] = $id;
			$cart[$cartId]['name'] = $productFirstrow->product_title;
			$cart[$cartId]['baseprice'] = $price;
			$cart[$cartId]['qty'] = $qty;
			$cart[$cartId]['variation_price'] = 0;

			foreach ($var_item as $key => $value) {

				$data = ProductAttribute::where('product_id', $_POST['product_id'])
					->where('value', $value)->first();
				$cart[$cartId]['variation'][$data->id]['attribute'] = 	$data->attribute->name;
				$cart[$cartId]['variation'][$data->id]['attribute_val'] = 	$data->attributesValues->value;
				$cart[$cartId]['variation'][$data->id]['attribute_price'] = 	$data->price;
				$cart[$cartId]['variation_price'] += $data->price;
			}


			Session::put('cart', $cart);
			Session::flash('message', 'Product Added to cart Successfully');
			Session::flash('alert-class', 'alert-success');
			return redirect('/cart');
		} else {
			Session::flash('flash_message', 'Sorry! You can not proceed with 0 quantity');
			Session::flash('alert-class', 'alert-success');
			return back();
		}
	}

	public function clearCart(){
	    Session::forget('cart');
	    return back();
	}
	public function updateCart(Request $request)
	{
	

		$cart = Session::get('cart');
		$row = $_POST['row'];
	
		foreach($row as $key => $value){
		    $cart[$key]['qty']  = (int)($value);
		}

		Session::put('cart', $cart);
		Session::flash('message', 'Your Cart Updated Successfully');
		Session::flash('alert-class', 'alert-success');
		return back();
		return redirect('/checkout');
	}


	public function removeCart($id)
	{

		if ($id != "") {

			if (Session::has('cart')) {

				$cart = Session::get('cart');
			}

			if (array_key_exists($id, $cart)) {

				unset($cart[$id]);
			}

			Session::put('cart', $cart);
		}

		// echo 'success';
		Session::flash('flash_message', 'Product item removed successfully');
		Session::flash('alert-class', 'alert-success');
		return back();
	}

	public function shop($category = null, $name = null)
	{
	    $category = Request::get('category');
	    $name = Request::get('name');

	    $shops = Product::query();

	    if($category != null){
	        $shops = $shops->where('category', $category);
	    }

	    if($name != null){
	        $shops = $shops->where('product_title', 'LIKE', "%$name%")->orWhere('sku', $name)->orWhere('item_number', $name);
	    }

//	    //eliminate products without images unless searched by SKU or Item number or Title
//	    $shops->where(function ($q) {
//	        return $q->where('image', '!=', 'uploads/products/')
//                ->where('image', '!=', 'uploads/products/10055B.jpg')
//                ->where('image', '!=', 'uploads/products/10010B.JPG')
//                ->where('image', '!=', 'uploads/products/10010C.jpg')
//                ->where('image', '!=', 'uploads/products/10010D.JPG')
//                ->where('image', '!=', 'uploads/products/10012.jpg')
//                ->where('image', '!=', 'uploads/products/100357.jpg')
//                ->where('image', '!=', 'uploads/products/10010E.jpg')
//                ->where('image', '!=', 'uploads/products/0090TRP.jpg')
//                ->where('image', '!=', 'uploads/products/no_image.jpg')
//                ->having('product_images', '>', 0);
//        })
//        ->orWhere(function ($q) use ($name) {
//            return $q->when(!is_null($name), function ($q) use ($name) {
//                return $q->where('product_title', 'LIKE', "%$name%")->orWhere('sku', $name)->orWhere('item_number', $name);
//            });
//        });

	    $shops = $shops->paginate(100);


	   // $shops = Product::paginate(100);
		$page = DB::table('pages')->where('id', 4)->first();
		$count = DB::table('products')->count();

		$categories = Category::all();
		return view('shop.shop', compact('shops', 'page', 'categories', 'count'));
	}

	public function shopDetail($id, $name)
	{

        $page = DB::table('pages')->where('id', 4)->first();
		$product = new Product;
		$product_detail = $product->where('id', $id)->first();
		$att_model = ProductAttribute::groupBy('attribute_id')->where('product_id', $id)->get();
		$att_id = DB::table('product_attributes')->where('product_id', $id)->get();
		$shops = Product::where('category', $product_detail->category)->where('id', '!=', $id)->inRandomOrder()->limit(10)->get();
        $product_images = DB::table('product_imagess')->where('product_id', $id)->get();
        $featured_product = DB::table('products')->where('is_featured', 1)->where('id', '!=', $id)->take(4)->get();
		return view('shop.detail', compact('page', 'product_detail', 'shops', 'att_id', 'att_model', 'product_images', 'featured_product'));
	}


	public function invoice($id)
	{

		$order_id = $id;
		$order = orders::where('id', $order_id)->first();
		$order_products = orders_products::where('orders_id', $order_id)->get();

		return view('account.invoice')->with('title', 'Invoice #' . $order_id)->with(compact('order', 'order_products'))->with('order_id', $order_id);;
	}

	public function checkout()
	{


		if (Session::get('cart') && count(Session::get('cart')) > 0) {
			$countries = DB::table('countries')
				->get();
			return view('checkout', ['cart' => Session::get('cart'), 'countries' => $countries]);
		} else {
			Session::flash('flash_message', 'No Product found');
			Session::flash('alert-class', 'alert-success');
			return redirect('/');
		}
	}


	public function language()
	{
		$languages = $_POST['id'];

		Session::put('language', $languages);

		Session::put('is_select_dropdown', 1);
		// Session::put('language',$languages);
		// $test = Session::get('language');

		// Session::put('test',$test);

		//return redirect('shop-detail/1', ['test'=>$test]);
	}

	public function shipping(Request $request)
	{
	   Session::forget('shipping');
	   $shipping = [
	        "servicesfedex" => $_POST['servicesfedex'],
	        "packagesfedex" => $_POST['packagesfedex'],

	        ];
	   $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://apis-sandbox.fedex.com/oauth/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "grant_type=client_credentials&client_id=l710bb292a27ce44d4ac06b2be4e9538a6&client_secret=b345e3a0095d477dbd83f089050018db");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));



        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



        $token = json_decode(curl_exec ($ch))->access_token;
        curl_close($ch);

        $cart = Session::get('cart');
        $requestedPackageLineItems = [];
        foreach($cart as $key => $value){
            $weightarray = [
                            "weight" => [
                                        "units" => "KG",
                                        "value" => Product::find($value['id'])->weight
                                     ]
                                            ];
            array_push($requestedPackageLineItems,$weightarray);

        }

        $jayParsedAry = [
                       "accountNumber" => [
                             "value" => "740561073"
                          ],
                       "requestedShipment" => [
                                "shipper" => [
                                   "address" => [
                                      "postalCode" => 65247,
                                      "countryCode" => "US"
                                   ]
                                ],
                                "recipient" => [
                                         "address" => [
                                            "postalCode" => 75063,
                                            "countryCode" => "US"
                                         ]
                                      ],
                                "pickupType" => "CONTACT_FEDEX_TO_SCHEDULE",
                                "rateRequestType" => [
                                               "LIST"
                                            ],
                                "requestedPackageLineItems" => $requestedPackageLineItems
                             ]
                    ];
        dump($token);
        $cURLConnection = curl_init('https://apis-sandbox.fedex.com/rate/v1/rates/quotes');
        curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array('Content-Type:application/json','authorization:Bearer '.$token));
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, json_encode($jayParsedAry));

        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $jsonArrayResponse = json_decode($apiResponse);

        foreach($jsonArrayResponse->output->rateReplyDetails as $key => $innerjson){
            if($innerjson->serviceType == $_POST['servicesfedex']){
                $shipping["response"] = $innerjson;
             $shipping["totalshipingamount"] = $innerjson->ratedShipmentDetails[0]->totalNetFedExCharge;
            }

        }
        Session::put('shipping',$shipping);

        return redirect('/cart');
	}
}
