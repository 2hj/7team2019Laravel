@extends ('../headers.header')

@section('content')
<div class="discs">
    <div class="container">
        <div class="row discs_row">

            <div class="container">
                <h1>조원 추가</h1>

                <hr/>

                <form id="storeData" action="{{ route('members.store') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="nameLabel">이름 : </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control"/>
                        {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('files') ? 'has-error' : '' }}">
                        <label for="files">사진 : </label>
                        <input type="file" name="files[]" id=files class="form-control" multiple="multiple"/>
                        {!! $errors->first('files.0', '<span class="form-error">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('number') ? 'has-error' : '' }}">
                        <label for="phoneLabel">전화번호 : </label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control"/>
                        {!! $errors->first('phone_number', '<span class="form-error">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                        <label for="address">주소 :</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control"/>
                        {!! $errors->first('address', '<span class="form-error">:message</span>') !!}
                    </div>

                    <div class="form-group {{ $errors->has('mottoes') ? 'has-error' : '' }}">
                        <label for="contentLabel">하고 싶은 말 : </label>
                        <textarea name="mottoes" id="mottoes" rows="10" class="form-control">{{ old('mottoes') }}</textarea>
                        {!! $errors->first('mottoes', '<span class="form-error">:message</span>') !!}
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">저장하기</button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"><a href="{{ route('members.index') }}">취소</a></button>
                    </div>

                </form>
            </div>

        </div>
	</div>

    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#storeData').submit(function() {
                var data = new FormData($('#storeData'))[0];

                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "ajaxtest",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        formData: data,
                    },
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        console.log(data);
                        // $('#postRequestData').html(data);
                    }
                });
            });
        });
    </script>
</div>


@stop