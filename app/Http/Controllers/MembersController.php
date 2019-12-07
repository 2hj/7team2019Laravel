<?php

namespace App\Http\Controllers;

use Vaildator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\MembersRequest;
use App\Member;
use Datatables;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = \App\Member::get();
        
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 타입형을 Request 클래스 경로로 바꾸어준다
    // \App\Http\Requests\MembersRequest
    public function store(Request $request)
    {
        if($request->has('img')) {
            $image = $request->file("img");
            $filename = Str::random(15).filter_var($image->getClientOriginalName(),FILTER_SANITIZE_URL);
            $image->move(public_path('img'),$filename);

            $members = \App\Member::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>$filename,
            ]); 
        } 
        else {
            $members = \App\Member::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>null,
            ]); 
        }
        
        

        return $members;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $member = \App\Member::where('id', '=', $id)->get();

        return $member;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
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
        // if($request->has('img')) {
            $image = $request->file("img");
            $filename = Str::random(15).filter_var($image->getClientOriginalName(),FILTER_SANITIZE_URL);
            $image->move(public_path('img'),$filename);

            \App\Member::where('id', '=', $id)->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>$filename,
            ]);
        /* }
        else {
            \App\Member::where('id', '=', $id)->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>null,
            ]);
        } */

        

        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Member::find($id)->delete();

        return response($id);
    }

}