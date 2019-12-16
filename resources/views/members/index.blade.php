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
            @if( isset($members) )
               @forelse($members as $member)
                  <div class="col-xl-4 col-md-6 memberbox" id="memberbox_{{ $member->id }}">
                     <div class="disc" id="memberbox_disc_{{ $member->id }}">
                     <form class="showMember member-form" id="showMember_{{ $member->id }}" data-id="{{ $member->id }}" action="#" enctype="multipart/form-data">
                        <a class="member-form" id="showingMember_{{ $member->id }}" data-id="{{ $member->id }}">
                           <div class="disc_image" id="member_img_{{ $member->id }}">   
                              @if( $member->img != null )
                                 <img id="memberImage_{{ $member->id }}" width="360" height="360" src="/img/{{ $member->img }}">
                              @elseif( $member->img == null ) 
                                 <img id="memberImage_{{ $member->id }}" width="360" height="360" src="/images/none_image.png">
                              @endif
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
            @endif

         </div>
      </div>
   </div>
      @if( isset($admin) && $admin == true )
         <form id="createMember" action="#" >
            <button type="submit" class="btn btn-warning" id="create">멤버추가</button>
         </form>
         <form id="addMember" action="#" enctype="multipart/form-data" >
         </form>
      @endif
      
   </div>

</body>


   <script type="text/javascript">
      $(document).ready(function() {

         var create_count = 0;


         // 멤버 추가 버튼 눌렀을 때-> 양식 띄움
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

                  console.log('addMember', addMember);
                  create_count++;
                  if(create_count % 2 == 1) {
                     addMember.append(html);
                  } else {
                     addMember.html("");
                  }

               }
            });
         });


         // 양식 입력 후 submit 눌렀을 때 (request던짐)
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

                  // var members = data;
                  // members.forEach(function(member){
                    var html = $(`
                      <div class="col-xl-4 col-md-6 memberbox" id="memberbox_${data['id']}">
                          <div class="disc" id="memberbox_disc_${data['id']}">
                            <form class="showMember member-form" id="showMember_${data['id']}" data-id="${data['id']}" action="" enctype="multipart/form-data">
                              <a class="member-form" id="showingMember_${data['id']}" data-id="${data['id']}">
                                  <div class="disc_image" id="member_img_${data['id']}">   
                                    @if( $member->img != null )
                                        <img id="memberImage_${data['id']}" width="360" height="360" src="/img/${data['img']}">
                                    @elseif( $member->img == null ) 
                                        <img id="memberImage_${data['id']}" width="360" height="360" src="/images/none_image.png">
                                    @endif
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
                  // })
                  var addMember = $('#addMember');
                  var empty = $('#empty');

                  var row = $('.row');
                  row.append(html);
                  // row.append(html);

                  addMember.html("");
                  empty.remove();
               
                  var showMemberId = $(`#showingMember_${data['id']}`);
                  var editAndDeleteId = $(`#editAndDelete_${data['id']}`);

                  editAndDeleteId.on("click", onDeleteMember);
                  showMemberId.on("click", onShowMember);
                  // var row = $('.row');
                  
               }
            });
         });
         
         var edit_data = {};
         var showMember = $('.showMember');


         ///////////클릭 각각//////
         $(showMember.each(function() {
            var showMemberId = $(`#showMember_${$(this).attr('data-id')}`);

            showMemberId.on("click", onShowMember);
         }));

         var show_count = 0;



         ////////클릭하면 보여지는 폼////////
         function onShowMember() {
            var member_id = $(this).attr('data-id');
            console.log('member_id', member_id);

            $.ajax({
               headers:{
                  'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
               },
               type: "GET",
               url: "/members/" + member_id, 
               success: function(data) {
                  console.log('data', data);
                  edit_data = data.member;
                  member = data.member

                  console.log('edit data', edit_data);
                  console.log('member data', member);

                  var htmlAfter = $(`
                  <h3 name="id">이름 : ${member[0]['name']}</h3>
                  <h3 name="phone_number">전화번호 : ${member[0]['phone_number']}</h3>
                  <h3 name="address">주소 : ${member[0]['address']}</h3>
                  <h3 name="mottoes">좌우명 : ${member[0]['mottoes']}</h3>
                  `);

                  var editAndDelete = $(`
                  @if( isset($admin) && $admin == true )
                     <form class="editMember" id="editMember_${member[0]['id']}" data-id="${member[0]['id']}" action="#" enctype="multipart/form-data">
                        <button type="button" name="edit">수정</button>
                     </form>
                     <form class="deleteMember" id="deleteMember_${member[0]['id']}" data-id="${member[0]['id']}" action="#" enctype="multipart/form-data">
                        <button type="button" name="delete">삭제</button>
                     </form>
                  @endif
                  `);

                  var htmlBefore= $(`
                  <div class="disc_title">${member[0]['name']}</div>
                  <div class="disc_subtitle">${member[0]['mottoes']}</div>
                  `);

                  /* var imgFile= $(`
                     <img name="img" id="memberImage_${member[0]['id']}" width="360" height="360" src="/img/${member[0]['img']}" alt="No Image">
                  `); */

                  var member_img_Div = $(`#member_img_${member[0]['id']}`);
                  var memberDiv = $(`#member_${member[0]['id']}`);
                  var editAndDeleteDiv = $(`#editAndDelete_${member[0]['id']}`);

                  show_count++;

                  if(show_count % 2 == 1) {
                     /* member_img_Div.empty();
                     member_img_Div.append(imgFile); */

                     memberDiv.append(htmlAfter);
                     editAndDeleteDiv.append(editAndDelete);

                     var deleteMember = $(`#deleteMember_${member[0]['id']}`);
                     var editMember = $(`#editMember_${member[0]['id']}`);

                     editMember.on("click", onEditMemberCreateInput);
                     deleteMember.on("click", onDeleteMember);

                  } else {
                     memberDiv.html(htmlBefore);
                     editAndDeleteDiv.html("");
                  }
               }
            });

         }



         /////////삭제 /////////
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

                  show_count = 0;
               },
               error: function(request, status, error){
                  console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
               }
            });

         }





         /////////수정 폼////////
         function onEditMemberCreateInput() {

            var member_id = $(this).attr('data-id');
            var editMember = $(`#memberbox_${member_id}`);
            console.log(member_id);
            console.log(editMember[0]);

            var html = $(`
               <form class="member-form-edit" id="editCommitMember_${member_id}" data-id="${member_id}" action="#" enctype="multipart/form-data">
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

            var goEditMember = $(`#editCommitMember_${member_id}`);
            goEditMember.bind("submit",function(e){ 
               e.preventDefault();
               onEditMember(member_id);
            });

         }



         ///////수정 후 폼///////
         function onEditMember(member_id) {

            var editMember_num_form = $(`#editCommitMember_${member_id}`)[0];
            var data = new FormData(editMember_num_form);
            console.log(editMember_num_form);

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
                  console.log('edit data' ,data);
                  console.log('img data' ,data[0]['img']);
                  
                  var html = $(`
                  <a class="member-form" id="showingMember_${member_id}" data-id="${member_id}">
                     <div class="disc_image" id="member_img_${member_id}">
                        @if( $member->img != null )
                           <img id="memberImage_${member_id}" width="360" height="360" src="/img/${data[0]['img']}">
                        @elseif( $member->img == null ) 
                           <img id="memberImage_${member_id}" width="360" height="360" src="/images/none_image.png">
                        @endif
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

                  $(`#memberbox_${member_id}`).html("");
                  $(`#memberbox_${member_id}`).append(html);

                  var memberImage = $(`#memberImage_${member_id}`);
                  memberImage.attr("src", `/img/${data[0]['img']}`);

                  var showMember_id = $(`#showingMember_${member_id}`);
                  showMember_id.bind("click", onShowMember);

               }
            });
         }

      });
   </script>
@stop