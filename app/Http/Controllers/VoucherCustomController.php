<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Voucher;
class VoucherCustomController extends Controller
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
            $voucher = Voucher::find($id);
            $voucher->status="REMOVED";
            $voucher->save();

             $vouchers = Voucher::where('status','PENDING')->get();
            session()->put('vouchers',$vouchers);
            return redirect('/admin-voucher')->with('success','Successfully remove voucher from the list');
        }else if($request->input('status')=="APPROVED"){

            $voucher = Voucher::find($id);
            $voucher->status="APPROVED";
            $voucher->save();

            $voucher = Voucher::where('status','PENDING');
            $vouchers = Voucher::where('status','PENDING')->get();
            session()->put('vouchers',$vouchers);

            return redirect('/admin-voucher')->with('success','Successfully approved voucher.');
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
