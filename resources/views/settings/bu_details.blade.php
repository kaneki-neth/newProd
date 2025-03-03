<div class="row p-1">
    <div class="col-12">

        <div class="row">
            <label class="form-label col-form-label col-md-3">BU Code <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->bu_code}}
            </div>
        </div>
        
        <div class="row">
            <label class="form-label col-form-label col-md-3"> BU Name<span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->bu_name}}
            </div>
        </div>

        <div class="row">
            <label class="form-label col-form-label col-md-3">Telephone Number</label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->tel_num}}
            </div>
        </div>

        <div class="row">
            <label class="form-label col-form-label col-md-3">Address 1 <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->address_line1}}
            </div>
        </div>

        <div class="row">
            <label class="form-label col-form-label col-md-3">Address 2</label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->address_line12}}
            </div>
        </div>

        <div class="row">
            <label class="form-label col-form-label col-md-3">City <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->city}}
            </div>
        </div>

        <div class="row">
            <label class="form-label col-form-label col-md-3">Province <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->province}}
            </div>
        </div>  

        <div class="row">       
            <label class="form-label col-form-label col-md-3">Postal Code <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->postal_code}}
            </div>
        </div>
        <div class="row">
            <label class="form-label col-form-label col-md-3">Country <span style="color:red">*</span></label>
            <div class="col-md-9 d-flex align-items-center">
            {{$combusunit->country}}
            </div>
        </div>

        <div class="row mt-4">
            <label class="form-label col-form-label col-md-3">&nbsp;</label>
            <div class="col-md-9">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" <?php if($combusunit->enabled === 1){echo "checked";}?> disabled>
                    <label class="form-check-label" for="">Enabled</label>
                </div>
            </div>
        </div>

    </div>


</div>