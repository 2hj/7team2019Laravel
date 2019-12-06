<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
// use DataTables;

class QnAsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Question::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('qna');

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

    /*
    public function store(Request $request)
    {
        // 사용자입력값에 대한 유효성 검사 규칙
        $rules = [
            'title' => ['required'],
            'content' => ['required', 'min:10'],
        ];

        // 오류메시지 커스터마이징
        $messages = [
          'title.required' => '제목은 필수 입력 항목입니다.',
          'content.required' => '본문은 필수 입력 항목입니다.',
          'content.min' => '본문은 최소 :min 글자 이상 필요합니다.',
        ];

        //
        //   $validator = \Validator::make($request->all(), $rules, $messages);

        //   if($validator->fails()) {
        //       return back()->withError($validator)->withInput();
        //   }
        //
        // 트레이트의 메서드 validate() == (유효성검사기만들기 + 유효성검사 통과못할 시 오류메시지 세션에저장 + 이전페이지로 돌려보내기)
        $this->validate($request, $rules, $messages);
        $question = \App\User::find(1)->questions()->create($request->all());

        if(! $question) {
            return back()->with('flash_message', '글이 저장되지 않았습니다')->withInput();
        }

        return redirect(route('qna.index'))->with('flash_message', '작성하신 글이 저장되었습니다');

    }
    */

    public function store(Request $request){
      $rules = array(
        'title'=>'required',
        'content'=>'required|min:10',
      );

      $validator = \Validator::make($request->all(), $rules);

      if($validator->fails()){
        return response()->json(['error'=> $validator->errors()->all()]);
      }

      $question = array(
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => $request->hidden_id,
      );

      Question::create($question);

      return response()->json(['success'=>'Data Added Successfully!']);
    // public function store(\App\Http\Requests\QuestionsRequest $request){
    //     // $question = \App\User::find(1)->questions()->create($request->all());
    //     $question = auth()->user()->questions()->create($request->all());

    //     if(! $question){
    //         return back()->withErrors('flash_message', '글이 저장되지 않았습니다.')->withInput();
    //     }

    //     return redirect(route('qna.index'))->with('flash_message', '작성한 글이 저장되었습니다.');
    // }

    // 이상민코드
    // public function store(Request $request)
    // {
    //     Question::updateOrCreate(['id' => $request->id],
    //             ['title' => $request->title, 'content' => $request->content, 'user_id' => $request->user_id]);
    //     return response()->json(['success'=>'Content saved successfully.']);
    // }

    // public function store(\App\Http\Requests\QuestionsRequest $request){
    //     // $question = \App\User::find(1)->questions()->create($request->all());
    //     // $question = auth()->user()->questions()->create($request->all());

    //     // if(! $question){
    //       if($request->fails()){
    //         // return back()->withErrors('flash_message', '글이 저장되지 않았습니다.')->withInput();
    //         return response()->json(['errors'=> $error->errors()->all()]);
    //     }

    //     $form_data = array(
    //       'title' => $request->title,
    //       'content' => $request->content,
    //       'user_id' => $request->hidden_id
    //     );

    //     $question = Question::create($form_data);
    //     return response()->json(['success'=>'Data Added Successfully.']);

    //     // return response()->json();
    //     return redirect(route('qna.index'))->with('flash_message', '작성한 글이 저장되었습니다.');
    // }

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
        $question = Question::find($id);
        return response()->json($question);
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
        \App\Question::find($id)->delete();

        return response($id);

        // 이상민 코드
        // Question::find($id)->delete();
        //
        // return response()->json(['success'=>'Question deleted successfully.']);

    }

}
