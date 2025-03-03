<style>
    span.select2-selection.select2-selection--single {
        height: 30px!important;
    }
    
    .update_modal_form{
        max-height: 350px;
        overflow-y: auto;

        padding-right: 15px;
    }
    .table-update-wrapper {
        overflow: -moz-scrollbars-vertical; 
		overflow-y:scroll;
		height:320px;
    }
    ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 7px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0,0,0,.5);
        -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
    }
    #trash-icon{
        color: red;
        font-size: 17px;
        text-align: left;
    }
    #icon-td{
        padding-left:0;
    }
</style>

<form method="POST" id="update_roles" autocomplete="off">
    
    <div class="row">
        <label for="type" class="col-sm-4 col-form-label form-label">Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-sm" id="role_name" value="{{$roles->rname}}" name="role_name" onkeyup="remove_error(this)" placeholder="...">
            <span id="role_name-msg" class="text-danger"></span>
        </div>
    </div>
    <div class="table-update-wrapper">
    <table class="table align-middle dataTable no-footer dtr-inline">
        <thead class="table-light">
            <tr>
                <th width="500px">Permission</th>
                <th style="padding-left:0;"><button type="button" id="addRowBtn" onclick="addRow()" class="btn btn-primary btn-xs"><i class="fa fa-add"></i></th>
            </tr>
        </thead>
        <tbody id="tableBody" class="update_modal_form">
            @foreach($role as $r => $rol)
                <tr>
                    <td>
                        <div id="div-{{$r}}_permission_id">
                            <select class="form-select form-select-xs select2" name="permission_id[]" id="{{$r}}_permission_id" onchange="remove_error(this)" >
                                <option value="{{ $rol->id }}" selected>{{ $rol->display_name }}</option>
                                @foreach ($permissionname as $pn)
                                    @if($pn->id != $rol->id && !$role->contains('id', $pn->id))
                                        <option value="{{ $pn->id }}">{{ $pn->display_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span id="{{$r}}_permission_id-msg" class="text-danger"></span>
                        </div>
                    </td>
                    
                    <td class="text-start" id="icon-td">
                        @if($r > 0)
                            <button type="button" class="btn btn-xs float-left" onclick="removeRow(this)"><i class="fa fa-trash" id='trash-icon'></i></button>
                        @endif
                    </td>
                </tr>

                @php
                    $lastID = $loop->last ? $r : null;
                @endphp
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="mt-3 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-xs m-1">Save</button>
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1">Cancel</button>
    </div>


    
</form>

<script>

    $('#role_name').keypress(function() {
        if($(this).val().length >= 50) {
            $(this).val($(this).val().slice(0, 50));
            return false;
        }
    });


    $(document).ready(function(){
        $('.select2').select2({
            dropdownParent: $('#main_modal')
        });
    }); 

    var roleindex = `{{ $lastID + 1 }}`;

    function addRow() {
        var tableBody = document.getElementById("tableBody");

        var newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td> 
                <div id="div-${roleindex}_permission_id">
                    <select name="permission_id[]" id="${roleindex}_permission_id" class="form-select form-select-sm select2" onchange="remove_error(this)">
                        <option value="">Select Role</option>
                        @foreach ($permissionname as $pn)
                            <option value="{{ $pn->id }}">{{ $pn->display_name }}</option>
                        @endforeach
                    </select>
                    <span id="${roleindex}_permission_id-msg" class="text-danger"></span>
                </div>
            </td>
            <td id="icon-td">
                <button type="button" class="btn btn-xs" onclick="removeRow(this)"><i class="fa fa-trash" id='trash-icon'></i></button>
            </td>
            
        `;
        tableBody.appendChild(newRow);

        $('#'+roleindex+'_permission_id').select2({
            dropdownParent: $('#main_modal')
        });

        var existingSelects = document.querySelectorAll('select[name^="permission_id"]');
        existingSelects.forEach(function(select) {
            var selectedValue = $(select).val();
            if (selectedValue) {
                $('#'+roleindex+'_permission_id option[value="'+selectedValue+'"]').remove();
            }
        });
        
        roleindex++;
        var tableWrapper = document.querySelector(".table-update-wrapper");
        if (tableWrapper.scrollHeight > tableWrapper.clientHeight) {
            tableWrapper.scrollTo(0, tableWrapper.scrollHeight);
        }
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        roleindex--;
    }

    $(document).on('change', 'select[name^="permission_id"]', function() {
        var roleId = $(this).attr('id').split('_')[0];
        $('#' + roleId + '_permission_id').next('.select2-container').find('.select2-selection').css('border', '1px solid grey');
    });

$('#update_roles').submit(function(e) {
        e.preventDefault();
        $(".btn").attr("disabled", true);
        let formData = new FormData(this);
        
        formData.append('_token', `{{ csrf_token() }}`);

        formData.append('_role', '{{ $roles->role_id }}');
        
        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '{{ route('roles.update') }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => { 
                // Swal.fire({
                //     icon: 'success',
                //     title: 'Data Successfully Updated!',
                //     showConfirmButton: false,
                //     timer: 1500
                // }).then(() => {
                //     location.reload();
                // });
                location.reload();
            
            }, error: function (reject) {
                $(".btn").attr("disabled", false);
                var errors = $.parseJSON(reject.responseText);
                $("#modal-content").removeClass("modal-before");
                $("#div-modal-loader").attr('style', 'display:none!important');
                $.each(errors.errors, function (field, messages) {
                    $("#" + field).css('border', '1px solid red');
                    $("span#" + field + "-msg").text(messages[0]);
                    if (field.endsWith("_permission_id")) {
                        var roleId = field.split("_")[0];
                        $("div#div-" + roleId + "_permission_id ").find(".select2-selection").css('border', '1px solid red');
                    }
                });
            }
        });
    });
</script>
