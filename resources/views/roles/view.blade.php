<form>
    
    <div class="row">
        <label for="type" class="col-sm-4 col-form-label form-label">Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-sm" value="{{$roles->rname}}" disabled style="background: #e7e7e7;">
        </div>
    </div>

    <table class="table align-middle dataTable no-footer dtr-inline">
        <thead class="table-light">
            <tr>
                <th>Permission</th>
            </tr>
        </thead>
        <tbody>
            @foreach($role as $r => $rol)
                <tr>
                    <td>
                        <input type="text" class="form-control form-control-sm" value="{{ $rol->display_name }}" disabled style="background: #e7e7e7;">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3 d-flex justify-content-end">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1">Back</button>
    </div>
    
</form>