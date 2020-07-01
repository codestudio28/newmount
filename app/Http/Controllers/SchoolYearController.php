<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SchoolYear;
class SchoolYearController extends Controller
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
        $school_years =SchoolYear::orderBy('created_at','desc')->get();
        return view('schoolyear.index')->with('school_years',$school_years);
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
         return view('schoolyear.create');
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
            'school_year'=>'required',
            'semester'=>'required',
        ]);
         $school_year=SchoolYear::all();
        if(count($school_year)>0){
            $school_year = SchoolYear::where('school_year',$request->input('school_year'))->where('semester',$request->input('semester'))->get();
              if(count($school_year)>0){
                return redirect('/admin-school-year/create')->with('error','School year already in the system');
            }
            $status1="OPEN";
            $stats = SchoolYear::where('status',$status1)->get();
              if(count($stats)>0){
                return redirect('/admin-school-year/create')->with('error','Close the current school year before creating new school year');
            }

        }



        $status="OPEN";
         $school_year = new SchoolYear;
        $school_year->school_year = $request->input('school_year');
        $school_year->semester = $request->input('semester');
        $school_year->status = $status;
        $school_year->save();
        return redirect('/admin-school-year')->with('success','New school year successfully added');
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
            $school_year = SchoolYear::find($id);
         return view('schoolyear.edit')->with('school_year',$school_year);
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
            'school_year'=>'required',
            'semester'=>'required',
        ]);
         $school_year=SchoolYear::all();
        if(count($school_year)>0){
            $school_year = SchoolYear::where('school_year',$request->input('school_year'))->where('semester',$request->input('semester'))->get();
              if(count($school_year)>0){
                     $year_id = SchoolYear::where('id',$id)->where('school_year',$request->input('school_year'))->where('semester',$request->input('semester'))->get();
                     if(count($year_id)>0){

                     }else{
                        return redirect('/admin-school-year/'.$id.'/edit')->with('error','School year and semester already in the system');
                     }
               }
            }
        $status="OPEN";
        $school_year = SchoolYear::find($id);
        $school_year->school_year = $request->input('school_year');
        $school_year->semester = $request->input('semester');
        $school_year->status = $status;
        $school_year->save();
        return redirect('/admin-school-year')->with('success','School year and semester successfully updated');
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
