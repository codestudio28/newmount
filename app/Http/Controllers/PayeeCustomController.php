<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Payee;
use App\Log;
class PayeeCustomController extends Controller
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
            $payee = Payee::find($id);
            $payee->status="REMOVED";
            $payee->save();
            return redirect('/admin-payee')->with('success','Successfully remove payee from active list');
        }else if($request->input('status')=="ACTIVE"){
            $payee = Payee::find($id);
            $payee->status="ACTIVE";
            $payee->save();
            return redirect('/admin-payee')->with('success','Successfully retrieve payee to active list');
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

                    $payee_name= $data['payeename'];
                    $address= $data['address'];
                    $contactnumber= $data['contactnumber'];
                    $tin= $data['tin'];
                    $remarks= $data['remarks'];
                    $status= $data['status'];

                    $newpayee=Payee::where('payee_name',$payee_name)->get();

                    if(count($newpayee)<=0){
                        $client = new Payee;
                        $client->payee_name =$payee_name;
                        $client->address=$address;
                        $client->contactnumber=$contactnumber;
                        $client->tin=$tin;
                        $client->remarks=$remarks;
                        $client->status=$status;
                        $client->save();

                    }
                  

                }
                    $admin_id=session('Data')[0]->id;

        $log = new Log;
         $log->admin_id=$admin_id;
        $log->module="Payee";
        $log->description="Import payee";
        $log->save();
             return redirect('/admin-payee')->with('success','Successfully import payee information to the list. ');
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
