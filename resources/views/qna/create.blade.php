@extends('headers.header')

<!--
@section('content')

    <form action="{{ route('qna.store')}}" method="POST">
        @csrf
-->
    <form class="member_form" action="{{ route('qna.store')}}" method="POST">
        {!! csrf_field() !!}

        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title">제목 : </label>
            <input type="text" name="title" id="title" value="{{ old('name') }}" class="form-control"/>
            {!! $errors->first('title', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
            <label for="content">질문 내용 : </label>
            <textarea name="content" id="content" rows="10" class="form-control">{{ old('name') }}</textarea>
            {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">저장하기</button>
        </div>

    </form>
