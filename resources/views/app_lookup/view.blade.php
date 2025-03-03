<form>

    <div class="row">
        <label for="lookup_type" class="col-sm-3 col-form-label form-label">Type</label>
        <div class="col-sm-9 mt-3">
            <b>{{$lookups->lookup_type}}</b>
        </div>
    </div>

    <div class="row">
        <label for="lookup_code" class="col-sm-3 col-form-label form-label">Code</label>
        <div class="col-sm-9 mt-2">
            <b>{{$lookups->lookup_code}}</b>
        </div>
    </div>

    <div class="row">
        <label for="meaning" class="col-sm-3 col-form-label form-label">Meaning</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" value="{{$lookups->meaning}}" disabled style="background: #e7e7e7;">
        </div>
    </div>

    <div class="row mb-1">
        <label for="tag" class="col-sm-3 col-form-label form-label">Tag</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" value="{{$lookups->tag}}" disabled style="background: #e7e7e7;">
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col-sm-9">

            <div class="form-check mb-4" style="padding-left: 0;">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" disabled <?php if($lookups->enabled === 1){echo "checked";}?>>
                    <label class="form-check-label" for="">Enabled</label>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1">Cancel</button>
            </div>
        </div>
    </div>
</form>