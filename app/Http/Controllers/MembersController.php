<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MembersRequest;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 타입형을 Request 클래스 경로로 바꾸어준다
    // \App\Http\Requests\MembersRequest
    public function store(MembersRequest $request)
    {
        /* $rules = [
            // 이름, 폰번호, 모토 유효성 검사 규칙
            'name' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'motto' => ['required', 'min:10'],
        ];

        $messages = [
            'name.required' => '이름은 필수 입력 항목입니다.',
            'phone_number.required' => '전화번호는 필수 입력 항목입니다.',
            'address' => '주소는 필수 입력 항목입니다.',
            'motto.required' => '모토는 필수 입력 항목입니다.',
            'motto.min' => '본문은 최소 :min 글자 이상이 필요합니다.',
        ];

        $this->validate($request, $rules, $messages);

        $validator = \Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } */

        // $validated = $request->validated();
        

        $members = \App\Member::create($request->all()); 

        if(!$members) {
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        return redirect(route('members.index'))->with('flash_message', '작성하신 글이 저장되었습니다.');

        /* $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'phone_number' => 'required|max:13',
            'motto' => 'required|min:10',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
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
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('members.edit');
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
        dd($request->checking);
        return $request->checking;
    }
}
