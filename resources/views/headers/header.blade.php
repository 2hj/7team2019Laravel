<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="description" content="Mixtape template project">
<title>{{ config('app.name', 'Laravel') }}</title>

<link rel="stylesheet" type="text/javascript" href="{{ URL::asset('js/jquery-3.2.1.min.js') }}">
<link rel="stylesheet" type="text/javascript" href="{{ URL::asset('css/styles/bootstrap-4.1.2/bootstrap.min.js') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/bootstrap-4.1.2/bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/OwlCarousel2-2.2.1/animate.css') }}">

<script src="{{ URL::asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ URL::asset('js/custom.js') }}"></script>

<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Select CSS -->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/main_styles.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles/responsive.css') }}">


  @include('sweetalert::alert')
</head>

<body>

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
								<a href="{{ route('logout') }}"
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
							<li><a href="{{ route('Mainpage') }}">Home</a></li>
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

				<div class="hamburger ml-auto">
					<div class="d-flex flex-column align-items-end justify-content-between">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>

			</div>

		</header>

		<!-- Menu -->
		<div class="menu">
			<div>
				<div class="menu_overlay"></div>

				<div class="menu_container d-flex flex-column align-items-start justify-content-center">
					<div class="menu_log_reg">
						<ul class="d-flex flex-row align-items-start justify-content-start">
							@guest
								<li><a href="{{ route('login') }}">Login</a></li>
								<li><a href="{{ route('register') }}">Register</a></li>
							@else
								<li>{{ Auth::user()->name }}</li>
								<li>
									<a href="{{ route('logout') }}"
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

					<nav class="menu_nav">
						<ul class="d-flex flex-column align-items-start justify-content-start">
							<!-- Select Active-->
							@if( str_replace('http://', 'https://', Request::url()) == 'https://127.0.0.1:8000' )
								<li class="active"><a href="{{ route('Mainpage') }}">Home</a></li>
							@else
								<li><a href="{{ route('Mainpage') }}">Home</a></li>
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

			</div>
		</div>	

	</div>

</body>

<main>
  @yield('content')
  @yield('script')
</main>
