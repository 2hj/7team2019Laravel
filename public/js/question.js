// var q_id = null;
// var question = [];
// var cnt = '{{ $allQuestions->count() }}';
// for(var i = cnt ; i < cnt ; i++){
//   question[i+1] = 0;
// }

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

    // document.querySelector('.openQuestion').addEventListener('click', onClick(data['id']));
  }

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
    
    if( $('#action_button').val() == 'Add' ){
      $.ajax({
        url: "/qna",
        method: "POST",
        // data: data,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        // dataType: 'html',
        success: function(data){
          console.log('success');
          console.log(data);
          $('#questionModal').modal('hide');
          reloadAdd(data);
          // $('#ul').load('/qna #loadDiv');
        },
        error: function(request, status, error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
      });
    }

    if( $('#action_button').val() == 'Edit' ){
      var id = $('#hidden_qid')[0]['value'];
      console.log(id);
      var form = $('#question-form')[0];
      var data = new FormData(form);
      data.append('_method', 'patch');

      $.ajax({
        type: 'POST',
        url: '/qna/'+id,
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
        },
        error: function(request, status, error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
      });
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
    console.log('글 클릭함');
    $.ajax({
      type: 'get',
      url: '/qna/' + id,
      data: {
        "_token": "{{ csrf_token() }}",
        qid: id,
      },
      success: function(result){
          $('p#questionValue').remove();
          $('button#editQuestion').remove();
          $('button#deleteQuestion').remove();
          
          var p = document.createElement('p');
          p.innerHTML = result['value'];
          p.setAttribute('id', 'questionValue');
          
          if(selected != result['qid']) {
          selected = result['qid'];
          document.getElementById('ques_'+result['qid']).appendChild(p);
          
          var editBtn = document.createElement('button');
          editBtn.innerHTML = '수정';
          editBtn.setAttribute('id', 'editQuestion');
          editBtn.setAttribute('data-id', result['qid']);
          editBtn.addEventListener('click', onClickEdit);
          document.getElementById('option_'+result['qid']).appendChild(editBtn);

          var deleteBtn = document.createElement('button');
          deleteBtn.innerHTML = '삭제';
          deleteBtn.setAttribute('id', 'deleteQuestion');
          deleteBtn.setAttribute('data-id', result['qid']);
          deleteBtn.addEventListener('click', onClickDelete);
          document.getElementById('option_'+result['qid']).appendChild(deleteBtn);
          } else {
          selected = -1;
          }
      },
      error: function(request, status, error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      }
    });

    function onClickDelete() {
      var id = $('#deleteQuestion').attr('data-id');
      
      if(confirm('글을 삭제 하시겠습니까?')) {
        $.ajax({
          type:'delete',
          url: '/qna/'+id,
          success: function(id) {
              // $('li#ques_'+id).remove();
              // $('button#editQuestion').remove();
              // $('button#deleteQuestion').remove();
              // console.log(id);

              var ques_id = '#ques_'+id;
              $(ques_id).remove();
              $('button#editQuestion').remove();
              $('button#deleteQuestion').remove();
              // console.log( $(ques_id).children() );

            },
          error: function(request, status, error){
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
          }
        });
      }
    }
    
    function onClickEdit(){
      var id = $('#editQuestion').attr('data-id');
      $('#action_button').val('Edit');
      
      $.ajax({
        type: 'get',
        url: '/qna/'+id+'/edit',
        success: function(data){
          console.log(data);
          console.log(document.forms);
          var form = document.forms[2];
          console.log(form.elements);
          form.elements[1]['value'] = data.title;
          form.elements[2]['value'] = data.content;
          form.elements[4]['value'] = id
          $('#questionModal').modal('show');

        }
      });
    }
  }
});