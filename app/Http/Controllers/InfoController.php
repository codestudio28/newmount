<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Admin;
class InfoController extends Controller
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
           
            
             return view('admin_info.index');
            
           
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
        //
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
        if($request->input('process')=="INFO"){
               $this->validate($request,[
            'firstname'=>'required',
            'middlename'=>'required',
            'lastname'=>'required',
            'personal_photo'=>'image|max:1999'
        ]);

        $getadmin = Admin::where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
        if(count($getadmin)>0){
             $getadminid = Admin::where('id',$id)->where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
             if(count($getadminid)<=0){
                  return redirect('/admin-info')->with('error','Your info has duplicate entry to the system.');
             }
        }

        if($request->hasFile('personal_photo')){
        $filenameWithExt=$request->file('personal_photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('personal_photo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->personal_photo->move(public_path('avatar'),$fileNameToStore);
        }

        $admin = Admin::find($id);
        $admin->firstname=$request->input('firstname');
        $admin->middlename==$request->input('middlename');
        $admin->lastname==$request->input('lastname');
        if($request->hasFile('personal_photo')){
            $admin->profile=$fileNameToStore;
        }
        $admin->save();

        $admin = Admin::where('id',$id)->get();
        $request->session()->put('Data',$admin);
        return redirect('/admin-info')->with('success','You successfully update your information.');
        }else{
             $this->validate($request,[
            'oldpassword'=>'required',
            'newpassword'=>'required',
            ]);
            $oldpassword=$request->input('oldpassword');
            $newpassword=$request->input('newpassword');
             $admin = Admin::find($id);
             $oldpass = $admin->password;

             if($oldpass==md5($oldpassword)){
                $admin = Admin::find($id);
                $admin->password=md5($newpassword);
                $admin->save();
                return redirect('/admin-info')->with('success','You successfully update your password.');
             }else{
                 return redirect('/admin-info')->with('error','Wrong password.');
             }


        }
     

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
