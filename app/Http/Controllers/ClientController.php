<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
class ClientController extends Controller
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
            $clients = Client::where('status','ACTIVE')->get();

          return view('client.index')->with('clients',$clients);
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
             return view('client.create');
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
            'firstname'=>'required',
            'lastname'=>'required',
            'address1'=>'required',
            'barangay'=>'required',
            'city'=>'required',
            'province'=>'required',
            'cts'=>'required',
            'sales_rep'=>'required',
        ]);

       
            
             $client = Client::where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
             if(count($client)>0){
                 return redirect('/admin-client/create')->with('error','This client is already in the system.');
             }else{

             }
         

      
        $status="ACTIVE";
        $client = new Client;
        $client->firstname = $request->input('firstname');
        $client->middlename = $request->input('middlename');
        $client->lastname = $request->input('lastname');
        $client->contactnumber = $request->input('contactnumber');
        $client->address1 = $request->input('address1');
        $client->barangay = $request->input('barangay');
        $client->city = $request->input('city');
        $client->province = $request->input('province');
        $client->cts = $request->input('cts');
        $client->sales_rep = $request->input('sales_rep');
        $client->status = $status;
        $client->save();
        return redirect('/admin-client')->with('success','New client successfully added');
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
             $client = Client::find($id);
         return view('client.edit')->with('client',$client);
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
            'firstname'=>'required',
            'lastname'=>'required',
            'address1'=>'required',
            'barangay'=>'required',
            'city'=>'required',
            'province'=>'required',
             'cts'=>'required',
            'sales_rep'=>'required',
        ]);

       
            
             $client = Client::where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
             if(count($client)>0){
                 $clientid = Client::where('id',$id)->where('firstname',$request->input('firstname'))->where('lastname',$request->input('lastname'))->get();
                   if(count($clientid)>0){

                   }else{
                    $path="/admin-client/".$id."/edit";
                    return redirect($path)->with('error','This client is already in the system.');
                   }
               
             }else{

             }
        
     
        $client = Client::find($id);
        $client->firstname = $request->input('firstname');
        $client->middlename = $request->input('middlename');
        $client->lastname = $request->input('lastname');
        $client->contactnumber = $request->input('contactnumber');
        $client->address1 = $request->input('address1');
        $client->barangay = $request->input('barangay');
        $client->city = $request->input('city');
        $client->province = $request->input('province');
        $client->cts = $request->input('cts');
        $client->sales_rep = $request->input('sales_rep');
        $client->save();
        return redirect('/admin-client')->with('success','Client information successfully updated');
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
