@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Company</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h5 class="page-header">Company Settings</h5>
	<!-- end page-header -->

	<!-- begin panel -->
	<div class="panel panel-inverse">

		<div class="panel-body">
			<form id="form-company" autocomplete="off">
				<div class="row p-4">
					<div class="col-6">

						<div class="row">
							<label class="form-label col-form-label col-md-3">Company Name <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" name="company_name" onkeyup="remove_error(this)" id="company_name"
									value="{{$com_set->company_name}}" class="form-control form-control-sm mb-5px"
									placeholder="Company Name">
								<span id="company_name-msg" class="text-danger"></span>
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Short Name <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" id="short_name" onkeyup="remove_error(this)" name="short_name"
									value="{{$com_set->short_name}}" class="form-control form-control-sm mb-5px"
									placeholder="Company Short Name">
								<span id="short_name-msg" class="text-danger"></span>
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Telephone Number</label>
							<div class="col-md-9">
								<input type="text" id="tel_num" name="tel_num" value="{{$com_set->tel_num}}"
									class="form-control form-control-sm mb-5px" placeholder="Telephone Number">
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Address 1 <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" onkeyup="remove_error(this)" id="address_line1" name="address_line1"
									value="{{$com_set->address_line1}}" class="form-control form-control-sm mb-5px"
									placeholder="Address 1">
								<span id="address_line1-msg" class="text-danger"></span>
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Address 2</label>
							<div class="col-md-9">
								<input type="text" id="address_line2" name="address_line2"
									value="{{$com_set->address_line2}}" class="form-control form-control-sm mb-5px"
									placeholder="Address 2">
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row">
							<label class="form-label col-form-label col-md-3">City <span style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" onkeyup="remove_error(this)" id="city" name="city"
									value="{{$com_set->city}}" class="form-control form-control-sm mb-5px"
									placeholder="City">
								<span id="city-msg" class="text-danger"></span>
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Province <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" onkeyup="remove_error(this)" id="province" name="province"
									value="{{$com_set->province}}" class="form-control form-control-sm mb-5px"
									placeholder="Province">
								<span id="province-msg" class="text-danger"></span>
							</div>
						</div>

						<div class="row">
							<label class="form-label col-form-label col-md-3">Postal Code <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" onkeyup="remove_error(this)" id="postal_code" name="postal_code"
									value="{{$com_set->postal_code}}" class="form-control form-control-sm mb-5px"
									placeholder="Postal Code">
								<span id="postal_code-msg" class="text-danger"></span>
							</div>
						</div>
						<div class="row">
							<label class="form-label col-form-label col-md-3">Country <span
									style="color:red">*</span></label>
							<div class="col-md-9">
								<input type="text" onkeyup="remove_error(this)" id="country" name="country"
									value="{{$com_set->country}}" class="form-control form-control-sm mb-5px"
									placeholder="Country">
								<span id="country-msg" class="text-danger"></span>
							</div>
						</div>
					</div>
					<div class="col-12 mt-4">
						<button type="submit" class="btn btn-primary btn-xs px-4"> SAVE</button>
					</div>

				</div>
			</form>
		</div>
	</div>

	<h5 class="page-header">Business Unit</h5>
	<div class="panel panel-inverse">

		<div class="panel-body">
			<form id="form-company">
				<div class="row p-4">
					<div class="col-12">
						<button type="button" class="btn btn-primary btn-xs px-4" onclick="showmodalsettings()"> +
							ADD</button>
						<table class="table table-hover mb-0 text-dark">
							<thead>
								<tr>
									<th>BU Code</th>
									<th>Business Unit</th>
									<th style="width:35%">Address</th>
									<th>enabled</th>
									<th width="280px">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($combusunit as $bus_unit)
									<tr>
										<td>{{$bus_unit->bu_code}}</td>
										<td>{{$bus_unit->bu_name}}</td>
										<td style="width:35%">{{$bus_unit->address_line1}}</td>
										<td>
											@if ($bus_unit->enabled)
												<i class="fa fa-check text-success"></i>
											@else
												<i class="fa fa-times text-danger"></i>
											@endif
										</td>
										<td width="280px">
											<a href="#"
												class="btn btn-lg border-0 rounded-pill w-40px p-0 d-flex align-items-center justify-content-center"
												data-bs-toggle="dropdown">
												<i class="fa fa-ellipsis-h text-gray-600"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-end">
												<button type="button" onclick="show_modal_update(this)"
													bu="{{$bus_unit->bu_id}}" class="dropdown-item"><i
														class="fa fa-fw fa-edit fa-lg me-1"></i> Edit BU</button>
												<button type="button" onclick="show_bu_details(this);" bu="{{$bus_unit->bu_id}}"
													class="dropdown-item"><i class="fa fa-fw fa-file fa-lg me-1"></i> Show
													Details</button>

												@if ($bus_unit->enabled)
													<a href="#" class="dropdown-item" bu="{{$bus_unit->bu_id}}"
														onclick="disabled(this)"><i class="fa fa-fw fa-trash-alt fa-lg me-1"></i>
														Disable</a>
												@else
													<a href="#" class="dropdown-item" bu="{{$bus_unit->bu_id}}"
														onclick="enabled(this)"><i class="fas fa-trash-restore"
															style="font-size:17px;margin-left: 2px;"></i> <span
															style="margin-left: 6px;">Enable</span></a>
												@endif


											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- end panel -->
	<script src="/assets/js/jquery-3.6.4.min.js"></script>
	<script>
		$("#menu_profile").addClass("active");
		$("#appSidebarProfileMenu").addClass("expand");
		$("#appSidebarProfileMenu").attr("style", "display: block; box-sizing: border-box;");
		$("#company_settings").addClass("active");


		$('#company_name').keypress(function () {
			if ($(this).val().length >= 50) {
				$(this).val($(this).val().slice(0, 50));
				return false;
			}
		});

		$('#short_name').keypress(function () {
			if ($(this).val().length >= 20) {
				$(this).val($(this).val().slice(0, 20));
				return false;
			}
		});

		$('#tel_num').keypress(function () {
			if ($(this).val().length >= 50) {
				$(this).val($(this).val().slice(0, 50));
				return false;
			}
		});

		$('#address_line1').keypress(function () {
			if ($(this).val().length >= 50) {
				$(this).val($(this).val().slice(0, 50));
				return false;
			}
		});

		$('#address_line2').keypress(function () {
			if ($(this).val().length >= 50) {
				$(this).val($(this).val().slice(0, 50));
				return false;
			}
		});

		$('#city').keypress(function () {
			if ($(this).val().length >= 50) {
				$(this).val($(this).val().slice(0, 50));
				return false;
			}
		});

		$('#province').keypress(function () {
			if ($(this).val().length >= 30) {
				$(this).val($(this).val().slice(0, 30));
				return false;
			}
		});

		$('#postal_code').keypress(function () {
			if ($(this).val().length >= 10) {
				$(this).val($(this).val().slice(0, 10));
				return false;
			}
		});

		$('#country').keypress(function () {
			if ($(this).val().length >= 2) {
				$(this).val($(this).val().slice(0, 2));
				return false;
			}
		});


		function show_modal_update(e) {
			var bu = $(e).attr('bu');

			$.ajax({
				method: 'get',
				url: '/settings/company/bu/edit?bu=' + bu,
				contentType: false,
				processData: false,
				success: (response) => {
					$("#main_modal").modal('show');
					$("#modal-title").html(`Business Unit (Edit)`);
					$("#modal-body").html(response);
				},
				error: function (reject) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong! Please contact your system admin',
					})
				}
			});
		}

		function show_bu_details(e) {
			var bu = $(e).attr('bu');
			$.ajax({
				method: 'get',
				url: '/settings/company/bu/details?bu=' + bu,
				contentType: false,
				processData: false,
				success: (response) => {
					$("#main_modal").modal('show');
					$("#modal-title").html(`Business Unit (Details)`);
					$("#modal-body").html(response);
				},
				error: function (reject) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong! Please contact your system admin',
					})
				}
			});
		}

		function showmodalsettings() {

			$.ajax({
				method: 'get',
				url: '/settings/company/bu',
				contentType: false,
				processData: false,
				success: (response) => {
					$("#main_modal").modal('show');
					$("#modal-title").html(`Business Unit (Add)`);
					$("#modal-body").html(response);
				},
				error: function (reject) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong! Please contact your system admin',
					})
				}
			});

		}

		function enabled(e) {
			var bu = $(e).attr('bu');
			Swal.fire({
				title: "Are you sure?",
				text: "You are trying to enable this business unit!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, enable it!"
			}).then((result) => {
				if (result.isConfirmed) {
					let formData = new FormData();
					formData.append('_token', `{{ csrf_token() }}`);
					$.ajax({
						method: 'post',
						url: '/settings/company/bu/enabled?bu=' + bu,
						data: formData,
						contentType: false,
						processData: false,
						success: (response) => {
							location.reload();
						},
						error: function (reject) {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong please contact your admin! ",
							});
						}
					});
				}
			});
		}

		function disabled(e) {
			var bu = $(e).attr('bu');

			Swal.fire({
				title: "Are you sure?",
				text: "You are trying to disable this business unit!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, disable it!"
			}).then((result) => {
				if (result.isConfirmed) {
					let formData = new FormData();
					formData.append('_token', `{{ csrf_token() }}`);
					$.ajax({
						method: 'post',
						url: '/settings/company/bu/disabled?bu=' + bu,
						data: formData,
						contentType: false,
						processData: false,
						success: (response) => {
							location.reload();
						},
						error: function (reject) {
							Swal.fire({
								icon: "error",
								title: "Oops...",
								text: "Something went wrong please contact your admin! ",
							});
						}
					});
				}
			});
		}

		$('#form-company').submit(function (e) {
			e.preventDefault();
			$(".btn").attr("disabled", true);
			let formData = new FormData(this);
			formData.append('_token', `{{ csrf_token() }}`);

			$.ajax({
				method: 'post',
				url: '/settings/company/update',
				data: formData,
				contentType: false,
				processData: false,
				success: (response) => {
					location.reload();
				},
				error: function (reject) {
					$(".btn").attr("disabled", false);
					var errors = $.parseJSON(reject.responseText);
					$.each(errors.errors, function (field, messages) {
						// Highlight the form field with an error
						$("input#" + field).css('border', '1px solid red');
						// Display the first error message
						$("span#" + field + "-msg").text(messages[0]);
					});

				}
			});
		});

	</script>
@endsection