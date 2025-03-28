@extends('layouts.app')

@section('title', 'Guests')

@section('content')
    <style>
        .custom-input {
            height: 30px;
        }

        .select2-search {
            display: none;
        }

        span.select2-selection.select2-selection--single {
            height: 30px !important;
        }

        .btnRoles:hover {
            font-weight: bold;
            color: #28acb5;
        }
    </style>

    <!--  breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="/guests">Guests</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>

    <!-- page-header -->
    <h1 class="page-header">Create Guest</h1>
    <div class="panel panel-inverse">
        <div class="panel-body">
            <form method="POST" id="add_guest" autocomplete="off">
                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">First Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-md" id="first_name" name="first_name"
                                onkeyup="remove_error(this)" placeholder="...">
                            <span id="first_name-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Middle Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-md" id="middle_name" name="middle_name"
                                onkeyup="remove_error(this)" placeholder="...">
                            <span id="middle_name-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Last Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-md" id="last_name" name="last_name"
                                onkeyup="remove_error(this)" placeholder="...">
                            <span id="last_name-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Gender <span style="color:red">*</span></label>
                            <select class="form-control form-control-md select2" id="gender" name="gender">
                                <option selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <span id="gender-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Contact Number <span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="contact_number"
                                name="contact_number" onkeyup="this.value = this.value.toLowerCase(); remove_error(this);"
                                placeholder="...">
                            <span id="contact_number-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Email <span style="color:red">*</span></label>
                            <input type="email" class="form-control form-control-md" id="email" name="email"
                                onkeyup="this.value = this.value.toLowerCase(); remove_error(this);" placeholder="...">
                            <span id="email-msg" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Address 1<span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-md" id="address_1" name="address_1"
                                onkeyup="remove_error(this)" placeholder="...">
                            <span id="address_1-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Address 2 <span style="color:red">*</span></label>
                            <input type="text" class="form-control form-control-md" id="address_2" name="address_2"
                                onkeyup="remove_error(this)" placeholder="...">
                            <span id="address_2-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Company <span>(Select NA if
                                    none)</span> <span style="color:red">*</span></label>
                            <select class="form-control form-control-md select2" id="company" name="company">
                                <option selected disabled>Select Company</option>
                                <option value="NA">NA</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->c_id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <span id="company-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row mt-2">
                        <label for="type" class="col-form-label form-label">Enabled <span style="color:red">*</span></label>
                        <div class="form-check mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" id="enabled" name="enabled"
                                    checked>
                                <span id="enabled-msg" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-4">

                <a type="button" href="/guests" class="btn btn-secondary btn-xs px-2 m-1" style="float: right">Back</a>
                <button type="submit" class="btn btn-primary btn-xs px-2 m-1" style="float: right">Save</button>
        </div>
    </div>
    </div>
    </form>
    </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $("#guests").addClass("active");
        $("#guests").attr("style", "display: block; box-sizing: border-box;");

        $(document).ready(function () {
            $('#gender').select2();
            $('#company').select2();
        });


        $('#add_guest').submit(function (e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);

            let formData = new FormData(this);

            formData.append('_token', `{{ csrf_token() }}`);
            formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);


            $.ajax({
                method: 'post',
                url: '/guests/store',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    $(".btn").attr("disabled", false);
                    if (xhr.status === 400) {
                        const errors = xhr.responseJSON.errors;
                        $("input").css('border', '');
                        $(".error-msg").text('');
                        Object.keys(errors).forEach(field => {
                            $(`#${field}`).css('border', '1px solid red');
                            $(`#${field}-msg`).text(errors[field]);
                        });
                    }
                }
            });
        });
    </script>

@endsection