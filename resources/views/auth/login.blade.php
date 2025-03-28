@extends('layouts.authpage')

@section('title', 'Login Page')

@section('content')
	<!-- BEGIN login -->
	<div class="login login-v2 fw-bold">
		<!-- BEGIN login-cover -->
		<div class="login-cover">
			<div class="login-cover-img" style="background-image: url(/assets/img/login-bg/login-bg-14.jpg)"
				data-id="login-cover-image"></div>
			<div class="login-cover-bg"></div>
		</div>
		<!-- END login-cover -->

		<!-- BEGIN login-container -->
		<div class="login-container">
			<!-- BEGIN login-header -->
			<div class="login-header">
				<div class="brand">
					<img src="{{url('restologo.png')}}" alt="user_profile" width="250px">
				</div>
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
			</div>
			<!-- END login-header -->

			<!-- BEGIN login-content -->
			<div class="login-content">
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="form-floating mb-20px">
						<input id="email" type="email"
							class="form-control fs-13px h-45px border-0 form-control @error('email') is-invalid @enderror"
							name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
							placeholder="Email Address" />
						<label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Email
							Address</label>
						@error('email')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-floating mb-20px">
						<input id="password" type="password"
							class="form-control fs-13px h-45px border-0 form-control @error('password') is-invalid @enderror"
							name="password" required autocomplete="current-password" placeholder="Password" />
						<label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

					<div class="mb-20px">
						<button type="submit" class="btn btn-theme d-block w-100 h-45px btn-lg">Sign me in</button>
					</div>

				</form>
			</div>
			<!-- END login-content -->
		</div>
		<!-- END login-container -->
	</div>
	<!-- END login -->

	<!-- BEGIN login-bg -->
	{{-- <div class="login-bg-list clearfix">
		<div class="login-bg-list-item active"><a href="javascript:;" class="login-bg-list-link"
				data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-17.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-17.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg"
				data-img="/assets/img/login-bg/login-bg-16.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-16.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg"
				data-img="/assets/img/login-bg/login-bg-15.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-15.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg"
				data-img="/assets/img/login-bg/login-bg-14.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-14.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg"
				data-img="/assets/img/login-bg/login-bg-13.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-13.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg"
				data-img="/assets/img/login-bg/login-bg-12.jpg"
				style="background-image: url(/assets/img/login-bg/login-bg-12.jpg)"></a></div>
	</div> --}}
	<!-- END login-bg -->
@endsection