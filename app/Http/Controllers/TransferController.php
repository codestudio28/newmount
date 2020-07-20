<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Buy;
use App\Client;
use App\Property;
use App\PaymentScheme;
use App\Misc;
use App\Equity;
use App\Penalty;
use App\Inhouse;
use App\Transfer;
class TransferController extends Controller
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
            $properties = Property::where('status','OCCUPIED')->get();
          return view('admin_transfer.index')->with('clients',$clients)->with('properties',$properties);
        }
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
         $this->validate($request,[
            'clientid'=>'required',
            'property'=>'required',
            'cts'=>'required'
        ]);
         $client_id = $request->input('clientid');
         $property_id = $request->input('property');
         $cts = $request->input('cts');

         return $cts;

         $buy = Buy::where('cts',$cts)->get();
         if(count($buy)<=0){

            $transfers = Transfer::where('property_id',$property_id)->orderBy('id')->get();
            if(count($transfers)<=0){

                $transferscts = Transfer::where('cts',$cts)->get();
                return $transferscts;
                if(count($transferscts)<=0){
                    $buys = Buy::where('property_id',$property_id)->first();
                    $buysid=$buys->id;
                    $buy = Buy::find($buysid);
                    $oldclient_id = $buy->client_id;
                   
                    $buy->client_id=$client_id;
                    $buy->cts=$cts;
                    $buy->save();

                    $miscs = Misc::where('property_id',$property_id)->get();
                    $equities = Equity::where('property_id',$property_id)->get();
                    
                    foreach ($miscs as $key => $misc) {
                        $newmisc = Misc::find($misc->id);
                        $newmisc->client_id=$client_id;
                        $newmisc->save();
                    }
                    foreach ($equities as $key => $equity) {
                        $newmisc = Equity::find($equity->id);
                        $newmisc->client_id=$client_id;
                        $newmisc->save();
                    }

                    $inhouses = Inhouse::where('property_id',$property_id)->get();

                    if(count($inhouses)>0){
                        foreach ($inhouses as $key => $inhouse) {
                            $newinhouse = Inhouse::find($inhouse->id);
                            $newinhouse->client_id=$client_id;
                            $newinhouse->cts=$cts;
                            $newinhouse->save();
                            
                        }
                    }

                    $newtransfer = new Transfer;
                    $newtransfer->property_id=$property_id;
                    $newtransfer->oldclient_id =$oldclient_id;
                    $newtransfer->newclient_id = $client_id;
                    $newtransfer->cts = $cts;
                    $newtransfer->status = "TRANSFER";
                    $newtransfer->save();
                    }

                 return redirect('admin-transfer')->with('success','Successfully transfer property.');
            }else{
                return redirect('admin-transfer')->with('error','CTS already in used.');
            }



            

         }else{
            return redirect('admin-transfer')->with('error','CTS already in used.');
         }

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
        //
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
