<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\About;
class AboutController extends Controller
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
              $about = About::all();
            if(count($about)>0){
                return view('admin_about.index')->with('about',$about);
            }else{
                return view('admin_about.index')->with('about',$about);    
            }
           
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aboutss = About::all();

         if(count($aboutss)>0){
              $this->validate($request,[
            'content'=>'required',
            'about_photo'=>'image|max:1999',
            'about_banner'=>'image|max:1999'
            ]);

            if($request->hasFile('about_photo')){
            $filenameWithExt=$request->file('about_photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('about_photo')->getClientOriginalExtension();
            $fileNameToStore =$filename.'_'.time().'.'.$extension;
            $request->about_photo->move(public_path('about_photo'),$fileNameToStore);
            }

            if($request->hasFile('about_banner')){
            $filenameWithExt=$request->file('about_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('about_banner')->getClientOriginalExtension();
            $fileNameToStores =$filename.'_'.time().'.'.$extension;
            $request->about_banner->move(public_path('about_photo'),$fileNameToStores);
            }
            $abouts = About::first();
            $aboutid =$abouts->id;
            $about = About::find($aboutid);
            $about->content= $request->input('content');
            if($request->hasFile('about_photo')){
            $about->banner = $fileNameToStore;
            }
             if($request->hasFile('about_banner')){
            $about->headbanner = $fileNameToStores;
            }
            $about->save();

         }else{
            $this->validate($request,[
            'content'=>'required',
            'about_photo'=>'image|required|max:1999',
             'about_banner'=>'image|required|max:1999'
            ]);

             $filenameWithExt=$request->file('about_photo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('about_photo')->getClientOriginalExtension();
            $fileNameToStore =$filename.'_'.time().'.'.$extension;
            $request->about_photo->move(public_path('about_photo'),$fileNameToStore);

             $filenameWithExt=$request->file('about_banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('about_banner')->getClientOriginalExtension();
            $fileNameToStores =$filename.'_'.time().'.'.$extension;
            $request->about_banner->move(public_path('about_photo'),$fileNameToStores);

            $about = new About;
            $about->content= $request->input('content');
            $about->banner = $fileNameToStore;
            $about->headbanner = $fileNameToStores;
            $about->save();
         }
      
         return redirect('/admin-about')->with('success','Successfully update about information.');
       

      
     
      

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
        //
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
        //
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
