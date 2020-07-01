<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Scholarship;
class TugonCustomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        if($request->input('status')=="REMOVED"){
            $scholars = Scholarship::where('user_id',$id)->get();
            $scholar_id = $scholars[0]->id;
            $scholars = Scholarship::find($scholar_id);
            $scholars->status = $request->input('status');
            $scholars->save();
            if($request->input('scholars')=="Tugon"){
                  return redirect('/tugon')->with('success','Applicant successfully removed from the list ');
            }else if($request->input('scholars')=="Senior High"){
                 return redirect('/admin-senior-high')->with('success','Applicant successfully removed from the list ');
            }else if($request->input('scholars')=="College"){
                 return redirect('/admin-college')->with('success','Applicant successfully removed from the list ');
            }
          
        }else if($request->input('status')=="NEW APPLICANT"){
            $scholars = Scholarship::where('user_id',$id)->get();
            $scholar_id = $scholars[0]->id;
            $scholars = Scholarship::find($scholar_id);
            $scholars->status = $request->input('status');
            $scholars->save();
             if($request->input('scholars')=="Tugon"){
                  return redirect('/tugon')->with('success','Applicant successfully send as new applicant.');
            }else if($request->input('scholars')=="Senior High"){
                 return redirect('/admin-senior-high')->with('success','Applicant successfully send as new applicant.');
            }else if($request->input('scholars')=="College"){
                  return redirect('/admin-college')->with('success','Applicant successfully send as new applicant.');
            }
          
        }else if($request->input('status')=="INTERVIEW"){
            $scholars = Scholarship::where('user_id',$id)->get();
            $scholar_id = $scholars[0]->id;
            $scholars = Scholarship::find($scholar_id);
            $scholars->status = $request->input('status');
            $scholars->save();
             if($request->input('scholars')=="Tugon"){
                  return redirect('/tugon')->with('success','Applicant successfully send for interview.');
            }else if($request->input('scholars')=="Senior High"){
                 return redirect('/admin-senior-high')->with('success','Applicant successfully send for interview.');
            }else if($request->input('scholars')=="College"){
                  return redirect('/admin-college')->with('success','Applicant successfully send for interview.');
            }
          
        }else if($request->input('status')=="ASSESSMENT"){
            $scholars = Scholarship::where('user_id',$id)->get();
            $scholar_id = $scholars[0]->id;
            $scholars = Scholarship::find($scholar_id);
            $scholars->status = $request->input('status');
            $scholars->save();
             if($request->input('scholars')=="Tugon"){
                   return redirect('/tugon')->with('success','Applicant successfully send for assessment.');
            }else if($request->input('scholars')=="Senior High"){
                 return redirect('/admin-senior-high')->with('success','Applicant successfully send for assessment.');
            }else if($request->input('scholars')=="College"){
                 return redirect('/admin-college')->with('success','Applicant successfully send for assessment.');
            }
          
        }else if($request->input('status')=="SCHOLARS"){
            $scholars = Scholarship::where('user_id',$id)->get();
            $scholar_id = $scholars[0]->id;
            $scholars = Scholarship::find($scholar_id);
            $scholars->status = $request->input('status');
            $scholars->save();
            if($request->input('scholars')=="Tugon"){
                    return redirect('/tugon')->with('success','Applicant successfully approve as new scholars.');
            }else if($request->input('scholars')=="Senior High"){
                 return redirect('/admin-senior-high')->with('success','Applicant successfully approve as new scholars.');
            }else if($request->input('scholars')=="College"){
                 return redirect('/admin-college')->with('success','Applicant successfully approve as new scholars.');
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
