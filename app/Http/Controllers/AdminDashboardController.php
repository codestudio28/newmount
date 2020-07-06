<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;
use App\Voucher;
use App\Misc;
use App\Equity;
use App\Inhouse;
class AdminDashboardController extends Controller
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

            date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
            $hour=date('G');
            $min=date('i');
            $sec=date('s');


            $dates=$year."-".$month."-".$day;
            $times=$hour.":".$min.":".$sec;


            $newdates = strtotime($dates);
            $month = date('M', $newdates);
            
            $daily=0;
            $annual=0;
            $monthly=0;

            $daily_voucher=0;
            $annual_voucher=0;
            $monthly_voucher=0;


            $vouchers = Voucher::where('status','APPROVED')->get();

            foreach ($vouchers as $key => $voucher) {
                if($voucher->dates==$dates){
                    $daily_voucher=$daily_voucher+$voucher->amount;
                }
                $newdates = strtotime($voucher->dates);
                $years = date('Y', $newdates);
                if($years==$year){
                    $annual_voucher=$annual_voucher+$voucher->amount;
                }
                $newdates = strtotime($voucher->dates);
                $years = date('Y', $newdates);
                $months = date('M', $newdates);
                if(($years==$year)&&($months==$month)){
                    $monthly_voucher=$monthly_voucher+$voucher->amount;
                }
            }
           
            $miscs = Misc::where('status','PAID')->get();
            
            foreach ($miscs as $key => $misc) {
                if($misc->datepaid==$dates){
                    $daily=$daily+$misc->payment;
                }
                $newdates = strtotime($misc->datepaid);
                $years = date('Y', $newdates);
                if($years==$year){
                    $annual=$annual+$misc->payment;
                }
                $newdates = strtotime($misc->datepaid);
                $years = date('Y', $newdates);
                $months = date('M', $newdates);
                if(($years==$year)&&($months==$month)){
                    $monthly=$monthly+$misc->payment;
                }
            }

            $equities = Equity::where('status','PAID')->get();
            
            foreach ($equities as $key => $equity) {
                if($equity->datepaid==$dates){
                    $daily=$daily+$equity->payment;
                }
                $newdates = strtotime($equity->datepaid);
                $years = date('Y', $newdates);
                if($years==$year){
                    $annual=$annual+$equity->payment;
                }

                $newdates = strtotime($equity->datepaid);
                $years = date('Y', $newdates);
                $months = date('M', $newdates);
                if(($years==$year)&&($months==$month)){
                    $monthly=$monthly+$equity->payment;
                }
            }

             $inhouses = Inhouse::where('status','PAID')->get();
            
            foreach ($inhouses as $key => $inhouse) {
                if($inhouse->date_due==$dates){
                    $daily=$daily+$inhouse->payment;
                }
                $newdates = strtotime($inhouse->date_due);
                $years = date('Y', $newdates);
                if($years==$year){
                    $annual=$annual+$inhouse->payment;
                }

                $newdates = strtotime($inhouse->date_due);
                $years = date('Y', $newdates);
                $months = date('M', $newdates);
                if(($years==$year)&&($months==$month)){
                    $monthly=$monthly+$inhouse->payment;
                }
            }
           
            $message = Message::where('status','UNREAD')->get();
            $vouchers = Voucher::where('status','PENDING')->get();
            session()->put('message',$message);
            session()->put('vouchers',$vouchers);

            return view('dashboard.dashboard')->with('daily',$daily)->with('annual',$annual)->with('monthly',$monthly)->with('daily_voucher',$daily_voucher)->with('annual_voucher',$annual_voucher)->with('monthly_voucher',$monthly_voucher);
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
