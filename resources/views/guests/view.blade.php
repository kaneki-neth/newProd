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
        <li class="breadcrumb-item active">View</li>
    </ol>

    <!-- page-header -->
    <h1 class="page-header">View Guest</h1>
    <div class="panel panel-inverse">
        <div class="panel-body">
            <div class="d-flex justify-content-start">
                <a class="btn btn-primary btn-xs" href="/guests/edit/{{ $guest->g_id }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>
                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-md" id="first_name" name="first_name"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $guest->first_name }}" disabled>
                            <span id="first_name-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Middle Name</label>
                            <input type="text" class="form-control form-control-md" id="middle_name" name="middle_name"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $guest->middle_name }}" disabled>
                            <span id="middle_name-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-md" id="last_name" name="last_name"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $guest->last_name }}" disabled>
                            <span id="last_name-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Gender</label>
                            <input class="form-control form-control-md select2" id="gender" name="gender" value="{{ $guest->gender }}" disabled>
                            </input>
                            <span id="gender-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Contact Number</label>
                            <input type="text" class="form-control form-control-sm" id="contact_number"
                                name="contact_number" onkeyup="this.value = this.value.toLowerCase(); remove_error(this);"
                                placeholder="..." value="{{ $guest->contact_number }}" disabled>
                            <span id="contact_number-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-md" id="email" name="email"
                                onkeyup="this.value = this.value.toLowerCase(); remove_error(this);" placeholder="..." value="{{ $guest->email }}" disabled>
                            <span id="email-msg" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Address 1</label>
                            <input type="text" class="form-control form-control-md" id="address_1" name="address_1"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $guest->address_1 }}" disabled>
                            <span id="address_1-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Address 2</label>
                            <input type="text" class="form-control form-control-md" id="address_2" name="address_2"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $guest->address_2 }}" disabled>
                            <span id="address_2-msg" class="text-danger"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Company</label>
                            <input class="form-control form-control-md select2" id="company" name="company" 
                            @if ($guest->company_name)
                            value="{{ $guest->company_name }}" 
                            @else 
                            value="Not connected in any company" 
                            @endif disabled>
                            <span id="company-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="row mt-2">
                        <label for="type" class="col-form-label form-label">Enabled</label>
                        <div class="form-check mt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" value="1" id="enabled" name="enabled"
                                    {{ $guest->enabled == 1 ? 'checked' : '' }} disabled>
                                <span id="enabled-msg" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
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
    </script>

@endsection