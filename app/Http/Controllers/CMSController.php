<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banner;
use App\Listings;
use App\About;
use App\Message;
class CMSController extends Controller
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
            if($request->input('cms')=="BANNER"){
                $banner = Banner::find($id);
                $banner->status = "DRAFT";
                $banner->save();
                return redirect('/admin-banner')->with('success','Banner successfully removed from the active list.');
            }else if($request->input('cms')=="LISTINGS"){
                $listings = Listings::find($id);
                $listings->status = "DRAFT";
                $listings->save();
                return redirect('/admin-listings')->with('success','Listings successfully removed from the active list.');
            }else if($request->input('cms')=="MESSAGE"){
                Message::where('id',$id)->delete();
                return redirect('/admin-inquiry')->with('success','Inquiry successfully deleted.');
            }
          
        }else if($request->input('status')=="PUBLISHED"){
            if($request->input('cms')=="BANNER"){
                $banner = Banner::find($id);
                $banner->status = "PUBLISHED";
                $banner->save();
                return redirect('/admin-banner')->with('success','Banner successfully published to the active list.');
            }else if($request->input('cms')=="LISTINGS"){
                $listings = Listings::find($id);
                $listings->status = "PUBLISHED";
                $listings->save();
                return redirect('/admin-listings')->with('success','Listings successfully published to the active list.');
            }
          
        }else if($request->input('status')=="STAR"){
            if($request->input('cms')=="BANNER"){
                $banner = Banner::find($id);
                $banner->status = "PUBLISHED";
                $banner->save();
                return redirect('/admin-banner')->with('success','Banner successfully published to the active list.');
            }else if($request->input('cms')=="LISTINGS"){
                $listings = Listings::find($id);
                $listings->status = "LATEST";
                $listings->save();
                return redirect('/admin-listings')->with('success','Listings successfully make to the latest list.');
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
