$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Create a Question ajax
  $('#createQuestion').click(function(e){
    $('#action_button').val('Add');
    $('#title').val('');
    $('#content').val('');
    $('#questionModal').modal('show');
  });

  // 글 내용 리로드
  function reloadAdd(data){
    var li = document.createElement('li');
    li.setAttribute('class', 'openQuestion');
    li.setAttribute('id', 'ques_'+data['id']);

    var p1 = document.createElement('p');
    p1.setAttribute('id', 'questionId');
    p1.setAttribute('style', 'color=#FFFFFF;');
    p1.innerHTML = data['id'];

    var p2 = document.createElement('p');
    p2.innerHTML = data['title'];
    
    var small = document.createElement('small');
    small.setAttribute('style', 'color: #FFFFFF;');
    small.innerHTML = 'by' + data['user_id'];

    li.appendChild(p1);
    li.appendChild(p2);
    li.appendChild(small);

    var optionDiv = document.createElement('div');
    optionDiv.setAttribute('id', 'option_'+data['id']);

    var parent = document.getElementById('div');
    parent.prepend(optionDiv);
    parent.prepend(li);

    document.getElementById('ques_'+data['id']).addEventListener('click', function(){
        onClickEvent(data['id']);
    });
  }

  // 수정 후 리로드
  function reloadEdit(data){
    var ques_id = '#ques_'+data['hidden_qid'];
    // var option_id = '#option_'+data['hidden_qid'];
    // console.log(ques_id);
    // $(ques_id)[0]['id'] = 'ques_'+(data['id']);
    // console.log( $(ques_id).children() );
    
    $(ques_id).children()[1].innerHTML = data['title'];

    // 글 클릭 할 때 펼쳐지면서 추가되는 #questionValue가 3번째 칠드런
    $(ques_id).children()[3].innerHTML = data['content'];
  }


  $('#question-form').on('submit', function(e){
    e.preventDefault();

    // var form = $('#question-form')[0];
    // console.log(form);
    // var data = new FormData(form);

    // 글 저장을 누른 경우
    if( $('#action_button').val() == 'Add' ){
      $.ajax({
        url: "/qna",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        success: function(data){
          console.log('success');
          console.log(data);
          $('#questionModal').modal('hide');
          if(data['content']) {
            reloadAdd(data);
          }
          // document.querySelector('.openQuestion').addEventListener('click');
        }
      });
    }

    // 글 수정을 할 경우
    if( $('#action_button').val() == 'Edit' ){
      var qid = $('#hidden_qid')[0]['value'];
      console.log(qid);
      var form = $('#question-form')[0];
      var data = new FormData(form);
      data.append('_method', 'patch');

      $.ajax({
        type: 'POST',
        url: '/qna/'+qid,
        data: data,
        processData: false,
        contentType: false,
        success: function(data){
          console.log('success');
          console.log(data);
          $('#title').val('');
          $('#content').val('');
          $('#action_button').val('Add');
          $('#questionModal').modal('hide');
          
          reloadEdit(data);
        }
      });
    }
  });

  // openquestion 클래스 각각에 click 속성을 추가
  document.querySelectorAll('.openQuestion').forEach(function (e){
    e.addEventListener('click',function(){
      let selectOpen = e.querySelector('#questionId').innerHTML;
      onClickEvent(selectOpen);
    });
  });

  // 글이 선택 되었는지 유무를 판단
  var selected = -1;

  // 클릭이 일어난 경우
  function onClickEvent(selectOpen){
    console.log('글 클릭함');
    $.ajax({
      type: 'get',
      url: '/qna/' + selectOpen,
      data: selectOpen,
      success: function(result){      
          deleteModule(result['qid']);
          var p = document.createElement('p');
          p.innerHTML = result['content'];
          p.setAttribute('id', 'questionValue');
          if(selected != result['qid']) {
            selected = result['qid'];
            document.getElementById('ques_'+result['qid']).appendChild(p);
            
            var editBtn = document.createElement('button');
            editBtn.innerHTML = '수정';
            editBtn.setAttribute('id', 'editQuestion');
            editBtn.setAttribute('data-edit-id', result['qid']);
            editBtn.addEventListener('click', onClickEdit);
            document.getElementById('option_'+result['qid']).appendChild(editBtn);

            var showAnswerBtn = document.createElement('button');
            showAnswerBtn.innerHTML = '답변';
            showAnswerBtn.setAttribute('id', 'showAnswer');
            showAnswerBtn.setAttribute('data-answer-id', result['qid']);
            showAnswerBtn.addEventListener('click', onClickShowAnswer);
            document.getElementById('option_'+result['qid']).appendChild(showAnswerBtn);
            console.log(result['qid']);


            var deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = '삭제';
            deleteBtn.setAttribute('id', 'deleteQuestion');
            deleteBtn.setAttribute('data-delete-id', result['qid']);
            deleteBtn.addEventListener('click', onClickDelete);
            document.getElementById('option_'+result['qid']).appendChild(deleteBtn);
          
          } else {
            selected = -1;
          }
      }
    });
  }

  // 수정 버튼을 누른 경우
  function onClickEdit(){
    var editID = $('#editQuestion').attr('data-edit-id');
    $('div#answer_'+selectedAnswer).html('');
    $('#action_button').val('Edit');
    
    $.ajax({
      type: 'get',
      url: '/qna/'+editID+'/edit',
      success: function(data){
        console.log(data);
        console.log(document.forms);
        var form = document.forms[2];
        form.elements[1]['value'] = data.title;
        form.elements[2]['value'] = data.content;
        form.elements[4]['value'] = data.id;
        $('#questionModal').modal('show');
      }
    });
  }

  // 삭제 버튼을 누른 경우
  function onClickDelete() {
    var deleteId = $('#deleteQuestion').attr('data-delete-id');
    $('div#answer_'+selectedAnswer).html('');
    
    if(confirm('글을 삭제 하시겠습니까?')) {
      $.ajax({
        type:'delete',
        url: '/qna/'+deleteId,
        success: function(deleteId) {
          $('li#ques_'+deleteId).remove();
          deleteModule(deleteId)
        }
      });
    }
  }

  var selectedAnswer = -1;

  // 답변 보기
  function onClickShowAnswer() {
    var showAns = $('#showAnswer').attr('data-answer-id');

    $.ajax({
      type:'get',
      url: '/qna/'+showAns+'/answer/'+showAns,
      data: showAns,
      success: function(data) {
        var result = data[0];

        if(data[0] != null) {
          console.log(result['id']);

          if(result['id'] == selectedAnswer) { 
            $('#ans_'+result['id']).remove();
            $('button#ansEditBtn').remove();
            $('button#ansDeleteBtn').remove();
            
            selectedAnswer = -1;
          } else {
            var p = document.createElement('p');
            p.innerHTML = result['answer_content'];
            p.setAttribute('id', 'ans_'+result['id']);

            var ansEidt = document.createElement('button');
            ansEidt.innerHTML = '답변 수정';
            ansEidt.setAttribute('id', 'ansEditBtn');

            var ansDelete = document.createElement('button');
            ansDelete.innerHTML = '답변 삭제';
            ansDelete.setAttribute('data-ans-del-id', result['id']);
            ansDelete.setAttribute('id', 'ansDeleteBtn');
            ansDelete.addEventListener('click', deleteAnswer);
            
            var ansDiv = document.getElementById('answer_'+result['id']);
            ansDiv.appendChild(p);
            ansDiv.appendChild(ansEidt);
            ansDiv.appendChild(ansDelete);

            selectedAnswer = result['id'];
          }
        } else {
          $.ajax({
            type:'get',
            url: '/qna/'+showAns+'/answer/create',
            data: showAns,
            success: function(result) {
              console.log(result);
              
              if(selectedAnswer != result) {
                selectedAnswer = result;
                var html = $(`
                  <form id="answer-form">
                    <div class="answer-group" data-ans-in-id="${selectedAnswer}">
                      <label for="answer_content" class="col-form-label">본문</label>
                      <textarea class="form-control" name="answer_content" id="answer_content"></textarea>
                    </div>
                    <div class="answer-group">
                      <input type="submit" name="answer_button" id="answer_button" class="btn btn-warning" value="Add Ans">
                    </div>
                  </form>
                `);
                $('div#answer_'+selectedAnswer).append(html);
              } else {
                $('div#answer_'+selectedAnswer).html('');
                selectedAnswer = -1;
              }
            }
          });

        }
      }
    });
  }

  function deleteAnswer() {
    var deleteAns = $('button#ansDeleteBtn').attr('data-ans-del-id');

    if(confirm('댓글을 삭제 하시겠습니까?')) {
      $.ajax({
        type: 'delete',
        url: '/qna/'+ deleteAns +'/answer/' + deleteAns,
        data: deleteAns,
        success: function(id) {
          $('p#ans_'+id).remove();
          $('button#ansEditBtn').remove();
          $('button#ansDeleteBtn').remove();
        }
      });
    }
  }
  
  // 일괄 삭제/숨김 함수
  function deleteModule(id) {
    $('p#questionValue').remove();
    $('button#editQuestion').remove();
    $('button#showAnswer').remove();
    $('button#deleteQuestion').remove();
    $('p#ans_'+id).remove();
    $('button#ansEditBtn').remove();
    $('button#ansDeleteBtn').remove();
    $('div#answer_'+selectedAnswer).html('');
  }


  $('#answer-form').on('submit', function(e){
    e.preventDefault();
    console.log('에이작스 전');
    // 답변 저장
    if( $('#answer_button').val() == 'Add Ans' ){
      var aid = $('div#answer-group').attr('data-ans-in-id');
      console.log(aid);

      $.ajax({
        url: "/qna/"+ aid + '/answer',
        method: "POST",
        data: {
          aid: aid,
          answer_content: answer_content,
        },
        success: function(data){
          console.log('success');
          console.log(data);
        },
        error: function(request, status, error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
      });
    }
  });
});

