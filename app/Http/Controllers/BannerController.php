<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banner;
class BannerController extends Controller
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
            $banners = Banner::all();

          return view('banner.index')->with('banners',$banners);
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
          
          return view('banner.create');
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
            'title'=>'required',
            'banner_photo'=>'image|required|max:1999',
        ]);

        $filenameWithExt=$request->file('banner_photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('banner_photo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->banner_photo->move(public_path('banner_photo'),$fileNameToStore);
        $status="DRAFT";
        $banner = new Banner;
        $banner->title = $request->input('title');
        $banner->cover_photo = $fileNameToStore;
        $banner->status = $status;
        $banner->save();
         return redirect('/admin-banner')->with('success','New banner successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $banner = Banner::find($id);

          return view('banner.edit')->with('banner',$banner);
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
            'title'=>'required',
            'banner_photo'=>'image|max:1999',
        ]);

        if($request->hasFile('banner_photo')){
        $filenameWithExt=$request->file('banner_photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('banner_photo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->banner_photo->move(public_path('banner_photo'),$fileNameToStore);
        }
        $banner = Banner::find($id);
        $banner->title = $request->input('title');
         if($request->hasFile('banner_photo')){
        $banner->cover_photo = $fileNameToStore;
        }
        $banner->save();
         return redirect('/admin-banner')->with('success','Banner successfully updated.');
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
