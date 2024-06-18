<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\orders;
use App\orders_products;
use App\Product;
use App\imagetable;
use App\Attributes;
use App\Models\SubCategory;
use App\AttributeValue;
use App\ProductAttribute;
use Illuminate\Http\Request;
use Image;
use File;
use DB;
use Session;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */


    public function index(Request $request)
    {

        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            if (!empty($keyword)) {
                $product = Product::select(DB::raw('*'))
                ->where('products.product_title', 'LIKE', "%$keyword%")
                ->orWhere('products.sku', 'LIKE', "%$keyword%")
//				->leftjoin('categories', 'products.category', '=', 'categories.id')
//                ->orWhere('products.description', 'LIKE', "%$keyword%")->orWhere('products.sku', $keyword)->orWhere('products.item_number', $keyword)
                ->paginate(100);
            } else {
                $product = Product::paginate(100);
            }

            return view('admin.product.index', compact('product')); 
        }
        return response(view('403'), 403);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $subcategory = SubCategory::all();
            $att = Attributes::all();
            $attval = AttributeValue::all();

			// $items = Category::all(['id', 'name']);
			$items = Category::pluck('name', 'id');

            return view('admin.product.create', compact('items', 'att','attval','subcategory'));
        }
        return response(view('403'), 403);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


    	    //echo "<pre>";
    	    //print_r($_FILES);
    	    //return;
    
    		//dd($_FILES);
            $model = str_slug('product','-');
            if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
                $this->validate($request, [
    			'product_title' => 'required',
    			'description' => 'required',
    			'list_price' => 'required',
    			'image' => 'required',
    			'item_id' => 'required',
    		]);
		

		    //echo implode(",",$_POST['language']);
		    //return;
			$product = new product;

            $product->product_title = $request->input('product_title');
			$product->list_price = $request->input('list_price');
			$product->stand_price = $request->input('stand_price');

            $product->description = $request->input('description');
            $product->category = $request->input('item_id');
            $product->subcategory = $request->input('subcategory');


			$product->is_featured = $request->input('is_featured');
			$product->item_number = $request->input('item_number');
			$product->sku = $request->input('sku');
			$product->weight = $request->input('weight');
			$product->stock = $request->input('stock');
			$product->vendor = $request->input('vendor');
			$product->length = $request->input('length');
			$product->width = $request->input('width');
			$product->height = $request->input('height');



            $file = $request->file('image');

            //make sure yo have image folder inside your public
            $destination_path = 'uploads/products/';
            $profileImage = date("Ymdhis").".".$file->getClientOriginalExtension();

            Image::make($file)->save(public_path($destination_path) . DIRECTORY_SEPARATOR. $profileImage);

            $product->image = $destination_path.$profileImage;
            $product->save();


            if(! is_null(request('images'))) {

                $photos=request()->file('images');
                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/products/';

                    $filename = date("Ymdhis").uniqid().".".$photo->getClientOriginalExtension();
                    //dd($photo,$filename);
                    Image::make($photo)->save(public_path($destinationPath) . DIRECTORY_SEPARATOR. $filename);

                    DB::table('product_imagess')->insert([

                        ['image' => $destination_path.$filename, 'product_id' => $product->id]

                    ]);

                }

            }




            return redirect('admin/product')->with('message', 'Product added!');
        }
        return response(view('403'), 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $product = Product::findOrFail($id);
            return view('admin.product.show', compact('product'));
        }
        return response(view('403'), 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {



        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {

            $att = Attributes::all();
            $product = Product::findOrFail($id);
            $subcategory = SubCategory::all();


			$items = Category::pluck('name', 'id');

			$product_images = DB::table('product_imagess')
                          ->where('product_id', $id)
                          ->get();



            return view('admin.product.edit', compact('product','items','product_images','att','subcategory'));
        }
        return response(view('403'), 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $this->validate($request, [
			'product_title' => 'required',
			'description' => 'required',
			'item_id' => 'required'
		]);

        $requestData['product_title'] = $request->input('product_title');
        $requestData['description'] = $request->input('description');
		$requestData['sku'] = $request->input('sku');
		$requestData['list_price'] = $request->input('list_price');
		$requestData['stand_price'] = $request->input('stand_price');
		$requestData['category'] = $request->input('item_id');
        $requestData['is_featured'] = $request->input('is_featured');
        $requestData['subcategory'] = $request->input('subcategory');


        $requestData['item_number'] = $request->input('item_number');
        $requestData['sku'] = $request->input('sku');
        $requestData['weight'] = $request->input('weight');
        $requestData['stock'] = $request->input('stock');
        $requestData['vendor'] = $request->input('vendor');
        $requestData['width'] = $request->input('width');
        $requestData['height'] = $request->input('height');
        $requestData['length'] = $request->input('length');



        // dump($request->input());
        // die();
    /*Insert your data*/

    // Detail::insert( [
        // 'images'=>  implode("|",$images),
    // ]);

        if ($request->hasFile('image')) {

			$product = product::where('id', $id)->first();
			$image_path = public_path($product->image);

			if(File::exists($image_path)) {

				File::delete($image_path);
			}

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/products/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

			$requestData['image'] = 'uploads/products/'.$fileNameToStore;
        }

            if(! is_null(request('images'))) {

                $photos=request()->file('images');
                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/products/';

                    $filename = date("Ymdhis").uniqid().".".$photo->getClientOriginalExtension();
                    //dd($photo,$filename);
                    Image::make($photo)->save(public_path($destinationPath) . DIRECTORY_SEPARATOR. $filename);

                    $product = product::where('id', $id)->first();

                    DB::table('product_imagess')->insert([

                        ['image' => $destinationPath.$filename, 'product_id' => $product->id]

                    ]);

                }

            }

        product::where('id', $id)
                ->update($requestData);



         
        if(! is_null(request('images')) && $request->hasFile('images')) {


                DB::table('product_imagess')->where('product_id', '=', $id)->delete();
            
            
                
                $photos=request()->file('images');

                
            
                foreach ($photos as $photo) {
                    $destinationPath = 'uploads/products/';

                    $fileName = uniqid() . "_" . $photo->getClientOriginalName();
                    $photo->move(storage_path($destinationPath), $fileName);


                    DB::table('product_imagess')->insert([

                        ['image' => $destinationPath.$filename, 'product_id' => $product->id]

                    ]);

                }

        }
        


             return redirect()->back()->with('message', 'Product updated!');
        }
        return response(view('403'), 403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $model = str_slug('product','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Product::destroy($id);

            return redirect('admin/product')->with('flash_message', 'Product deleted!');
        }
        return response(view('403'), 403);

    }
	public function orderList() {

		$orders = orders::
				    select('orders.*')
				   ->get();

		return view('admin.ecommerce.order-list', compact('orders'));
	}

	public function orderListDetail($id) {

		$order_id = $id;
		$order = orders::where('id',$order_id)->first();
		$order_products = orders_products::where('orders_id',$order_id)->get();



		return view('admin.ecommerce.order-page')->with('title','Invoice #'.$order_id)->with(compact('order','order_products'))->with('order_id',$order_id);

		// return view('admin.ecommerce.order-page');
	}

	public function updatestatuscompleted($id) {

		$order_id = $id;
		$order = DB::table('orders')
              ->where('id', $id)
              ->update(['order_status' => 'Completed']);


		Session::flash('message', 'Order Status Updated Successfully');
						Session::flash('alert-class', 'alert-success');
						return back();

	}
	public function updatestatusPending($id) {

		$order_id = $id;
		$order = DB::table('orders')
              ->where('id', $id)
              ->update(['order_status' => 'Pending']);


		Session::flash('message', 'Order Status Updated Successfully');
						Session::flash('alert-class', 'alert-success');
						return back();

	}

}
