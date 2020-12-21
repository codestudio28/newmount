<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\PaymentScheme;
use App\Buy;
use App\Log;
class UploadBuyerController extends Controller
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
                    $firstname = $data['clientfirstname'];
                    $middlename = $data['clientmiddlename'];
                    $lastname = $data['clientlastname'];
                    $block = $data['block'];
                    $lot = $data['lot'];
                    $payment_name = $data['paymentname'];
                    $years = $data['years'];
                    $tcp = $data['tcp'];
                    $loanable = $data['loanable'];
                    $total_equity = $data['totalequity'];
                    $total_misc = $data['totalmisc'];
                    $monthly_equity = $data['monthlyequity'];
                    $monthly_misc = $data['monthlymisc'];
                    $months = $data['months'];
                    $reserve_fee = $data['reservationfee'];
                    $penalty_misc = $data['miscpenalty'];
                    $penalty_equity = $data['equitypenalty'];

                    $client = Client::where('firstname',$firstname)->where('middlename',$middlename)->where('lastname',$lastname)->first();

                    $client_id=$client->id;

                    $property = Property::where('block',$block)->where('lot',$lot)->first();
                    $property_id=$property->id;

                    $paymentscheme = PaymentScheme::where('paymentname',$payment_name)->where('years',$years)->first();
                    $paymentscheme_id=$paymentscheme->id;

                  
                   
                    $newbuyer=Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();

                    if(count($newbuyer)<=0){
                        $buyers = new Buy;
                        $buyers->client_id =$client_id;
                        $buyers->property_id=$property_id;
                        $buyers->paymentscheme_id=$paymentscheme_id;
                        $buyers->tcp=$tcp;
                        $buyers->loanable=$loanable;
                        $buyers->totalequity=$total_equity;
                        $buyers->totalmisc=$total_misc;
                        $buyers->equity=$monthly_equity;
                        $buyers->misc=$monthly_misc;
                        $buyers->months=$months;
                        $buyers->reservationfee=$reserve_fee;
                        $buyers->misc_penalty=$penalty_misc;
                        $buyers->equity_penalty=$penalty_equity;
                        $buyers->status='ACTIVE';
                        $buyers->cts=$cts;
                        $buyers->save();

                        $properties = Property::where('id',$property_id)->first();
                        $properties->status="OCCUPIED";
                        $properties->save();
                    }
                  

                }
                   $admin_id=session('Data')[0]->id;

        $log = new Log;
        $log->admin_id=$admin_id;
        $log->module="Buyer";
        $log->description="Import buyer";
        $log->save();
             return redirect('/admin-collection')->with('success','Successfully import buyer to the system. ');
        
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
