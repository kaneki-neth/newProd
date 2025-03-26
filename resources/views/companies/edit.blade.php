@extends('layouts.app')

@section('title', 'Companies')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="/companies">Companies</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Company</h1>
    <!-- end page-header -->
    <style>
        .select2.select2-container .selection .select2-selection.select2-selection--single {
            height: 28px !important;
        }
    </style>
    <div class="panel panel-inverse">
        <div class="panel-body">
            <form method="POST" id="edit_company" autocomplete="off">
                <div class="col-md-12">
                    <div class="row mt-2">
                        <label for="type" class="col-md-2 col-form-label form-label">Name <span
                                style="color:red">*</span></label>
                        <div class="col-md-4" id="div-name">
                            <input type="text" class="form-control form-control-md" id="name" name="name"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $company->name }}">
                            <span id="name-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row mt-2">
                        <label for="type" class="col-md-2 col-form-label form-label">Description <span
                                style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-md" id="description" name="description"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $company->description }}">
                            <span id="description-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row mt-2">
                        <label for="type" class="col-md-2 col-form-label form-label">Address <span
                                style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-md" id="address" name="address"
                                onkeyup="remove_error(this)" placeholder="..." value="{{ $company->address }}">
                            <span id="address-msg" class="text-danger"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row mt-2">
                        <label for="type" class="col-md-2 col-form-label form-label">Contact Number <span
                                style="color:red">*</span></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" id="contact_number"
                                name="contact_number" onkeyup="this.value = this.value.toLowerCase(); remove_error(this);"
                                placeholder="..." value="{{ $company->contact_number }}">
                            <span id="contact_number-msg" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row mt-2">
                            <label for="type" class="col-md-2 col-form-label form-label">Email <span
                                    style="color:red">*</span></label>
                            <div class="col-md-4">
                                <input type="email" class="form-control form-control-md" id="email" name="email"
                                    onkeyup="this.value = this.value.toLowerCase(); remove_error(this);" placeholder="..."
                                    value="{{ $company->email }}">
                                <span id="email-msg" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row mt-2">
                                <label for="type" class="col-md-2 col-form-label form-label">Enabled <span
                                        style="color:red">*</span></label>
                                <div class="col-md-4">
                                    <div class="form-check" style="padding-left: 0; margin-top:2%">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="1" id="enabled"
                                                name="enabled" {{ $company->enabled == 1 ? 'checked' : '' }}>
                                            <span id="enabled-msg" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-3 mb-4">

                            <a type="button" href="/companies" class="btn btn-secondary btn-xs px-2 m-1"
                                style="float: right">Back</a>
                            <button type="submit" class="btn btn-primary btn-xs px-2 m-1" style="float: right">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script>
        $("#companies").addClass("active");
        $("#companies").attr("style", "display: block; box-sizing: border-box;");

        $('#edit_company').submit(function (e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);

            let formData = new FormData(this);

            formData.append('_token', `{{ csrf_token() }}`);
            formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);


            $.ajax({
                method: 'post',
                url: '/companies/update/{{ $company->c_id }}',
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