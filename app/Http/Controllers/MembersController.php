<?php

namespace App\Http\Controllers;

use Vaildator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
      
        if(Auth::check()) {
            $user = Auth::user();

            $admin = $user->admin;

            return view('members.index', compact('members', 'admin'));
        }
        else {
            return view('members.index', compact('members'));            
        }
        
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

            $member = \App\Member::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>$filename,
            ]); 
        } 
        else {
            $member = \App\Member::create([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>null,
            ]); 
        }
        
        

        return $member;
        
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

        if(Auth::check()) {
            $user = Auth::user();

            $admin = $user->admin;

            return compact('member', 'admin');
        }
        else {
            $admin = 0;
            return compact('member', 'admin');
        }
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
      //   $image = $request->file("img");
      //   $filename = Str::random(15).filter_var($image->getClientOriginalName(),FILTER_SANITIZE_URL);
      //   $image->move(public_path('img'),$filename);

      //   $update_member = \App\Member::where('id', '=', $id)->update([
      //       'name'=>$request->name,
      //       'address'=>$request->address,
      //       'phone_number'=>$request->phone_number,
      //       'mottoes'=>$request->mottoes,
      //       'img'=>$filename,
      //   ]);
      // }
      // else {
      //     $update_member = \App\Member::where('id', '=', $id)->update([
      //         'name'=>$request->name,
      //         'address'=>$request->address,
      //         'phone_number'=>$request->phone_number,
      //         'mottoes'=>$request->mottoes,
      //         'img'=>$request->img,
      //     ]);
      // } 

      // $member = $update_member::get();

      // return $member;

        if($request->has('img')) {
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
        }
        else {
            \App\Member::where('id', '=', $id)->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'phone_number'=>$request->phone_number,
                'mottoes'=>$request->mottoes,
                'img'=>$request->img,
            ]);
        } 
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