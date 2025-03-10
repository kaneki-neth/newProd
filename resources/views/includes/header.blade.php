@if ($message = Session::get('success'))                     
	<script>
		Swal.fire({
			position: 'center-center',
			icon: 'success',
			title: 'SUCCESS',
			text:"{{ session('success') }}",
			showConfirmButton: true,
		})
	</script>
@endif

@if ($message = Session::get('error'))
	<script>   
		Swal.fire({
			position: 'center-center',
			icon: 'error',
			title: 'ERROR',
			text:"{{ session('error') }}",
			showConfirmButton: true,
		})
	</script>
@endif

@include('includes.mainModal')

<div id="header" class="app-header">
    <!-- BEGIN navbar-header -->
    <div class="navbar-header">
    <a href="/home"><img src="{{url('web/assets/img/mainlogo.png')}}" width="140px" class="ps-5" data-aos="fade-in"></a>
    <!-- <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> -->
    </div>
    <!-- END navbar-header -->
    <!-- BEGIN header-nav -->
    <div class="navbar-nav">
        <div class="w-100">
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="navbar-item navbar-user dropdown">
            <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
				<div class="">
					<!-- <i class="fa fa-user"></i> -->
                    <img src="{{ url(auth()->user()->user_profile) }}" alt="user_profile">
				</div> 
				<span>
					<span class="d-none d-md-inline">
						<!-- {{ Auth::user()->name }} -->
						{{ Auth::user()->first_name }}, {{ Auth::user()->last_name }} 
					</span>
					<b class="caret"></b>
				</span>
			</a>
            <div class="dropdown-menu dropdown-menu-end me-1">
                <a href="extra_profile.html" class="dropdown-item">Edit Profile</a>
                <a href="email_inbox.html" class="dropdown-item d-flex align-items-center">
                    Inbox
                    <span class="badge bg-danger rounded-pill ms-auto pb-4px">2</span> 
                </a>
                <a href="calendar.html" class="dropdown-item">Calendar</a>
                <a href="extra_settings_page.html" class="dropdown-item">Settings</a>
                <div class="dropdown-divider"></div>
                <a onclick="event.preventDefault();
						document.getElementById('logout-form').submit();" class="dropdown-item">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>    
        </div>
        </div>
    </div>
    <!-- END header-nav -->
</div>


