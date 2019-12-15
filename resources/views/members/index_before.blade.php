@extends ('headers.header')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/member.css') }}">

<div class="discs">
   <div class="container">
      <div class="memberArea">
         @forelse($members as $member)
         <div class="memberbox" id="memberbox_{{ $member->id }}">
            <form class="showMember member-form" id="showMember_{{ $member->id }}" data-id="{{ $member->id }}" action="#">
               <div id="member_{{ $member->id }}">
                  <h3>{{ $member->name }}</h3>
                  <img id="memberImage_{{ $member->id }}" width="100" src="" alt="이미지가 없습니다.">
               </div>
            </form>
            <div id="editAndDelete_{{ $member->id }}">

            </div>
         </div>
         @empty
            <p id="empty">조원이 등록되지 않았습니다.</p>
         @endforelse
      </div>

      <form id="createMember" action="#">
         <button type="submit" class="btn btn-warning" id="create">멤버추가</button>
      </form>
      <form id="addMember" action="#">

      </form>
      
      
      
      
   </div>
</div>



   <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
   <script type="text/javascript">
      $(document).ready(function() {

         var count = 0;

         $('#createMember').on("submit", function(event) {
            event.preventDefault();

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "GET",
               url: "{{ route('members.create') }}", 
               success: function(data) {
                  var html = $(`
                  <label for="name">이름</label>
                  <input type="text" name="name">
                  <label for="phone">전화번호</label>
                  <input type="text" name="phone_number">
                  <label for="address">주소</label>
                  <input type="text" name="address">
                  <label for="mottoes">좌우명</label>
                  <input type="text" name="mottoes">
                  
                  <label for="img">사진</label>
                  <input type="file" name="img">

                  <input type="submit" value="제출">
                  `);

                  var addMember = $('#addMember');
                  count++;
                  if(count % 2 == 1) {
                     addMember.append(html);
                  } else {
                     addMember.html("");
                  }

               }
            });
         });

         $('#addMember').on("submit", function(event) {
            event.preventDefault();

            var form = $('#addMember')[0];
            var data = new FormData(form);

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "POST",
               url: "{{ route('members.store') }}", 
               contentType: false,
               processData: false,
               data: data,
               success: function(data) {
                  // name, address, mottoes, phone_number
                  var html = $(`
                  <div class='memberbox' id="memberbox_${data['id']}">
                     <form class="showMember" id="showMember_${data['id']}" data-id="${data['id']}" action="#">
                        <div id="member_${data['id']}">
                           <h3>${data['name']}</h3>
                           <img id="memberImage_${data['id']}" width="100" src="/images/disc_2.jpg" alt="이미지가 없습니다.">
                        </div>
                     </form>
                     <div id="editAndDelete_${data['id']}">

                     </div>
                  </div>
                  `);

                  var memberArea = $('.memberArea');
                  var addMember = $('#addMember');
                  var empty = $('#empty');

                  memberArea.append(html);
                  addMember.html("");
                  empty.remove();
               
                  var showMemberId = $(`#showMember_${data['id']}`);
                  var editAndDeleteId = $(`#editAndDelete_${data['id']}`);

                  editAndDeleteId.on("click", onDeleteMember);
                  showMemberId.on("click", onShowMember);
                  
               }
            });
         });

         var showMember = $('.showMember');
         $(showMember.each(function() {
            var showMemberId = $(`#showMember_${$(this).attr('data-id')}`);

            showMemberId.on("click", onShowMember);
         }));

         function onShowMember() {
            var member_id = $(this).attr('data-id');

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "GET",
               url: "/members/" + member_id, 
               success: function(data) {
                  var htmlAfter = $(`
                  <h3 name="id">아이디 : ${data[0]['id']}</h3>
                  <h3 name="phone_number">전화번호 : ${data[0]['phone_number']}</h3>
                  <h3 name="address">주소 : ${data[0]['address']}</h3>
                  <h3 name="mottoes">좌우명 : ${data[0]['mottoes']}</h3>
                  `);

                  var editAndDelete = $(`
                  <form class="editMember" id="editMember_${data[0]['id']}" data-id="${data[0]['id']}" action="#">
                     <button type="button" name="edit">수정</button>
                  </form>
                  <form class="deleteMember" id="deleteMember_${data[0]['id']}" data-id="${data[0]['id']}" action="#">
                     <button type="button" name="delete">삭제</button>
                  </form>
                  `);

                  var htmlBefore= $(`
                  <h3>${data[0]['name']}</h3>
                  <img id="memberImage_${data[0]['id']}" width="100" src="/images/disc_1.img" alt="이미지가 없습니다.">
                  `);

                  var memberDiv = $(`#member_${data[0]['id']}`);
                  var editAndDeleteDiv = $(`#editAndDelete_${data[0]['id']}`); 

                  count++;

                  if(count % 2 == 1) {
                     memberDiv.append(htmlAfter);
                     editAndDeleteDiv.append(editAndDelete);

                     var deleteMember = $(`#deleteMember_${data[0]['id']}`);
                     var editMember = $(`#editMember_${data[0]['id']}`);

                     editMember.on("click", onEditMemberCreateInput);
                     deleteMember.on("click", onDeleteMember);

                  } else {
                     memberDiv.html(htmlBefore);
                     editAndDeleteDiv.html("");
                  }
               }
            });

         }

         function onDeleteMember() {
            var member_id = $(this).attr('data-id');

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "DELETE",
               url: "/members/" + member_id,
               success: function(data) {
                  var memberBoxId = $(`#memberbox_${data}`);

                  memberBoxId.remove();
               },
               error: function(request, status, error){
                  console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
               }
            });

         }

         function onEditMemberCreateInput() {

            var member_id = $(this).attr('data-id');
            var editMember = $(`#memberbox_${member_id}`);

            var html = $(`
            <form class="member-form-edit" id="editMember_${member_id}" data-id="${member_id}" action="#">
            <label for="name">이름</label>
            <input type="text" name="name">
            <br>
            <label for="phone">전화번호</label>
            <input type="text" name="phone_number">
            <br>
            <label for="address">주소</label>
            <input type="text" name="address">
            <br>
            <label for="mottoes">좌우명</label>
            <input type="text" name="mottoes">
            <br>


            <label for="img">사진</label>
            <input type="file" name="img">

            <button id="editSubmit" type="submit">수정완료</button>
            <button id="editCancel" type="button">취소</button>
            </form>
            `);

            editMember.html("");
            editMember.append(html);

            var goEditMember = $('.member-form-edit');
            goEditMember.bind("submit",function(e){ 
               e.preventDefault();
               onEditMember(member_id);
            });

            var editCancel = $('#editCancel');
            editCancel.bind("click", function(e) {
               e.preventDefault();
               onEditCancel();
            })

         }

         function onEditMember(member_id) {
            var editMember_num_form = $(`#editMember_${member_id}`)[0];
            var data = new FormData(editMember_num_form);
            data.append('_method','PATCH');

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "POST",
               url: "/members/" + member_id,
               contentType: false,
               processData: false,
               data: data,
               success: function(data) {
                  console.log('data', data);
                  var memberBox = $(`#memberbox_${member_id}`);
                  var html = $(`
                     <form class="showMember" id="showMember_${member_id}" data-id="${member_id}" action="#">
                        <div id="member_${member_id}">
                           <h3>${data['name']}</h3>
                           <img id="memberImage_${member_id}" width="100" src="${data['img']}" alt="이미지가 없습니다.">
                        </div>
                     </form>
                     <div id="editAndDelete_${member_id}">

                     </div>
                  `);

                  memberBox.html("");
                  memberBox.append(html);

                  var showMember_id = $(`#showMember_${member_id}`);
                  showMember_id.bind("click", onShowMember);

               },
               error: function(request, status, error){
                  console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
               }
            });
         }

         function onEditCancel() {
            var memberFromEdit = $(`.member-form-edit`);
            
         }


      });
   </script>


   
@stop