@extends ('headers.header')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/QnA.css') }}">
</head>
<body>

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
							@if ( Auth::user()->admin == 1 || $question->user->name == Auth::user()->name)
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
<div name="CreateQuestionDIV">
	<form action="" method="post" style="text-align:center;">
		<div>
			<p>TITLE</p>
			<input type="text" name="q_title">
		</div>
		<div>
			<p>CONTENT</p>
			<input type="text" name="q_content">
		</div>
	</form>
</div>
</body>
<script type="text/javascript">

	// 테이블 qna_div 투명도 주기
	function BeOpacity(){
		qna_div = document.getElementById('qna_div');
		if(qna_div.style.opacity != "0.4")
			qna_div.style.opacity="0.4";
		else
			qna_div.style.opacity="1.0";
	}

	function FloatBackground(){
		var body = document.body;
		var newDIV = document.createElement("div");				// ==> 배경 투명도
		
		newDIV.setAttribute("id", "myDiv");
		newDIV.style.position = "fixed"
		newDIV.style.backgroundColor = "black";
		newDIV.style.opacity = "0.4";
		newDIV.style.height = "100%";
		newDIV.style.width = "100%";
		newDIV.style.top = "0";
		newDIV.style.left = "0";
		newDIV.onclick = function() {	//누를경우 위에 띄워진 창 제거
			BeOpacity();

			var p = this.parentElement; // 부모 HTML 태그 요소
			p.removeChild(this); // 자신을 부모로부터 제거
		};

		body.appendChild(newDIV);

<div class="Align_Center">
		<!-- <button type="button" id="btn" data-toggle="modal" data-target="#layerpop`">Create Question</button> -->
		<!-- <button class="btn btn-warning btn-detail open_modal">Create Question</button> -->
    <button id="questionModalBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#questionModal" >Create Question</button>

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
  $('#questionModalBtn').click(function(e){
    e.preventDefault();
    console.log('event emitted');
    // $('#questionModal').modal();
    $('#questionModal').modal('show');
  });
});
</script>
@stop
