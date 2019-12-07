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

    public function index()
    {
        $questions = \App\Question::with('user')->latest()->paginate(10);
        
        return view('qna.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $search = \App\Question::where('id', '=', $id)->get();
        
      return response([
          'qid' => $search[0]['id'],
          'value' => $search[0]['content'],
      ]);
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
      // $question = Question::find($id);
      // return response()->json($question);
      return response()->json($id);
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
    }

}
