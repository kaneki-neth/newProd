<style>
    .modal-before:before{
        content: "";
        border-radius: 5px;
        z-index: 1;
        background: transparent;
        backdrop-filter: blur(6px);
        position: absolute;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
    }

    #div-modal-loader{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
    }


</style>





<div class="modal fade" id="main_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div id="div-modal-loader" hidden>
            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="background: none; display: block; shape-rendering: auto;" width="121px" height="121px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <rect x="22" y="34.5" width="6" height="31" fill="#5be1e1">
                    <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="25.2;34.5;34.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate>
                    <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="49.6;31;31" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.2s"></animate>
                    </rect>
                    <rect x="47" y="34.5" width="6" height="31" fill="#6af8d4">
                    <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="27.525;34.5;34.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate>
                    <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="44.95;31;31" keySplines="0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.1s"></animate>
                    </rect>
                    <rect x="72" y="34.5" width="6" height="31" fill="#81b7bd">
                    <animate attributeName="y" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="27.525;34.5;34.5" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
                    <animate attributeName="height" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.5;1" values="44.95;31;31" keySplines="0 0.5 0.5 1;0 0.5 0.5 1"></animate>
                    </rect>
                    </svg>
                </div>        
            </div>
        </div>

    <div class="modal-dialog modal-dialog-centered" id="modal-dialog" role="document">
        <div class="modal-content" id="modal-content" style="overflow: hidden">
            <div class="modal-header" >
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="modal-body">

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="main_changes_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
        </div>
        <div class="modal-body">

            <form method="POST" id="changepass_form_onlogin">
                <div class="modal-body">
                   
                    <div class="alert alert-danger">
                        <h5><i class="fa fa-info-circle"></i> Warning</h5>
                        <p class="mb-1">You are required to change your password.</p>
                        <p>Please Remember your Credentials.</p>
                    </div>

                    <div class="row">
                        <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" readonly="" class="form-control form-control-sm" style="background: #e7e7e7;" name="email_l" id="email_l" value="{{auth()->user()->email}}">
                            <span id="email_l-msg" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="row">
                        <label for="cur_password" class="col-sm-4 col-form-label form-label">Current Password</label>
                        <div class="col-sm-8">
                            <input type="password" id="current_password_l" class="form-control form-control-sm" name="current_password_l" autocomplete="off" onkeyup="remove_error(this)">
                            <span id="current_password_l-msg" class="text-danger"></span>
                        </div>
                    </div>


                    <div class="row">
                        <label for="new_password" class="col-sm-4 col-form-label form-label">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" id="password_l" class="form-control form-control-sm" name="password_l" autocomplete="off" onkeyup="remove_error(this)">
                            <span id="password_l-msg" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="row">
                        <label for="confirm_password" class="col-sm-4 col-form-label form-label">Confirm New Password</label>
                        <div class="col-sm-8">
                            <input type="password" id="confirm-password_l" name="confirm-password_l" class="form-control form-control-sm" autocomplete="off" onkeyup="remove_error(this)">
                            <span id="confirm-password_l-msg" class="text-danger"></span>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="submit" id="changepass_btn_l" name="changepass_btn_l" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

