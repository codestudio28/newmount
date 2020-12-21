<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\PaymentScheme;
use App\Buy;
use App\Misc;
use App\Log;
class UploadMiscController extends Controller
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

             
              

                    $cts = $data['cts'];
                    $datedue = $data['date'];
                    $newdatedue = date("Y-m-d", strtotime($datedue));

                    $amountdue = $data['amountdue'];
                    $unpaiddues = $data['unpaiddues'];
                    $penalty = $data['penalty'];
                    $totaldues = $data['totaldues'];
                    $payments = $data['payments'];
                    $balance = $data['balance'];
                    $orarno = $data['orarno'];
                    $paymenttype = $data['paymenttype'];
                    $chequenumber = $data['chequenumber'];
                    $bankname = $data['bankname'];
                    $branch = $data['branch'];

                    $datepaid = $data['datepaid'];
                    if(strlen($datepaid)>0){
                         $newdatepaid = date("Y-m-d", strtotime($datepaid));
                    }else{
                         $newdatepaid = "";
                    }
                   

                    $status = $data['status'];
                 

                    $buy = Buy::where('cts',$cts)->first();

                    $client_id = $buy->client_id;
                    $property_id = $buy->property_id;

                  
                   
                  
                   
                    $newequity=Misc::where('client_id',$client_id)->where('property_id',$property_id)->where('date',$newdatedue)->get();

                    if(count($newequity)<=0){
                        $equity = new Misc;
                        $equity->client_id =$client_id;
                        $equity->property_id =$property_id;
                        $equity->date =$newdatedue;
                        $equity->balance =$balance;
                        $equity->misc_fee =$amountdue;
                        $equity->penalty =$penalty;
                        $equity->payment =$payments;
                        $equity->payment_type =$paymenttype;
                        $equity->aror =$orarno;
                        $equity->checknumber =$chequenumber;
                        $equity->bankname =$bankname;
                        $equity->branch =$branch;
                        $equity->datepaid =$newdatepaid;
                        $equity->status =$status;
                        $equity->amountdue =$amountdue;
                        $equity->unpaiddues =$unpaiddues;
                        $equity->totaldues =$totaldues;
                        $equity->save();

                    }
                  

                }
                   $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Misc";
        $log->description="Import misc";
        $log->save();
             return redirect('/admin-collection')->with('success','Successfully import misc collection to the system. ');
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
