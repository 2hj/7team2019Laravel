@extends ('headers.header')

@section('content')
<!-- Q & A -->
<div class="contact_info_list">
  <h1>Q & A</h1>
    <!-- 질문글-->
    <h3 id="fill-title">질문글 제목</h3>
    <p id="fill-content">목록을 클릭하면 내용이 여기에 뜸</p>
</div>

<!-- Contact Form -->
<div class="">
  <div class="contact_form">
    <div class="contact_title">Create Question</div>

    {{--질문글 작성 폼--}}
    <form action="{{ route('qna.store') }}" method="POST" class="contact_form" id="contact_form">
    @csrf
      {{--제목--}}
      <input type="text" name="title" id="title" value="{{ old('name') }}" class="contact_input" placeholder="Title">
      {!! $errors->first('title', '<span class="form-error">:message</span>') !!}

      {{--내용--}}
      <textarea name="content" id="content" rows="10" class="contact_input contact_textarea" placeholder="Content" required="required">{{ old('name') }}</textarea>
      {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
      
      <button type="submit" class="contact_button">글 저장</button>
    </form>
  </div>
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
@if($questions->count())
    <div class='text-center' id="questions-render">
        {!! $questions->render() !!}
    </div>
@endif
<p style="text-align: center"><a href="{{ route('qna.create') }}">질문하기</a></p>
<!-- <p style="text-align: center"><a class="save-question">질문하기</a></p> -->
@stop

@section('script')
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
