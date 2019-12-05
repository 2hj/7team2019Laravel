<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
    
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="description" content="Mixtape template project">
<title>{{ config('app.name', 'Laravel') }}</title>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/bootstrap-4.1.2/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/OwlCarousel2-2.2.1/animate.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<script src="{{ URL::asset('js\jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::asset('css\styles\bootstrap-4.1.2\bootstrap.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css\styles\bootstrap-4.1.2\bootstrap.min.css') }}">


<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	
	<!-- Select CSS -->
	@if( 	Request::url() == 'http://127.0.0.1:8000' ||
			Request::url() == 'http://127.0.0.1:8000/login' ||
			Request::url() == 'http://127.0.0.1:8000/register' ||
			Request::url() == 'http://127.0.0.1:8000/password/reset' ||
			Request::url() == 'http://127.0.0.1:8000/members/create' ||
			Request::url() == 'http://127.0.0.1:8000/japan/create' ||
			Request::url() == 'http://127.0.0.1:8000/qna/create')
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/main_styles.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/responsive.css') }}">
	@elseif( Request::url() == 'http://127.0.0.1:8000/japan' )
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about_responsive.css') }}">
	@elseif( Request::url() == 'http://127.0.0.1:8000/members' )
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/about_responsive.css') }}">
	@elseif( Request::url() == 'http://127.0.0.1:8000/qna' )
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/contact.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/contact_responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	
	
	@endif



  @include('sweetalert::alert')
</head>
<body>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

<div class="super_container">
	
	<!-- Header -->
	<header class="header">
		<div class="header_content d-flex flex-row align-items-center justify-content-center">
			<div class="logo"><a href="{{ route('Mainpage') }}">Seven_Team</a></div>
			<div class="log_reg">
				<ul class="d-flex flex-row align-items-start justify-content-start">
                    @guest
    					<li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li>{{ Auth::user()->name }}</li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
				</ul>
			</div>
			<nav class="main_nav">
				<ul class="d-flex flex-row align-items-start justify-content-start">
						<!-- Select Active-->
						@if( str_replace('http://', 'https://', Request::url()) == 'https://127.0.0.1:8000' )
						<li class="active"><a href="{{ route('Mainpage') }}">Home</a></li>
						@else
						<li ><a href="{{ route('Mainpage') }}">Home</a></li>
						@endif

						@if( str_replace('http://', 'https://', Request::url()) == 'https://127.0.0.1:8000/japan' )
							<li class="active"><a href="{{ route('japan.index')}}">현지 학기제</a></li>
						@else
							<li><a href="{{ route('japan.index')}}">현지 학기제</a></li>
						@endif
						
						@if( str_replace('http://', 'https://', Request::url()) == 'https://127.0.0.1:8000/members' )
							<li class="active"><a href="{{ route('members.index') }}">조원 소개</a></li>
						@else
							<li><a href="{{ route('members.index') }}">조원 소개</a></li>
						@endif

						@if( str_replace('http://', 'https://', Request::url()) == 'https://127.0.0.1:8000/qna' )
							<li class="active"><a href="{{ route('qna.index') }}">QnA</a></li>
						@else
							<li><a href="{{ route('qna.index') }}">QnA</a></li>
						@endif
				</ul>
			</nav>
			
		</div>
		
	</header>
  <main>
  
  @yield('content')
  @yield('script')
  </main>
</div>
