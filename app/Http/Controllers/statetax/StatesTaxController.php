<?php

namespace App\Http\Controllers\statetax;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\StatesTax;
use Illuminate\Http\Request;
use Image;
use File;

class StatesTaxController extends Controller
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
        $keyword = $request->get('search');
        $perPage = 25;
        if (!empty($keyword)) {
            $statestax = StatesTax::where('name', 'LIKE', "%$keyword%")
            ->orWhere('code', 'LIKE', "%$keyword%")
            ->orWhere('tax', 'LIKE', "%$keyword%")
            ->all();
        } else {
            $statestax = StatesTax::all();
        }
        return view('statetax.states-tax.index', compact('statestax'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('statetax.states-tax.create');
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
        $statestax = new StatesTax($request->all());

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            
            //make sure yo have image folder inside your public
            $statestax_path = 'uploads/statestaxs/';
            $fileName = $file->getClientOriginalName();
            $profileImage = date("Ymd").$fileName.".".$file->getClientOriginalExtension();

            Image::make($file)->save(public_path($statestax_path) . DIRECTORY_SEPARATOR. $profileImage);

            $statestax->image = $statestax_path.$profileImage;
        }
        
        $statestax->save();
        return redirect()->back()->with('message', 'StatesTax added!');
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
        $statestax = StatesTax::findOrFail($id);
        return view('statetax.states-tax.show', compact('statestax'));
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
        $statestax = StatesTax::findOrFail($id);
        return view('statetax.states-tax.edit', compact('statestax'));
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
        $requestData = $request->all();    
        if ($request->hasFile('image')) {
            $statestax = StatesTax::where('id', $id)->first();
            $image_path = public_path($statestax->image); 
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $file = $request->file('image');
            $fileNameExt = $request->file('image')->getClientOriginalName();
            $fileNameForm = str_replace(' ', '_', $fileNameExt);
            $fileName = pathinfo($fileNameForm, PATHINFO_FILENAME);
            $fileExt = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            $pathToStore = public_path('uploads/statestaxs/');
            Image::make($file)->save($pathToStore . DIRECTORY_SEPARATOR. $fileNameToStore);

             $requestData['image'] = 'uploads/statestaxs/'.$fileNameToStore;               
        }
        $statestax = StatesTax::findOrFail($id);
        $statestax->update($requestData);
        return redirect()->back()->with('message', 'StatesTax updated!');
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
        StatesTax::destroy($id);
        return redirect()->back()->with('message', 'StatesTax deleted!');
    }
}
