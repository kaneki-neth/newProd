<!DOCTYPE html>
<html lang="en">
<head>
	@include('includes.head')
</head>
<body>
	<!-- BEGIN #loader -->
	@include('includes.component.page-loader')
	<!-- END #loader -->

	<!-- BEGIN #app -->
	<div id="app" class="app">

		<!-- BEGIN #content -->
        <div id="content" class="">
            @yield('content')
        </div>
		<!-- END #content -->

		<!-- BEGIN theme-panel -->
		@include('includes.component.theme-panel')
		<!-- END theme-panel -->
		<!-- BEGIN scroll-top-btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-theme btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
		<!-- END scroll-top-btn -->
	</div>
	<!-- END #app -->
	
	@include('includes.page-js')
</body>
</html>