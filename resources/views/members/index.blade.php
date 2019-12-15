@extends ('headers.header')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about_responsive.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/member.css') }}">


<!-- Discs -->

   <div class="discs">
      <div class="container">
         <div class="row discs_row">
            
            <!-- Disc -->
            @forelse($members as $member)
               <div class="col-xl-4 col-md-6 memberbox" id="memberbox_{{ $member->id }}">
                  <div class="disc" id="memberbox_disc_{{ $member->id }}">
                  <form class="showMember member-form" id="showMember_{{ $member->id }}" data-id="{{ $member->id }}" action="#" enctype="multipart/form-data">
                     <a class="member-form" id="showMember_{{ $member->id }}" data-id="{{ $member->id }}">
                        <div class="disc_image" id="member_img_{{ $member->id }}">   
                           <img id="memberImage_{{ $member->id }}" width="360" height="360" src="/img/{{ $member->img }}">
                        </div>
                        <div class="disc_container">
                           <div>
                              <div class="disc_content_6" id="member_{{ $member->id }}">
                                 <div class="disc_title">{{ $member->name }}</div>
                                 <div class="disc_subtitle">{{ $member->mottoes }}</div>
                              </div>
                              <div id="editAndDelete_{{ $member->id }}"></div>
                           </div>
                        </div>
                     </a>
                  </form>
                  </div>
               </div>
            @empty
            <p id="empty">조원이 등록되지 않았습니다.</p>
             @endforelse


         </div>
      </div>
   </div>

      <form id="createMember" action="#" >
         <button type="submit" class="btn btn-warning" id="create">멤버추가</button>
      </form>
      <form id="addMember" action="#" enctype="multipart/form-data" >
      </form>
      
   </div>

</body>


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
                  <input type="file" name="img" id="img">
                  <br>
                  <input type="submit" value="생성">
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
               cache: false,
               data: data,
               success: function(data) {
                  // name, address, mottoes, phone_number
                  console.log('data', data)

                  
                  var html = $(`
                     <div class="col-xl-4 col-md-6 memberbox" id="memberbox_${data['id']}">
                        <div class="disc" id="memberbox_disc_${data['id']}">
                        <form class="showMember member-form" id="showMember_${data['id']}" data-id="${data['id']}" action="#" enctype="multipart/form-data">
                           <a class="member-form" id="showMember_${data['id']}" data-id="${data['id']}">
                              <div class="disc_image" id="member_img_${data['id']}">   
                                 <img id="memberImage_${data['id']}" width="360" height="360" src="/img/${data['img']}">
                              </div>
                              <div class="disc_container">
                                 <div>
                                    <div class="disc_content_6" id="member_${data['id']}">
                                       <div class="disc_title">${data['name']}</div>
                                       <div class="disc_subtitle">${data['mottoes']}</div>
                                    </div>
                                    <div id="editAndDelete_${data['id']}"></div>
                                 </div>
                              </div>
                           </a>
                        </form>
                        </div>
                     </div>
                  `);

                  var row = $('.row');
                  var addMember = $('#addMember');
                  var empty = $('#empty');

                  row.append(html);
                  row.append(html);

                  addMember.html("");
                  empty.remove();
               
                  var showMemberId = $(`#showMember_${data['id']}`);
                  var editAndDeleteId = $(`#editAndDelete_${data['id']}`);

                  editAndDeleteId.on("click", onDeleteMember);
                  showMemberId.on("click", onShowMember);
                  var row = $('.row');
                  
               }
            });
         });
         
         var edit_data = {};
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
                  edit_data = data;

                  console.log(edit_data);

                  var htmlAfter = $(`
                  <h3 name="id">아이디 : ${data[0]['name']}</h3>
                  <h3 name="phone_number">전화번호 : ${data[0]['phone_number']}</h3>
                  <h3 name="address">주소 : ${data[0]['address']}</h3>
                  <h3 name="mottoes">좌우명 : ${data[0]['mottoes']}</h3>
                  `);

                  var editAndDelete = $(`
                  <form class="editMember" id="editMember_${data[0]['id']}" data-id="${data[0]['id']}" action="#" enctype="multipart/form-data">
                     <button type="button" name="edit">수정</button>
                  </form>
                  <form class="deleteMember" id="deleteMember_${data[0]['id']}" data-id="${data[0]['id']}" action="#" enctype="multipart/form-data">
                     <button type="button" name="delete">삭제</button>
                  </form>
                  `);

                  var htmlBefore= $(`
                  <div class="disc_title">${data[0]['name']}</div>
                  <div class="disc_subtitle">${data[0]['mottoes']}</div>
                  `);

                  var imgFile= $(`
                     <img id="memberImage_${data[0]['id']}" width="360" height="360" src="/img/${data[0]['img']}">
                  `);

                  var member_img_Div = $(`#member_img_${data[0]['id']}`);
                  var memberDiv = $(`#member_${data[0]['id']}`);
                  var editAndDeleteDiv = $(`#editAndDelete_${data[0]['id']}`);
                  var dataArray = data[0];

                  count++;

                  if(count % 2 == 1) {
                     member_img_Div.empty();
                     member_img_Div.append(imgFile);

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
                  //data값 - id값만 들어있음

                  var memberBoxId = $(`#memberbox_${data}`);

                  memberBoxId.remove();

                  count--;
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
               <form class="member-form-edit" id="editMember_${member_id}" data-id="${member_id}" action="#" enctype="multipart/form-data">
               <label for="name">이름</label>
               <input type="text" name="name" value="${edit_data[0].name}">
               <br>
               <label for="phone">전화번호</label>
               <input type="text" name="phone_number" value="${edit_data[0].phone_number}">
               <br>
               <label for="address">주소</label>
               <input type="text" name="address" value="${edit_data[0].address}">
               <br>
               <label for="mottoes">좌우명</label>
               <input type="text" name="mottoes" value="${edit_data[0].mottoes}">
               <br>
               <input type="file" name="img" accept="image/x-png,image/gif,image/jpeg">
               <br>
               <button id="editSubmit" type="submit">수정완료</button>
               </form>
            `);

            editMember.html("");
            editMember.append(html);

            var goEditMember = $('.member-form-edit');
            goEditMember.bind("submit",function(e){ 
               e.preventDefault();
               onEditMember(member_id);
            });

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

                  
                  var memberBox = $(`#showMember_${member_id}`);
                  var html = $(`
                  <a class="member-form" id="showMember_${member_id}" data-id="${member_id}">
                     <div class="disc_image" id="member_img_${member_id}">   
                        <img id="memberImage_${member_id}" width="360" height="360" src="/img/${data['img']}">
                     </div>
                     <div class="disc_container">
                        <div>
                           <div class="disc_content_6" id="member_${member_id}">
                              <div class="disc_title">${data[0]['name']}</div>
                              <div class="disc_subtitle">${data[0]['mottoes']}</div>
                           </div>
                           <div id="editAndDelete_${member_id}"></div>
                        </div>
                     </div>
                  </a>
                  `);

                  memberBox.html("");
                  memberBox.append(html);

                  var memberImage = $(`#memberImage_${member_id}`);
                  memberImage.attr("src", `/img/${data['img']}`)

                  var showMember_id = $(`#showMember_${member_id}`);
                  showMember_id.bind("click", onShowMember);

               }
            });
         }

      });
   </script>
@stop