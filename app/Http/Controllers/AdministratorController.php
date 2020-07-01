<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Admin;
class AdministratorController extends Controller
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
            $admins = Admin::where('usertype','admin')->where('status','ACTIVE')->get();

        return view('administrator.index')->with('admins',$admins);
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
             return view('administrator.create');
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
            'email'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'lastname'=>'required'
        ]);

        $admin=Admin::all();
         if(count($admin)>0){
             $useremail = Admin::where('email',$request->input('email'))->get();
             if(count($useremail)>0){
                 return redirect('/admin/create')->with('error','Email already taken.');
             }else{

             }
             $adminname = Admin::where('firstname',$request->input('firstname'))->where('middlename',$request->input('middlename'))->where('lastname',$request->input('lastname'))->get();
             if(count($adminname)>0){
                 return redirect('/admin/create')->with('error','This user is already an administrator.');
             }else{

             }
         }

        $password="1234567";
        $usertype="admin";
        $status="ACTIVE";
        $admin = new Admin;
        $admin->email = $request->input('email');
        $admin->firstname = $request->input('firstname');
        $admin->middlename = $request->input('middlename');
        $admin->lastname = $request->input('lastname');
        $admin->password = md5($password);
        $admin->usertype = $usertype;
        $admin->profile = "avatar.png";
        $admin->status = $status;
        $admin->save();
        return redirect('/admin')->with('success','New administrator successfully added');
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
             $admin = Admin::find($id);
         return view('administrator.edit')->with('admin',$admin);
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
            'email'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'lastname'=>'required'
        ]);

        $admin=Admin::all();
         if(count($admin)>0){
             $useremail = Admin::where('email',$request->input('email'))->get();
             if(count($useremail)>0){
                 $useremailid = Admin::where('email',$request->input('email'))->where('id',$id)->get();
                 if(count($useremailid)>0){

                 }else{
                    $path="/admin/".$id."/edit";
                    return redirect($path)->with('error','Email already taken.');
                 }
                 
             }else{

             }
             $adminname = Admin::where('firstname',$request->input('firstname'))->where('middlename',$request->input('middlename'))->where('lastname',$request->input('lastname'))->get();
             if(count($adminname)>0){
                      $adminnameid = Admin::where('firstname',$request->input('firstname'))->where('middlename',$request->input('middlename'))->where('lastname',$request->input('lastname'))->where('id',$id)->get();
                       if(count($adminnameid)>0){

                       }else{
                             return redirect('/admin/')->with('error','This user is already an administrator.');
                       }
                
             }else{

             }
         }

      
        $admin = Admin::find($id);
        $admin->email = $request->input('email');
        $admin->firstname = $request->input('firstname');
        $admin->middlename = $request->input('middlename');
        $admin->lastname = $request->input('lastname');
        $admin->save();
        return redirect('/admin')->with('success','Administrator information successfully updated');
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
