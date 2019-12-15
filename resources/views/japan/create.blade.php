@extends('../layouts/app')

@section('content')

    <form action="{{ route('japan.store') }}" method="POST" >
        {!! csrf_field() !!}

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="titleLable">장소 : </label>
            <input type="text" name="title" id="title" value="{{ old('name') }}" class="form-control"/>
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            <label for="contentLable">개요 : </label>
            <textarea name="content" id="content" rows="10" class="form-control">{{ old('name') }}</textarea>
            {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">저장하기</button>
        </div>

    </form>

@stop