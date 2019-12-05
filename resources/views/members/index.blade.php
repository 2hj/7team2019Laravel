@extends ('headers.header')

@section('content')
<div class="discs">
		<div class="container">
			<div class="row discs_row">
				
				
			@forelse($members as $member)	
				<!-- Disc -->
				<div class="col-xl-4 col-md-6">
					<div class="disc">
						<form id="ajaxtest" action="#">
							<!-- 토큰정보 -->
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<a href="/members/{{ $member->id }}">
								<div class="disc_image"><img src="images/disc_2.jpg" alt="https://unsplash.com/@kasperrasmussen"></div>
								<div class="disc_container">
									<div>
										<div class="disc_content_2 d-flex flex-column align-items-center justify-content-center">
											<div>
												<div class="disc_title">조원1</div>
												<div class="disc_subtitle">조원1간략</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</form>
					</div>
				</div>

			@empty
				<p>조원이 등록되지 않았습니다.</p>
			@endforelse	
				<form id="ajaxtest" action="#">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<button type="button" class="btn btn-warning" id="testbutton">테스트</button>
				</form>

				<form id="createMember" action="#">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<button type="button" class="btn btn-warning" id="create">멤버추가</button>
				</form>

				<div id="createDiv">

				</div>		

				<form id="addMember" action="#">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				
				</form>
				

				
				
		</div>
	</div>
</div>

	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			/* $('#ajaxtest').submit(function() {
				var a = 0;

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "",
					data: {
						"_token": "{{ csrf_token() }}",
					},
					success: function(data) {
						console.log(data);
						// $('#postRequestData').html(data);
					}
				});
			}); */

			/* $('#createMemeber').click(function() {
				console.log('click');
				var createHTML = document.createElement("div");

				createHTML.id = "create";
				createHTML.className = "col-xl-4 col-md-6";
				createHTML.innerHTML = "테스트";
				
				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "ajaxtest",
					data: {
						"_token": "{{ csrf_token() }}",
						create: craeteHTML,
					},
					success: function(data) {
						console.log(data);
						// $('#postRequestData').html(data);
					}
				});
			}); */

			$('#testbutton').click(function() {
				console.log('click');

				var testval = "테스트 데이터";

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "ajaxtest",
					data: {
						"_token": "{{ csrf_token() }}",
						test: testval,
					},
					success: function(data) {
						console.log("data: ", data);
						// $('#postRequestData').html(data);
					}
				});
			});

			// 불렀는지 유무
			// 전역변수
			var called = false;
			var count = 0;
			var createDiv = document.getElementById('createDiv');

			// 멤버 추가 버튼 생성 함수
			function createHTML() {
				
				var nameInputSpace = document.createElement('input');
				nameInputSpace.type = "text";
				nameInputSpace.name = "name";
				nameInputSpace.id = "name";
				nameInputSpace.value = "{!! old('name') !!}";

				var submitButton = document.createElement('button');
				submitButton.type = "submit";
				submitButton.name = "addMember";
				submitButton.id = "addMember";
				submitButton.innerHTML = "조원추가";

				var html = $(`<input type="text" name="phone_number" id="phone_number" value="{!! old('phone_number') !!}"><input type="text" name="address" id="address" value="{!! old('address') !!}"><input type="text" name="mottoes" id="mottoes" value="{!! old('mottoes') !!}">`);

				console.log("nameInputSpace:", nameInputSpace);

				createDiv.append(nameInputSpace);
				createDiv.append(html);
				createDiv.append(submitButton);

				console.log(count);

				called=false;
			}

			$('#create').click(function() {
				console.log('createMember');
				called = true;
				var check = false;

				if(called) {
					check = true;
				}

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "createMember",
					contentType: false,
					processData: false,
					data: {
						"_token": "{{ csrf_token() }}",
						checking: check,
					},
					success: function(data) {
						console.log("data: ", data);
						count++;
						console.log(count);
						if(data && count % 2 == 1) {
							createHTML();
						} else {
							createDiv.innerHTML = "";
						}
						// $('#postRequestData').html(data);
					}
				});
			});

			$('#addMember').click(function() {
				var name = $('#name').val();

				console.log("name:",name);
				
				formData = new FormData()
				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "addMember",
					contentType: false,
					processData: false,
					data: {
						"_token": "{{ csrf_token() }}",
						name: name,
					},
					success: function(data) {
						
					}
				});
			});

		});
	</script>
@stop