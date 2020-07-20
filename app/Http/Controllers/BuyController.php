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
class BuyController extends Controller
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
            $properties = Property::where('status','ACTIVE')->get();
            $payments = PaymentScheme::where('status','ACTIVE')->get();
          return view('buy.index')->with('clients',$clients)->with('properties',$properties)->with('payments',$payments);
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
            'months'=>'required',
            'loanable'=>'required',
            'paymentscheme'=>'required',
            'cts'=>'required',
        ]);
         $contract=$request->input('cts');
         $cts = Buy::where('cts',$contract)->get();

         if(count($cts)>0){
             return redirect('admin-buy')->with('error','CTS already in used.');
         }


         $paymentscheme =PaymentScheme::find($request->input('paymentscheme'));

         $property = Property::find($request->input('property'));
         $totalcontract =$property->price;
         $months =$request->input('months');
         $misc_percent = ($property->proptype->misc)/100;
         $total_misc = $totalcontract * $misc_percent;
         $loanable = $request->input('loanable');
         $total_equity = $totalcontract-$loanable;
         $monthly_misc = round($total_misc/$request->input('months'),2);
         $monthly_equity = round($total_equity/$request->input('months'),2);
         $reservationfee=$request->input('reservationfee');

         $client = Client::find($request->input('clientid'));

         return view('buy.show')->with('client',$client)
         ->with('paymentscheme',$paymentscheme)
         ->with('property',$property)
         ->with('totalcontract',$totalcontract)
         ->with('total_misc',$total_misc)
         ->with('monthly_misc',$monthly_misc)
         ->with('total_equity',$total_equity)
         ->with('monthly_equity',$monthly_equity)
         ->with('loanable',$loanable)
         ->with('reservationfee',$reservationfee)
          ->with('cts',$contract)
         ->with('months',$months);

    }

      public function buy(Request $request)
    {
        
        $this->validate($request,[
            'clientid'=>'required',
            'propertyid'=>'required',
            'paymentschemeid'=>'required',
            'contractprice'=>'required',
            'loan'=>'required',
            'totalm'=>'required',
            'monthlym'=>'required',
            'totale'=>'required',
            'monthlye'=>'required',
            'monthsnumber'=>'required',
            'reservation'=>'required',
            'ctsid'=>'required',
            'dates'=>'required',
        ]);
            $penalties = Penalty::all();
            $penalty = $penalties[0]->penalty;

          



            $buy = new Buy;
            $buy->client_id = $request->input('clientid');
            $buy->property_id = $request->input('propertyid');
            $buy->paymentscheme_id = $request->input('paymentschemeid');
            $buy->tcp = $request->input('contractprice');
            $buy->loanable = $request->input('loan');
            $buy->totalequity = $request->input('totale');
            $buy->totalmisc = $request->input('totalm');
            $buy->misc = $request->input('monthlym');
            $buy->misc_penalty = $penalty;
            $buy->equity_penalty =  $penalty;
            $buy->equity = $request->input('monthlye');
            $buy->months = $request->input('monthsnumber');
            $buy->reservationfee = $request->input('reservation');
            $buy->cts = $request->input('ctsid');
            $buy->status = "ACTIVE";
            $buy->save();

            $misc = new Misc;
            $misc->client_id = $request->input('clientid');
            $misc->property_id = $request->input('propertyid');
            $misc->date = $request->input('dates');
            $misc->balance = $request->input('totalm');
            $misc->misc_fee = $request->input('monthlym');
            $misc->penalty = "";
            $misc->payment = "";
            $misc->payment_type = "";
            $misc->aror = "";
            $misc->checknumber = "";
            $misc->bankname = "";
            $misc->branch = "";
            $misc->datepaid = "";
            $misc->status = "PENDING";
            $misc->save();

            $equity = new Equity;
            $equity->client_id = $request->input('clientid');
            $equity->property_id = $request->input('propertyid');
            $equity->date = $request->input('dates');
            $equity->balance = $request->input('totale');
            $equity->equity_fee = $request->input('monthlye');
            $equity->penalty = "";
            $equity->payment = "";
            $equity->payment_type = "";
            $equity->aror = "";
            $equity->checknumber = "";
            $equity->bankname = "";
            $equity->branch = "";
            $equity->datepaid = "";
            $equity->status = "PENDING";
            $equity->save();
          

            $propertyid = $request->input('propertyid');
            $property = Property::find($propertyid);
            $property->status="OCCUPIED";
            $property->save();
            return redirect('/admin-buy')->with('success','Client successfully bought a property.');
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
         $this->validate($request,[
            'clientid'=>'required',
            'property'=>'required',
            'months'=>'required',
            'loanable'=>'required',
            'paymentscheme'=>'required',
        ]);
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
