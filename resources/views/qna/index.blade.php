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



<div id="qna_div">
	<table class="table-container">
		<thead>
			<tr>
				<th><h1>번호</h1></th>
				<th><h1>제목</h1></th>
				<th><h1>작성자</h1></th>
				<th><h1>작성일</h1></th>
			</tr>
		</thead>
		@foreach ($questions as $question)
			<tbody id="{{ $question->id }}">
				<tr class="title">
						<td>
							<p>{{ $question->id }}</p>
						</td>
						<td>
							<p>{{ $question->title }}</p>
						</td>
						<td>
							<p>{{ $question->user->name }}</p>
						</td>
						<td>
							<p>{{ $question->created_at }}</p>
						</td>
				</tr>

				<tr name="content">
					<td colspan="4">
						<p>{{ $question->content }}</p>
						@auth
							@if ( Auth::user()->admin == 1 )
								<button class="btn-delete">
									삭제
								</button>
							@endif
						@endauth
					</td>
				</tr>
			</tbody>
		@endforeach
	</table>
</div>

<div class="right-side">
  <h1 style="color: #FFFFFF;">포럼 글 목록</h1>
  <hr/>
  <ul>
      @forelse($questions as $question)
        <li class="openQuestion" id="ques_{{$question->id}}">
          <p id="questionId" style="color: #FFFFFF;">{{ $question->id }}</p>
          <p> {{ $question->title }} </p>
          <small style="color: #FFFFFF;"> by {{ $question->user->name }} </small>
        </li>
      @empty
        <p style="color: #FFFFFF;">글이 없습니다</p>
      @endforelse
  </ul>
</div>


<!-- 질문글 작성 모달창 -->
<div class="modal fade" id="questionModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Create Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
      </div>

      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="question-title" class="col-form-label">Title</label>
            <input type="text" class="form-control" id="question-title">
          </div>
          <div class="form-group">
            <label for="question-content" class="col-form-label">Content</label>
            <textarea class="form-control" id="question-content"></textarea>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">질문 저장하기</button>
        <!-- <button type="button" class="btn btn-primary">질문 저장</button> -->
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{ URL::asset('js\jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::asset('css\styles\bootstrap-4.1.2\bootstrap.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css\styles\bootstrap-4.1.2\bootstrap.min.css') }}">
<script>
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var selected = -1;

  document.querySelectorAll('.openQuestion').forEach(function (e){
    e.addEventListener('click',function(){
      let id = e.querySelector('#questionId').innerHTML;
      onClick(id);
    });
  });

  function onClick(id){
    $.ajax({
      headers:{
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },
      type: 'get',
      url: '/qna/' + id,
      data: {
        "_token": "{{ csrf_token() }}",
        qid: id,
      },
      success: function(result){
        $('p#questionValue').remove();
        var p = document.createElement('p');
        p.innerHTML = result['value'];
        p.setAttribute('id', 'questionValue');
        if(selected != result['qid']) {
          selected = result['qid'];
          document.getElementById('ques_'+result['qid']).appendChild(p);
        } else {
          selected = -1;
        }
      },
      error: function(request, status, error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      }
    });
  }
});
</script>
@stop