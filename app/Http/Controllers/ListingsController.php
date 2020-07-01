<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Listings;
use App\PropertyType;
class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
            $listings = Listings::all();

          return view('listings.index')->with('listings',$listings);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
            $proptypes = PropertyType::where('status','ACTIVE')->get();
          return view('listings.create')->with('proptypes',$proptypes);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $this->validate($request,[
            'name'=>'required',
            'proptype'=>'required',
            'area'=>'required',
            'bed'=>'required',
            'garage'=>'required',
            'bath'=>'required',
            'description'=>'required',
            'listings_photo'=>'image|required|max:1999'
        ]);

        $filenameWithExt=$request->file('listings_photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('listings_photo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->listings_photo->move(public_path('listings_photo'),$fileNameToStore);

        $status="DRAFT";
        $listings = new Listings;
        $listings->name = $request->input('name');
        $listings->proptype_id = $request->input('proptype');
        $listings->area = $request->input('area');
        $listings->bed = $request->input('bed');
        $listings->bath =  $request->input('bath');
        $listings->garage = $request->input('garage');
        $listings->description = $request->input('description');
        $listings->listings_photo = $fileNameToStore;
        $listings->status = $status;
        $listings->save();
        return redirect('/admin-listings')->with('success','New listings successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
            $proptypes = PropertyType::where('status','ACTIVE')->get();
            $listing = Listings::find($id);
          return view('listings.edit')->with('proptypes',$proptypes)->with('listing',$listing);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request,[
            'name'=>'required',
            'proptype'=>'required',
            'area'=>'required',
            'bed'=>'required',
            'garage'=>'required',
            'bath'=>'required',
            'description'=>'required',
            'listings_photo'=>'image|max:1999'
        ]);
          if($request->hasFile('listings_photo')){
        $filenameWithExt=$request->file('listings_photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('listings_photo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->listings_photo->move(public_path('listings_photo'),$fileNameToStore);
        }
       
        $listings = Listings::find($id);
        $listings->name = $request->input('name');
        $listings->proptype_id = $request->input('proptype');
        $listings->area = $request->input('area');
        $listings->bed = $request->input('bed');
        $listings->bath =  $request->input('bath');
        $listings->garage = $request->input('garage');
        $listings->description = $request->input('description');
        if($request->hasFile('listings_photo')){
        $listings->listings_photo = $fileNameToStore;
        }
        $listings->save();
        return redirect('/admin-listings')->with('success','Listings successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
