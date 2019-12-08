<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return response($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'answer_content'=>'required',
        ];
    
          $validator = \Validator::make($request->all(), $rules);
    
          if($validator->fails()){
            return response()->json(['error'=> $validator->errors()->all()]);
          }
    
          $answerArray = array(
            'target_id'=>$request->aid,
            'answer_content' => $request->content,
          );
    
          $question =\App\Answer::create($answerArray);
    
          return response($answer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $search = \App\Answer::where('target_id', '=', $id)->get();
        
        if(! $search) {
            return response(['']);
        }

        return response($search);
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
        \App\Answer::find($id)->delete();

        return response($id);
    }
}