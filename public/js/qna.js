$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Create a Question ajax
  $('#createQuestion').click(function(e){
    if(document.getElementsByClassName('useradmininput')[0].value == 1 ||
    document.getElementsByClassName('useradmininput')[0].value == 0 ) {
      $('div#modalTitle').css('display', 'inline');
      $('#action_button').val('Add');
      $('#title').val('');
      $('#content').val('');
      $('#qnaModal').modal('show');
    } else {
      alert('로그인이 필요합니다.');
    }
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
    small.innerHTML = 'by ' + data['user_id'];

    var userDiv = document.createElement('div');
    userDiv.innerHTML = $('input.userinput').val();
    userDiv.setAttribute('style', 'display: none;');

    var optionDiv = document.createElement('div');
    optionDiv.setAttribute('id', 'option_'+data['id']);
    optionDiv.setAttribute('style', 'padding: 10px;');
    
    var answerDiv = document.createElement('div');
    answerDiv.setAttribute('id', 'answer'+data['id']);
    answerDiv.setAttribute('style', 'padding: 10px;');

    var parent = document.getElementById('div');

    li.appendChild(p1);
    li.appendChild(p2);
    li.appendChild(small);
    li.appendChild(userDiv);

    parent.appendChild(li);
    parent.appendChild(optionDiv);
    parent.appendChild(answerDiv);

    document.getElementById('ques_'+data['id']).addEventListener('click', function(){
        onClickEvent(data['id']);
    });
  }

  // 수정 후 리로드
  function reloadEdit(data){
    console.log(data);
    $('#ques_'+data['hidden_qnaid']).children()[1].innerHTML = data['title'];
    $('#option_'+data['hidden_qnaid']).children()[0].innerHTML = data['content'];
  }


  $('#qna-form').on('submit', function(e){
    e.preventDefault();

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
          $('#qnaModal').modal('hide');
          if(data['content']) {
            reloadAdd(data);
          }
        }
      });
    }

    // 글 수정을 할 경우
    if( $('#action_button').val() == 'Edit' ){
      var qid = $('#hidden_qnaid')[0]['value'];
      var form = $('#qna-form')[0];
      var data = new FormData(form);
      data.append('_method', 'patch');

      $.ajax({
        type: 'POST',
        url: '/qna/'+qid,
        data: data,
        processData: false,
        contentType: false,
        success: function(data){
          $('div#modalTitle').css('display', 'inline');
          $('#title').val('');
          $('#content').val('');
          $('#action_button').val('Add');
          $('#qnaModal').modal('hide');
          reloadEdit(data);
        }
      });
    }

    // 답글 저장
    if( $('#action_button').val() == 'Add Ans' ) {
      var aid = $('#hidden_qnaid').val();
      console.log(aid);
      var content = $('textarea#content').val();

      $.ajax({
        url: "/qna/" + aid + '/answer',
        method: "POST",
        data: {
          id: aid,
          content: content,
        },
        success: function(data) {
          $('#qnaModal').modal('hide')
          console.log(data);
        }
      });
    }

    // 답글 수정
    if( $('#action_button').val() == 'Edit Ans') {
      var aid = $('#hidden_qnaid').val();
      var form = $('#qna-form')[0];
      var data = new FormData(form);
      data.append('_method', 'patch');

      $.ajax({
        type: 'POST',
        url: '/qna/'+aid+'/answer/'+aid,
        data: data,
        processData: false,
        contentType: false,
        success: function(data){
          console.log(data);
          selectedAnswer = -1;
          $('p#ans_'+data['hidden_qnaid']).remove();
          $('button#ansEditBtn').remove();
          $('button#ansDeleteBtn').remove();
          $('#qnaModal').modal('hide');
        },
        error: function(e) {
          console.log(e);
          console.log('Error!');
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
      success: function(result){      
        deleteModule(result['qid']);
        var p = document.createElement('p');
        p.innerHTML = result['content'];
        p.setAttribute('id', 'questionValue');
        if(selected != result['qid']) {
          var body = document.getElementById('option_'+result['qid']);
          selected = result['qid'];
          body.appendChild(p);
          
          var editBtn = document.createElement('button');
          editBtn.innerHTML = '수정';
          editBtn.setAttribute('id', 'editQuestion');
          editBtn.setAttribute('data-edit-id', result['qid']);
          editBtn.setAttribute('class', 'btn');
          editBtn.addEventListener('click', onClickEdit);

          var showAnswerBtn = document.createElement('button');
          showAnswerBtn.innerHTML = '답변';
          showAnswerBtn.setAttribute('id', 'showAnswer');
          showAnswerBtn.setAttribute('data-answer-id', result['qid']);
          showAnswerBtn.setAttribute('class', 'btn');
          showAnswerBtn.addEventListener('click', onClickShowAnswer);
          
          var deleteBtn = document.createElement('button');
          deleteBtn.innerHTML = '삭제';
          deleteBtn.setAttribute('id', 'deleteQuestion');
          deleteBtn.setAttribute('data-delete-id', result['qid']);
          deleteBtn.setAttribute('class', 'btn');
          deleteBtn.addEventListener('click', onClickDelete);
          
          if(document.getElementsByClassName('useradmininput')[0].value == 0 ||
          document.getElementsByClassName('useradmininput')[0].value == 1) {
            body.appendChild(editBtn);
            body.appendChild(showAnswerBtn);
            body.appendChild(deleteBtn);
          } else {
            body.appendChild(showAnswerBtn);
          }
          
        } else {
          selected = -1;
        }
      }
    });
  }

  // 수정 버튼을 누른 경우
  function onClickEdit(){
    var editID = $('#editQuestion').attr('data-edit-id');
    console.log(editID);
    var user = $('#ques_'+editID).children()[3].innerHTML;

    console.log(user);
    
    if(user == document.getElementsByClassName('userinput')[0].value ||
    document.getElementsByClassName('useradmininput')[0].value == 1) {
      $('div#modalTitle').css('display', 'inline');
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
          $('#qnaModal').modal('show');
        }
      });
    } else {
      alert('다른 사용자의 글은 수정할 수 없습니다.');
    }
  }

  // 삭제 버튼을 누른 경우
  function onClickDelete() {
    var deleteId = $('#deleteQuestion').attr('data-delete-id');
    var user = $('#ques_'+deleteId).children()[3].innerHTML;
    
    console.log(user);
    console.log(document.getElementsByClassName('userinput')[0].value);
    
    if(user == document.getElementsByClassName('userinput')[0].value ||
    document.getElementsByClassName('useradmininput')[0].value == 1) {
      $('div#answer_'+selectedAnswer).html('');
      
      if(confirm('글을 삭제 하시겠습니까?')) {
        $.ajax({
          type:'delete',
          url: '/qna/'+deleteId,
          success: function(deleteId) {
            $('li#ques_'+deleteId).remove();
            deleteModule(deleteId);
            $('div#option_'+deleteId).remove();
            $('div#answer_'+deleteId).remove();
          }
        });
      }
    } else {
      alert('타인의 글을 삭제할 수 없습니다.');
    }
  }

  var selectedAnswer = -1;

  // 답변 보기
  function onClickShowAnswer() {
    var showAns = $('#showAnswer').attr('data-answer-id');
    console.log(showAns);
    $.ajax({
      type:'get',
      url: '/qna/'+showAns+'/answer/'+showAns,
      success: function(data) {
        console.log(data);
        var result = data[0];

        if(data[0] != null) {
          console.log(result['target_id']);

          if(result['target_id'] == selectedAnswer) { 
            $('#ans_'+result['target_id']).remove();
            $('button#ansEditBtn').remove();
            $('button#ansDeleteBtn').remove();
            
            selectedAnswer = -1;
          } else {
            var p = document.createElement('p');
            p.innerHTML = result['answer_content'];
            p.setAttribute('id', 'ans_'+result['target_id']);

            var ansEdit = document.createElement('button');
            ansEdit.innerHTML = '답변 수정';
            ansEdit.setAttribute('data-ans-edit-id', result['target_id']);
            ansEdit.setAttribute('id', 'ansEditBtn');
            ansEdit.setAttribute('class', 'btn');
            ansEdit.addEventListener('click', editAnswer);

            var ansDelete = document.createElement('button');
            ansDelete.innerHTML = '답변 삭제';
            ansDelete.setAttribute('data-ans-del-id', result['target_id']);
            ansDelete.setAttribute('id', 'ansDeleteBtn');
            ansDelete.setAttribute('class', 'btn');
            ansDelete.addEventListener('click', deleteAnswer);
            
            var ansDiv = document.getElementById('answer_'+result['target_id']);
            ansDiv.appendChild(p);

            if(document.getElementsByClassName('useradmininput')[0].value == 1) {
              ansDiv.appendChild(ansEdit);
              ansDiv.appendChild(ansDelete);
            }

            selectedAnswer = result['target_id'];
          }
        } else {
          $.ajax({
            type:'get',
            url: '/qna/'+showAns+'/answer/create',
            success: function(result) {
              if(document.getElementsByClassName('useradmininput')[0].value == 1) {
                $('div#modalTitle').css('display', 'none');
                $('#action_button').val('Add Ans');
                $('#title').val('');
                $('#content').val('');
                $('#hidden_qnaid').val(result);
                $('#qnaModal').modal('show');
              } else {
                if(selectedAnswer != result) {
                  var div = document.createElement('div');
                  div.innerHTML = '답변이 없습니다.';
                  console.log(selectedAnswer);
                  console.log(result);
                  console.log(selectedAnswer);
                  document.getElementById('answer_'+result).appendChild(div);
                  div.setAttribute('id', 'noans');
                  selectedAnswer = result;
                } else {
                  $('#noans').remove();
                  selectedAnswer = -1;
                }
              }
            }
          });
        }
      }
    });
  }

  // 답변 수정
  function editAnswer() {
    var editAns = $('button#ansEditBtn').attr('data-ans-edit-id');
    console.log(editAns);

    $.ajax({
      type: 'get',
      url: '/qna/'+editAns+'/answer/'+editAns+'/edit',
      success: function(data){
        console.log(data);
        console.log(document.forms[2].elements[2]);
        var form = document.forms[2];
        $('div#modalTitle').css('display', 'none');
        form.elements[4]['value'] = data.target_id;
        form.elements[2]['value'] = data.answer_content;
        $('#action_button').val('Edit Ans');
        $('#qnaModal').modal('show');
      }
    });
  }

  // 답변 삭제
  function deleteAnswer() {
    var deleteAns = $('button#ansDeleteBtn').attr('data-ans-del-id');
    console.log(deleteAns);
    if(confirm('댓글을 삭제 하시겠습니까?')) {
      $.ajax({
        type: 'delete',
        url: '/qna/'+ deleteAns +'/answer/' + deleteAns,
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
    $('div#answer_'+id).html('');
  }

});
