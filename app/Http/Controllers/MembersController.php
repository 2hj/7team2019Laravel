<?php

namespace App\Http\Controllers;

use Vaildator;
use Illuminate\Http\Request;
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
        // $members = DB::table('members')->get();
        // dd($members);

        return view('members.index', compact('members'));
        // return view('members.index');
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
        // debug("store");
        // dd('dd');

        $members = \App\Member::create($request->all()); 

        // dd($members);
        return $members;
        /* return response([
            'name' => $members[0]['name'],
            'address' => $members[0]['address'],
            'mottoes' => $members[0]['mottoes'],
            'phone_number' => $members[0]['phone_number'],
        ]); */
        
        /* if(!$members) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        return redirect(route('members.index'))->with('flash_message', '작성하신 글이 저장되었습니다.'); */

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
        \App\Member::where('id', '=', $id)->update([
            'name'=>$request->name,
            'address'=>$request->address,
            'phone_number'=>$request->phone_number,
            'mottoes'=>$request->mottoes
        ]);

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

    function members()
    {
        $data = DB::table('members')->get();

        return $data;
    }

    public function test(Request $request) {
        return $request->test;
    }

    public function ajaxtest(Request $request) {
        return $request->test;
    }

    public function createMember(Request $request) {
        // dd($request->testing);
        return $request;
    }
}
