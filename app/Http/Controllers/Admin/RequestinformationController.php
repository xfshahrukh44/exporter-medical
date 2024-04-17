<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Requestinformation;
use Illuminate\Http\Request;
use Image;
use File;

class RequestinformationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $requestinformation = Requestinformation::where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('how_can_we_help_you', 'LIKE', "%$keyword%")
                ->orWhere('questions', 'LIKE', "%$keyword%")
                ->paginate($perPage);
            } else {
                $requestinformation = Requestinformation::paginate($perPage);
            }

            return view('requestinformation.requestinformation.index', compact('requestinformation'));
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            return view('requestinformation.requestinformation.create');
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','add-'.$model)->first()!= null) {
            $this->validate($request, [
			'first_name' => 'required',
			'last_name' => 'required',
			'phone' => 'required',
			'email' => 'required',
			'questions' => 'required'
		]);

            $requestinformation = new Requestinformation($request->all());

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                
                //make sure yo have image folder inside your public
                $requestinformation_path = 'uploads/requestinformations/';
                $fileName = $file->getClientOriginalName();
                $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

                Image::make($file)->save(public_path($requestinformation_path) . DIRECTORY_SEPARATOR. $profileImage);

                $requestinformation->image = $requestinformation_path.$profileImage;
            }
            
            $requestinformation->save();
            return redirect()->back()->with('message', 'Requestinformation added!');
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','view-'.$model)->first()!= null) {
            $requestinformation = Requestinformation::findOrFail($id);
            return view('requestinformation.requestinformation.show', compact('requestinformation'));
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $requestinformation = Requestinformation::findOrFail($id);
            return view('requestinformation.requestinformation.edit', compact('requestinformation'));
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','edit-'.$model)->first()!= null) {
            $this->validate($request, [
			'first_name' => 'required',
			'last_name' => 'required',
			'phone' => 'required',
			'email' => 'required',
			'questions' => 'required'
		]);
            $requestData = $request->all();
            

        if ($request->hasFile('image')) {
            
            $requestinformation = Requestinformation::where('id', $id)->first();
            $image_path = public_path($requestinformation->image); 
            
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/requestinformations/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/requestinformations/'.$fileNameToStore;               
        }


            $requestinformation = Requestinformation::findOrFail($id);
            $requestinformation->update($requestData);
            return redirect()->back()->with('message', 'Requestinformation updated!');
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
        $model = str_slug('requestinformation','-');
        if(auth()->user()->permissions()->where('name','=','delete-'.$model)->first()!= null) {
            Requestinformation::destroy($id);
            return redirect()->back()->with('message', 'Requestinformation deleted!');
        }
        return response(view('403'), 403);

    }
}
