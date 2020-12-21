<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Equity;
use App\Pin;
use App\Log;
use App\WaiveMisc;
use App\WaiveEquity;
use App\Voucher;
class WaiveController extends Controller
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
        if($request->input('process')=="MISC"){
             $misc = Misc::find($id);
             $misc->penalty = 0.00;
             $misc->save();

            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;


            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully waive penalty.');  
        }else if($request->input('process')=="MISCREQUEST"){
            $misc = Misc::find($id);
            
              $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $newwaive = WaiveMisc::where('collect_id',$id)->get();
            if(count($newwaive)>1){
                  $path = "admin-misc/".$buy_id."/edit";
                return redirect($path)->with('error','You already request a waive for this transaction.'); 
            }

            $waive = new WaiveMisc;
            $waive->collect_id=$id;
            $waive->status="OPEN";
            $waive->save();
           
           

            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully sent waive penalty request.');  
        }else if($request->input('process')=="MISCAPPROVED"){
            $misc = Misc::find($id);
            

            $waive = WaiveMisc::where('collect_id',$id)->first();;
            $waive->status="CLOSED";
            $waive->save();

             $misc = Misc::find($id);
             $misc->penalty = 0.00;
             $misc->save();
           
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully approved waive penalty request.');  
        }
        else if($request->input('process')=="MISCAPPROVED2"){
            $misc = Misc::find($id);
            $totaldues = $misc->totaldues;
            $penalty =$misc->penalty;
            $newtotaldues=round($totaldues,2)-round($penalty,2);


            $waive = WaiveMisc::where('collect_id',$id)->first();;
            $waive->status="CLOSED";
            $waive->save();

             $misc = Misc::find($id);
             $misc->penalty = 0.00;
             $misc->totaldues=$newtotaldues;
             $misc->save();
           
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $path = "admin-misc/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully approved waive penalty request.');  
        }
        else if($request->input('process')=="EQUITYREQUEST"){
            $misc = Equity::find($id);
            
              $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $newwaive = WaiveEquity::where('collect_id',$id)->get();
            if(count($newwaive)>1){
                  $path = "admin-misc/".$buy_id."/edit";
                return redirect($path)->with('error','You already request a waive for this transaction.'); 
            }

            $waive = new WaiveEquity;
            $waive->collect_id=$id;
            $waive->status="OPEN";
            $waive->save();
           
           

            $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully sent waive penalty request.');  
        } else if($request->input('process')=="EQUITYAPPROVED"){
            
           
            $misc = Equity::find($id);
            $totaldues = $misc->totaldues;
            $penalty =$misc->penalty;
            $newtotaldues=round($totaldues,2)-round($penalty,2);

            
            $waive = WaiveEquity::where('collect_id',$id)->first();;
            $waive->status="CLOSED";
            $waive->save();

             $misc = Equity::find($id);
             $misc->penalty = 0.00;
             $misc->totaldues=$newtotaldues;
             $misc->save();
           
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully approved waive penalty request.');  
        } else if($request->input('process')=="EQUITYAPPROVED2"){
            $misc = Equity::find($id);
            $totaldues = $misc->totaldues;
            $penalty =$misc->penalty;
            $newtotaldues=round($totaldues,2)-round($penalty,2);


            $waive = WaiveEquity::where('collect_id',$id)->first();;
            $waive->status="CLOSED";
            $waive->save();

             $misc = Equity::find($id);
             $misc->penalty = 0.00;
             $misc->totaldues=$newtotaldues;
             $misc->save();
           
            $client_id = $misc->client_id;
            $property_id = $misc->property_id;
            $buy = Buy::where('client_id',$client_id)->where('property_id',$property_id)->get();
            $buy_id=$buy[0]->id;

            $path = "admin-equity/".$buy_id."/edit";
            return redirect($path)->with('success','Successfully approved waive penalty request.');  
        }else if($request->input('process')=="REFUND"){
           $this->validate($request,[
                'transact'=>'required',
                'amount'=>'required',
                'bankname'=>'required',
                'cheque'=>'required'
            ]);
           $buy = Buy::find($id);
           $cheque=$request->input('cheque');
           
           $voucher = Voucher::where('cheque',$cheque)->get();

         
           if(count($voucher)<=0){

                $property_id= $buy->property_id;
                $property = Property::find($property_id);
                $property->status="ACTIVE";
                $property->save();

                $newvouch = new Voucher;
                $newvouch->amount=$request->input('amount');
                $newvouch->bank=$request->input('bankname');
                $newvouch->dates=$request->input('transact');
                $newvouch->cheque=$request->input('cheque');
                $newvouch->terms="REFUND";
                $newvouch->cv=$property_id;
                $newvouch->save();

                $buy->status="REFUND";
                $buy->save();

                $path = "admin-collection/";
                return redirect($path)->with('success','Successfully save refund.');                   

           }else{

            $path = "admin-collection/";
            return redirect($path)->with('error','Cheque number already in the system.');
           }
           


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
