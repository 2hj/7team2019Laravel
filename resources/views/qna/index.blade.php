@extends ('headers.header')

@section('content')

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/QnA.css') }}">

<div>
	@auth
		<input class="useradmininput" type="hidden" value="{{ Auth::user()->admin }}">
	@else
		<input class="useradmininput" type="hidden" value="0">
	@endauth
</div>

<!-- <div class="table-responsive">
  <table class="table table-bordered table-striped" id="question_table">
    <thead>
      <tr>
        <th width="10%">번호</th>
        <th width="35%">제목</th>
        <th width="35%">작성자</th>
        <th width="50%">작성일</th>
      </tr>
    </thead>
  </table>
</div>
<br>
<br> -->

<div class="question-list">
  <h1 style="color: #FFFFFF;">질문 목록</h1>
  <hr/>
  <div id="question-list">
    <ul id="ul">
      <div id="div"></div>
      
        <!-- <li class="openQuestion idAdd" id="add">
          <p class="addQuestionId" id="questionId" style="color:#FFFFFF;"></p>
          <p id="addTitle"></p>
          <small id="addUserName" style="color: #FFFFFF;"></small>
        </li>
        <div class="option" id=""></div> -->
        @forelse($questions as $question)
        <li class="openQuestion" id="ques_{{$question->id}}">
          <p id="questionId" style="color: #FFFFFF;">{{ $question->id }}</p>
          <p> {{ $question->title }} </p>
          <small style="color: #FFFFFF;"> by {{ $question->user->name }} </small>
        </li>
        <div id="option_{{$question->id}}"></div>
        @empty
        <p style="color: #FFFFFF;">글이 없습니다</p>
        @endforelse
    </ul>
  </div>
</div>

@if($questions->count())
  <div class="text-center">
    {!! $questions->render() !!}
  </div>
@endif

<!-- Trigger Modal -->
<div class="Align_Center">
    <button type="button" id="createQuestion" name="createQuestion" class="btn btn-success btn-sm" data-toggle="modal" data-target="#questionModal" data-backdrop="false">Create Question</button>
</div>

<!-- 질문글 작성 모달창 -->
<div class="modal fade" id="questionModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">새 글 쓰기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
      </div>

      <div class="modal-body">
        <span id="form_result"></span>
        <form id="question-form">
          @csrf

          <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title" class="col-form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            <!-- {!! $errors->first('title', '<span class="form-error">:message</span>') !!} -->
          </div>

          <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            <label for="content" class="col-form-label">본문</label>
            <textarea class="form-control" name="content" id="content">{{ old('content') }}</textarea>
            <!-- {!! $errors->first('content', '<span class="form-error">:message</span>') !!} -->
          </div>
          
          <div class="form-group">
            <input type="hidden" name="hidden_id" id="hidden_id" value="{{ Auth::id() }}">
            <input type="hidden" name="hidden_qid" id="hidden_qid" value="">
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add">
          </div>

        </form>
      </div>

      <div class="modal-footer">
        
        <button id="closeQuestionModal" type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{ URL::asset('js\jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::asset('css\styles\bootstrap-4.1.2\bootstrap.min.js') }}"></script>
<script src="js/question.js"></script>
@stop