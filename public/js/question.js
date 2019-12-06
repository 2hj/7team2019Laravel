$(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    // Modal 띄우기
    $('#questionModalBtn').click(function(e){
      e.preventDefault();
      console.log('event emitted');
      // $('#questionModal').modal();
      $('#questionModal').modal('show');
    });
  
    // Create a Question ajax
    $('#createQuestion').click(function(e){
      $('#questionModal').modal('show');
    });
  
    $('#question-form').on('submit', function(e){
      e.preventDefault();
      if( $('#action_button').val() == 'Add' ){
        $('#questionModal').modal('hide');
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
            editBtn.setAttribute('data-id', result['qid'])
            document.getElementById('option_'+result['qid']).appendChild(editBtn);

            var deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = '삭제';
            deleteBtn.setAttribute('id', 'deleteQuestion');
            deleteBtn.setAttribute('data-id', result['qid']);
            deleteBtn.addEventListener('click', onClickRemove);
            document.getElementById('option_'+result['qid']).appendChild(deleteBtn);
            } else {
            selected = -1;
            }
        },
        error: function(request, status, error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
      });

      function onClickEdit() {
        var id = $('#deleteQuestion').attr('data-id');
        
        if(confirm('글을 삭제 하시겠습니까?')) {
          $.ajax({
            type:'delete',
            url: '/qna/'+id,
            success: function(id) {
                $('li#ques_'+id).remove();
                $('button#editQuestion').remove();
                $('button#deleteQuestion').remove();
            },
            error: function(request, status, error){
              console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            }
          });
        }
      }
    }
});