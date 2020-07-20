<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PropertyType;
use App\Log;
class PropertyTypeController extends Controller
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
            $proptypes = PropertyType::where('status','ACTIVE')->get();
         
        return view('propertype.index')->with('proptypes',$proptypes);
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
             return view('propertype.create');
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
            'typename'=>'required',
            'description'=>'required',
            'equity'=>'required',
            'misc'=>'required'
        ]);

         $proptype = PropertyType::where('typename',$request->input('typename'))->get();
         if(count($proptype)>0){
             return redirect('/admin-proptype/create')->with('error','Type name already taken.');
         }else{

         }

        $status="ACTIVE";
        $proptype = new PropertyType;
        $proptype->typename = $request->input('typename');
        $proptype->description = $request->input('description');
        $proptype->equity = $request->input('equity');
        $proptype->misc = $request->input('misc');
        $proptype->status = $status;
        $proptype->save();


        $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Property Type";
        $log->description="Add property type";
        $log->save();


        return redirect('/admin-proptype')->with('success','New property type successfully added');
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
             $proptype = PropertyType::find($id);
         return view('propertype.edit')->with('proptype',$proptype);
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
            'typename'=>'required',
            'description'=>'required',
            'equity'=>'required',
            'misc'=>'required'
        ]);

         $proptype = PropertyType::where('typename',$request->input('typename'))->get();
         if(count($proptype)>0){
             $proptypeid = PropertyType::where('typename',$request->input('typename'))->where('id',$id)->get();
                  if(count($proptypeid)>0){

                  }else{
                    $path = "/admin-proptype/".$id."/edit";
                     return redirect($path)->with('error','Type name already taken.');
                  }
            
         }else{

         }

      
        $proptype = PropertyType::find($id);
        $proptype->typename = $request->input('typename');
        $proptype->description = $request->input('description');
        $proptype->equity = $request->input('equity');
        $proptype->misc = $request->input('misc');
        $proptype->save();

           $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Property Type";
        $log->description="Update property type";
        $log->save();
        return redirect('/admin-proptype')->with('success','Property type successfully updated');
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
