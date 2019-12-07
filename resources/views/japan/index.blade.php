@extends ('headers.header')

@section('content')


<div class="discs">
	<div class="container">
		<div class="JapanArea">
			@forelse($japans as $japan)
				<div class="japanbox" id="japanbox_{{ $japan->id }}">
					<form class="showJapan japan-form" id="showJapan_{{ $japan->id }}" data-id="{{ $japan->id }}" action="#" enctype="multipart/form-data">
						<div id="japan_{{ $japan->id }}">
							<h3>장소 : {{ $japan->place }}</h3>
						</div>
					</form>
					<div id="editAndDelete_{{ $japan->id }}">

					</div>
				</div>
			@empty
				<p id="empty">등록 된 자료가 없습니다.</p>
			@endforelse
		</div>

		<form id="createJapan" action="#">
			<button type="submit" class="btn btn-warning" id="create">자료추가</button>
		</form>
		<form id="addJapan" action="#" enctype="multipart/form-data">

		</form>

	</div>
</div>

	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			var count = 0;

			$('#createJapan').on("submit", function(event) {
				event.preventDefault();

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{ route('japan.create') }}", 
					success: function(data) {
						var html = $(`
						<label for="place">장소</label>
						<input type="text" name="place">
						<br>
						<label for="explain">설명</label>
						<input type="text" name="explain">
						<br>
						<input type="file" name="img" id="img" accept="image/x-png,image/gif,image/jpeg">
						<br>
						<input type="submit" value="생성">
						`);

						var addJapan = $('#addJapan');
						count++;
						if(count % 2 == 1) {
							addJapan.append(html);
						} else {
							addJapan.html("");
						}

					}
				});
			});

			$('#addJapan').on("submit", function(event) {
				event.preventDefault();

				var form = $('#addJapan')[0];
				console.log('form', form);
				var data = new FormData(form);
				console.log('data', data);

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "{{ route('japan.store') }}", 
					contentType: false,
					processData: false,
					cache: false,
					data: data,
					success: function(data) {
						// name, address, mottoes, phone_number
						var html = $(`
						<div class='japanbox' id="japanbox_${data['id']}">
							<form class="showJapan" id="showJapan_${data['id']}" data-id="${data['id']}" action="#">
								<div id="Japan_${data['id']}">
									<h3>장소 : ${data['place']}</h3>
								</div>
							</form>
							<div id="editAndDelete_${data['id']}">

							</div>
						</div>
						`);

						var japanArea = $('.JapanArea');
						var addJapan = $('#addJapan');
						var empty = $('#empty');
						empty.remove();
						japanArea.append(html);
						addJapan.html("");
						
					
						var showJapanId = $(`#showJapan_${data['id']}`);
						var editAndDeleteId = $(`#editAndDelete_${data['id']}`);

						showJapanId.on("click", onShowJapan);
						editAndDeleteId.on("click", onDeleteJapan);
						
					}
				});
			});

			var edit_data = {};
			var showJapan = $('.showJapan');
			$(showJapan.each(function() {
				var showJapanId = $(`#showJapan_${$(this).attr('data-id')}`);

				showJapanId.on("click", onShowJapan);
			}));

			function onShowJapan() {
				var japan_id = $(this).attr('data-id');

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "/japan/" + japan_id, 
					success: function(data) {
						console.log('data', data);
						edit_data = data;
						var htmlAfter = $(`
						<h3 name="id">아이디 : ${data[0]['id']}</h3>
						<img id="japanImage_${data[0]['id']}" width="100" src="/img/${data[0]['img']}" alt="이미지가 등록되어있지 않습니다.">
						<h3 name="explain">주소 : ${data[0]['explain']}</h3>
						`);

						var editAndDelete = $(`
						<form class="editJapan" id="editJapan_${data[0]['id']}" data-id="${data[0]['id']}" action="#">
							<button type="button" name="edit">수정</button>
						</form>
						<form class="deleteJapan" id="deleteJapan_${data[0]['id']}" data-id="${data[0]['id']}" action="#">
							<button type="button" name="delete">삭제</button>
						</form>
						`);

						var htmlBefore= $(`
						<h3>장소 : ${data[0]['place']}</h3>
						`);

						var japanDiv = $(`#japan_${data[0]['id']}`);
						var editAndDeleteDiv = $(`#editAndDelete_${data[0]['id']}`);
						

						count++;

						if(count % 2 == 1) {
							japanDiv.append(htmlAfter);
							editAndDeleteDiv.append(editAndDelete);

							var deleteJapan = $(`#deleteJapan_${data[0]['id']}`);
							var editJapan = $(`#editJapan_${data[0]['id']}`);

							editJapan.on("click", onEditJapanCreateInput);
							deleteJapan.on("click", onDeleteJapan);

						} else {
							japanDiv.html(htmlBefore);
							editAndDeleteDiv.html("");
						}
					}
				});

			}

			function onDeleteJapan() {
				var japan_id = $(this).attr('data-id');

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "DELETE",
					url: "/japan/" + japan_id,
					success: function(data) {
						var japanBoxId = $(`#japanbox_${data}`);

						japanBoxId.remove();
					},
					error: function(request, status, error){
						console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
					}
				});

			}

			function onEditJapanCreateInput() {

				var japan_id = $(this).attr('data-id');
				var editJapan = $(`#japanbox_${japan_id}`);

				var html = $(`
				<form class="japan-form-edit" id="editJapan_${japan_id}" data-id="${japan_id}" action="#" enctype="multipart/form-data">
				<label for="place">장소</label>
				<input type="text" name="place" value="${edit_data[0].place}">
				<br>
				<label for="explain">설명</label>
				<input type="text" name="explain" value="${edit_data[0].explain}">
				<br>
				<input type="file" name="img">
				<br>
				<button id="editSubmit" type="submit">수정완료</button>
				</form>
				`);

				editJapan.html("");
				editJapan.append(html);

				var goEditJapan = $('.japan-form-edit');
				goEditJapan.bind("submit",function(e){ 
					e.preventDefault();
					onEditJapan(japan_id);
				});

			}

			function onEditJapan(japan_id) {
				var editJapan_num_form = $(`#editJapan_${japan_id}`)[0];
				var data = new FormData(editJapan_num_form);
				data.append('_method','PATCH');

				$.ajax({
					headers:{
						'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
					},
					type: "POST",
					url: "/japan/" + japan_id,
					contentType: false,
					processData: false,
					data: data,
					success: function(data) {
						console.log('data', data);
						var japanBox = $(`#japanbox_${japan_id}`);
						var html = $(`
							<form class="showJapan" id="showJapan_${japan_id}" data-id="${japan_id}" action="#" enctype="multipart/form-data">
								<div id="japan_${japan_id}">
									<h3>장소 : ${data['place']}</h3>
								</div>
							</form>
							<div id="editAndDelete_${japan_id}">

							</div>
						`);

						japanBox.html("");
						japanBox.append(html);

						var japanImage = $(`#japanImage_${japan_id}`);
						japanImage.attr("src", `/img/${data['img']}`)

						var showJapan_id = $(`#showJapan_${japan_id}`);
						showJapan_id.bind("click", onShowJapan);

					},
					error: function(request, status, error){
						console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
					}
				});
			}

		});
	</script>
@stop