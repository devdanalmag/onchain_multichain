<style>
    .color-blue-dark {
        background-color: #0000 !important;
    }

    @media screen and (max-width: 768px) {
        .data-lists span {
            font-size: 15px !important;
        }
    }

    @media screen and (max-width: 480px) {
        .data-lists span {
            font-size: 10px !important;
        }

    }
</style>
<?php
if (isset($_GET['set-wallet'])) {
    $wallettab = "data-active";
    $tab1show = "";
    $tab2show = "";
    $tab3show = "";
    $tab4show = "show";
    $pintab = "";
    $profiletab = "";
    $passtab = "";
} else if (isset($_GET['set-pin'])) {
    $pintab = "data-active";
    $wallettab = "";
    $profiletab = "";
    $passtab = "";
    $tab1show = "";
    $tab2show = "";
    $tab3show = "show";
    $tab4show = "";
} else if (isset($_GET['set-pass'])) {
    $passtab = "data-active";
    $wallettab = "";
    $profiletab = "";
    $passtab = "";
    $tab1show = "";
    $tab2show = "show";
    $tab3show = "";
    $tab4show = "";
} else if (isset($_GET['set-profile'])) {
    $profiletab = "data-active";
    $wallettab = "";
    $passtab = "";
    $passtab = "";
    $tab1show = "show";
    $tab2show = "";
    $tab3show = "";
    $tab4show = "";
} else {
    $profiletab = "data-active";
    $wallettab = "";
    $passtab = "";
    $pintab = "";
    $tab1show = "show";
    $tab2show = "";
    $tab3show = "";
    $tab4show = "";
}

?>
<div class="page-content header-clear-medium" id="page-file-name" page-name="profile">


    <div class="card card-style bg-theme pb-0">
        <div class="content" id="tab-group-1">
            <div class="tab-controls tabs-small tabs-rounded" data-highlight="bg-highlight">
                <a href="#" <?php echo $profiletab; ?> data-bs-toggle="collapse" data-bs-target="#tab-1">Profile</a>
                <a href="#" <?php echo $passtab; ?> data-bs-toggle="collapse" data-bs-target="#tab-2">Password</a>
                <a href="#" <?php echo $pintab; ?> data-bs-toggle="collapse" data-bs-target="#tab-3">Pin</a>
                <a href="#" <?php echo $wallettab; ?> data-bs-toggle="collapse" data-bs-target="#tab-4">Wallet</a>
                <!-- <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-5">S/Media</a> -->


            </div>
            <div class="clearfix mb-3"></div>
            <div data-bs-parent="#tab-group-1" class="collapse <?php echo $tab1show ?>" id="tab-1">
                <p class="mb-n1 color-highlight font-600 font-12">Account Details</p>
                <h4>Basic Information</h4>

                <div class="list-group list-custom-small">
                    <a href="#" class="data-lists" style="display: <?php if ($data->sUsername == "" || $data->sUsername == NULL) {
                                                                        echo "none";
                                                                    } else {
                                                                        echo "block";
                                                                    } ?>;">
                        <i class="fa font-14 fa-user rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>Username: </b> <?php echo $data->sUsername; ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#" class="data-lists">
                        <i class="fa font-14 fa-level-up rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>Account Level: </b><?php echo $controller->formatUserType($data->sType); ?></span>
                        </span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#" class="data-lists" style="display: <?php if ($data->sFname == "" || $data->sFname == NULL) {
                                                                        echo "none";
                                                                    } else {
                                                                        echo "block";
                                                                    } ?>;">
                        <i class="fa font-14 fa-user rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>Name: </b> <?php echo $data->sFname . " " . $data->sLname; ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#" class="data-lists">
                        <i class="fa font-14 fa-envelope rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>Email: </b> <?php echo $data->sEmail; ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#" class="data-lists" style="display: <?php if ($data->sPhone == "" || $data->sPhone == NULL) {
                                                                        echo "none";
                                                                    } else {
                                                                        echo "block";
                                                                    } ?>;">
                        <i class="fa font-14 fa-phone rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>Phone: </b> <?php echo $data->sPhone; ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#" class="data-lists" style="display: <?php if ($data->sState == "" || $data->sState == NULL) {
                                                                        echo "none";
                                                                    } else {
                                                                        echo "block";
                                                                    } ?>;">
                        <i class="fa font-14 fa-globe rounded-xl shadow-xl color-blue-dark"></i>
                        <span><b>State: </b> <?php echo $data->sState; ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                 <i style="color: red;"><?php if ($data->sType == 1 || $data->sType == "1") {
                                                                                                                                        echo " Fill Below TO Level Up";
                                                                                                                                    }; ?></i>
                <form id="profileForm" method="post">
                    <div class="mt-5 mb-3">
                        <div class="input-style  no-borders has-icon mb-4">
                            <i class="fa fa-user"></i>
                            <input type="text" value="<?php if ($data->sFname <> "" || $data->sFname <> NULL) {
                                                            echo $data->sFname;
                                                        } ?>" class="form-control" id="fname" name="fname" placeholder="First Name" required />
                            <label for="name" class="color-highlight"> First Name</label>
                            <em>(required)</em>
                        </div>
                        <div class="input-style  no-borders has-icon mb-4">
                            <i class="fa fa-user"></i>
                            <input type="text" value="<?php if ($data->sLname <> "" || $data->sLname <> NULL) {
                                                            echo $data->sLname;
                                                        } ?>" class="form-control" id="lname" name="lname" placeholder="Last Name" required />
                            <label for="name" class="color-highlight"> Last Name</label>
                            <em>(required)</em>
                        </div>
                        <?php if ($data->sEmail == "" || $data->sEmail == NULL) { ?>
                            <div class="input-style  no-borders has-icon mb-4">
                                <i class="fa fa-envelope"></i>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
                                <label for="email" class="color-highlight"> Email</label>
                                <em>(required)</em>
                            </div>
                        <?php } ?>
                        <?php if ($data->sPhone == "" || $data->sPhone == NULL) { ?>
                            <div class="input-style  no-borders has-icon mb-4">
                                <i class="fa fa-phone"></i>
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone Number" required />
                                <label for="phone" class="color-highlight"> Phone Number</label>
                                <em style="color: red;">(required-once)</em>
                            </div>
                        <?php } ?>
                        <?php if ($data->sState == "" || $data->sState == NULL) { ?>
                            <div class="input-style  no-borders has-icon mb-4">
                                <i class="fa fa-map"></i>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="" selected disabled>State</option>
                                    <option value="Abuja FCT" style="color:#000000 !important;">Abuja FCT</option>
                                    <option value="Abia" style="color:#000000 !important;">Abia</option>
                                    <option value="Adamawa" style="color:#000000 !important;">Adamawa</option>
                                    <option value="Akwa Ibom" style="color:#000000 !important;">Akwa Ibom</option>
                                    <option value="Anambra" style="color:#000000 !important;">Anambra</option>
                                    <option value="Bauchi" style="color:#000000 !important;">Bauchi</option>
                                    <option value="Bayelsa" style="color:#000000 !important;">Bayelsa</option>
                                    <option value="Benue" style="color:#000000 !important;">Benue</option>
                                    <option value="Borno" style="color:#000000 !important;">Borno</option>
                                    <option value="Cross River" style="color:#000000 !important;">Cross River</option>
                                    <option value="Delta" style="color:#000000 !important;">Delta</option>
                                    <option value="Ebonyi" style="color:#000000 !important;">Ebonyi</option>
                                    <option value="Edo" style="color:#000000 !important;">Edo</option>
                                    <option value="Ekiti" style="color:#000000 !important;">Ekiti</option>
                                    <option value="Enugu" style="color:#000000 !important;">Enugu</option>
                                    <option value="Gombe" style="color:#000000 !important;">Gombe</option>
                                    <option value="Imo" style="color:#000000 !important;">Imo</option>
                                    <option value="Jigawa" style="color:#000000 !important;">Jigawa</option>
                                    <option value="Kaduna" style="color:#000000 !important;">Kaduna</option>
                                    <option value="Kano" style="color:#000000 !important;">Kano</option>
                                    <option value="Katsina" style="color:#000000 !important;">Katsina</option>
                                    <option value="Kebbi" style="color:#000000 !important;">Kebbi</option>
                                    <option value="Kogi" style="color:#000000 !important;">Kogi</option>
                                    <option value="Kwara" style="color:#000000 !important;">Kwara</option>
                                    <option value="Lagos" style="color:#000000 !important;">Lagos</option>
                                    <option value="Nassarawa" style="color:#000000 !important;">Nassarawa</option>
                                    <option value="Niger" style="color:#000000 !important;">Niger</option>
                                    <option value="Ogun" style="color:#000000 !important;">Ogun</option>
                                    <option value="Ondo" style="color:#000000 !important;">Ondo</option>
                                    <option value="Osun" style="color:#000000 !important;">Osun</option>
                                    <option value="Oyo" style="color:#000000 !important;">Oyo</option>
                                    <option value="Plateau" style="color:#000000 !important;">Plateau</option>
                                    <option value="Rivers" style="color:#000000 !important;">Rivers</option>
                                    <option value="Sokoto" style="color:#000000 !important;">Sokoto</option>
                                    <option value="Taraba" style="color:#000000 !important;">Taraba</option>
                                    <option value="Yobe" style="color:#000000 !important;">Yobe</option>
                                    <option value="Zamfara" style="color:#000000 !important;">Zamfara</option>
                                </select>
                                <label for="state" class="color-highlight">State</label>
                                <em style="color: red;">(required-once)</em>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($data->sPhone == "" || $data->sPhone == NULL || $data->sState == "" || $data->sState == NULL) { ?>
                        <div class="input-style  no-borders has-icon mb-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="login-pass" name="loginpass" placeholder="Login Password" required />
                            <label for="login-pass" class="color-highlight"> Login Password:</label>
                            <em style="color: red;">(required)</em>
                        </div>
                    <?php } ?>
                    <button type="submit" id="update-info-btn" style="width: 100%;"
                        class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Update Information
                    </button>
                </form>
                <p class="mb-n1 mt-2 color-highlight font-600 font-12">Referral</p>
                <h4>Referral Link</h4>
                <div class="list-group list-custom-small">
                    <a href="#">
                        <input type="text" class="form-control" readonly
                            value="<?php echo $siteurl . "app/register/?referral=" . $data->sUsername; ?>" />
                    </a>
                    <a style="background-color: #0000; margin-top: 10px; padding: 0; border: 0px; border-radius: 0px;">
                        <button class="btn btn-danger btn-sm"
                            onclick='copyToClipboard("<?php echo $siteurl . "app/register/?referral=" . $data->sUsername; ?>")'>Copy
                            Link</button>
                        <div style="width: 10px; height: 2px;"> </div>
                        <button class="btn btn-success btn-sm" onclick="window.open('referrals')">View
                            Commission</button>
                    </a>
                </div>


                <?php if ($data->sType == 3): ?>
                    <p class="mb-n1 mt-2 color-highlight font-600 font-12">Developer</p>
                    <h4>Api Documentation</h4>
                    <div class="list-group list-custom-small">
                        <a href="#">
                            <input type="text" class="form-control" readonly value="<?php echo $data->sApiKey; ?>" />
                        </a>
                        <a href="#">
                            <button class="btn btn-danger btn-sm"
                                onclick="copyToClipboard('<?php echo $data->sApiKey; ?>')">Copy Api Key</button>
                            <?php if (!empty($data2)): ?>
                                <button class="pl-5 btn btn-success btn-sm"
                                    onclick="window.open('<?php echo $data2->apidocumentation; ?>')">View Documentation</button>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <div data-bs-parent="#tab-group-1" class="collapse <?php echo $tab2show ?>" id="tab-2">
                <p class="mb-n1 color-highlight font-600 font-12">Update Login Details</p>
                <h4>Login Details</h4>

                <form id="passForm" method="post">
                    <div class="mt-5 mb-3">

                        <div class="input-style has-borders no-icon input-style-always-active mb-4">
                            <input type="password" class="form-control" id="old-pass" name="oldpass"
                                placeholder="Old Password" required>
                            <label for="old-pass" class="color-highlight">Old Password</label>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                            <input type="password" class="form-control" id="new-pass" name="newpass"
                                placeholder="New Password" required>
                            <label for="new-pass" class="color-highlight">New Password</label>
                            <em>(required)</em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active mb-4">
                            <input type="password" class="form-control" id="retype-pass" placeholder="Retype Password"
                                required>
                            <label for="retype-pass" class="color-highlight">Retype Password</label>
                            <em>(required)</em>
                        </div>
                    </div>
                    <button type="submit" id="update-pass-btn" style="width: 100%;"
                        class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Update Password
                    </button>
                </form>
            </div>

            <div data-bs-parent="#tab-group-1" class="collapse <?php echo $tab3show ?>" id="tab-3">
                <p class="mb-n1 color-highlight font-600 font-12">Update Transaction Pin</p>
                <h4>Transaction Pin</h4>

                <form id="pinForm" method="post">
                    <div class="mt-3 mb-3">
                        <p class="text-danger"><b>Note: </b> The Default Transaction Pin Is '1234'. Your Transaction Pin
                            should be a four digit number. </p>
                        <div class="input-style has-borders no-icon input-style-always-active mb-4">
                            <input type="number" class="form-control" id="old-pin" name="oldpin" placeholder="Old Pin"
                                required>
                            <label for="old-pin" class="color-highlight">Old Pin</label>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                            <input type="number" class="form-control" id="new-pin" name="newpin" placeholder="New Pin"
                                required>
                            <label for="new-pin" class="color-highlight">New Pin</label>
                            <em>(required)</em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active mb-4">
                            <input type="number" class="form-control" id="retype-pin" placeholder="Retype Pin" required>
                            <label for="retype-pin" class="color-highlight">Retype Pin</label>
                            <em>(required)</em>
                        </div>
                    </div>
                    <button type="submit" id="update-pin-btn" style="width: 100%;"
                        class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Update Pin
                    </button>
                </form>

                <!-- <hr />

                <p class="mb-n1 color-highlight font-600 font-12">Disable Transaction Pin</p>
                <h4>Disable Pin</h4> -->

                <!-- <form class="the-submit-form" method="post">
                    <div class="mt-3 mb-3">
                        <p class="text-danger"><b>Note: </b> Only Disable Pin When You Are Sure About The Security Of
                            Your Phone And Your Account Is Secured With A Strong Password. </p>
                        <div class="input-style has-borders no-icon input-style-always-active mb-4">
                            <input type="number" maxlength="4" class="form-control" id="old-pin" name="oldpin"
                                placeholder="Old Pin" required>
                            <label for="old-pin" class="color-highlight">Old Pin</label>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active  mb-4">
                            <select name="pinstatus">
                                <option value="">Change Status</option>
                                <?php if ($data->sPinStatus == 0): ?>
                                    <option value="0" selected>Enable</option>
                                    <option value="1">Disable</option>
                                <?php else: ?>
                                    <option value="0">Enable</option>
                                    <option value="1" selected>Disable</option>
                                <?php endif; ?>
                            </select><label for="new-pin" class="color-highlight">Change Status</label>
                            <em>(required)</em>
                        </div>
                    </div>
                    <button type="submit" name="disable-user-pin" style="width: 100%;"
                        class="the-form-btn btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Update Pin
                    </button>
                </form> -->
            </div>



            <div data-bs-parent="#tab-group-1" class="collapse <?php echo $tab4show ?>" id="tab-4">
                <p class="mb-n1 color-highlight font-600 font-12">Manage Wallet</p>
                <div id="tonconn-div" class="tonconnectdiv" style="display: none;">
                    <div id="ton-connect"></div>
                </div>
                <form id="add-walletform" method="post">
                    <!-- <iframe src="../../assets/images/chains/ton_logo_light_background.png" alt="Ton" class="input-image" id="ton-logo-add" style="display: block;"> </iframe> -->
                    <!-- <div id="wallet-info" style="display: none;"></div> -->
                    <div class="input-style list-group list-custom-small has-icon" id="walletinfo-div" style="display: none;">
                        <input type="text" class="form-control" name="walletaddress" id="wallet-add" readonly
                            value="<?php echo $data->sTonaddress ?>" changestatus="0" saved-address="<?php echo $data->sTonaddress ?>" address-status="<?php echo $data->tonaddstatus; ?>" />
                        <em style="right: -42px !important; margin-top: -34px !important;  opacity: 1 !important;">
                            <iframe src="../../assets/images/icons/check.png" alt="Saved" class="input-image" id="saved-add" style="display: block;"></iframe>
                            <iframe src="../../assets/images/icons/caution.png" alt="Unsaved" class="input-image" id="unsaved-add" style="display: none;"></iframe>
                        </em>
                        <div class="list-group list-custom-small">
                            <a style="background-color: #0000; margin-top: 10px; padding: 0; border: 0px; border-radius: 0px;">
                                <button class="btn btn-success btn-sm"
                                    onclick='copyToClipboard("<?php echo $data->sTonaddress ?>")'>Copy
                                    Address</button>
                                <div style="width: 10px; height: 2px;"> </div>
                                <button class="btn btn-danger btn-sm " id="change-wallet">Change Wallet</button>
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="input-style has-borders no-icon input-style-always-active  mb-4" style="display: none;">
                        <select id="blockchainselect" disabled>
                            <option value="" disabled>Select Chain To Use</option>
                            <option value="ton" selected> <b> Ton Blockchain </b> </option>
                            <option value="other">Other Chains</option>
                        </select><label for="blockchainselect" class="color-highlight">Select Chain To Use</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style has-borders no-icon input-style-always-active mb-4" id="transpin-div"
                        style="display: none;">

                        <input type="number" class="form-control" id="trans-pin" name="accpin" placeholder="Pin"
                            required>
                        <label for="trans-pin" class="color-highlight">Transaction Pin</label>
                        <em>(required)</em>
                        <h8 style="color:red;">Note: Default Pin is '1234' Click Pin Tab to change Pin</h8>
                    </div>
                    <button type="submit" id="add-wallet-btn" style="width: 100%; display: none;"
                        class="the-form-btn btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-sm">
                        <b>Add Wallet</b>
                    </button>

                    <button type="submit" id="update-wallet-btn" style="width: 100%; display: none;"
                        class="the-form-btn btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-sm">
                        <b>Update Wallet</b>
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>