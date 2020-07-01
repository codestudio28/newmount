<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Barangay;
use App\User;
class BarangayController extends Controller
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
              $barangays = Barangay::where('status','ACTIVE')->get();
        // return $barangays;
        return view('barangay.index')->with('barangays',$barangays);
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
               return view('barangay.create');
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
            'barangay_logo'=>'image|required|max:1999',
            'barangay_name'=>'required',
            'barangay_firstname'=>'required',
            'barangay_middlename'=>'required',
            'barangay_lastname'=>'required'
        ]);
        
      

        $barangay=Barangay::all();
        if(count($barangay)>0){
              $barangayname = Barangay::where('barangay_name',$request->input('barangay_name'))->get();
              if(count($barangayname)>0){
                return redirect('/admin-barangay/create')->with('error','Barangay already in the system');
              }

             $barangayemail = Barangay::where('email',$request->input('email'))->get();
            
              if(count($barangayemail)>0){
                return redirect('/admin-barangay/create')->with('error','Barangay email already is already taken.');
              }

               $barangayname = Barangay::where('barangay_firstname',$request->input('barangay_firstname'))
                    ->where('barangay_middlename',$request->input('barangay_middlename'))
                    ->where('barangay_lastname',$request->input('barangay_lastname'))
                    ->get();
              if(count($barangayname)>0){
                return redirect('/admin-barangay/create')->with('error','Barangay captain already in the system');
              }
        }

        $user=User::all();
       if(count($user)>0){
            $useremail = User::where('email',$request->input('email'))->get();
              if(count($useremail)>0){
                return redirect('/admin-barangay/create')->with('error','Barangay email already is already taken.');
              }else{

              }
       }
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $password= implode($pass); //turn the array into a string
        



        // handle file upload
        $filenameWithExt=$request->file('barangay_logo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('barangay_logo')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->barangay_logo->move(public_path('barangay_logo'), $fileNameToStore);
      
        // $path = $request->file('barangay_logo')->storeAs('public/barangay_logo',$fileNameToStore); 
        // Save data

        $status="ACTIVE";
        $barangay = new Barangay;
        $barangay->barangay_name = $request->input('barangay_name');
        $barangay->email = $request->input('email');
        $barangay->barangay_logo = $fileNameToStore;
        $barangay->barangay_firstname = $request->input('barangay_firstname');
        $barangay->barangay_middlename = $request->input('barangay_middlename');
        $barangay->barangay_lastname = $request->input('barangay_lastname');
        $barangay->status = $status;
        $barangay->save();

        $user = new User;
        $usertype="barangay";
        $user->email = $request->input('email');
        $user->firstname = $request->input('barangay_firstname');
        $user->middlename = $request->input('barangay_middlename');
        $user->lastname = $request->input('barangay_lastname');
        $user->profile = $fileNameToStore;
        $user->usertype = $usertype;
        $user->password = $password;
        $user->status = $status;
        $user->save();
        return redirect('/admin-barangay')->with('success','New barangay successfully added');
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
               $barangay = Barangay::find($id);
         return view('barangay.edit')->with('barangay',$barangay);
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
            'barangay_logo'=>'image|max:1999',
            'barangay_name'=>'required',
            'barangay_firstname'=>'required',
            'barangay_middlename'=>'required',
            'barangay_lastname'=>'required'
        ]);

        $barangay=Barangay::all();
        if(count($barangay)>0){
              $barangayname = Barangay::where('barangay_name',$request->input('barangay_name'))->get();
              if(count($barangayname)>0){
                 $barangayid = Barangay::where('id',$id)->where('barangay_name',$request->input('barangay_name'))->get();
                 if(count($barangayid)>0){

                 }else{
                    return redirect('/admin-barangay/'.$id.'/edit')->with('error','Barangay already in the system');
                 }
              }

            $barangayemail = Barangay::where('email',$request->input('email'))->get();
            
                if(count($barangayemail)>0){
                 $barangayid = Barangay::where('id',$id)->where('email',$request->input('email'))->get();
                     if(count($barangayid)>0){

                     }else{
                         return redirect('/admin-barangay/'.$id.'/edit')->with('error','Email already in the system');
                     }
                 }   
               $barangayname = Barangay::where('barangay_firstname',$request->input('barangay_firstname'))
                    ->where('barangay_middlename',$request->input('barangay_middlename'))
                    ->where('barangay_lastname',$request->input('barangay_lastname'))
                    ->get();
                if(count($barangayname)>0){
                    $barangayid = Barangay::where('id',$id)->where('barangay_firstname',$request->input('barangay_firstname'))
                    ->where('barangay_middlename',$request->input('barangay_middlename'))
                    ->where('barangay_lastname',$request->input('barangay_lastname'))->get();
                     if(count($barangayid)>0){

                     }else{
                         return redirect('/admin-barangay/'.$id.'/edit')->with('error','Chairman is already in the system');
                     }
                 }
        
        }
       
        if($request->hasFile('barangay_logo')){
             $filenameWithExt=$request->file('barangay_logo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('barangay_logo')->getClientOriginalExtension();
            $fileNameToStore =$filename.'_'.time().'.'.$extension;
            $request->barangay_logo->move(public_path('barangay_logo'), $fileNameToStore);
            // $path = $request->file('barangay_logo')->storeAs('public/barangay_logo',$fileNameToStore); 
        }
       
        $barangay = Barangay::find($id);
        $barangay->barangay_name = $request->input('barangay_name');
        $barangay->email = $request->input('email');
         if($request->hasFile('barangay_logo')){
             $barangay->barangay_logo = $fileNameToStore;    
         }
       
        $barangay->barangay_firstname = $request->input('barangay_firstname');
        $barangay->barangay_middlename = $request->input('barangay_middlename');
        $barangay->barangay_lastname = $request->input('barangay_lastname');
        $barangay->save();
        return redirect('/admin-barangay')->with('success','Barangay information successfully updated ');
    }
  
    // public function status(Request $request, $id)
    // {
    //          $barangay = Barangay::find($id);
    //          return $barangay;
    // }

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
