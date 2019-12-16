@extends ('headers.header')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/QnA.css') }}">

<div>
	@auth
    <input class="useradmininput" type="hidden" value="{{ Auth::user()->admin }}">
    <input class="userinput" type="hidden" value="{{ Auth::user()->id }}">
	@else
		<input class="useradmininput" type="hidden" value="-1">
	@endauth
</div>


<div class="question-list">
  <h1 style="color: #FFFFFF;">질문 목록</h1>
  <hr/>
  <div id="question-list">
    <ul id="ul">
      <div id="div"></div>
        @forelse($questions as $question)
        <li class="openQuestion" id="ques_{{$question->id}}" style="padding: 10px;"></style>
          <p id="questionId" style="color: #FFFFFF;">{{ $question->id }}</p>
          <p> {{ $question->title }} </p>
          <small style="color: #FFFFFF;"> by {{ $question->user->name }} </small>
          <div style="display: none;">{{$question->user->id}}</div>
        </li>
          <div style="padding: 10px;" id="option_{{$question->id}}"></div>
          <div style="padding: 10px;" id="answer_{{$question->id}}"></div>
        @empty
        <p style="color: #FFFFFF; padding: 10px;">글이 없습니다</p>
        @endforelse
    </ul>
  </div>
</div>

<br>

<!-- Trigger Modal -->
<div class="Align_Center">
  {{ $questions->links() }}
  
  <button type="button" id="createQuestion" name="createQuestion" class="btn btn-success btn-sm" data-toggle="modal" data-target="#questionModal" data-backdrop="false">Create Question</button>
</div>

<!-- 질문글 작성 모달창 -->
<div class="modal fade" id="qnaModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">새 글 쓰기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
      </div>

      <div class="modal-body">
        <span id="form_result"></span>
        <form id="qna-form">
          @csrf

          <div id="modalTitle" class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title" class="col-form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            <!-- @include('flash::message') -->

            {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
          </div>

          <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            <label for="content" class="col-form-label">본문</label>
            <textarea class="form-control" name="content" id="content">{{ old('content') }}</textarea>
            <!-- @include('flash::message') -->

            {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
          </div>
          
          <div class="form-group">
            <input type="hidden" name="hidden_id" id="hidden_id" value="{{ Auth::id() }}">
            <input type="hidden" name="hidden_qnaid" id="hidden_qnaid" value="">
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
<script src="js/qna.js"></script>
@stop