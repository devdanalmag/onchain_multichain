
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
              <h4 class="box-title">Manage Account</h4>
			</div>
            <!-- /.box-header -->
            <div class="box-body">
            <form  name="chngpwd" method="post" class="form-submit">
                        <div class="form-group">
                        <label for="success" class="control-label">Account Name</label>
                        <div class="">
                        <input type="text" pattern="[A-Za-z',.:@_() ]{1,100}" title="Only Aplhanumeric Values Are Accepted" name="name" value="<?php echo AdminController::$adminName; ?>" class="form-control" required="required" id="success">
                        </div>
                        </div>
                        
                        <div class="form-group">
                        <label for="success" class="control-label">Account Username</label>
                        <div class="">
                        <input type="text" pattern="[A-Za-z',.:@_() 0-9]{1,100}" title="Only Aplhanumeric Values Are Accepted" name="username" value="<?php echo AdminController::$adminUsername; ?>" class="form-control" required="required" id="success" autocomplete="off" readonly />
                        </div>
                        </div>
                        
                        <div class="form-group" >
                        <label for="success" class="control-label">Current Password</label>
                        <div class="">
                        <input type="password" name="password" placeholder="Current Password" class="form-control"  required="required" id="success" autocomplete="off"  />
                        </div>
                        </div>
                        <p class="text-danger"><b><i>Note: Leave The Below Inputs Empty If You Don't Want To Update Your Password</i></b></p>
                        <div class="form-group">
                        <label for="success" class="control-label">New Password</label>
                        <div class="">
                          <input type="password" name="newpassword" placeholder="New Password" class="form-control" id="success" autocomplete="off" />
                        </div>
                        </div>

                        <div class="form-group" id="inputDiv">
                        <label for="success" class="control-label">Confirm Password</label>
                        <div class="">
                          <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control" onkeyup="validateInput();" id="success" autocomplete="off" />
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="">
                           <button type="submit" name="update-account" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                        </div>
                        </div>
                      </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>



