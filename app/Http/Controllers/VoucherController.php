<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Voucher;
use App\Payee;
use App\Admin;
use App\Explanation;
class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::where('status','!=','REMOVED')->get();
        return view('admin_voucher.index')->with('vouchers',$vouchers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payees = Payee::where('status','ACTIVE')->get();
        $admins = Admin::where('status','ACTIVE')->where('usertype','admin')->get();
        $superadmin = Admin::where('usertype','superadmin')->get();
        return view('admin_voucher.create')->with('payess',$payees)->with('admins',$admins)->with('superadmin',$superadmin[0]);
    
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
            'payeename'=>'required',
            'amount'=>'required',
            'cv'=>'required',
            'bankname'=>'required',
            'cheque'=>'required',
            'terms'=>'required',
            'notedby'=>'required'
        ]);
         $voucher = Voucher::where('cv',$request->input('cv'))->get();
         if(count($voucher)>0){
             return redirect('/admin-voucher/create')->with('error','Voucher number is already in the system.');
         }
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
        $today=$year."-".$month."-".$day;
         $user_id = session('Data')[0]->id;
         $approve = Admin::where('usertype','superadmin')->get();
         $approve_id =$approve[0]->id; 

         $voucher = new Voucher;
         $voucher->payee_id=$request->input('payeename');
         $voucher->amount=$request->input('amount');
         $voucher->cv=$request->input('cv');
         $voucher->bank=$request->input('bankname');
         $voucher->cheque=$request->input('cheque');
         $voucher->terms=$request->input('terms');
         $voucher->dates=$today;
         $voucher->prepared_admin_id= $user_id;
         $voucher->noted_admin_id=$request->input('notedby');
         $voucher->approved_admin_id=$approve_id;
         $voucher->status="PENDING";
         $voucher->save();

        $vouchers = new Voucher;
        $vouchers = Voucher::select('id')
        ->where('cv',$request->input('cv'))->get();
        $vid = $vouchers[0]->id;


        $explanation = $request->input('explanation');
        $amount_each = $request->input('amount_each');
         if(strlen($explanation[0])>0){
                 foreach ($explanation as $key => $ex)
                     {
                        $explain = new Explanation;
                        $explain->voucher_id = $vid;
                        $explain->explain=$explanation[$key];
                        $explain->amount=$amount_each[$key];
                        $explain->save();
                       
                     }
            }else{
                  
            }

         return redirect('/admin-voucher')->with('success','Voucher successfully created.');

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
        $voucher = Voucher::find($id);
        $payees = Payee::where('status','ACTIVE')->get();
        $admins = Admin::where('status','ACTIVE')->where('usertype','admin')->get();
        $superadmin = Admin::where('usertype','superadmin')->get();
        return view('admin_voucher.edit')->with('payess',$payees)->with('admins',$admins)->with('superadmin',$superadmin[0])->with('voucher',$voucher);
       
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
         $this->validate($request,[
            'payeename'=>'required',
            'amount'=>'required',
            'cv'=>'required',
            'bankname'=>'required',
            'cheque'=>'required',
            'terms'=>'required',
            'notedby'=>'required'
        ]);
         $voucher = Voucher::where('cv',$request->input('cv'))->get();
         if(count($voucher)>0){
            $voucherid = Voucher::where('id',$id)->where('cv',$request->input('cv'))->get();
            if(count($voucherid)>0){

            }else{
                $path="/admin-voucher/".$id."/edit";
             return redirect($path)->with('error','Voucher number is already in the system.');
            }
         }
         date_default_timezone_set("Asia/Manila");
            $year =date('Y');
            $month=date('m');
            $day=date('d');
         $today=$year."-".$month."-".$day;
         $user_id = session('Data')[0]->id;
         $approve = Admin::where('usertype','superadmin')->get();
         $approve_id =$approve[0]->id; 

         $voucher = Voucher::find($id);
         $voucher->payee_id=$request->input('payeename');
         $voucher->amount=$request->input('amount');
         $voucher->cv=$request->input('cv');
         $voucher->bank=$request->input('bankname');
         $voucher->cheque=$request->input('cheque');
         $voucher->terms=$request->input('terms');
         $voucher->dates=$today;
         $voucher->prepared_admin_id= $user_id;
         $voucher->noted_admin_id=$request->input('notedby');
         $voucher->approved_admin_id=$approve_id;
         $voucher->save();

        Explanation::where('voucher_id',$id)->delete();

        $explanation = $request->input('explanation');
        $amount_each = $request->input('amount_each');
         if(strlen($explanation[0])>0){
                 foreach ($explanation as $key => $ex)
                     {
                        $explain = new Explanation;
                        $explain->voucher_id = $id;
                        $explain->explain=$explanation[$key];
                        $explain->amount=$amount_each[$key];
                        $explain->save();
                       
                     }
            }else{
                  
            }

         return redirect('/admin-voucher')->with('success','Voucher successfully updated.');
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
