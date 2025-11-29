<div class="row">
    <div class="col-12">

        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Subscriber Details</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit row">
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Username Name</label>
                        <div class="">
                            <input type="text" name="uname" value="<?php echo $data->sUsername; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">First Name</label>
                        <div class="">
                            <input type="text" name="fname" value="<?php echo $data->sFname; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Last Name</label>
                        <div class="">
                            <input type="text" name="lname" value="<?php echo $data->sLname; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Email</label>
                        <div class="">
                            <input type="text" name="email" value="<?php echo $data->sEmail; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Phone</label>
                        <div class="">
                            <input type="number" name="phone" value="<?php echo $data->sPhone; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">State</label>
                        <div class="">
                            <input type="text" name="state" value="<?php echo $data->sState; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Transaction Pin</label>
                        <div class="">
                            <input type="number" name="pin" value="<?php echo $data->sPin; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Registration Date</label>
                        <div class="">
                            <input type="text" value="<?php echo $controller->formatDate($data->sRegDate); ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Last Activity</label>
                        <div class="">
                            <input type="text" value="<?php echo $controller->formatDate($data->sLastActivity); ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Wallet Balance</label>
                        <div class="">
                            <input type="text" value="<?php echo number_format($data->sWallet); ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Referral Balance</label>
                        <div class="">
                            <input type="text" value="<?php echo number_format($data->sRefWallet); ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="success" class="control-label">Referred By</label>
                        <div class="">
                            <input type="text" value="<?php echo $data->sReferal; ?>" class="form-control" name="referal">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Wallet Status</label>
                        <div class="">
                            <select class="form-control" name="wstatus" readonly required>
                                <?php if ($data->sType == 1): echo '<option value="1" selected>Active</option>';
                                else: echo '<option value="1">Active</option>';
                                endif; ?>
                                <?php if ($data->sType == 0): echo '<option value="0" selected>Not Active</option>';
                                else: echo '<option value="0">Not Active</option>';
                                endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Wallet Adress</label>
                        <div class="">
                            <input type="text" value="<?php echo $data->sTonaddress; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Account Type</label>
                        <div class="">
                            <select class="form-control" name="accounttype" required>
                                <?php if ($data->sType == 1): echo '<option value="1" selected>Subscriber</option>';
                                else: echo '<option value="1">Subscriber</option>';
                                endif; ?>
                                <?php if ($data->sType == 2): echo '<option value="2" selected>Agent</option>';
                                else: echo '<option value="2">Agent</option>';
                                endif; ?>
                                <?php if ($data->sType == 3): echo '<option value="3" selected>Vendor</option>';
                                else: echo '<option value="3">Vendor</option>';
                                endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Account Status</label>
                        <div class="">
                            <select class="form-control" name="accountstatus" required>
                                <?php if ($data->sRegStatus == 0): echo '<option value="0" selected>Active</option>';
                                else: echo '<option value="0">Active</option>';
                                endif; ?>
                                <?php if ($data->sRegStatus == 1): echo '<option value="1" selected>Blocked</option>';
                                else: echo '<option value="1">Blocked</option>';
                                endif; ?>
                                <?php if ($data->sRegStatus == 2): echo '<option value="2" selected>Pending Account Verification</option>';
                                else: echo '<option value="2">Pending Account Verification</option>';
                                endif; ?>
                                <?php if ($data->sRegStatus == 3): echo '<option value="3" selected>Pending Email Verification</option>';
                                else: echo '<option value="3">Pending Email Verification</option>';
                                endif; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="user" value="<?php echo base64_encode($data->sId); ?>" />

                    <div class="form-group col-md-6">
                        <div class="">
                            <button type="submit" name="update-subscriber" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
                            <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>






        <div class="box mt-2">
            <div class="box-header with-border">
                <h4 class="box-title">Reset Password</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit2 row">

                    <div class="form-group col-md-12">
                        <label for="success" class="control-label">New Password</label>
                        <div class="">
                            <input type="password" name="paccess" placeholder="New Password" class="form-control" required="required">
                        </div>
                    </div>
                    <input type="hidden" name="user" value="<?php echo base64_encode($data->sId); ?>" />

                    <div class="form-group col-md-12">
                        <div class="">
                            <button type="submit" name="update-subscriber-pass" class="btn btn-info btn-submit2"><i class="fa fa-save" aria-hidden="true"></i> Reset</button>
                            <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box mt-2">
            <div class="box-header with-border">
                <h4 class="box-title">Delete Account</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit3 row">

                    <p class="text-danger col-md-12">
                        <b>Note: </b>
                        When you delete an account, all details about the user including transaction records and wallet history would be removed permanently from the system. You should only delete an account when you notice the account was registered with fake details or looks suspicious.
                    </p>

                    <div class="form-group col-md-12">
                        <div class="">
                            <button type="button" onclick="terminateUserAccount('<?php echo base64_encode($data->sId); ?>');" name="update-subscriber-pass" class="btn btn-danger btn-submit3"><i class="fa fa-trash" aria-hidden="true"></i> Delete Account</button>
                            <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box mt-2">
            <div class="box-header with-border">
                <h4 class="box-title">Reset Account API Key</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit4 row">

                    <p class="text-danger col-md-12">
                        <b>Note: </b>
                        When Api is changed, all transactions via the API would be stopped until when updated. You should only reset API Key for security reasons only.
                    </p>

                    <div class="form-group col-md-12">
                        <div class="">
                            <input type="text" class="form-control" value="<?php echo $data->sApiKey; ?>" />
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <div class="">
                            <button type="button" onclick="resetUserApi('<?php echo base64_encode($data->sId); ?>');" name="reset-subscriber-api" class="btn btn-danger btn-submit4"><i class="fa fa-refresh" aria-hidden="true"></i> Reset Api Key</button>
                            <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>



    </div>
</div>