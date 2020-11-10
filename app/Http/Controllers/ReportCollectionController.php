<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Client;
use App\Property;
use App\Buy;
use App\Misc;
use App\Equity;
use Codedge\Fpdf\Fpdf\Fpdf;
class ReportCollectionController extends Controller
{
    private $fpdf;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;

        $totalrecords = session('totalrecords');
        if(strlen($totalrecords)<=0){
            session()->put('totalrecords',0);
          
        }
        $startrecords = session('startrecords');
        if(strlen($startrecords)<=0){
            session()->put('startrecords',1);
          
        }
        $sfiltered = session('filtered');
        if(strlen($sfiltered)<=0){
            session()->put('filtered','ALL');
          
        }
        $srecords = session('records');
        if(strlen($srecords)<=0){
            session()->put('records','10');
          
        }

         $ssearch = session('search');
        if(strlen($ssearch)<=0){
            session()->put('search','');
          
        }
         $sdatefrom = session('datefrom');
        if(strlen($sdatefrom)<=0){
            session()->put('datefrom',$today);
          
        }
        $sdateto = session('dateto');
        if(strlen($sdateto)<=0){
            session()->put('dateto',$today);
          
        }

        $datefrom =session('datefrom');
        $dateto =session('dateto');
        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");

        $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->take($records)->get();
        $count= count($miscs);
        $equities = Equity::where("status",'PAID')->orderBy('id','desc')->take($records)->get();
        $count1= count($equities);
        $client_misc=array();
        $client_equity=array();
        $prop_misc=array();
        $prop_equity=array();
        $equity_block=array();
        $equity_lot=array();
        $misc_block=array();
        $misc_lot=array();
        $tcp=array();
        $status=array();
        $equity_payment=array();
        $equity_date=array();
        $misc_date=array();
         $equity_due=array();
        $misc_due=array();
        $misc_payment=array();
        $equity_date=array();
        $equity_payment=array();
        $equity_pen=array();
        $misc_pen=array();
        $misc_pay=array();
        $equity_pay=array();
        $m=0;
        $e=0;
        foreach ($miscs as $key => $mic) {
            if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                    array_push($prop_misc,$mic->property->id);
                    array_push($misc_block,$mic->property->block);
                    array_push($misc_due,$mic->date);
                    array_push($misc_lot,$mic->property->lot);
                    array_push($misc_date,$mic->datepaid);
                    array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                    array_push($misc_pay,$mic->payment);
            }
        
        }
        foreach ($equities as $key => $equity) {
             if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                 array_push($prop_equity,$equity->property->id);
                 array_push($equity_due,$equity->date);
                array_push($equity_block,$equity->property->block);
                array_push($equity_lot,$equity->property->lot);
                array_push($equity_date,$equity->datepaid);
                array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                array_push($equity_pay,$equity->payment);
            }
        }
        $swi =0;
        if($count>=$count1){
            $swi =1;
        }

        return view('report.collection')
        ->with('swi',$swi)
        ->with('client_misc',$client_misc)
        ->with('prop_misc',$prop_misc)
        ->with('misc_block',$misc_block)
        ->with('misc_lot',$misc_lot)
         ->with('misc_pay',$misc_pay)
          ->with('equity_pay',$equity_pay)
        ->with('misc_date',$misc_date)
         ->with('misc_due',$misc_due)
        ->with('misc_payment',$misc_payment)
        ->with('client_equity',$client_equity)
        ->with('prop_equity',$prop_equity)
        ->with('equity_block',$equity_block)
        ->with('equity_lot',$equity_lot)
        ->with('equity_date',$equity_date)
        ->with('equity_due',$equity_due)
        ->with('equity_payment',$equity_payment)
         ->with('filtered',$filtered)
         ->with('records',$records)
         ->with('search',$search)
         ->with('filters',$filters)
         ->with('display',$display);
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
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;
        $filtered = $request->input('filter');
        $records = $request->input('records');
        $search = $request->input('search');
        $datefrom = $request->input('date_from');
        $dateto = $request->input('date_to');

        session()->put('filtered',$filtered);
        session()->put('records',$records);
        session()->put('search',$search);
        session()->put('datefrom',$datefrom);
        session()->put('dateto',$dateto);

        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");
         if($filtered=="ALL"){

               $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    // if(strtoupper($search)==strtoupper($mic->client->lastname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                             array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    // }
                 }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     // if(strtoupper($search)==strtoupper($equity->client->lastname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    // }
                }
                }
         }else if($filtered=="LAST NAME"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->client->lastname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                             array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                 }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->client->lastname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }else if($filtered=="FIRST NAME"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->client->firstname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->client->firstname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
              
         }else if($filtered=="BLOCK"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->property->block)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->property->block)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }else if($filtered=="LOT"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->property->lot)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->property->lot)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }





         // View
          $swi =0;
        if($count>=$count1){
            $swi =1;
        }

        return view('report.collection')
        ->with('swi',$swi)
        ->with('client_misc',$client_misc)
        ->with('prop_misc',$prop_misc)
        ->with('misc_block',$misc_block)
        ->with('misc_lot',$misc_lot)
         ->with('misc_pay',$misc_pay)
          ->with('equity_pay',$equity_pay)
        ->with('misc_date',$misc_date)
         ->with('misc_due',$misc_due)
        ->with('misc_payment',$misc_payment)
        ->with('client_equity',$client_equity)
        ->with('prop_equity',$prop_equity)
        ->with('equity_block',$equity_block)
        ->with('equity_lot',$equity_lot)
        ->with('equity_date',$equity_date)
        ->with('equity_due',$equity_due)
        ->with('equity_payment',$equity_payment)
         ->with('filtered',$filtered)
         ->with('records',$records)
         ->with('search',$search)
         ->with('filters',$filters)
         ->with('display',$display);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;
      
     

        $filtered = session('filtered');
        $records = session('records');
        $search = session('search');
        $dateto = session('dateto');
        $datefrom = session('datefrom');
    
        $filters = array("ALL", "LAST NAME", "FIRST NAME", "BLOCK","LOT");
        $display = array("1", "5", "10", "50", "100", "500");
         if($filtered=="ALL"){
                 $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    // if(strtoupper($search)==strtoupper($mic->client->lastname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                             array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    // }
                 }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     // if(strtoupper($search)==strtoupper($equity->client->lastname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    // }
                }
                }
         }else if($filtered=="LAST NAME"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->client->lastname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                             array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                 }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->client->lastname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }else if($filtered=="FIRST NAME"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->client->firstname)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->client->firstname)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }else if($filtered=="BLOCK"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                 $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->property->block)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->property->block)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }else if($filtered=="LOT"){

             $miscs = Misc::where("status",'PAID')->orderBy('id','desc')->get();
                $count= count($miscs);
                $equities = Equity::where("status",'PAID')->orderBy('id','desc')->get();
                $count1= count($equities);
                $client_misc=array();
                $client_equity=array();
                $prop_misc=array();
                $prop_equity=array();
                $equity_block=array();
                $equity_lot=array();
                $misc_block=array();
                $misc_lot=array();
                $tcp=array();
                $status=array();
                $equity_payment=array();
                $equity_date=array();
                $misc_date=array();
                $equity_due=array();
                $misc_due=array();
                $misc_payment=array();
                $equity_date=array();
                $equity_payment=array();
                $equity_pen=array();
                $misc_pen=array();
                $misc_pay=array();
                $equity_pay=array();
                $m=0;
                $e=0;
                $misc_counter=1;
                $equity_counter=1;
                foreach ($miscs as $key => $mic) {
                    if(($dateto>=$mic->date)&&($datefrom<=$mic->date)){
                    if(strtoupper($search)==strtoupper($mic->property->lot)){
                        if($misc_counter<=$records){
                            array_push($client_misc,$mic->client->firstname." ".$mic->client->lastname);
                            array_push($prop_misc,$mic->property->id);
                            array_push($misc_block,$mic->property->block);
                            array_push($misc_due,$mic->date);
                            array_push($misc_lot,$mic->property->lot);
                            array_push($misc_date,$mic->datepaid);
                            array_push($misc_payment,"Php. ".number_format($mic->payment,2));
                            array_push($misc_pay,$mic->payment);
                            $misc_counter=$misc_counter+1;
                        }
                       
                    }
                }
                  
                }
                foreach ($equities as $key => $equity) {
                    if(($dateto>=$equity->date)&&($datefrom<=$equity->date)){
                     if(strtoupper($search)==strtoupper($equity->property->lot)){
                        if($equity_counter<=$records){
                             array_push($client_equity,$equity->client->firstname." ".$equity->client->lastname);
                            array_push($prop_equity,$equity->property->id);
                            array_push($equity_due,$equity->date);
                            array_push($equity_block,$equity->property->block);
                            array_push($equity_lot,$equity->property->lot);
                            array_push($equity_date,$equity->datepaid);
                            array_push($equity_payment,"Php. ".number_format($equity->payment,2));
                            array_push($equity_pay,$equity->payment);
                            $equity_counter=$equity_counter+1;
                        }
                       
                    }
                }
                }
         }





         // View
          $swi =0;
        if($count>=$count1){
            $swi =1;
        }

        // return view('report.collection')
        // ->with('swi',$swi)
        // ->with('client_misc',$client_misc)
        // ->with('prop_misc',$prop_misc)
        // ->with('misc_block',$misc_block)
        // ->with('misc_lot',$misc_lot)
        //  ->with('misc_pay',$misc_pay)
        //   ->with('equity_pay',$equity_pay)
        // ->with('misc_date',$misc_date)
        //  ->with('misc_due',$misc_due)
        // ->with('misc_payment',$misc_payment)
        // ->with('client_equity',$client_equity)
        // ->with('prop_equity',$prop_equity)
        // ->with('equity_block',$equity_block)
        // ->with('equity_lot',$equity_lot)
        // ->with('equity_date',$equity_date)
        // ->with('equity_due',$equity_due)
        // ->with('equity_payment',$equity_payment)
        //  ->with('filtered',$filtered)
        //  ->with('records',$records)
        //  ->with('search',$search)
        //  ->with('filters',$filters)
        //  ->with('display',$display);
         date_default_timezone_set("Asia/Manila");
        $year =date('Y');
        $month=date('m');
        $day=date('d');
        $hour=date('G');
        $min=date('i');
        $sec=date('s');

        $dates=$year."-".$month."-".$day;
        $times=$hour.":".$min.":".$sec;

        $today = $dates." ".$times;
        $logo = url('logo/logo.png');

        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage('L');
        $this->fpdf->SetFont('Arial','',12);
        $this->fpdf->Image($logo,10,10,30);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Mount Malarayat Property Development Corporation",0,0,'L');
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Address",0,0,'L');
        $this->fpdf->Cell(0,5,'',0,1);
        $this->fpdf->Cell(30,5,"",0,0,'L');
        $this->fpdf->Cell(100,5,"Contact Number:",0,0,'L');

        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->SetFont('Arial','',14);
        $this->fpdf->Cell(250,7,"List of Collections",0,0,'C');
        $this->fpdf->SetFont('Arial','',8);
        $this->fpdf->Cell(28,7,$today,0,0,'R');

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(0,10,'',0,1);
        $this->fpdf->Cell(11.16,7,"#",1,0,'C');
        $this->fpdf->Cell(37,7,"Date Due",1,0,'C');
        $this->fpdf->Cell(50.8,7,"Client name",1,0,'C');
        $this->fpdf->Cell(32.9,7,"Property",1,0,'C');
        $this->fpdf->Cell(33.48,7,"EQ Payment",1,0,'C');
        $this->fpdf->Cell(33.48,7,"MF Payment",1,0,'C');
        $this->fpdf->Cell(36.9,7,"Total",1,0,'C');
         $this->fpdf->Cell(37,7,"Date Paid",1,0,'C');

         $this->fpdf->SetFont('Arial','',8);
        if($swi==1){
            foreach ($client_misc as $key => $cl) {
                 $counter=0;
                 $total_equity=0;
                $this->fpdf->Cell(0,7,'',0,1);
                $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
                $this->fpdf->Cell(37,7,$misc_due[$key],1,0,'C');
                $this->fpdf->Cell(50.8,7,$cl,1,0,'C');
                $this->fpdf->Cell(32.9,7,'Block: '.$misc_block[$key].' Lot: '.$misc_lot[$key],1,0,'C');

                foreach ($client_equity as $keys => $equity) {
                   if(($misc_due[$key]==$equity_due[$keys])&&($prop_misc[$key]==$prop_equity[$keys])){
                         $this->fpdf->Cell(33.48,7,$equity_payment[$keys],1,0,'R');
                         $total_equity=$equity_pay[$keys];
                         $counter=1;
                   }
                }
                if($counter==0){
                     $this->fpdf->Cell(33.48,7,'Php. 0.00',1,0,'R');
                }

                $this->fpdf->Cell(33.48,7,$misc_payment[$key],1,0,'R');
                $this->fpdf->Cell(36.9,7,'Php. '.number_format($misc_pay[$key]+$total_equity,2),1,0,'R');
                $this->fpdf->Cell(37,7,$misc_date[$key],1,0,'C');
            }
        }else{
            foreach ($client_equity as $key => $cl) {
                 $counter=0;
                 $total_misc=0;
                $this->fpdf->Cell(0,7,'',0,1);
                $this->fpdf->Cell(11.16,7,$key+1,1,0,'C');
                $this->fpdf->Cell(37,7,$equity_due[$key],1,0,'C');
                $this->fpdf->Cell(50.8,7,$cl,1,0,'C');
                $this->fpdf->Cell(32.9,7,'Block: '.$equity_block[$key].' Lot: '.$equity_lot[$key],1,0,'C');

                

                $this->fpdf->Cell(33.48,7,$misc_payment[$key],1,0,'R');
                foreach ($client_misc as $keys => $misc) {
                   if(($equity_due[$key]==$misc_due[$keys])&&($prop_equity[$key]==$prop_misc[$keys])){
                         $this->fpdf->Cell(33.48,7,$misc_payment[$keys],1,0,'R');
                         $total_misc=$misc_pay[$keys];
                         $counter=1;
                   }
                }
                if($counter==0){
                     $this->fpdf->Cell(33.48,7,'Php. 0.00',1,0,'R');
                }
                $this->fpdf->Cell(36.9,7,'Php. '.number_format($equity_pay[$key]+$total_misc,2),1,0,'R');
                $this->fpdf->Cell(37,7,$equity_date[$key],1,0,'C');
            }
        }
            

            $this->fpdf->Output();
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
