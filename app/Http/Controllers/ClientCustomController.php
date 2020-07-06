<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
class ClientCustomController extends Controller
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
             $user = Client::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-client')->with('success','Client successfully removed from the active list ');
        }else if($request->input('status')=="ACTIVE"){
             $user = Client::find($id);
            $user->status = $request->input('status');
            $user->save();
             return redirect('/admin-client-removed')->with('success','Client successfully retrieved to the active list ');
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

                    $firstname= $data['firstname'];
                    $middlename= $data['middlename'];
                    $lastname= $data['lastname'];
                    $contactnumber= $data['contactnumber'];
                    $address1= $data['address'];
                    $barangay= $data['barangay'];
                    $city= $data['city'];
                    $province= $data['province'];
                    $status= $data['status'];

                    $newclient=Client::where('firstname',$firstname)->where('middlename',$middlename)->where('lastname',$lastname)->get();

                    if(count($newclient)<=0){
                        $client = new Client;
                        $client->firstname =$firstname;
                        $client->middlename=$middlename;
                        $client->lastname=$lastname;
                        $client->contactnumber=$contactnumber;
                        $client->address1=$address1;
                        $client->barangay=$barangay;
                        $client->city=$city;
                        $client->province=$province;
                        $client->status=$status;
                        $client->save();

                    }
                  

                }

             return redirect('/admin-client')->with('success','Successfully import client information to the list. ');
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
