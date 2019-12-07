<?php

namespace App\Http\Controllers;

use Vaildator;
use Illuminate\Http\Request;
use App\Http\Requests\MembersRequest;
use App\Member;

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

        return view('members.index_before', compact('members'));


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
        $members = \App\Member::create($request->all()); 

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



    function action(Request $request)
    {
     $validation = Validator::make($request->all(), [
      'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
     ]);
     if($validation->passes())
     {
      $image = $request->file('img');
      $new_name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('images'), $new_name);
      return response()->json([
       'message'   => 'Image Upload Successfully',
       'memberImage_${member_id}' => '<img src="/images/'.$new_name.'" class="img-thumbnail" width="300" />',
       'class_name'  => 'alert-success'
      ]);
     }
     else
     {
      return response()->json([
       'message'   => $validation->errors()->all(),
       'memberImage_${member_id}' => '',
       'class_name'  => 'alert-danger'
      ]);
     }
    }

}
