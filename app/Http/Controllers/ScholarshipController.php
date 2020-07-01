<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Scholarship;
use App\UserInfo;
use App\TugonInfo;
use App\Barangay;
use App\SchoolYear;
class ScholarshipController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // $userinfo = new UserInfo;
        // $userinfo = UserInfo::select('id')->where('firstname','Jerwin')->where('middlename','Pinangang')->where('lastname','Cruz')->get();
        // $userinfo = UserInfo::first();
        // return $userinfo->scholarships;
      
        // return $userinfo->scholarship;
            // return view('scholarship.index');
        // return view('scholarship.index',compact('userinfo'));
        // return $userinfo;
         if(strlen(session('Data'))<=0){
            return redirect('/');
        }else{
                  $userinfo=UserInfo::all();
         return view('scholarship.index')->with('users',$userinfo);
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
                  $barangays=Barangay::all();
        $school_years = SchoolYear::where('status','OPEN')->get();
        // return $school_years;
         return view('scholarship.create')->with('barangays',$barangays)->with('school_years',$school_years);
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
            'profile_picture'=>'image|required|max:1999',
            'schoolyear'=>'required',
            'scholars'=>'required',
            'contact'=>'required',
            'address'=>'required',
            'barangay'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'lastname'=>'required',
            'birthday'=>'required',
            'birthplace'=>'required',
            'gender'=>'required',
            'civil'=>'required',
            'ffirstname'=>'required',
            'fmiddlename'=>'required',
            'flastname'=>'required',
            'foccupation'=>'required',
            'mfirstname'=>'required',
            'mmiddlename'=>'required',
            'mlastname'=>'required',
            'schoollast'=>'required',
            'schoollastaddress'=>'required',
            'lastgradelevel'=>'required',
            'gwa'=>'required',
            'school'=>'required',
            'schooladdress'=>'required',
            'gradelevel'=>'required',
        ]);

         // Create user
        $userinfo=UserInfo::all();
        if(count($userinfo)>0){
              $userinfo = UserInfo::where('firstname',$request->input('firstname'))
         ->where('middlename',$request->input('middlename'))
         ->where('lastname',$request->input('lastname'))->get();

        $mother = UserInfo::where('mfirstname',$request->input('mfirstname'))
         ->where('mmiddlename',$request->input('mmiddlename'))
         ->where('mlastname',$request->input('mlastname'))->get();

         $father = UserInfo::where('ffirstname',$request->input('ffirstname'))
         ->where('fmiddlename',$request->input('fmiddlename'))
         ->where('flastname',$request->input('flastname'))->get();

         $emails = UserInfo::where('email_address',$request->input('email'))->get();

         if(count($userinfo)>0){
               return redirect('/tugon/create')->with('error','Applicant already exist');
         }
         if(count($emails)>0){
               return redirect('/tugon/create')->with('error','Email already exist');
         }
         if(count($mother)>0){
            $userid = $mother[0]->id;
            $scholars = Scholarship::where('user_id',$userid)->get();
            $scholars_status = $scholars[0]->status;
            if($scholars_status=="NEW APPLICANT"){
                 return redirect('/tugon/create')->with('error','Mother of the applicant has child that already an applicant.');
            }if($scholars_status=="SCHOLARS"){
                 return redirect('/tugon/create')->with('error','Mother of the applicant has child that already has a financial assistance.');
            }if($scholars_status=="INTERVIEW"){
                  return redirect('/tugon/create')->with('error','Mother of the applicant has child that already an applicant.');
            }if($scholars_status=="ASSESSMENT"){
                  return redirect('/tugon/create')->with('error','Mother of the applicant has child that already an applicant.');
            }
              
            
         }
        

         if(count($father)>0){
            $userid = $father[0]->id;
            $scholars = Scholarship::where('user_id',$userid)->get();
            $scholars_status = $scholars[0]->status;
            if($scholars_status=="NEW APPLICANT"){
                 return redirect('/tugon/create')->with('error','Father of the applicant has child that already an applicant.');
            }if($scholars_status=="SCHOLARS"){
                 return redirect('/tugon/create')->with('error','Father of the applicant has child that already has a financial assistance.');
            }if($scholars_status=="INTERVIEW"){
                  return redirect('/tugon/create')->with('error','Father of the applicant has child that already an applicant.');
            }if($scholars_status=="ASSESSMENT"){
                  return redirect('/tugon/create')->with('error','Father of the applicant has child that already an applicant.');
            }
              
            
         }
            
        }
      
         $filenameWithExt=$request->file('profile_picture')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('profile_picture')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->profile_picture->move(public_path('profile_picture'),$fileNameToStore);



        $userinfo = new UserInfo;
        $userinfo->firstname = $request->input('firstname');
        $userinfo->middlename = $request->input('middlename');
        $userinfo->lastname = $request->input('lastname');
        $userinfo->email_address = $request->input('email');
        $userinfo->profile = $fileNameToStore;
        $userinfo->address1 = $request->input('address');
        $userinfo->contactnumber = $request->input('contact');
        $userinfo->barangay_id = $request->input('barangay');
        $userinfo->birthday = $request->input('birthday');
        $userinfo->birthplace = $request->input('birthplace');
        $userinfo->civil = $request->input('civil');
        $userinfo->gender = $request->input('gender');
        $userinfo->ffirstname = $request->input('ffirstname');
        $userinfo->fmiddlename = $request->input('fmiddlename');
        $userinfo->flastname = $request->input('flastname');
        $userinfo->mfirstname = $request->input('mfirstname');
        $userinfo->mmiddlename = $request->input('mmiddlename');
        $userinfo->mlastname = $request->input('mlastname');
        $userinfo->foccupation = $request->input('foccupation');
        $userinfo->moccupation = $request->input('moccupation');
        $userinfo->save();

        $userinfo = new UserInfo;
        $userinfo = UserInfo::select('id')
        ->where('firstname',$request->input('firstname'))
        ->where('middlename',$request->input('middlename'))
        ->where('lastname',$request->input('lastname'))->get();
        $id = $userinfo[0]->id;

      

        $status="NEW APPLICANT";
        $scholars = new Scholarship;
        $scholars->user_id = $id;
         $scholars->school_year_id=$request->input('schoolyear');
        $scholars->scholartype=$request->input('scholars');
        $scholars->school_last=$request->input('schoollast');
        $scholars->school_last_address=$request->input('schoollastaddress');
        $scholars->grade_level_last=$request->input('lastgradelevel');
        $scholars->school=$request->input('school');
        $scholars->school_address=$request->input('schooladdress');
        $scholars->grade_level=$request->input('gradelevel');
        $scholars->gwa=$request->input('gwa');
        $scholars->status=$status;
        $scholars->save();

        return redirect('/tugon')->with('success','New tugon applicant successfully added');
    
       
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
                   $barangays=Barangay::all();
        $school_years = SchoolYear::where('status','OPEN')->get();
         $user = UserInfo::find($id);
         return view('scholarship.edit')->with('user',$user)->with('barangays',$barangays)->with('school_years',$school_years);
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
            'profile_picture'=>'image|max:1999',
            'schoolyear'=>'required',
            'scholars'=>'required',
            'contact'=>'required',
            'address'=>'required',
            'barangay'=>'required',
            'firstname'=>'required',
            'middlename'=>'required',
            'lastname'=>'required',
            'birthday'=>'required',
            'birthplace'=>'required',
            'gender'=>'required',
            'civil'=>'required',
            'ffirstname'=>'required',
            'fmiddlename'=>'required',
            'flastname'=>'required',
            'foccupation'=>'required',
            'mfirstname'=>'required',
            'mmiddlename'=>'required',
            'mlastname'=>'required',
            'schoollast'=>'required',
            'schoollastaddress'=>'required',
            'lastgradelevel'=>'required',
            'gwa'=>'required',
            'school'=>'required',
            'schooladdress'=>'required',
            'gradelevel'=>'required',
        ]);

         // Create user
        $userinfo=UserInfo::all();
        if(count($userinfo)>0){
              $userinfo = UserInfo::where('firstname',$request->input('firstname'))
         ->where('middlename',$request->input('middlename'))
         ->where('lastname',$request->input('lastname'))->get();

        $mother = UserInfo::where('mfirstname',$request->input('mfirstname'))
         ->where('mmiddlename',$request->input('mmiddlename'))
         ->where('mlastname',$request->input('mlastname'))->get();

         $father = UserInfo::where('ffirstname',$request->input('ffirstname'))
         ->where('fmiddlename',$request->input('fmiddlename'))
         ->where('flastname',$request->input('flastname'))->get();

         $emails = UserInfo::where('email_address',$request->input('email'))->get();

         if(count($userinfo)>0){
                 $userinfo_id = UserInfo::where('id',$id)->where('firstname',$request->input('firstname'))
                 ->where('middlename',$request->input('middlename'))
                 ->where('lastname',$request->input('lastname'))->get();
                if(count($userinfo_id)>0){

                }else{
                       return redirect('/tugon/'.$id.'/edit')->with('error','Applicant already exist');
                }
            
         }
         if(count($emails)>0){
                $emails_id = UserInfo::where('id',$id)->where('email_address',$request->input('email'))->get();
                if(count($emails_id)>0){

                }else{
                     return redirect('/tugon/'.$id.'/edit')->with('error','Email already exist');
                }
              
         }
         if(count($mother)>0){
             $mother_id = UserInfo::where('id',$id)->where('mfirstname',$request->input('mfirstname'))
             ->where('mmiddlename',$request->input('mmiddlename'))
             ->where('mlastname',$request->input('mlastname'))->get();
             if(count($mother)>0){

             }else{
                 $userid = $mother[0]->id;
                $scholars = Scholarship::where('user_id',$userid)->get();
                $scholars_status = $scholars[0]->status;
                if($scholars_status=="NEW APPLICANT"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
                }if($scholars_status=="SCHOLARS"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Mother of the applicant has child that already has a financial assistance.');
                }if($scholars_status=="INTERVIEW"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
                }if($scholars_status=="ASSESSMENT"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
                }
             }
           
              
            
         }
        

         if(count($father)>0){
             $father_id = UserInfo::where('id',$id)->where('ffirstname',$request->input('ffirstname'))
             ->where('fmiddlename',$request->input('fmiddlename'))
             ->where('flastname',$request->input('flastname'))->get();
              if(count($father_id)>0){

              }else{
                  $userid = $father[0]->id;
                $scholars = Scholarship::where('user_id',$userid)->get();
                $scholars_status = $scholars[0]->status;
                if($scholars_status=="NEW APPLICANT"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
                }if($scholars_status=="SCHOLARS"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Father of the applicant has child that already has a financial assistance.');
                }if($scholars_status=="INTERVIEW"){
                      return redirect('/tugon/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
                }if($scholars_status=="ASSESSMENT"){
                     return redirect('/tugon/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
                }
              }
          
              
            
         }
            
        }
      
      if($request->hasFile('profile_picture')){
         $filenameWithExt=$request->file('profile_picture')->getClientOriginalName();
      
        $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension = $request->file('profile_picture')->getClientOriginalExtension();
        $fileNameToStore =$filename.'_'.time().'.'.$extension;
        $request->profile_picture->move(public_path('profile_picture'),$fileNameToStore);
       }


        $userinfo = UserInfo::find($id);
        $userinfo->firstname = $request->input('firstname');
        $userinfo->middlename = $request->input('middlename');
        $userinfo->lastname = $request->input('lastname');
        $userinfo->email_address = $request->input('email');
        if($request->hasFile('profile_picture')){
            $userinfo->profile = $fileNameToStore;
        }
        $userinfo->address1 = $request->input('address');
        $userinfo->contactnumber = $request->input('contact');
        $userinfo->barangay_id = $request->input('barangay');
        $userinfo->birthday = $request->input('birthday');
        $userinfo->birthplace = $request->input('birthplace');
        $userinfo->civil = $request->input('civil');
        $userinfo->gender = $request->input('gender');
        $userinfo->ffirstname = $request->input('ffirstname');
        $userinfo->fmiddlename = $request->input('fmiddlename');
        $userinfo->flastname = $request->input('flastname');
        $userinfo->mfirstname = $request->input('mfirstname');
        $userinfo->mmiddlename = $request->input('mmiddlename');
        $userinfo->mlastname = $request->input('mlastname');
        $userinfo->foccupation = $request->input('foccupation');
        $userinfo->moccupation = $request->input('moccupation');
        $userinfo->save();

        // $userinfo = UserInfo::select('id')
        // ->where('firstname',$request->input('firstname'))
        // ->where('middlename',$request->input('middlename'))
        // ->where('lastname',$request->input('lastname'))->get();
        // $id = $userinfo[0]->id;
     
        $scholars = Scholarship::where('user_id',$id)->get();
        $scholar_id = $scholars[0]->id;
        $scholars = Scholarship::find($scholar_id);
        $scholars->school_year_id=$request->input('schoolyear');
        $scholars->scholartype=$request->input('scholars');
        $scholars->school_last=$request->input('schoollast');
        $scholars->school_last_address=$request->input('schoollastaddress');
        $scholars->grade_level_last=$request->input('lastgradelevel');
        $scholars->school=$request->input('school');
        $scholars->school_address=$request->input('schooladdress');
        $scholars->grade_level=$request->input('gradelevel');
        $scholars->gwa=$request->input('gwa');
        $scholars->save();

        return redirect('/tugon')->with('success','Tugon applicant information successfully updated');
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
