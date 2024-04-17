<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\inquiry;
use App\schedule;
use App\newsletter;
use App\post;
use App\banner;
use App\imagetable;
use DB;
use App\Category;
use App\Product;
use Mail;
use View;
use Session;
use App\Http\Helpers\UserSystemInfoHelper;
use App\Http\Traits\HelperTrait;
use Auth;
use App\Profile;
use App\Page;
use Image;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class HomeController extends Controller
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

        $logo = imagetable::
                     select('img_path')
                     ->where('table_name','=','logo')
                     ->first();

        $favicon = imagetable::
                     select('img_path')
                     ->where('table_name','=','favicon')
                     ->first();

        View()->share('logo',$logo);
        View()->share('favicon',$favicon);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $page = DB::table('pages')->where('id', 1)->first();
       $banner = DB::table('banners')->get();
       $category = Category::where('is_featured', 1)->get();
       $product = Product::where('is_featured', 1)->get();
       $section = DB::table('section')->where('page_id',1)->get();
       $bestselling = DB::table('products')->inRandomOrder()->limit(3)->get();


       return view('welcome', compact('page','banner','category', 'product', 'section', 'bestselling'));
    }
    
    public function test(){
        $product = Product::all();
        foreach($product as $key => $pro){
        $sku = '000'.$pro->id;   
        
        $affected = DB::table('products')
              ->where('id', $pro->id)
              ->update(['sku' => $sku]);
        
        dump($pro->sku);    
        }
        
    }
    
    
    public function getPages($name){
        $pages = DB::table('pages')->where('slug', $name)->first();
        return view('pages', compact('pages'));
    }
    
    public function payonline(){
        return view('payonline');
    }
    public function thankyou(){
        
        return view('thankyou');
    }
    public function about(){
        $page = DB::table('pages')->where('id', 11)->first();
        $section = DB::table('section')->where('page_id', 11)->get();
        $testimonials = DB::table('testimonials')->get();
        return view('about', compact('page', 'section', 'testimonials'));
    }

    public function wholesale()
    {
        $page = DB::table('pages')->where('id', 2)->first();
        $section = DB::table('section')->where('page_id',2)->get();
        return view('wholesale', compact('page', 'section'));
    }

    public function contact()
    {
        $page = DB::table('pages')->where('id', 3)->first();
        $section = DB::table('section')->where('page_id',3)->get();
        return view('contact', compact('page', 'section'));
    }

    public function creditview()
    {
        return view('creditview');
    }

    public function upload(){
        $file = public_path('assets/subcategories.csv');

    }


    public function invoice(){
        return view('order_invoice');
    }

    public function aboutUsSubmit(Request $request)
    {
        $data = [
            'fname' => $request->get('first_name'),
            'lname' => $request->get('last_name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'notes' => $request->get('notes')
        ];

        Inquiry::create($data);
        $data['extra_content'] = $request->get('extra_content');
        
        Mail::send('about-you', $data, function($message) use ($emails, $subject){
            $message->from(env('MAIL_USERNAME'), 'About Us Form');
            $message->to(HelperTrait::returnFlag(218))->subject($subject);
        });
        
        return response()->json(['message'=>'Thank you for your message', 'status' => true]);

    }

    public function careerSubmit(Request $request)
    {
        request()->validate([
            'cc' => 'required',
            'month' => 'required',
            'expr' => 'required',
            'amount' => 'required',
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
        $invoice = rand(0, 999999999999999);
        $neworder = new AnetAPI\OrderType();
        $neworder->setInvoiceNumber($invoice);
        $neworder->setDescription($request->order_notes);

        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType('individual');
        $customerData->setEmail($request->input('email'));

        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request->input('fname'));
        $customerAddress->setLastName($request->input('lname'));
        $customerAddress->setAddress($request->input('address'));
        $customerAddress->setCity($request->input('city'));
        $customerAddress->setZip($request->input('zip'));
        $customerAddress->setState($request->input('state'));
        $customerAddress->setCountry($request->input('country'));



        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType(
            'authCaptureTransaction'
        );
        $transactionRequestType->setAmount(
            number_format($request->input('amount'), 2, '.', '') . ''
        );
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->setOrder($neworder);
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
                    $inquiry = new Inquiry;
                    $inquiry->fname = $request->input('fname');
                    $inquiry->lname = $request->input('lname');
                    $inquiry->email = $request->input('email');
                    $inquiry->extra_content = $request->input('extra_content');
                    
                    $inquiry->form_name = 'Pay Online Form';
                    $inquiry->address = $request->input('address');
                    $inquiry->invoice =1;
                    $inquiry->country = $request->input('country');
                    $inquiry->city = $request->input('city');
                    $inquiry->state = $request->input('state');
                    $inquiry->zip = $request->input('zip');
                    $inquiry->amount = $request->input('amount');
                    $inquiry->trans_id =$tresponse->getTransId();
                    


                    $inquiry->save();

                    $data = array(
                            'fname'=>$request->fname,
                            'lname'=>$request->lname,
                        
                            'order_id'=>$inquiry->id,
                            'trans_id'=>$tresponse->getTransId(),
                            'address'=>$request->address. ', ' . $request->state . $request->zip . ', ' . $request->country,
                            'email'=>$request->email,
                            'notes'=>$request->extra_content,
                            'amount'=>$request->amount
            
                    );
                    Mail::send('invoice', $data, function($message) use ($emails, $subject){
                        $message->from(trim(config('services.mail.username')), 'Pay Online Form');
                        $message->to(trim(HelperTrait::returnFlag(218)))->subject($subject);
                    });
                    $emails = $request->email;
                    Mail::send('invoice', $data, function($message) use ($emails, $subject){
                        $message->from(config('services.mail.username'), 'Pay Online Form');
                        $message->to($emails)->subject($subject);
                    });
                
                 



                } 
                else {
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
                if(explode("-",$message_text)[2] == null)
                {
                    $message_text = $message_text;
                }
                else{
                    $message_text = explode("-",$message_text)[2];
                    
                }
     
    
                return response()->json(['message'=>$message_text, 'status' => false]);
            }
            else{
                return response()->json(['message'=>$message_text, 'status' => true]);

            }
        }

        else{
            
                return response()->json(['message'=>'Charge Credit Card Null response returned', 'status' => false]);

        }
        

    }

    public function newsletterSubmit(Request $request){

        $is_email = newsletter::where('newsletter_email',$request->newsletter_email)->count();
        if($is_email == 0) {
            $inquiry = new newsletter;
            $inquiry->newsletter_email = $request->newsletter_email;
            $inquiry->save();
            return response()->json(['message'=>'Thank you for contacting us. We will get back to you asap', 'status' => true]);

        }else{
            return response()->json(['message'=>'Email already exists', 'status' => false]);
        }

    }
    
    public function querysubmit(Request $request){
        
        inquiry::create($request->all());
        
        $data = array(
                'name' => $request->fname. ' ' .$request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'company'=> $request->last_company,
                'link' => $request->link,
                'form_name' => $request->form_name

        );
        
        $subject = 'Request for Product';
        Mail::send('product-request', $data, function($message) use ($emails, $subject){
            $message->from(trim(config('services.mail.username')), 'Request for Product');
            $message->to(trim(HelperTrait::returnFlag(218)))->subject($subject);
        });
        
        
        return response()->json(['message'=>'Thank you for contacting us. We will get back to you asap', 'status' => true]);
    }

    public function updateContent(Request $request){
        $id = $request->input('id');
        $keyword = $request->input('keyword');
        $htmlContent = $request->input('htmlContent');
        if($keyword == 'page'){
            $update = DB::table('pages')
                        ->where('id', $id)
                        ->update(array('content' => $htmlContent));

            if($update){
                return response()->json(['message'=>'Content Updated Successfully', 'status' => true]);
            }else{
                return response()->json(['message'=>'Error Occurred', 'status' => false]);
            }
        }else if($keyword == 'section'){
            $update = DB::table('section')
                        ->where('id', $id)
                        ->update(array('value' => $htmlContent));
            if($update){
                return response()->json(['message'=>'Content Updated Successfully', 'status' => true]);
            }else{
                return response()->json(['message'=>'Error Occurred', 'status' => false]);
            }
        }
    }

}
