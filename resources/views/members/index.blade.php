@extends ('headers.header')

@section('content')
<div class="discs">
		<div class="container">

			<div id="addingMember" class="row discs_row">
				@forelse($members as $member)
					<div class="col-xl-4 col-md-6">
						<div class="disc">
							<form class="showMember" data-id="{{$member->id}}" action="#">
								<a href="">
									<div class="disc_image" id="uploaded_image"><img src="images/disc_2.jpg" alt="https://unsplash.com/@kasperrasmussen"></div>
									<div class="disc_container">
										<div>
											<div class="disc_content_2 d-flex flex-column align-items-center justify-content-center">
												<div>
													<div id="member_name" name="member_name" class="disc_title">{{ $member->name }}</div>
													<div id="member_id" name="member_id" class="disc_subtitle">{{ $member->id }}</div>
												</div>
											</div>
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
			<form id="createMember" action="#">
				<button type="button" class="btn btn-warning" id="create">멤버추가</button>
			</form>
			<!-- <form id="deleteMember" action="#">
				<button type="button" class="btn btn-waring" id="delete">멤버삭제</button>				
			</form> -->

			<div id="createDiv">
				<form id="addMember">
					
				
				</form>
			</div>	

	</div>
</div>




	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			// 불렀는지 유무
			// 전역변수
			var called = false;
			var count = 0;

			// 멤버 생성 제한
			var memberCreateLimit = 0;
			// var createForm = document.getElementById('addMember');
			// jquery랑 javascript를 같이 사용할 수 없다.
			var createForm = $('#addMember');
			var addingMember = $('#addingMember');

			$('.showMember').on('click', function(event) {
				event.preventDefault();

				var num = $(this).attr('data-id');
				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: '/members/'+num, 
					success: function(data) {
						console.log('show data:', data);
					}
				});
			});

			// 멤버 추가 버튼 생성 함수
			function createHTML() {
				var html = $(`
				<label for="name">이름</label>
				<input type="text" name="name" id="name" value="{!! old('name') !!}">
				<label for="phone_number">전화번호</label>
				<input type="text" name="phone_number" id="phone_number" value="{!! old('phone_number') !!}">
				<label for="address">주소</label>
				<input type="text" name="address" id="address" value="{!! old('address') !!}">
				<label for="mottoes">좌우명</label>
				<input type="text" name="mottoes" id="mottoes" value="{!! old('mottoes') !!}">
				
				<button type="submit" >조원추가</button>
				`);

				createForm.append(html);

				console.log('function count', count);

				called=false;
			}

			// 멤버 추가 버튼 클릭 함수
			$('#create').click(function() {
				console.log('createMember');
				called = true;
				var check = false;

				if(called) {
					console.log('called');
					check = true;
				}

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{ route('members.create') }}",
					data: {
						checking: check,
					},
					success: function(data) {
						console.log("data.checking: ", data.checking);
						count++;
						console.log('success data', count);

						if(memberCreateLimit == 6) {
							alert('멤버를 더 이상 추가할 수 없습니다!!');
						} else {
							if(data.checking && count % 2 == 1) {
								createHTML();
							} else {
								createForm.html("");
								console.log('createForm: ', createForm);
							}
						}
						
					}
				});
			});
			
			// 멤버 추가 html 추가 함수
			function addingHTML(id, name, address, mottoes, phone_number) {
				var html = $(`
				<div class="col-xl-4 col-md-6">
					<div class="disc">
						<form class="showMember" data-id="${id}" action="#">
							<a href="">
								<div class="disc_image"><img src="images/disc_2.jpg" alt="https://unsplash.com/@kasperrasmussen"></div>
								<div class="disc_container">
									<div>
										<div class="disc_content_2 d-flex flex-column align-items-center justify-content-center">
											<div>
												<div name="member_name" class="disc_title">${name}</div>
												<div name="member_id" class="disc_subtitle">${id}</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</form>
					</div>
				</div>
				`);

				memberCreateLimit++;
				addingMember.append(html);
			}

			// 멤버 추가
			$('#addMember').on("submit", function(event) {
				event.preventDefault();
				console.log('came add');
				
				var form = $('#addMember')[0];
				console.log('form:', form);
				var data  = new FormData(form);
				console.log('before sending',data);
				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "{{ route('members.store') }}",
					contentType: false,
					processData: false,
					// dataType: json,
					data: data,
					success: function(data) {
						console.log('adding data:', data);
						console.log(typeof(data));
						createForm.html("");
						var empty = $('#empty');
						empty.html("");
						called=false;
						checking=false;
						
						addingHTML(data['id'], data['name'], data['address'], data['mottoes'], data['phone_number']);
					}
				});
			});

			/* $('#deleteMember').on("submit", function(event) {
				event.preventDeafult();

				var form = $('#deleteMember')[0];
				var data = new FormData(form);


			}); */

		});
	</script>
@stop
