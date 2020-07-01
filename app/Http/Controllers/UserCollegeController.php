<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Scholarship;
use App\UserInfo;
use App\User;
use App\TugonInfo;
use App\Barangay;
use App\SchoolYear;
class UserCollegeController extends Controller
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
            $schools = SchoolYear::where('status','OPEN')->get();
        if(count($schools)>0){
            
            $user=session('Data');
            $firstname=$user[0]->firstname;
            $middlename=$user[0]->middlename;
            $lastname=$user[0]->lastname;

            $userinfo = UserInfo::where('firstname',$firstname)
             ->where('middlename',$middlename)
             ->where('lastname',$lastname)->get();
              if(count($userinfo)>0){
                $barangays=Barangay::all();
                $school_years = SchoolYear::where('status','OPEN')->get();
                $newid= $userinfo[0]->id;
                $scholarship = Scholarship::where('user_id',$newid)->get();
                $newstatus=$scholarship[0]->status;
                $scholartype=$scholarship[0]->scholartype;

                 if($scholartype=="Financial Assistance (Senior High School)"){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                      
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$userinfo);  
                    }else{
                         
                       $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-senior-high')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userinfo);  
                    }
                }  if(($scholartype=="Tugon (Elementary)")||($scholartype=="Tugon (Junior High School)")){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$userinfo);  
                    }else{
                     $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-tugon')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userinfo);   
                    }
                }else {
                    $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userinfo);
                }

                return view('user_tugon.index')->with('barangays',$barangays)->with('school_years',$school_years)
                 ->with('userinfo',$userinfo);  
             }

             // Father
             $userfather = UserInfo::where('ffirstname',$firstname)
             ->where('fmiddlename',$middlename)
             ->where('flastname',$lastname)->get();
            if(count($userfather)>0){
                $barangays=Barangay::all();
                $school_years = SchoolYear::where('status','OPEN')->get();
                $newid= $userfather[0]->id;
                $scholarship = Scholarship::where('user_id',$newid)->get();
                $newstatus=$scholarship[0]->status;
                $scholartype=$scholarship[0]->scholartype;
                 if(($scholartype=="Tugon (Elementary)")||($scholartype=="Tugon (Junior High School)")){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                      
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$userfather);  
                    }else{
                         
                        $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-tugon')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userfather);
                    }
                }else if($scholartype=="Financial Assistance (Senior High School)"){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$userfather);  
                    }else{
                       $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-senior-high')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userfather);      
                    }
                }else {
                    $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$userfather);
                }
                

             }
            $usermother = UserInfo::where('mfirstname',$firstname)
             ->where('mmiddlename',$middlename)
             ->where('mlastname',$lastname)->get();
            if(count($usermother)>0){

                $barangays=Barangay::all();
                $school_years = SchoolYear::where('status','OPEN')->get();
                $newid= $usermother[0]->id;
                $scholarship = Scholarship::where('user_id',$newid)->get();
                $newstatus=$scholarship[0]->status;
                $scholartype=$scholarship[0]->scholartype;
                 if(($scholartype=="Tugon (Elementary)")||($scholartype=="Tugon (Junior High School)")){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                      
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$usermother);  
                    }else{
                         
                         $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-tugon')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$usermother);   
                    }
                }else if($scholartype=="Financial Assistance (Senior High School)"){
                    if(($newstatus=="REMOVED")||($newstatus=="GRADUATE")){
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                        ->with('userinfo',$usermother);  
                    }else{
                        $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return redirect('/user-senior-high')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$usermother);    
                    }
                }else {
                    $barangays=Barangay::all();
                        $school_years = SchoolYear::where('status','OPEN')->get();
                        return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                         ->with('userinfo',$usermother);
                }
               
             }
              $barangays=Barangay::all();
                $school_years = SchoolYear::where('status','OPEN')->get();
                return view('user_college.index')->with('barangays',$barangays)->with('school_years',$school_years)
                 ->with('userinfo',$userinfo);

            
        }else{
             return redirect('/dashboard')->with('error','Scholarship Application is already closed. Please wait for further announcement');

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
         $this->validate($request,[
            'email'=>'required',
            'track'=>'required',
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
               return redirect('/user-college')->with('error','Applicant already exist');
         }
         if(count($emails)>0){
               return redirect('/user-college')->with('error','Email already exist');
         }
         if(count($mother)>0){
            $userid = $mother[0]->id;
            $scholars = Scholarship::where('user_id',$userid)->get();
            $scholars_status = $scholars[0]->status;
            if($scholars_status=="NEW APPLICANT"){
                  return redirect('/user-college')->with('error','Mother of the applicant has child that already an applicant.');
            }if($scholars_status=="SCHOLARS"){
                 return redirect('/user-college')->with('error','Mother of the applicant has child that already has a financial assistance.');
            }if($scholars_status=="INTERVIEW"){
                  return redirect('/user-college')->with('error','Mother of the applicant has child that already an applicant.');
            }if($scholars_status=="ASSESSMENT"){
                  return redirect('/user-college')->with('error','Mother of the applicant has child that already an applicant.');
            }if($scholars_status=="PRE-APPLICANT"){
                  return redirect('/user-college')->with('error','Mother of the applicant has child that already an applicant.');
            }

              
            
         }
        

         if(count($father)>0){
            $userid = $father[0]->id;
            $scholars = Scholarship::where('user_id',$userid)->get();
            $scholars_status = $scholars[0]->status;
            if($scholars_status=="NEW APPLICANT"){
                 return redirect('/user-college')->with('error','Father of the applicant has child that already an applicant.');
            }if($scholars_status=="SCHOLARS"){
                  return redirect('/user-college')->with('error','Father of the applicant has child that already has a financial assistance.');
            }if($scholars_status=="INTERVIEW"){
                   return redirect('/user-college')->with('error','Father of the applicant has child that already an applicant.');
            }if($scholars_status=="ASSESSMENT"){
                   return redirect('/user-college')->with('error','Father of the applicant has child that already an applicant.');
            }if($scholars_status=="PRE-APPLICANT"){
                 return redirect('/user-college')->with('error','Father of the applicant has child that already an applicant.');
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

      

        $status="PRE-APPLICANT";
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
        $scholars->course=$request->input('track');
        $scholars->status=$status;
        $scholars->save();

        return redirect('/user-college')->with('success','Your application successfully submitted');
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

            $user = UserInfo::find($id);
              $barangays=Barangay::all();
                $school_years = SchoolYear::where('status','OPEN')->get();
            return view('user_college.edit')->with('user',$user)->with('barangays',$barangays)->with('school_years',$school_years);
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
            'track'=>'required',
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
                       return redirect('/user-college/'.$id.'/edit')->with('error','Applicant already exist');
                }
            
         }
         if(count($emails)>0){
                $emails_id = UserInfo::where('id',$id)->where('email_address',$request->input('email'))->get();
                if(count($emails_id)>0){

                }else{
                     return redirect('/user-college/'.$id.'/edit')->with('error','Email already exist');
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
                     return redirect('/user-college/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
                }if($scholars_status=="SCHOLARS"){
                     return redirect('/user-college/'.$id.'/edit')->with('error','Mother of the applicant has child that already has a financial assistance.');
                }if($scholars_status=="INTERVIEW"){
                     return redirect('/user-college/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
                }if($scholars_status=="ASSESSMENT"){
                     return redirect('/user-college/'.$id.'/edit')->with('error','Mother of the applicant has child that already an applicant.');
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
                     return redirect('/user-college/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
                }if($scholars_status=="SCHOLARS"){
                     return redirect('/user-college/'.$id.'/edit')->with('error','Father of the applicant has child that already has a financial assistance.');
                }if($scholars_status=="INTERVIEW"){
                      return redirect('/user-college/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
                }if($scholars_status=="ASSESSMENT"){
                     return redirect('/user-college/'.$id.'/edit')->with('error','Father of the applicant has child that already an applicant.');
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
        $scholars->course=$request->input('track');
        $scholars->grade_level=$request->input('gradelevel');
        $scholars->gwa=$request->input('gwa');
        $status="PRE-APPLICANT";
        $scholars->status=$status;
        $scholars->save();

        return redirect('/user-college')->with('success','You successfully submit your application');
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
