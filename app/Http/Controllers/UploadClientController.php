<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Log;
class UploadClientController extends Controller
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

           
              

                    $firstname = $data['firstname'];
                    $lastname = $data['lastname'];
                    $middlename = $data['middlename'];
                    $contactnumber = $data['contactnumber'];
                    $address = $data['address'];
                    $salesrep = $data['salesrep'];
                  

                 
                  
                   
                  
                   
                    $newclient=Client::where('firstname',$firstname)->where('middlename',$middlename)->where('lastname',$lastname)->get();
                    echo count($newclient);
                    if(count($newclient)<=0){
                        $client = new Client;
                        $client->firstname =strtoupper($firstname);
                        $client->middlename =strtoupper($middlename);
                        $client->lastname =strtoupper($lastname);
                        $client->address1 =strtoupper($address);
                        $client->sales_rep =strtoupper($salesrep);
                        $client->status ="ACTIVE";
                        $client->save();

                    }
                  

                }
                   $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Client";
        $log->description="Import client list";
        $log->save();
             return redirect('/admin-client')->with('success','Successfully import client list to the system. ');
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
