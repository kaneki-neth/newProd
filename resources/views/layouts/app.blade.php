<!DOCTYPE html>
<html lang="en">

<head>
	@include('includes.head')
</head>
<script src="{{ asset('assets/js/global.js') }}"></script>

@php
	$bodyClass = (!empty($appBoxedLayout)) ? 'boxed-layout ' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : $bodyClass;
	$bodyClass .= (!empty($bodyClass)) ? $bodyClass . ' ' : $bodyClass;
	$appSidebarHide = (!empty($appSidebarHide)) ? $appSidebarHide : '';
	$appHeaderHide = (!empty($appHeaderHide)) ? $appHeaderHide : '';
	// $appSidebarTwo = (!empty($appSidebarTwo)) ? $appSidebarTwo : '';
	// $appSidebarSearch = (!empty($appSidebarSearch)) ? $appSidebarSearch : '';

	// $appTopMenu = (!empty($appTopMenu)) ? $appTopMenu : '';

	$appClass = (!empty($appHeaderHide)) ? 'app-without-header ' : ' app-header-fixed ';
	// $appClass .= (!empty($appTopMenu)) ? 'app-with-top-menu ' : '';
	// $appClass .= (!empty($appSidebarEnd)) ? 'app-with-end-sidebar ' : '';
	// $appClass .= (!empty($appSidebarWide)) ? 'app-with-wide-sidebar ' : '';
	// $appClass .= (!empty($appSidebarHide)) ? 'app-without-sidebar ' : '';
	// $appClass .= (!empty($appSidebarMinified)) ? 'app-sidebar-minified ' : '';
	// $appClass .= (!empty($appSidebarTwo)) ? 'app-with-two-sidebar app-sidebar-end-toggled ' : '';
	// $appClass .= (!empty($appSidebarHover)) ? 'app-with-hover-sidebar ' : '';
	// $appClass .= (!empty($appContentFullHeight)) ? 'app-content-full-height ' : '';

	$appContentClass = (!empty($appContentClass)) ? $appContentClass : '';
@endphp

<body class="{{ $bodyClass }}">
	<!-- BEGIN #loader -->
	@include('includes.component.page-loader')
	<!-- END #loader -->

	<!-- BEGIN #app -->
	<div id="app" class="app app-sidebar-fixed {{ $appClass }}">
		<!-- BEGIN #header -->
		@includeWhen(!$appHeaderHide, 'includes.header')
		<!-- END #header -->

		<!-- BEGIN #sidebar -->
		@includeWhen(!$appSidebarHide, 'includes.sidebar')
		<!-- END #sidebar -->

		<!-- BEGIN #content -->
		<div id="content" class="app-content {{ $appContentClass }}">
			@yield('content')
		</div>
		<!-- END #content -->

		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-theme btn-scroll-to-top"
			data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
		<!-- BEGIN theme-panel -->
		@include('includes.component.theme-panel')
		<!-- END theme-panel -->
	</div>
	<!-- END #app -->

	@include('includes.page-js')
</body>

</html>