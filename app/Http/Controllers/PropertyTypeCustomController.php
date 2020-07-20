<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PropertyType;
use App\Log;
class PropertyTypeCustomController extends Controller
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
             $user = PropertyType::find($id);
            $user->status = $request->input('status');
            $user->save();

               $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Property Type";
        $log->description="Remove property type";
        $log->save();
             return redirect('/admin-proptype')->with('success','Property type successfully removed from the active list ');
        }else if($request->input('status')=="ACTIVE"){
             $user = PropertyType::find($id);
            $user->status = $request->input('status');
            $user->save();


               $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Property Type";
        $log->description="Retrieve property type";
        $log->save();
             return redirect('/admin-proptype-removed')->with('success','Property type successfully retrieved to the active list ');
        }else if($request->input('status')=="IMPORT"){
                $upload = $request->file('import_file');

                $filePath = $upload->getRealPath();
                $file = fopen($filePath,'r');
                $header = fgetcsv($file);
                $escapeHeader=[];
                foreach ($header as $key => $value) {
                    $lheader=strtolower($value);
                    $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
                    // dd($escapedItem);
                    array_push($escapeHeader,$escapedItem);
                }
              
                while($columns=fgetcsv($file)){
                    if($columns[0]==""){
                        continue;
                    }

                    // foreach ($columns as $key => &$value) {
                    //     $value = preg_replace('/\D/', '', $value);
                    // }

                    $data=array_combine($escapeHeader, $columns);

                    $typename = $data['typename'];
                    $description = $data['description'];
                    $equity = $data['equity'];
                    $misc = $data['misc'];
                    $status = $data['status'];

                    $newproptype=PropertyType::where('typename',$typename)->where('description',$description)->get();

                    if(count($newproptype)<=0){
                        $proptype = new PropertyType;
                        $proptype->typename =$typename;
                        $proptype->description=$description;
                        $proptype->equity=$equity;
                        $proptype->misc=$misc;
                        $proptype->status=$status;
                        $proptype->save();

                    }
                  

                }
                   $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Property Type";
        $log->description="Import property type";
        $log->save();
             return redirect('/admin-proptype')->with('success','Successfully import property type information to the list. ');
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
