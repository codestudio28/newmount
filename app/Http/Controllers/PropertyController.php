<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Property;
use App\PropertyType;
use App\Log;
class PropertyController extends Controller
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
        $properties = Property::orWhere('status','ACTIVE')->orWhere('status','OCCUPIED')->get();
        
        return view('property.index')->with('properties',$properties);
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
            $proptypes = PropertyType::where('status','ACTIVE')->get();
             return view('property.create')->with('proptypes',$proptypes);
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
            'block'=>'required',
            'lot'=>'required',
            'proptype'=>'required',
            'area'=>'required',
            'price'=>'required'
        ]);

         $property = Property::where('block',$request->input('block'))->where('lot',$request->input('lot'))->get();
         if(count($property)>0){
             return redirect('/admin-property/create')->with('error','Block: '.$request->input('block').' Lot: '.$request->input('lot').' is already in the system');
         }else{

         }

        $status="ACTIVE";
        $property = new Property;
        $property->block = $request->input('block');
        $property->lot = $request->input('lot');
        $property->proptype_id = $request->input('proptype');
        $property->area = $request->input('area');
        $display_price =number_format($request->input('price'), 2, '.', '');
        $property->display_price = 'Php.'.$display_price;
        $property->price = $request->input('price');
        $property->status = $status;
        $property->save();

          $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Property";
        $log->description="Add property";
        $log->save();


        return redirect('/admin-property')->with('success','New property successfully added');
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
            $property = Property::find($id);
             $proptypes = PropertyType::where('status','ACTIVE')->get();
         return view('property.edit')->with('proptypes',$proptypes)->with('property',$property);
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
            'block'=>'required',
            'lot'=>'required',
            'proptype'=>'required',
            'area'=>'required',
            'price'=>'required'
        ]);

         $property = Property::where('block',$request->input('block'))->where('lot',$request->input('lot'))->get();
         if(count($property)>0){
            $propertyid = Property::where('id',$id)->where('block',$request->input('block'))->where('lot',$request->input('lot'))->get();
             if(count($propertyid)>0){

             }else{
                 $path = "/admin-property/".$id."/edit";
                  return redirect($path)->with('error','Block: '.$request->input('block').' Lot: '.$request->input('lot').' is already in the system');
             }
           
         }else{

         }

      
        $property = Property::find($id);
        $property->block = $request->input('block');
        $property->lot = $request->input('lot');
        $property->proptype_id = $request->input('proptype');
        $property->area = $request->input('area');
        $display_price =number_format($request->input('price'), 2, '.', '');
        $property->display_price = 'Php.'.$display_price;
        $property->price = $request->input('price');
        $property->save();

           $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Property";
        $log->description="Update property";
        $log->save();

        return redirect('/admin-property')->with('success','Property successfully updated.');
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
