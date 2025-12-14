<!-- TON Connect JS CODE START --->
<script>
    function trythis() {
        var myid = 10;
        $.ajax({
            url: 'home/includes/route.php?uid',
            data: {
                uid: myid
            },
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                console.log(resp);
                if (resp == 1) {
                    alert(resp);
                } else {
                    alert(resp);
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error:', error);
            }
        });
    }
    $("document").ready(function() {
        const tg = window.Telegram.WebApp;
        tg.expand(); // Expands the mini app to full height
        console.log(tg.initDataUnsafe.user); // Access user info

        purchase_pages = ["buy-airtime", "buy-data", "buy-cable", "buy-exam-pin", "buy-recharge-pin"];
        if (document.getElementById("resendText")) {
            resendmaill();
        }
        if (document.getElementById("walletdatainfo")) {
            let savedwallet = document.getElementById("walletdatainfo").getAttribute("address-status");
            if (savedwallet !== "1") {
                swal("Oops!", "Riderecting To Profile and Add Web3 Wallet.", "info");
                // tonConnectUI.disconnect();
                setTimeout(() => {
                    window.location.href = "profile?set-wallet";
                }, 3000);
            }
        }
        if (document.getElementById("walletdatainfo"))
            $("#ton-connect").click(function() {
                // $("#airtimeForm").submit(function(e) {
                //     e.preventDefault();
                // });
                // $('[type]').attr("disabled", "");
                $('[required]').attr("required-removed", "");
                $('[required]').prop("required", false);

                setTimeout(() => {
                    // Re-enable validation
                    // $('[type]').removeAttr("disabled", "");
                    $('[required-removed]').attr("required", "");
                    $('[required-removed]').removeAttr("required-removed");
                }, 500);
                return;
            });
        checkwalletbalance();
        // checkwalletstatus();
        //Dispaly Home Notification
        <?php echo $homemsg; ?>

        $("#thetranspin").val(null);

        $("#hideEye").click(function() {
            $("#hideEyeDiv").show();
            $("#openEyeDiv").hide();
            $("#openEye").show();
            $("#hideEye").hide();
        });

        $("#openEye").click(function() {
            $("#openEyeDiv").show();
            $("#hideEyeDiv").hide();
            $("#hideEye").show();
            $("#openEye").hide();
        });

        $(".the-submit-form").submit(function() {
            $('.the-form-btn').removeClass("gradient-highlight");
            $('.the-form-btn').addClass("btn-secondary");
            $('.the-form-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        //Update Profile Password
        $("#passForm").submit(function(e) {
            e.preventDefault();

            if ($("#new-pass").val() != $("#retype-pass").val()) {
                swal("Error!", "New Password & Retype Password Don't Match.", "error");
                return 0;
            }

            $('#update-pass-btn').removeClass("gradient-highlight");
            $('#update-pass-btn').addClass("btn-secondary");
            $('#update-pass-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');


            $.ajax({
                url: 'home/includes/route.php?update-pass',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        swal('Alert!!', "Password Updated Successfully.", "success");
                        $("#old-pass").val("");
                        $("#new-pass").val("");
                        $("#retype-pass").val("");
                    } else if (resp == 1) {
                        swal('Alert!!', "Old Password Is Incorrect.", "error");
                        $("#old-pass").val("");
                        $("#new-pass").val("");
                        $("#retype-pass").val("");
                    } else {
                        swal('Alert!!', "Unknow Error, Please Contact Our Customer Support", "error");
                    }

                    $('#update-pass-btn').removeClass("btn-secondary");
                    $('#update-pass-btn').addClass("gradient-highlight");
                    $('#update-pass-btn').html("Update Password");

                },
                error: function(xhr, status, error) {
                    swal('Alert!!', "Request Not Send", "error");
                    console.error(error);
                }
            });

        });

        //Update Transaction Pin
        $("#pinForm").submit(function(e) {
            e.preventDefault();

            if ($("#new-pin").val() != $("#retype-pin").val()) {
                swal("Error!", "New Pin & Retype Pin Don't Match.", "error");
                return 0;
            }

            if ($("#old-pin").val().length !== 4) {
                $(this).val(null);
                swal("Opps!!", "Pin Length Should Be Four Digits.", "info");
                return;
            }
            if ($("#new-pin").val().length !== 4) {
                $(this).val(null);
                swal("Opps!!", "Pin Length Should Be Four Digits.", "info");
                return;
            }
            if ($("#retype-pin").val().length !== 4) {
                $(this).val(null);
                swal("Opps!!", "Pin Length Should Be Four Digits.", "info");
                return;
            }

            $('#update-pin-btn').removeClass("gradient-highlight");
            $('#update-pin-btn').addClass("btn-secondary");
            $('#update-pin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');


            $.ajax({
                url: 'home/includes/route.php?update-pin',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        swal('Alert!!', "Pin Updated Successfully.", "success");
                        $("#old-pin").val("");
                        $("#new-pin").val("");
                        $("#retype-pin").val("");
                    } else if (resp == 1) {
                        swal('Alert!!', "Old Pin Is Incorrect.", "error");
                        $("#old-pin").val("");
                        $("#new-pin").val("");
                        $("#retype-pin").val("");
                    } else {
                        swal('Alert!!', "Unknow Error, Please Contact Our Customer Support", "error");
                    }

                    $('#update-pin-btn').removeClass("btn-secondary");
                    $('#update-pin-btn').addClass("gradient-highlight");
                    $('#update-pin-btn').html("Update Pin");

                }
            });

        });


        // Update Profile Information
        $("#profileForm").submit(function(e) {
            e.preventDefault();

            if ($("#fname").val() == "" || $("#fname").val() == null) {
                swal("Opps!!", "There Most Be A First name.", "info");
                return 0;
            }

            if ($("#lname").val() == "" || $("#lname").val() == null) {
                swal("Opps!!", "There Most Be A Last name.", "info");
                return 0;
            }

            $('#update-info-btn').removeClass("gradient-highlight");
            $('#update-info-btn').addClass("btn-secondary");
            $('#update-info-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');


            $.ajax({
                url: 'home/includes/route.php?update-profile-info',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        swal('Alert!!', "Profile Information Updated Successfully. You Are Now In Level 2", "success");
                        $("#login-pass").val("");
                        setTimeout(function() {
                            location.reload();
                        }, 1000)
                    } else if (resp == 22) {
                        swal('Alert!!', "Profile Name Updated Successfully.", "success");
                        setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else if (resp == 1) {
                        swal('Alert!!', "Phone number required.", "error");
                    } else if (resp == 2) {
                        swal('Alert!!', "State required.", "error");
                    } else if (resp == 3) {
                        swal('Alert!!', "Full name required.", "error");
                    } else if (resp == 4) {
                        swal('Alert!!', "Password required when updating missing fields.", "error");
                    } else if (resp == 6) {
                        swal('Alert!!', "Password Is incorrect.", "error");
                        $("#login-pass").val("");
                    } else {
                        swal('Alert!!', "Unknow Error, Please Contact Our Customer Support", "error");
                    }
                    $('#update-info-btn').removeClass("btn-secondary");
                    $('#update-info-btn').addClass("gradient-highlight");
                    $('#update-info-btn').html(" Update Information");

                }
            });

        });


        // ADD Wallet Wallet in Profile
        $("#add-walletform").submit(function(e) {
            e.preventDefault();
            if ($("#wallet-add").val() == "" || $("#wallet-add").val() == null) {
                swal("Error!", "Please Connect The Wallet.", "error");
                return;
            }
            if ($("#blockchainselect").val() == "" || $("#blockchainselect").val() == null) {
                swal("Error!", "Select Chain To Use.", "error");
                return;
            }

            let walletsatus = document.getElementById("wallet-add").getAttribute("address-status");

            if (walletsatus === "0") {
                $('#add-wallet-btn').removeClass("gradient-highlight");
                $('#add-wallet-btn').addClass("btn-secondary");
                $('#add-wallet-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Adding ...');
            } else {
                $('#update-wallet-btn').removeClass("gradient-highlight");
                $('#update-wallet-btn').addClass("btn-secondary");
                $('#update-wallet-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');
            }

            // if()

            $.ajax({
                url: 'home/includes/route.php?add-wallet',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        if (walletsatus === "0") {
                            swal('Alert!!', "Wallet Added Successfully.", "success");
                        } else {
                            swal('Alert!!', "Wallet Updated Successfully.", "success");
                        }
                        $("#trans-pin").val("");
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else if (resp == 1) {
                        swal('Alert!!', "Pin Is Incorrect.", "error");
                        $("#trans-pin").val("");
                    } else if (resp == 2) {
                        swal('Alert!!', "Wallet Exist For Another User", "error");
                        $("#trans-pin").val("");
                    } else if (resp == 3) {
                        swal('Alert!!', "No Changes Made.", "info");
                        $("#trans-pin").val("");
                    } else {
                        swal('Alert!!', "Unknow Error, Please Contact Our Customer Support", "error");
                        $("#trans-pin").val("");
                    }
                    if (walletsatus === "0") {
                        $('#add-wallet-btn').removeClass("btn-secondary");
                        $('#add-wallet-btn').addClass("gradient-highlight");
                        $('#add-wallet-btn').html("Add Wallet");
                    } else {
                        $('#update-wallet-btn').removeClass("btn-secondary");
                        $('#update-wallet-btn').addClass("gradient-highlight");
                        $('#update-wallet-btn').html("Update Wallet");
                    }

                }
            });

        });

        $("#old-pin").on("keyup", function() {
            if (isNaN($(this).val())) {
                $(this).val(null);
                swal("Opps!!", "Please Enter A Numeric Value.", "info");
            }
        });

        $("#new-pin").on("keyup", function() {
            if (isNaN($(this).val())) {
                $(this).val(null);
                swal("Opps!!", "Please Enter A Numeric Value.", "info");
            }
        });

        $("#retype-pin").on("keyup", function() {
            if (isNaN($(this).val())) {
                $(this).val(null);
                swal("Opps!!", "Please Enter A Numeric Value.", "info");
            }
        });


        // ----------------------------------------------------------------------------
        // Airtime Management
        // ----------------------------------------------------------------------------

        $("#transpinbtn").click(function(e) {
            let actionbtn = $(this).attr("action-btn");
            $("#transkey").val($("#thetranspin").val());
            $("#" + actionbtn).click();
            e.preventDefault();
        });

        $("#networktype").on("change", function() {
            $("#airtimeamount").val(null);
            $("#amounttopay").val(null);
            $("#discount").val(null);
        });

        $("#airtimeamount").on("keyup", function() {
            var airtimediscount = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
            if (!airtimediscount == "") {
                airtimediscount = JSON.parse(airtimediscount);
            }
            var amounttopay = 0;
            var discount = 0;
            var useraccount = getCookie("loginAccount");
            useraccount = useraccount.replace(/%3D/g, "=");
            useraccount = atob(useraccount);
            useraccount = parseInt(useraccount);
            let countdownInterval; // Store the interval ID globally
            var amount = $("#airtimeamount").val();
            amount = parseInt(amount);

            if ($("#networkid").val() == "" || $("#networkid").val() == null) {
                swal("Opps!!", "Please Select A Network First.", "info");
                $("#airtimeamount").val(null);
                return 0;
            }
            // Check if the Airtime is lessthan 100 Naira
            if (amount < 100 || amount == null || amount == "" || amount == 0) {
                document.getElementById("amounttopayinton").innerHTML = "0.00 Native";
                document.getElementById("amountwarning").removeAttribute("class");
                document.getElementById("amountwarning").style.display = "block";
                document.getElementById("airtime-btn").disabled = true;
                document.getElementById("airtime-btn").setAttribute("type", "submit");
                document.getElementById("airtime-btn").setAttribute("name", "purchase-airtime");
                document.getElementById("airtime-btn").style.display = "block";
                document.getElementById("fetch-price").style.display = "none";
                $('#airtime-btn').removeClass("btn-secondary");
                $('#airtime-btn').addClass("gradient-highlight");
                $('#airtime-btn').html('Buy Airtime');
                // Remove the added attributes for fetching price
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "false") {
                    document.getElementById("amountwarning").setAttribute("countdown", "false");
                }
                document.getElementById("countdown").textContent = 0;
                $("#amounttopay").val(null);
                $("#discount").val(null);

                if (countdownInterval !== null) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                return;
            } else if (amount >= 100) {
                // If the Airtime Amount to buy is upto 100 Naira 
                document.getElementById("amountwarning").style.display = "none";
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "true") {
                    document.getElementById("amountwarning").setAttribute("countdown", "true");
                }
                // Prevent multiple intervals from running
                document.getElementById("airtime-btn").disabled = true;
                document.getElementById("airtime-btn").removeAttribute("type");
                document.getElementById("airtime-btn").removeAttribute("name");
                document.getElementById("airtime-btn").style.display = "none";
                document.getElementById("fetch-price").style.display = "block";
                document.getElementById("fetch-price").removeAttribute("hidden");

                for (i = 0; i < airtimediscount.length; i++) {
                    if (airtimediscount[i].aNetwork == $("#networkid").val() && airtimediscount[i].aType == $("#networktype").val()) {
                        if (useraccount == 3 || useraccount == '3') {
                            discount = airtimediscount[i].aVendorDiscount;
                        } else if (useraccount == 2 || useraccount == '2') {
                            discount = airtimediscount[i].aAgentDiscount;
                        } else {
                            discount = airtimediscount[i].aUserDiscount;
                        }
                        discount = parseInt(discount);
                        amounttopay = (amount * discount) / 100;
                        discount = 100 - discount;
                    }
                }

                $("#amounttopay").val(amounttopay);
                $("#discount").val(discount + "%");
            } else {
                document.getElementById("amounttopayinton").innerHTML = "0.00 Native";
                document.getElementById("amountwarning").removeAttribute("class");
                document.getElementById("amountwarning").style.display = "block";
                document.getElementById("airtime-btn").disabled = true;
                document.getElementById("airtime-btn").setAttribute("type", "submit");
                document.getElementById("airtime-btn").setAttribute("name", "purchase-airtime");
                document.getElementById("airtime-btn").style.display = "block";
                document.getElementById("fetch-price").style.display = "none";
                $('#airtime-btn').removeClass("btn-secondary");
                $('#airtime-btn').addClass("gradient-highlight");
                $('#airtime-btn').html('Buy Airtime');
                // Remove the added attributes for fetching price
                $('#airtime-btn').removeClass("btn-secondary");
                $('#airtime-btn').addClass("gradient-highlight");
                $('#airtime-btn').html('Buy Airtime');
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "false") {
                    document.getElementById("amountwarning").setAttribute("countdown", "false");
                }
                document.getElementById("countdown").textContent = 0;
                $("#amounttopay").val(null);
                $("#discount").val(null);

                if (countdownInterval !== null) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                return;
            }
        });


        //Purchase Airtime Using TON
        $("#airtimeForm").submit(function(e) {

            if ($("#walletdatainfo").attr("connection") == "1") {
                if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                    e.preventDefault();
                    $("#transpinbtn").attr("action-btn", "airtime-btn");

                    let msg = "You are about to purchase an ";
                    msg += $('#networkid').find(":selected").attr('networkname') + " airtime of ";
                    msg += $("#airtimeamount").val() + "N @ " + "<b>" + $("#amounttopay").attr("nativepay") + " Native" + "</b>" + " for the phone number " + $("#phone").val();
                    msg += " <br/> Do you wish to continue?"

                    $("#continue-transaction-prompt-msg").html(msg);
                    $("#continue-transaction-prompt-btn").click();

                    return;
                }

                $('#airtime-btn').removeClass("gradient-highlight");
                $('#airtime-btn').addClass("btn-secondary");
                $('#airtime-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            } else {
                e.preventDefault();
                return;
            }
        });

        // ----------------------------------------------------------------------------
        // Cable Plan Management
        // ----------------------------------------------------------------------------

        //If provider selected, get plans
        $("#cableid").on("change", function() {
            if ($("#cableid").val() == '' || $("#cableid").val() == null) {
                swal("Opps!!", "Please Select A Provider First.", "info");
            } else {
                let provider = $("#cableid").val();
                let useraccount = getCookie("loginAccount");
                let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                let options = "<option value=''>Select Plan</option>";
                let price = 0;

                useraccount = useraccount.replace(/%3D/g, "=");
                useraccount = atob(useraccount);
                useraccount = parseInt(useraccount);

                if (!plans == "") {

                    plans = JSON.parse(plans);

                    for (i = 0; i < plans.length; i++) {

                        if (useraccount == 3 || useraccount == '3') {
                            price = plans[i].vendorprice;
                        } else if (useraccount == 2 || useraccount == '2') {
                            price = plans[i].agentprice;
                        } else {
                            price = plans[i].userprice;
                        }

                        if (plans[i].cableprovider == provider) {
                            options += "<option value='" + plans[i].cpId + "' cableprice='" + price + "' planname='" + plans[i].name + " (N" + plans[i].price + ")(" + plans[i].day + " Days) '>" + plans[i].name + " (N" + plans[i].price + ")(" + plans[i].day + " Days) </option>";
                        }

                    }

                }

                $("#cableplan").html(options);
                $("#amounttopay").val(null);

            }
        });

        //If Cable Plan Is Selected, Get And Set The Price
        $("#cableplan").on("change", function() {
            $("#amounttopay").val("N" + $('#cableplan').find(":selected").attr('cableprice'));
            $("#cabledetails").val($('#cableplan').find(":selected").attr('planname'));
        });

        //Verify cableplan
        $("#verifycableplanForm").submit(function(e) {

            $('#cable-btn').removeClass("gradient-highlight");
            $('#cable-btn').addClass("btn-secondary");
            $('#cable-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        //Purchase Cable Plan
        $("#cableplanForm").submit(function(e) {


            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "cable-btn");

                let msg = "You are about to purchase ";
                let cableplan = $('#cabledetails').val();
                msg += '"' + cableplan + " for the IUC Number " + '"' + $("#iucnumber").val() + '"';
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#cable-btn').removeClass("gradient-highlight");
            $('#cable-btn').addClass("btn-secondary");
            $('#cable-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        // ----------------------------------------------------------------------------
        // Recharge Card Pin Management
        // ----------------------------------------------------------------------------
        $("#rechargepinamount").on("keyup", function() {
            $("#amounttopay").val(null);
            $("#norechargepin").val(null);
        });

        $("#norechargepin").on("keyup", function() {

            if ($("#rechargepinamount").val() != null || $("#norechargepin").val() != null) {
                var airtimediscount = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                if (!airtimediscount == "") {
                    airtimediscount = JSON.parse(airtimediscount);
                }
                var amounttopay = 0;
                var discount = 0;
                var useraccount = getCookie("loginAccount");
                useraccount = useraccount.replace(/%3D/g, "=");
                useraccount = atob(useraccount);
                useraccount = parseInt(useraccount);

                var amount = $("#rechargepinamount").val();
                let quantity = parseInt($("#norechargepin").val());

                amount = parseInt(amount);
                quantity = parseInt(quantity);

                if ($("#networkid").val() == "" || $("#networkid").val() == null) {
                    swal("Opps!!", "Please Select A Network First.", "info");
                    $("#rechargepinamount").val(null);
                    return 0;
                }

                for (i = 0; i < airtimediscount.length; i++) {
                    if (airtimediscount[i].aNetwork == $("#networkid").val()) {
                        if (useraccount == 3 || useraccount == '3') {
                            discount = airtimediscount[i].aVendorDiscount;
                        } else if (useraccount == 2 || useraccount == '2') {
                            discount = airtimediscount[i].aAgentDiscount;
                        } else {
                            discount = airtimediscount[i].aUserDiscount;
                        }
                        discount = parseInt(discount);
                        if (!(quantity > 0)) {
                            quantity = 0;
                        }
                        if (!(amount > 0)) {
                            amount = 0;
                        }
                        amounttopay = amount * quantity;
                        amounttopay = (amounttopay * discount) / 100;
                        discount = 100 - discount;
                    }
                }

                $("#amounttopay").val(amounttopay);
                $("#discount").val(discount + "%");
            } else {
                $("#amounttopay").val("0");
            }
        });

        //Purchase Exam Pin
        $("#rechargepinForm").submit(function(e) {

            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "rechargepin-btn");

                let msg = "You are about to purchase ";
                msg += $("#norechargepin").val() + ' unit of N' + $("#rechargepinamount").val() + ' ';
                msg += $('#networkid').find(":selected").attr('networkname') + " recharge card pin at the price of N" + $("#amounttopay").val() + " with the business name " + $("#businessname").val();
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#rechargepin-btn').removeClass("gradient-highlight");
            $('#rechargepin-btn').addClass("btn-secondary");
            $('#rechargepin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        // ----------------------------------------------------------------------------
        // Exam Pin Management
        // ----------------------------------------------------------------------------

        $("#examid").on("change", function() {
            $("#amounttopay").val(null);
            $("#examquantity").val(null);
        });

        $("#examquantity").on("keyup", function() {

            if ($("#examid").val() != null || $("#examquantity").val() != null) {
                let price = parseInt($('#examid').find(":selected").attr('providerprice'));
                let quantity = parseInt($("#examquantity").val());
                let amount = 0;

                if (!(quantity > 0)) {
                    quantity = 0;
                }
                if (!(price > 0)) {
                    price = 0;
                }

                amount = price * quantity;

                $("#amounttopay").val("N" + amount);
            } else {
                $("#amounttopay").val("0");
            }

        });

        //Purchase Exam Pin
        $("#exampinForm").submit(function(e) {

            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "exampin-btn");

                let msg = "You are about to purchase ";
                let exampindetails = $('#examid').find(":selected").attr('providername');
                msg += $("#examquantity").val() + ' token of  ' + exampindetails + ' ';
                msg += " pin at the price of " + $("#amounttopay").val();
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#exampin-btn').removeClass("gradient-highlight");
            $('#exampin-btn').addClass("btn-secondary");
            $('#exampin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });


        // ----------------------------------------------------------------------------
        // Electricity Management
        // ----------------------------------------------------------------------------

        //If Amount Input, Get And Set The Price
        $("#meteramount").on("keyup", function() {
            let amount = parseInt($('#meteramount').val());
            let electricitycharges = parseInt($('#electricitycharges').text());
            let amounttopay = amount + electricitycharges;
            $("#amounttopay").val("N" + amounttopay);
            $("#electricitydetails").val($('#electricityid').find(":selected").attr('providername'));
        });

        $("#verifyelectricityplanForm").submit(function(e) {
            let amount = parseInt($('#meteramount').val());

            if (amount < 1000) {
                e.preventDefault();
                swal("Alert!!", "Minimum Unit Purchase Is N1000.", "error");
                return null;
            }

            $('#electricity-btn').removeClass("gradient-highlight");
            $('#electricity-btn').addClass("btn-secondary");
            $('#electricity-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        //Purchase Electricity Plan
        $("#electricityForm").submit(function(e) {


            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "electricity-btn");

                let msg = "You are about to purchase ";
                let electricitydetails = $('#electricitydetails').val();
                msg += '"' + electricitydetails + " (" + $("#metertype").val() + ") for the Meter Number " + '"' + $("#meternumber").val() + '"';
                msg += " at the price of " + $("#amounttopay").val();
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#electricity-btn').removeClass("gradient-highlight");
            $('#electricity-btn').addClass("btn-secondary");
            $('#electricity-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        // ----------------------------------------------------------------------------
        // Data Plan Management
        // ----------------------------------------------------------------------------

        //If  notwork selected, empty data type, plan, amount
        $("#networkid").on("change", function() {
            $("#datagroup").val(null);
            $("#dataplan").val(null);
            $("#amounttopay").val(null);

            let sme = $('#networkid').find(":selected").attr('sme');
            let gifting = $('#networkid').find(":selected").attr('gifting');
            let corporate = $('#networkid').find(":selected").attr('corporate');
            let vtu = $('#networkid').find(":selected").attr('vtu');
            let sharesell = $('#networkid').find(":selected").attr('sharesell');
            let networkname = $('#networkid').find(":selected").attr('networkname');
            let thegroup = '<option value="">Select Type</option>';

            //Check If Network Is Disabled
            if ($("#networkid").val() == "allnetwork") {
                thegroup += '<option value="smecg">SME/CG</option>';
            }

            if (sme == "On") {
                thegroup += '<option value="SME">SME</option>';
            }

            //Check If Network Is Disabled
            if (gifting == "On") {
                thegroup += '<option value="Gifting">Gifting</option>';
            }

            //Check If Network Is Disabled
            if (corporate == "On") {
                thegroup += '<option value="Corporate">Corporate</option>';
            }

            //Check If Network Is Disabled
            if (vtu == "On") {
                thegroup += '<option value="VTU">VTU</option>';
            }

            //Check If Network Is Disabled
            if (sharesell == "On") {
                thegroup += '<option value="Share And Sell">Share And Sell</option>';
            }
            $("#datagroup").html(thegroup);
            $("#networktype").html(thegroup);
        });

        //If data type selected, get plans
        $("#datagroup").on("change", function() {
            if ($("#networkid").val() == '' || $("#networkid").val() == null) {
                $("#datagroup").val(null);
                swal("Opps!!", "Please Select A Network First.", "info");
            } else {
                let network = $("#networkid").val();
                let datagroup = $("#datagroup").val();
                let useraccount = getCookie("loginAccount");
                let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                let options = "<option value=''>Select Plan</option>";
                let price = 0;
                let networkname = $('#networkid').find(":selected").attr('networkname');


                useraccount = useraccount.replace(/%3D/g, "=");
                useraccount = atob(useraccount);
                useraccount = parseInt(useraccount);

                if (!plans == "") {

                    plans = JSON.parse(plans);

                    for (i = 0; i < plans.length; i++) {

                        if (useraccount == 3 || useraccount == '3') {
                            price = plans[i].vendorprice;
                        } else if (useraccount == 2 || useraccount == '2') {
                            price = plans[i].agentprice;
                        } else {
                            price = plans[i].userprice;
                        }

                        if (plans[i].datanetwork == network && plans[i].type == datagroup) {
                            options += "<option value='" + plans[i].pId + "' dataprice='" + price + "' dataname='" + plans[i].name + " " + plans[i].type + " (N" + price + ")(" + plans[i].day + " Days) '>" + plans[i].name + " " + plans[i].type + " (N" + price + ")(" + plans[i].day + " Days)</option>";
                        }

                    }

                }

                $("#dataplan").html(options);
                $("#amounttopay").val(null);

            }
        });

        //If Data Plan Is Selected, Get And Set The Price
        $("#dataplan").on("change", function() {
            $("#amounttopay").val($('#dataplan').find(":selected").attr('dataprice'));

            if ($("#amounttopay").val() <= 0 || $("#amounttopay").val() == null) {
                $("#amounttopay").val("0");
                document.getElementById("amounttopayinton").innerHTML = "0.00 Native";
                document.getElementById("amountwarning").removeAttribute("class");
                document.getElementById("amountwarning").style.display = "block";
                document.getElementById("data-btn").disabled = true;
                document.getElementById("data-btn").setAttribute("type", "submit");
                document.getElementById("data-btn").setAttribute("name", "purchase-airtime");
                document.getElementById("data-btn").style.display = "block";
                document.getElementById("fetch-price").style.display = "none";
                $('#data-btn').removeClass("btn-secondary");
                $('#data-btn').addClass("gradient-highlight");
                $('#data-btn').html('Buy Data');
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "false") {
                    document.getElementById("amountwarning").setAttribute("countdown", "false");
                }
                if (countdownInterval !== null) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                return;
            } else if ($("#amounttopay").val() > 0) {
                // If the DAta Amount to buy is upto 100 Naira 
                document.getElementById("amountwarning").style.display = "none";
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "true") {
                    document.getElementById("amountwarning").setAttribute("countdown", "true");
                }
                // Prevent multiple intervals from running
                document.getElementById("data-btn").disabled = true;
                document.getElementById("data-btn").removeAttribute("type");
                document.getElementById("data-btn").removeAttribute("name");
                document.getElementById("data-btn").style.display = "none";
                document.getElementById("fetch-price").style.display = "block";
                document.getElementById("fetch-price").removeAttribute("hidden");
            } else {
                document.getElementById("amounttopayinton").innerHTML = "0.00 $TON";
                document.getElementById("amountwarning").removeAttribute("class");
                document.getElementById("amountwarning").style.display = "block";
                document.getElementById("data-btn").disabled = true;
                document.getElementById("data-btn").setAttribute("type", "submit");
                document.getElementById("data-btn").setAttribute("name", "purchase-airtime");
                document.getElementById("data-btn").style.display = "block";
                document.getElementById("fetch-price").style.display = "none";
                $('#data-btn').removeClass("btn-secondary");
                $('#data-btn').addClass("gradient-highlight");
                $('#data-btn').html('Buy Data');
                if (document.getElementById("amountwarning").getAttribute("countdown") !== "false") {
                    document.getElementById("amountwarning").setAttribute("countdown", "false");
                }
                if (countdownInterval !== null) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                return;
            }
        });

        //Purchase Data
        $("#dataplanForm").submit(function(e) {

            if ($("#walletdatainfo").attr("connection") == "1") {
                if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                    e.preventDefault();
                    $("#transpinbtn").attr("action-btn", "data-btn");

                    let msg = "You are about to purchase an ";
                    let dataplan = $('#dataplan').find(":selected").attr('dataname');
                    msg += $('#networkid').find(":selected").attr('networkname') + " dataplan of ";
                    msg += $("#amounttopay").val() + "N @ " + "<b>" + $("#amounttopay").attr("nativepay") + " Native" + "</b>" + " for the phone number " + $("#phone").val();
                    msg += " <br/> Do you wish to continue?"

                    $("#continue-transaction-prompt-msg").html(msg);
                    $("#continue-transaction-prompt-btn").click();

                    return;
                }

                $('#data-btn').removeClass("gradient-highlight");
                $('#data-btn').addClass("btn-secondary");
                $('#data-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            } else {
                e.preventDefault();
                return;
            }

        });
        // Post Job Form
        $("#postjobForm").submit(function(e) {
            // let jtype = "";
            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "job-btn");
                var jtype = "";
                var ljtype = "";
                var cjtype = "";
                var sjtype = "";
                var vjtype = "";
                var subsjtype = "";
                var fjtype = "";

                function checkck() {
                    if ($("#likeck").is(":checked")) {
                        ljtype = "Like";
                        lprice = 2;
                    }
                    if ($("#followck").is(":checked")) {
                        fjtype = " Follow,";
                        fprice = 2;

                    }
                    if ($("#commentck").is(":checked")) {
                        cjtype = " Comment,";
                        cprice = 2;

                    }
                    if ($("#viewck").is(":checked")) {
                        vjtype = " View,";
                        vprice = 1;

                    }
                    if ($("#subsck").is(":checked")) {
                        subsjtype = " Subscribe,";
                        subsprice = 5;

                    }
                    if ($("#shareck").is(":checked")) {
                        sjtype = " Share,";
                        sprice = 5;

                    }
                    if (!$("#likeck").is(":checked") &&
                        !$("#followck").is(":checked") &&
                        !$("#commentck").is(":checked") &&
                        !$("#viewck").is(":checked") &&
                        !$("#subsck").is(":checked") &&
                        !$("#shareck").is(":checked")) {
                        // alert("")
                        swal("Opps!!", "Please Select Media Type First.", "info");

                        mediaplan = "0";
                        jtype = "Unknown"
                    }
                }
                checkck();
                // $("#amounttopay").val() =10;
                jtype = ljtype + fjtype + cjtype + vjtype + subsjtype + sjtype;
                let msg = "You are about to purchase ";
                let mediaplan = $('#Jobnumbers').find(":selected").val();
                msg += '<b>' + mediaplan + '</b> ' + jtype + " plan of ₦";
                msg += '<b>' + $("#amounttopay").val() + '</b>' + " for the Social Media " + '<b>' + $("#Smedia").val() + '</b>';
                msg += " Link " + '<i>' + $("#jlink").val() + '</i>';
                msg += " <br/> Do you wish to continue?"
                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();
                swal("Alert!!", "Are You Sure The Job link is Correct. To Check Click No and verify Before tranction Confirmation", "error");
                return;
            }

            $('#job-btn').removeClass("gradient-highlight");
            $('#job-btn').addClass("btn-secondary");
            $('#job-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });


        // Create Giveaway Form
        $("#creategiveawayForm").submit(function(e) {
            // let jtype = "";
            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "job-btn");
                var jtype = "";
                var ljtype = "";
                var cjtype = "";
                var sjtype = "";
                var vjtype = "";
                var subsjtype = "";
                var fjtype = "";

                function checkck() {
                    if ($("#likeck").is(":checked")) {
                        ljtype = "Like";
                        lprice = 2;
                    }
                    if ($("#followck").is(":checked")) {
                        fjtype = " Follow,";
                        fprice = 2;

                    }
                    if ($("#commentck").is(":checked")) {
                        cjtype = " Comment,";
                        cprice = 2;

                    }
                    if ($("#viewck").is(":checked")) {
                        vjtype = " View,";
                        vprice = 1;

                    }
                    if ($("#subsck").is(":checked")) {
                        subsjtype = " Subscribe,";
                        subsprice = 5;

                    }
                    if ($("#shareck").is(":checked")) {
                        sjtype = " Share,";
                        sprice = 5;

                    }
                    if (!$("#likeck").is(":checked") &&
                        !$("#followck").is(":checked") &&
                        !$("#commentck").is(":checked") &&
                        !$("#viewck").is(":checked") &&
                        !$("#subsck").is(":checked") &&
                        !$("#shareck").is(":checked")) {
                        // alert("")
                        swal("Opps!!", "Please Select Media Type First.", "info");

                        mediaplan = "0";
                        jtype = "Unknown"
                    }
                }
                checkck();
                // $("#amounttopay").val() =10;
                jtype = ljtype + fjtype + cjtype + vjtype + subsjtype + sjtype;
                let msg = "You are about to purchase ";
                let mediaplan = $('#Jobnumbers').find(":selected").val();
                msg += '<b>' + mediaplan + '</b> ' + jtype + " plan of ₦";
                msg += '<b>' + $("#amounttopay").val() + '</b>' + " for the Social Media " + '<b>' + $("#Smedia").val() + '</b>';
                msg += " Link " + '<i>' + $("#jlink").val() + '</i>';
                msg += " <br/> Do you wish to continue?"
                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();
                swal("Alert!!", "Are You Sure The Job link is Correct. To Check Click No and verify Before tranction Confirmation", "error");
                return;
            }

            $('#job-btn').removeClass("gradient-highlight");
            $('#job-btn').addClass("btn-secondary");
            $('#job-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });



        // ----------------------------------------------------------------------------
        // Data Pin
        // ----------------------------------------------------------------------------

        //If data type selected, get plans
        $("#datapingroup").on("change", function() {

            if ($("#datanetworkid").val() == '' || $("#datanetworkid").val() == null) {
                swal("Opps!!", "Please Select A Network First.", "info");
                return 0;
            }

            let network = $("#datanetworkid").val();
            let datagroup = $("#datapingroup").val();
            let useraccount = getCookie("loginAccount");
            let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
            let options = "<option value=''>Select Plan</option>";
            let price = 0;
            let networkname = $('#datanetworkid').find(":selected").attr('networkname');


            useraccount = useraccount.replace(/%3D/g, "=");
            useraccount = atob(useraccount);
            useraccount = parseInt(useraccount);

            if (!plans == "") {

                plans = JSON.parse(plans);

                for (i = 0; i < plans.length; i++) {

                    if (useraccount == 3 || useraccount == '3') {
                        price = plans[i].vendorprice;
                    } else if (useraccount == 2 || useraccount == '2') {
                        price = plans[i].agentprice;
                    } else {
                        price = plans[i].userprice;
                    }

                    if (plans[i].datanetwork == network && plans[i].type == datagroup) {
                        options += "<option value='" + plans[i].dpId + "' dataprice='" + price + "' dataname='" + plans[i].name + " " + plans[i].type + " (N" + price + ")(" + plans[i].day + " Days) '>" + plans[i].name + " " + plans[i].type + " (N" + price + ")(" + plans[i].day + " Days)</option>";
                    }

                }

            }

            $("#datapinplan").html(options);
            $("#amount").val(null);
            $("#amounttopay").val(null);


        });

        //If Data Plan Is Selected, Get And Set The Price
        $("#datapinplan").on("change", function() {
            $("#amount").val($('#datapinplan').find(":selected").attr('dataprice'));
        });

        $("#datapinquantity").on("change", function() {

            if ($("#datanetworkid").val() == '' || $("#datanetworkid").val() == null) {
                swal("Opps!!", "Please Select A Network First.", "info");
            } else {
                let price = parseInt($("#amount").val());
                let quantity = parseInt($("#datapinquantity").val());
                let amounttopay = 0;
                if (quantity > 0) {
                    amounttopay = price * quantity;
                } else {
                    swal("Alert!!", "Please Enter A Valid Quantity", "error");
                }
                $("#amounttopay").val("N" + amounttopay);
            }

        });

        //Purchase Data Pin
        $("#datapinForm").submit(function(e) {


            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "datapin-btn");

                let dataplan = $('#datapinplan').find(":selected").attr('dataname');
                let msg = "You are about to purchase " + $("#datapinquantity").val() + " data pin of ";

                msg += '"' + $('#datanetworkid').find(":selected").attr('networkname') + '" ' + dataplan + " plan at ";
                msg += '"' + $("#amounttopay").val() + '"' + " with business name " + '"' + $("#businessname").val() + '"';
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#datapin-btn').removeClass("gradient-highlight");
            $('#datapin-btn').addClass("btn-secondary");
            $('#datapin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });



        // ----------------------------------------------------------------------------
        // Wallet Management
        // ----------------------------------------------------------------------------


        $("#transfertype").on("change", function() {
            if ($(this).val() == "wallet-wallet") {
                $("#walletreceiver").show();
                $("#walletreceiverinput").attr("required", "required");
            } else {
                $("#walletreceiver").hide();
                $("#walletreceiverinput").removeAttr("required");
            }
            $("#amounttopay").val("N0.00");
        });

        $("#wallettransferamount").on("keyup", function() {
            let amount = parseInt($('#wallettransferamount').val());
            let charges = parseInt($('#wallettowalletcharges').text());
            if ($("#transfertype").val() == "wallet-wallet") {
                amounttopay = amount + charges;
            } else {
                amounttopay = amount + 0;
            }
            $("#amounttopay").val("N" + amounttopay);
        });

        //Submit Transfer Request
        $("#transferForm").submit(function(e) {

            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "transfer-btn");

                let msg = "You are about to perform a  ";
                let action = "Wallet To Wallet";

                if ($("#transfertype").val() == 'referral-wallet') {
                    action = "Referal To Wallet Transfer";
                    receiver = "your main wallet.";
                } else {
                    action = "Wallet To Wallet Transfer";
                    receiver = $("#walletreceiverinput").val();
                }

                msg += action + " of N" + $('#wallettransferamount').val() + " to " + receiver;
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#transfer-btn').removeClass("gradient-highlight");
            $('#transfer-btn').addClass("btn-secondary");
            $('#transfer-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });

        // ----------------------------------------------------------------------------
        // Contact Page Management
        // ----------------------------------------------------------------------------

        //Send Contact Message
        $("#message-form").submit(function(e) {
            e.preventDefault();

            $('#message-btn').removeClass("gradient-highlight");
            $('#message-btn').addClass("btn-secondary");
            $('#message-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending ...');


            $.ajax({
                url: 'home/includes/route.php?save-message',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        swal('Alert!!', "Message Sent Successfully, We Would Get Back To You Soon.", "success");
                        $("#message-form")[0].reset();
                    } else {
                        swal('Alert!!', "Unexpected Error, Please Contact Our Customer Support Team.", "error");
                    }

                    $('#message-btn').removeClass("btn-secondary");
                    $('#message-btn').addClass("gradient-highlight");
                    $('#message-btn').html("Send Message");

                }
            });

        });

        // ----------------------------------------------------------------------------
        // Alpha Topup Management
        // ----------------------------------------------------------------------------

        //If Alpha Plan Is Selected, Get And Set The Price
        $("#alphaplan").on("change", function() {
            let useraccount = getCookie("loginAccount");
            useraccount = useraccount.replace(/%3D/g, "=");
            useraccount = atob(useraccount);
            useraccount = parseInt(useraccount);

            if (useraccount == 3) {
                $("#amounttopay").val("N" + $('#alphaplan').find(":selected").attr('vendor'));
            }
            if (useraccount == 2) {
                $("#amounttopay").val("N" + $('#alphaplan').find(":selected").attr('agent'));
            } else {
                $("#amounttopay").val("N" + $('#alphaplan').find(":selected").attr('user'));
            }
        });

        //Purchase Alpha Plan
        $("#alphaplanForm").submit(function(e) {


            if ($("#thetranspin").val() == null || $("#thetranspin").val() == '') {
                e.preventDefault();
                $("#transpinbtn").attr("action-btn", "alpha-plan-btn");

                let msg = "You are about to purchase ";
                let dataplan = $('#alphaplan').find(":selected").attr('plan');
                msg += dataplan + " Alpha Topup at " + $("#amounttopay").val() + " for the phone number " + '"' + $("#phone").val() + '"';
                msg += " <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#alpha-plan-btn').removeClass("gradient-highlight");
            $('#alpha-plan-btn').addClass("btn-secondary");
            $('#alpha-plan-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

        });
        // GIVEAWAY-section TYPE and OTHERS
        $("#whattype").on("change", function() {
            if ($("#giveawaytype").val() == "privategiveaway") {
                // if($("#whattype").val() == "cash"){
                //     // document.getElementById("uiddiv").style.display = "block";
                //     document.getElementById("numberdiv").style.display = "none";

                // }else{
                // document.getElementById("uiddiv").style.display = "none";
                document.getElementById("numberdiv").style.display = "block";
                $("#numberInput").attr("required", "");
                // }
            } else if ($("#giveawaytype").val() == "publicgiveaway") {
                // document.getElementById("uiddiv").style.display = "none";
                document.getElementById("numberdiv").style.display = "none";
            } else {
                $("#whattype").val("");
                swal("Oops!", "Select Giveaway Type Before", "info");
            }
        });
        $("#giveawaytype").on("change", function() {
            $("#whattype").val("");
            // $("#useruid").val("");
            $("#numberInput").val("");
            // document.getElementById("uiddiv").style.display = "none";
            document.getElementById("numberdiv").style.display = "none";
        });
        if (document.getElementById("page-file-name") && document.getElementById("page-file-name").getAttribute("page-name") == "profile") {
            changeWallet();
            checkwallet();
        }
        // mytonconnect();

        // Function to check the countdown and Display The $TON amout to pay
        function checkCountdown() {
            let countdownInterval; // Store the interval ID globally
            let currentAmount;
            const element = document.getElementById('amountwarning');
            const isCountdownTrue = element.getAttribute('countdown') === 'true';

            if (isCountdownTrue) {
                if (countdownInterval !== null) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }

                count = 10; // Reset countdown
                document.getElementById("countdown").textContent = count;

                countdownInterval = setInterval(() => {
                    if (document.getElementById("airtimeamount")) {
                        currentAmount = parseFloat(document.getElementById("airtimeamount").value) || 0;
                    }
                    var amounttopays = parseFloat(document.getElementById("amounttopay").value);

                    // let pricetopay = 0;
                    // Stop countdown if amount is reduced below 100
                    if (document.getElementById("page-file-name") && document.getElementById("page-file-name").getAttribute("page-name") == "buy-airtime") {
                        if (currentAmount < 100) {
                            clearInterval(countdownInterval);
                            countdownInterval = null;
                            document.getElementById("countdown").textContent = 0;
                            document.getElementById("amounttopayinton").innerHTML = "0.00 Native";
                            document.getElementById("airtime-btn").disabled = true;
                            document.getElementById("airtime-btn").setAttribute("type", "submit");
                            document.getElementById("airtime-btn").setAttribute("name", "purchase-airtime");
                            $('#airtime-btn').removeClass("btn-secondary");
                            $('#airtime-btn').addClass("gradient-highlight");
                            $('#airtime-btn').html('Buy Airtime');
                            return;
                        }
                    }
                    if (amounttopays <= 0) {
                        if (document.getElementById("page-file-name") && document.getElementById("page-file-name").getAttribute("page-name") == "buy-data") {
                            clearInterval(countdownInterval);
                            countdownInterval = null;
                            document.getElementById("countdown").textContent = 0;
                            document.getElementById("amounttopayinton").innerHTML = "0.00 Native";
                            document.getElementById("data-btn").disabled = true;
                            document.getElementById("data-btn").setAttribute("type", "submit");
                            document.getElementById("data-btn").setAttribute("name", "purchase-data");
                            $('#data-btn').removeClass("btn-secondary");
                            $('#data-btn').addClass("gradient-highlight");
                            $('#data-btn').html('Buy Data');
                            return;
                        }
                    }
                    // Update the amount to pay in TON
                    // let tonPrice = parseFloat(document.getElementById("tonprice").value) || 0;
                    // let amountToPay = (amounttopays / tonPrice).toFixed(2);
                    // document.getElementById("amounttopayinton").innerHTML = amountToPay + " $TON";

                    // Update the countdown
                    if (document.getElementById("airtime-btn")) {
                        document.getElementById("airtime-btn").disabled = false;
                    }
                    if (document.getElementById("data-btn")) {
                        document.getElementById("data-btn").disabled = false;
                    }
                    count--;
                    document.getElementById("countdown").textContent = count;

                    if (count < 1) {
                        if (document.getElementById("data-btn")) {
                            document.getElementById("data-btn").style.display = "none";
                        }
                        if (document.getElementById("airtime-btn")) {
                            document.getElementById("airtime-btn").style.display = "none";
                        }
                        document.getElementById("fetch-price").style.display = "block";
                        document.getElementById("fetch-price").removeAttribute("hidden");
                        $('#airtime-btn').removeClass("btn-secondary");
                        $('#fetch-price').addClass("gradient-highlight");
                        $('#fetch-price').html('Get Price');
                        // .catch(err => console.error(err));
                        count = 11; // Reset countdown
                    }
                }, 1000); // Update every second
            } else {

                // Leaving The Else empty because the code work
            }
        }

        // Use MutationObserver to detect attribute changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'countdown') {
                    checkCountdown();
                }
            });
        });

        // Start observing the element for attribute changes, only if it exists
        if (document.getElementById('amountwarning')) {
            var element = document.getElementById('amountwarning');
            observer.observe(element, {
                attributes: true // Configure it to listen to attribute changes
            });
        }

        // Initial check (optional)
        if (document.getElementById('page-file-name') &&
            document.getElementById('page-file-name').getAttribute("page-name") == purchase_pages[0] ||
            document.getElementById('page-file-name').getAttribute("page-name") == purchase_pages[1] ||
            document.getElementById('page-file-name').getAttribute("page-name") == purchase_pages[2] ||
            document.getElementById('page-file-name').getAttribute("page-name") == purchase_pages[3] ||
            document.getElementById('page-file-name').getAttribute("page-name") == purchase_pages[4]) {
            // Initialize the countdown when the page loads
            // Check if the countdown attribute is set to true
            // Call the function to check countdown when the page loads
            checkCountdown();
        }




    });

    function getP2PAction(links) {
        var msg = "Our Live Chat feature is currently unavailable, but it will be available soon. Feel Free To Contact The Merchant Via The WhatsApp Button Below To Complete Your Transaction.";
        document.getElementById("p2p-prompt-msg").innerHTML = msg;
        document.getElementById("w-contact-btn").setAttribute("href", links);
        document.getElementById("p2p-prompt-btn").click();
    }

    function resendmaill() {
        const COUNTDOWN_DURATION = 60;
        const resendText = document.getElementById("resendText");
        let timer;
        let email;

        function handleResendClick(e) {
            resendText.innerHTML = '<p href="#" id="resendLink" style="color:grey; font-weight:bold;">Resending...</p>';
            e.preventDefault();
            email = document.querySelector('input[name="email"]').value;
            console.log(email);

            $.ajax({
                url: 'home/includes/route.php?resend-mail-ver-code',
                data: {
                    email: email
                },
                cache: false,
                method: 'GET',
                success: function(resp) {
                    console.log(resp);
                    if (resp == 0) {
                        swal('Alert!!', "Resend Successfully.", "success");
                        startCountdown();
                    } else if (resp == 1) {
                        swal('Alert!!', "Mail Not Send: Invalid User Data.", "error");
                        resendText.innerHTML = '<a href="#" id="resendLink" style="color:green; font-weight:bold;">Resend</a>';
                        document.getElementById("resendLink").addEventListener("click", handleResendClick);
                    } else if (resp == 2) {
                        swal('Alert!!', "Mail Not Send.", "error");
                        resendText.innerHTML = '<a href="#" id="resendLink" style="color:green; font-weight:bold;">Resend</a>';
                        document.getElementById("resendLink").addEventListener("click", handleResendClick);

                    } else {
                        swal('Alert!!', "Unknown Error, Please Contact Our Customer Support", "error");
                        resendText.innerHTML = '<a href="#" id="resendLink" style="color:green; font-weight:bold;">Resend</a>';
                        document.getElementById("resendLink").addEventListener("click", handleResendClick);
                    }
                },
                error: function(xhr, status, error) {
                    swal('Alert!!', "Request Not Send", "error");
                    console.error(error);
                }
            });
        }

        function startCountdown() {
            let timeLeft = COUNTDOWN_DURATION;

            // Clear any existing timer
            if (timer) {
                clearInterval(timer);
            }

            // Remove any existing event listeners
            const oldLink = document.getElementById("resendLink");
            if (oldLink) {
                oldLink.removeEventListener("click", handleResendClick);
            }

            // Set up countdown display
            resendText.innerHTML = `Resend after <span id="countdown" style="color:green;">${COUNTDOWN_DURATION}</span> seconds`;
            const countdownSpan = document.getElementById("countdown");

            timer = setInterval(function() {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    resendText.innerHTML = '<a href="#" id="resendLink" style="color:green; font-weight:bold;">Resend</a>';
                    document.getElementById("resendLink").addEventListener("click", handleResendClick);
                } else {
                    countdownSpan.textContent = timeLeft;
                }
            }, 1000);
        }

        // Start initial countdown
        startCountdown();
    }

    function getNativePrice() {
        // let currentAmount = parseFloat(document.getElementById("airtimeamount").value) || 0;
        var amounttopays = parseFloat(document.getElementById("amounttopay").value);
        let page_name = document.getElementById("page-file-name").getAttribute("page-name");
        var purchase_btn = "";
        var _Purchase = "";
        document.getElementById("fetch-price").style.display = "block";
        $('#fetch-price').removeClass("gradient-highlight");
        $('#fetch-price').addClass("btn-secondary");
        $('#fetch-price').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Fetching price ...');
        $.ajax({
            url: 'home/includes/route.php?check-native-price',
            cache: false,
            contentType: false,
            processData: false,
            method: 'GET',
            type: 'GET',
            dataType: 'json', // ADD THIS LINE!
            success: function(resp) {
                // json.enc
                console.log(resp);
                // Get the first coin's price (dynamic coin ID)
                var coinPrice = Object.values(resp)[0].ngn;
                var pricetopay = amounttopays / parseFloat(coinPrice);
                pricetopay = Number(pricetopay.toFixed(4));
                console.log(pricetopay);
                pricetopay = Number(pricetopay.toFixed(4))
                document.getElementById("amounttopayinton").innerHTML = pricetopay + " Native";
                document.getElementById("amounttopay").setAttribute("nativepay", pricetopay);
                document.getElementById("fetch-price").style.display = "none";
                if (page_name === "buy-airtime") {
                    purchase_btn = "airtime-btn";
                    _Purchase = "purchase-airtime";
                } else if (page_name === "buy-data") {
                    purchase_btn = "data-btn";
                    _Purchase = "purchase-data";
                } else if (page_name === "buy-datapins") {
                    purchase_btn = "datapin-btn";
                    _Purchase = "purchase-data-pin";
                } else if (page_name === "buy-alpha-plan") {
                    purchase_btn = "alpha-plan-btn";
                    _Purchase = "purchase-alpha-plan";
                } else if (page_name === "wallet-transfer") {
                    purchase_btn = "transfer-btn";
                    _Purchase = "purchase-wallet-transfer";
                } else {
                    purchase_btn = null;
                }
                document.getElementById(purchase_btn).style.display = "block";
                document.getElementById(purchase_btn).disabled = false;
                document.getElementById(purchase_btn).setAttribute("type", "submit");
                document.getElementById(purchase_btn).setAttribute("name", _Purchase);
                $("#" + purchase_btn).removeClass("btn-secondary");
                $("#" + purchase_btn).addClass("gradient-highlight");
                $("#" + purchase_btn).html('Buy');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error:', error);
            }
        });

    }

    function copyToClipboard(url) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(url).select();
        document.execCommand("copy");
        $temp.remove();
        swal("Success!!", "Copied To Clipboard Successfully", "success");
    }

    function calculatePaystackCharges() {
        let charges = $("#paystackcharges").val();
        let amount = $("#amount").val();
        amount = parseInt(amount);
        charges = parseFloat(charges);

        if (amount > 2500) {
            let amounttopay = amount;
            let discount = 0;

            discount = ((amount * charges) / 100) + 100;
            amounttopay = amount - discount;

            $("#amounttopay").val("N" + amounttopay);
            $("#charges").val("N" + discount);
        } else {
            let amounttopay = amount;
            let discount = 0;

            discount = (amount * charges) / 100;
            amounttopay = amount - discount;

            $("#amounttopay").val("N" + amounttopay);
            $("#charges").val("N" + discount);
        }

    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function verifyNetwork() {

        // if (document.getElementById("mtnimg").getAttribute("SELECTED") == "SELECTED") {
        //     return;
        // }

        var selNetwork = $('#networkid').find(":selected").attr('networkname');
        var verNetwork = "";
        var phoneT = document.getElementById('phone').value;
        var phoneStr = phoneT.substr(0, 4);
        let fieldsd = document.getElementById('networkid');
        let mtns = document.getElementById('mtnspan');
        let airtels = document.getElementById('airtelspan');
        let glos = document.getElementById('glospan');
        let _9mobiles = document.getElementById('9mobilespan');



        if (phoneT === "" || phoneT.length < 6) {
            mtns.style.background = '#f2f2f2';
            document.getElementById('mtnimg').style.width = '45px';
            document.getElementById('mtnimg').style.height = '45px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            airtels.style.background = '#f2f2f2';
            document.getElementById('airtelimg').style.width = '45px';
            document.getElementById('airtelimg').style.height = '45px';
            /////////////////////////////////////////////
            glos.style.background = '#f2f2f2';
            document.getElementById('gloimg').style.width = '45px';
            document.getElementById('gloimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#f2f2f2';
            document.getElementById('9mobileimg').style.width = '45px';
            document.getElementById('9mobileimg').style.height = '45px';

            document.getElementById('verifyer').innerHTML = "";
        } else {
            if (/0702|0704|0803|0806|0703|0706|0813|0816|0810|0814|0903|0906|0913/.test(phoneStr)) {
                verNetwork = "MTN";
                // fieldsd.value = 1;
                selectNetworkByIcon('MTN'); // console.log(thetype.value);
                mtns.style.background = '#56d772d9';
                document.getElementById('mtnimg').style.width = '60px';
                document.getElementById('mtnimg').style.height = '60px';

            } else if (/0805|0807|0705|0815|0811|0905/.test(phoneStr)) {
                verNetwork = "GLO";
                // fieldsd.value = 2;
                selectNetworkByIcon('GLO');
                glos.style.background = '#56d772d9';
                document.getElementById('gloimg').style.width = '60px';
                document.getElementById('gloimg').style.height = '60px';

            } else if (/0702|0704|0803|0806|0703|0706|0813|0816|0810|0814|0903|0906|0913/.test(phoneStr)) {
                verNetwork = "GIFTING";
            } else if (/0802|0808|0708|0812|0701|0901|0902|0907|0912/.test(phoneStr)) {
                verNetwork = "AIRTEL";
                // fieldsd.value = 4;
                selectNetworkByIcon('AIRTEL');
                _9mobiles.style.background = '#f2f2f2';
                document.getElementById('9mobileimg').style.width = '45px';
                document.getElementById('9mobileimg').style.height = '45px';
                airtels.style.background = '#56d772d9';
                document.getElementById('airtelimg').style.width = '60px';
                document.getElementById('airtelimg').style.height = '60px';
            } else if (/0809|0818|0817|0908|0909/.test(phoneStr)) {
                verNetwork = "9MOBILE";
                // fieldsd.value = 3;
                selectNetworkByIcon('9MOBILE');
                _9mobiles.style.background = '#56d772d9';
                document.getElementById('9mobileimg').style.width = '60px';
                document.getElementById('9mobileimg').style.height = '60px';
            } else if (/0804/.test(phoneStr)) {
                verNetwork = "NTEL";
                selectNetworkByIcon('NTEL');

            } else {
                mtns.style.background = '#f2f2f2';
                document.getElementById('mtnimg').style.width = '45px';
                document.getElementById('mtnimg').style.height = '45px';
                // $('#mtnimg').style.height
                ////////////////////////////////////////////
                airtels.style.background = '#f2f2f2';
                document.getElementById('airtelimg').style.width = '45px';
                document.getElementById('airtelimg').style.height = '45px';
                /////////////////////////////////////////////
                glos.style.background = '#f2f2f2';
                document.getElementById('gloimg').style.width = '45px';
                document.getElementById('gloimg').style.height = '45px';
                //////////////////////////////////////////////////
                _9mobiles.style.background = '#f2f2f2';
                document.getElementById('9mobileimg').style.width = '45px';
                document.getElementById('9mobileimg').style.height = '45px';

                verNetwork = "Unable to identify network !";
            }
            if (selNetwork == "ETISALAT") {
                selNetwork = "9MOBILE";
                selectNetworkByIcon('9MOBILE');
                _9mobiles.style.background = '#56d772d9';
                document.getElementById('9mobileimg').style.width = '60px';
                document.getElementById('9mobileimg').style.height = '60px';
            }
            if (verNetwork == selNetwork) {
                var ic = "<i class = 'fas fa-check-circle' style ='color: #4BB543;'></i>";
            } else {
                ic = "<i class = 'fas fa-exclamation-triangle' style ='color:#B33A3A'></i>";
            }

            document.getElementById('verifyer').innerHTML = "Identified Network: <b>" + verNetwork + "  " + ic + "</b><br><b> Note: </b> Ignore warning for <b>Ported Numbers</b>";
        }
    }


    function selectNetworkByIcon(name) {
        let fieldsd = document.getElementById('networkid');
        let mtns = document.getElementById('mtnspan');
        let airtels = document.getElementById('airtelspan');
        let glos = document.getElementById('glospan');
        let _9mobiles = document.getElementById('9mobilespan');

        $("option[networkname]").removeAttr("selected");
        $("option[networkname='" + name + "']").attr("selected", "selected");
        if (name == 'MTN') {
            mtns.style.background = '#56d772d9';
            document.getElementById('mtnimg').style.width = '60px';
            document.getElementById('mtnimg').style.height = '60px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            airtels.style.background = '#f2f2f2';
            document.getElementById('airtelimg').style.width = '45px';
            document.getElementById('airtelimg').style.height = '45px';
            /////////////////////////////////////////////
            glos.style.background = '#f2f2f2';
            document.getElementById('gloimg').style.width = '45px';
            document.getElementById('gloimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#f2f2f2';
            document.getElementById('9mobileimg').style.width = '45px';
            document.getElementById('9mobileimg').style.height = '45px';
            document.getElementById('mtnimg').setAttribute("SELECTED", "SELECTED");
        } else if (name == 'GLO') {
            glos.style.background = '#56d772d9';
            document.getElementById('gloimg').style.width = '60px';
            document.getElementById('gloimg').style.height = '60px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            airtels.style.background = '#f2f2f2';
            document.getElementById('airtelimg').style.width = '45px';
            document.getElementById('airtelimg').style.height = '45px';
            /////////////////////////////////////////////
            mtns.style.background = '#f2f2f2';
            document.getElementById('mtnimg').style.width = '45px';
            document.getElementById('mtnimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#f2f2f2';
            document.getElementById('9mobileimg').style.width = '45px';
            document.getElementById('9mobileimg').style.height = '45px';
        } else if (name == '9MOBILE') {
            glos.style.background = '#f2f2f2';
            document.getElementById('gloimg').style.width = '45px';
            document.getElementById('gloimg').style.height = '45px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            airtels.style.background = '#f2f2f2';
            document.getElementById('airtelimg').style.width = '45px';
            document.getElementById('airtelimg').style.height = '45px';
            /////////////////////////////////////////////
            mtns.style.background = '#f2f2f2';
            document.getElementById('mtnimg').style.width = '45px';
            document.getElementById('mtnimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#56d772d9';
            document.getElementById('9mobileimg').style.width = '60px';
            document.getElementById('9mobileimg').style.height = '60px';
        } else if (name == 'AIRTEL') {
            airtels.style.background = '#56d772d9';
            document.getElementById('airtelimg').style.width = '60px';
            document.getElementById('airtelimg').style.height = '60px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            glos.style.background = '#f2f2f2';
            document.getElementById('gloimg').style.width = '45px';
            document.getElementById('gloimg').style.height = '45px';
            /////////////////////////////////////////////
            mtns.style.background = '#f2f2f2';
            document.getElementById('mtnimg').style.width = '45px';
            document.getElementById('mtnimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#f2f2f2';
            document.getElementById('9mobileimg').style.width = '45px';
            document.getElementById('9mobileimg').style.height = '45px';
        } else {
            mtns.style.background = '#f2f2f2';
            document.getElementById('mtnimg').style.width = '45px';
            document.getElementById('mtnimg').style.height = '45px';
            // $('#mtnimg').style.height
            ////////////////////////////////////////////
            airtels.style.background = '#f2f2f2';
            document.getElementById('airtelimg').style.width = '45px';
            document.getElementById('airtelimg').style.height = '45px';
            /////////////////////////////////////////////
            glos.style.background = '#f2f2f2';
            document.getElementById('gloimg').style.width = '45px';
            document.getElementById('gloimg').style.height = '45px';
            //////////////////////////////////////////////////
            _9mobiles.style.background = '#f2f2f2';
            document.getElementById('9mobileimg').style.width = '45px';
            document.getElementById('9mobileimg').style.height = '45px';
        }
        let sme = $('#networkid').find(":selected").attr('sme');
        let gifting = $('#networkid').find(":selected").attr('gifting');
        let corporate = $('#networkid').find(":selected").attr('corporate');
        let networkname = $('#networkid').find(":selected").attr('networkname');
        let thegroup = '<option value="">Select Type</option>';

        //Check If Network Is Disabled
        if (sme == "On") {
            thegroup += '<option value="SME">SME</option>';
        }

        //Check If Network Is Disabled
        if (gifting == "On") {
            thegroup += '<option value="Gifting">Gifting</option>';
        }

        //Check If Network Is Disabled
        if (corporate == "On") {
            thegroup += '<option value="Corporate">Corporate</option>';
        }
        $("#datagroup").html(thegroup);
    }


    function selectExamByIcon(name) {
        $("option[providername]").removeAttr("selected");
        $("option[providername='" + name + "']").attr("selected", "selected");
    }

    // <--- Create Giveaway JS CODE START--->
    function checktype() {
        var giveawaytype = document.getElementById("giveawaytype");
        var number_div = document.getElementById("numberdiv");
        let numbe_field = document.getElementById("numberInput");

        if (giveawaytype.value === "privategiveaway") {
            number_div.style.display = "block";
            numbe_field.required = true;
            swal("Alert!!", "Please Copy The Phone numbers and Paste. It Will Automatically Arrage It Min." +
                "<?php $minnumber = 5; ?> <?php echo $minnumber; ?>", "info");
        } else if (giveawaytype.value === "publicgiveaway") {
            number_div.style.display = "none";
            numbe_field.required = false;
        }
    }

    function handlePaste(event) {
        event.preventDefault(); // Prevent default paste action

        // Get the pasted data
        const pastedData = (event.clipboardData || window.clipboardData).getData('text');

        // Define the desired number length (11 digits) and min/max count
        const numberLength = 11;
        const minCount = 5;
        const maxCount = 100;

        // Split the pasted data by commas, trimming spaces
        let separatedNumbers = pastedData.split(',').map(num => num.trim());

        // Check if numbers are already in the correct format
        const allNumbersValid = separatedNumbers.every(num => num.length === numberLength && /^0\d{10}$/.test(num));

        if (allNumbersValid) {
            // If numbers are correctly formatted, display them directly
            if (separatedNumbers.length < minCount || separatedNumbers.length > maxCount) {
                document.getElementById('numberInput').value = ''; // Clear the input field
                swal("Oops!", "Minimum of 5 numbers and maximum of 100 numbers.", "info");
            } else {
                document.getElementById('numberInput').value = separatedNumbers.join(', ');
                document.getElementById('error').innerText = ''; // Clear any previous error
            }
        } else {
            // If not formatted, split pasted data into chunks of 11 digits
            separatedNumbers = [];
            for (let i = 0; i < pastedData.length; i += numberLength) {
                let chunk = pastedData.slice(i, i + numberLength);
                if (/^0\d{10}$/.test(chunk)) {
                    separatedNumbers.push(chunk);
                } else {
                    swal("Invalid Number", "Please check the number format. Only valid 11-digit Nigerian numbers are allowed.", "error");
                    return;
                }
            }
            // 091274063110912740631109127406311091274063110912740631109127406311091274063110912740631109127406311
            // Check if the number count is within the allowed range
            if (separatedNumbers.length < minCount || separatedNumbers.length > maxCount) {
                document.getElementById('numberInput').value = ''; // Clear the input field
                swal("Oops!", "Minimum of 5 numbers and maximum of 100 numbers.", "info");
            } else {
                // If within the range, display separated numbers in the input field
                document.getElementById('numberInput').value = separatedNumbers.join(', ');
                document.getElementById('error').innerText = ''; // Clear any previous error
            }
        }
    }


    function checkthedata() {
        // Get the pasted data
        const pastedData = document.getElementById("numberInput").value;

        // Define the desired number length (11 digits) and min/max count
        const numberLength = 11;
        const minCount = 5;
        const maxCount = 100;

        // Split the pasted data by commas, trimming spaces
        let separatedNumbers = pastedData.split(',').map(num => num.trim());

        // Check if numbers are already in the correct format
        const allNumbersValid = separatedNumbers.every(num => num.length === numberLength && /^0\d{10}$/.test(num));

        if (allNumbersValid) {
            // If numbers are correctly formatted, display them directly
            if (separatedNumbers.length < minCount || separatedNumbers.length > maxCount) {
                document.getElementById('numberInput').value = ''; // Clear the input field
                swal("Oops!", "Minimum of 5 numbers and maximum of 100 numbers.", "info");
            } else {
                document.getElementById('numberInput').value = separatedNumbers.join(',');
                document.getElementById('error').innerText = ''; // Clear any previous error
            }
        } else {
            // If not formatted, split pasted data into chunks of 11 digits
            separatedNumbers = [];
            for (let i = 0; i < pastedData.length; i += numberLength) {
                let chunk = pastedData.slice(i, i + numberLength);
                if (/^0\d{10}$/.test(chunk)) {
                    separatedNumbers.push(chunk);
                } else {
                    swal("Invalid Number", "Please check the number format. Only valid 11-digit Nigerian numbers are allowed.", "error");
                    return;
                }
            }
            // 091274063110912740631109127406311091274063110912740631109127406311091274063110912740631109127406311
            // Check if the number count is within the allowed range
            if (separatedNumbers.length < minCount || separatedNumbers.length > maxCount) {
                document.getElementById('numberInput').value = ''; // Clear the input field
                swal("Oops!", "Minimum of 5 numbers and maximum of 100 numbers.", "info");
            } else {
                // If within the range, display separated numbers in the input field
                document.getElementById('numberInput').value = separatedNumbers.join(',');
                document.getElementById('error').innerText = ''; // Clear any previous error
            }
        }
    }
    // function checkwhat() {
    //    var whattype = document.getElementById("whattype");
    //    var giveawaytype = document.getElementById("giveawaytype");
    //     if(giveawaytype.value !== "privategiveaway" && giveawaytype.value !== "publicgiveaway"){
    //         swal("Oops!", "Minimum of 5 numbers and maximum of 100 numbers.", "info");
    //     }
    // }


    // <--- Create Giveaway JS CODE END--->
    // Check Wallet Status START

    // Check Wallet STatus END
    // Create Update Wallet JS CODE START
    // let changebtn = ;

    function show_amount() {
        checkwalletbalance();
        event.preventDefault();
        var Seye = document.getElementById('eye-show');
        var Heye = document.getElementById('eye-hide');
        var Wbalance = document.getElementById('Wbalance');
        var Ebalance = document.getElementById('Ebalance');
        Seye.style.display = 'block';
        Heye.style.display = 'none';
        Wbalance.innerHTML = Wbalance.getAttribute('amount');
        Ebalance.innerHTML = Ebalance.getAttribute('amount');

    }

    function hide_amount() {
        event.preventDefault();
        var Seye = document.getElementById('eye-show');
        var Heye = document.getElementById('eye-hide');
        var Wbalance = document.getElementById('Wbalance');
        var Ebalance = document.getElementById('Ebalance');
        Heye.style.display = 'block';
        Seye.style.display = 'none';
        Wbalance.innerHTML = "**,***";
        Ebalance.innerHTML = "**,***";

    }

    function changeWallet() {
        $("#change-wallet").click(function() {
            var tonconnectdiv = document.getElementById("tonconn-div");
            var transpindiv = document.getElementById("transpin-div");
            let updatewallet_btn = document.getElementById("update-wallet-btn");
            tonconnectdiv.style.display = "flex";
            transpindiv.style.display = "block";
            updatewallet_btn.style.display = "block";
            // document.getElementById('saved-add').style.display = "none";
            // document.getElementById('unsaved-add').style.display = "block";
            document.getElementById("wallet-add").setAttribute("changestatus", "1");
        });

    }

    function checkwallet() {
        let savedwallet = document.getElementById("wallet-add").getAttribute("address-status");
        var tonconnectdiv = document.getElementById("tonconn-div");
        var transpindiv = document.getElementById("transpin-div");
        var walletinfo = document.getElementById("walletinfo-div");
        var savedaddress = document.getElementById("wallet-add");
        let addwallet_btn = document.getElementById("add-wallet-btn");
        let updatewallet_btn = document.getElementById("update-wallet-btn");

        if (savedwallet == "0") {
            // swal("Alert!!", "Please Connect Wallet", "info");
            tonconnectdiv.style.display = "flex";
            transpindiv.style.display = "block";
            savedaddress.value = "";
            addwallet_btn.style.display = "block";
            updatewallet_btn.style.display = "none";
            document.getElementById("saved-add").style.display = "none";
            document.getElementById("unsaved-add").style.display = "block";
            // addwallet_btn.setAttribute("name", "add-wallet");
            // updatewallet_btn.removeAttribute("name");
            // updatewallet_btn.removeAttribute("type");
        } else {
            walletinfo.style.display = "block";
            transpindiv.style.display = "none";
            savedaddress.value = document.getElementById("wallet-add").getAttribute("saved-address");

            addwallet_btn.style.display = "none";
            updatewallet_btn.style.display = "none";
            document.getElementById("saved-add").style.display = "block";
            document.getElementById("unsaved-add").style.display = "none";
            // updatewallet_btn.setAttribute("name", "update-wallet");
            // addwallet_btn.removeAttribute("name");
            // addwallet_btn.removeAttribute("type");

        }
    }


    function checkwalletbalance() {
        if (!document.getElementById("Wbalance")) {
            return; // Exit if the element is not found
        }
        let walletaddy = document.getElementById("Wbalance").getAttribute("address");
        if (!walletaddy || walletaddy === "") {
            console.error("Wallet address is empty or undefined.");
            return "error"; // Return error for further handling
        }
        $.ajax({
            url: 'home/includes/route.php?check-native-balance=1&address=' + walletaddy,
            method: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp.error || resp.status === 'fail') {
                    console.error("Error:", resp.error || resp.msg);
                    return "error"; // Return error for further handling
                } else {
                    const balance = resp.balance;
                    console.log("Wallet balance From check:", balance + " Native");
                    // You can update your HTML here
                    // document.getElementById('wallet-info').innerHTML += `Balance: ${balance} TON`;
                    // Set the balance attribute
                    if (document.getElementById("Wbalance")) {
                        document.getElementById("Wbalance").setAttribute("amount", parseFloat(balance).toFixed(3));
                    }
                    // Show the balance with 3 decimal places
                    // document.getElementById("Wbalance").innerHTML = parseFloat(balance).toFixed(3);
                    return balance; // Return the balance for further use
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

    window.Sendtransaction = function() {
        var amount = document.getElementById("amounttopay").getAttribute("nativepay");
        document.getElementById("native-to-pay").setAttribute("value", amount);
        // document.getElementById("continue-transaction-prompt").style.display = "none";
        $('#continue-transaction-in-wallet-prompt-btn').click();
        document.getElementById("continue-transaction-in-wallet-prompt").style.display = "block";
        startTransactions(amount);
        // $('#transpinbtn').click();
        // $('#thetranspin').val(5);
    }
    window.disconnectWallets = function() {
        disconnectwallet();
    }
    window.sharereceipt = async function() {
        const shareBtn = document.getElementById('share-receipt-btn');
        console.log('Share button clicked'); // Debug log
        try {
            const originalText = shareBtn.innerHTML;
            shareBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Preparing...';
            shareBtn.disabled = true;

            const element = document.getElementById('receipt-content');
            const canvas = await html2canvas(element, {
                scale: 2,
                logging: true,
                useCORS: true,
                allowTaint: true,
                backgroundColor: "white" // Transparent background
            });

            canvas.toBlob(async function(blob) {
                try {
                    const file = new File([blob], 'receipt.png', {
                        type: 'image/png'
                    });

                    if (navigator.share && navigator.canShare && navigator.canShare({
                            files: [file]
                        })) {
                        await navigator.share({
                            files: [file],
                            title: 'Transaction Receipt',
                            text: 'My transaction receipt from OnChain'
                        });
                    } else {
                        downloadImage(canvas);
                    }
                } catch (shareError) {
                    console.error('Sharing error:', shareError);
                    downloadImage(canvas);
                } finally {
                    shareBtn.style.display = 'inline'; // Show the share button again
                    shareBtn.innerHTML = originalText;
                    shareBtn.disabled = false;
                }
            }, 'image/png');

        } catch (error) {
            console.error('Error:', error);
            alert('Failed to generate receipt. Please try again.');
            shareBtn.style.display = 'inline'; // Hide the share button
            shareBtn.innerHTML = '<b>Share Receipt</b>';
            shareBtn.disabled = false;
        }
    };

    function downloadImage(canvas) {
        const link = document.createElement('a');
        link.download = 'receipt_' + new Date().getTime() + '.png';
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        alert('Receipt downloaded. You can now share it from your gallery.');
    }
    // Create Update Wallet JS CODE END
</script>
<script>
    // EVM Wallet Integration
    let TARGETADDRESS = '';
    let userAddress = null;

    if (document.getElementById("blockchainselect")) {
        let chainselect = document.getElementById("blockchainselect");
        checkchain(chainselect);
    }

    function checkchain(chainselect) {
        if (chainselect.value === "ton") {
            // Replaced with EVM connect
             connectEVMWallet();
        }
    }

    window.disconnectWallets = function() {
        // For EVM, we can't strictly disconnect from the website side in the same way as TON Connect
        // But we can clear our local state
        userAddress = null;
        // Update UI to reflect disconnection
         var page_name = document.getElementById("page-file-name").getAttribute("page-name");
         if (page_name === "buy-airtime" || page_name === "buy-data" || page_name === "buy-datapins" || page_name === "buy-alpha-plan" || page_name === "wallet-transfer") {
            document.getElementById('walletdatainfo').setAttribute("connection", "0");
            document.getElementById('ton-connect-btn-div').style.display = 'block';
            document.getElementById('purchase-btn-div').style.display = 'none';
             if(document.getElementById("disconnect-wallet-btn")){
                 document.getElementById("disconnect-wallet-btn").style.display = "none";
            }
        } else {
            document.getElementById('walletinfo-div').style.display = "none";
        }
         swal("Info", "Wallet disconnected from app. Please also disconnect in your wallet extension if needed.", "info");
    }

    async function connectEVMWallet() {
        if (typeof window.ethereum !== 'undefined') {
            try {
                const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                handleWalletConnection(accounts[0]);
            } catch (error) {
                console.error('User rejected connection:', error);
                swal("Error", "User rejected connection", "error");
            }
        } else {
            console.log('MetaMask not installed');
            swal("Error", "Please install MetaMask or another EVM wallet", "error");
        }
    }
    
    // Check if wallet is already connected
    window.addEventListener('load', async () => {
         if (typeof window.ethereum !== 'undefined') {
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            if (accounts.length > 0) {
                handleWalletConnection(accounts[0]);
            }
             
             // Listen for account changes
            window.ethereum.on('accountsChanged', function (accounts) {
                if(accounts.length > 0){
                    handleWalletConnection(accounts[0]);
                } else {
                    disconnectWallets();
                }
            });
         }
         
          TARGETADDRESS = '<?php echo $data9->walletaddress ?? ""; ?>';
    });


    function handleWalletConnection(address) {
        userAddress = address;
        console.log("Connected to EVM wallet:", userAddress);
        
        var page_name = document.getElementById("page-file-name").getAttribute("page-name");
        
        // Update UI button to show connected status (simplified)
         const connectBtn = document.getElementById('ton-connect');
         if(connectBtn) {
             connectBtn.innerHTML = '<button class="btn btn-success">Connected: ' + userAddress.substring(0, 6) + '...' + userAddress.substring(userAddress.length - 4) + '</button>';
         }
         
         if(document.getElementById("disconnect-wallet-btn")){
             document.getElementById("disconnect-wallet-btn").style.display = "flex";
         }

        if (page_name === "buy-airtime" || page_name === "buy-data" || page_name === "buy-datapins" || page_name === "buy-alpha-plan" || page_name === "wallet-transfer") {
            var walletaddy = document.getElementById("walletdatainfo").getAttribute("saved-address");
            let savedwallet = document.getElementById("walletdatainfo").getAttribute("address-status");
            document.getElementById('walletdatainfo').setAttribute("connection", "0");
            
            if (savedwallet !== "1") {
                swal("Oops!", "Redirecting To Profile and Add Web3 Wallet.", "info");
                setTimeout(() => {
                    window.location.href = "profile?set-wallet";
                }, 1000);
                return;
            } else {
                 // Case insensitive comparison for EVM addresses
                if (walletaddy.toLowerCase() !== userAddress.toLowerCase()) {
                    swal({
                        title: 'Alert!!',
                        text: `Wallet Address Mismatch, Please Update Wallet Address...  <i style = 'color:blue; font-size:small; '><br> <br>Profile/Saved Wallet:  ${walletaddy}</i>`,
                        html: true
                    });
                    return;
                } else {
                    if (walletaddy === "" || walletaddy === null) {
                        swal("Oops!", "Invalid Wallet.", "info");
                        return;
                    } else {
                        document.getElementById('walletdatainfo').setAttribute("connection", "1");
                        document.getElementById('ton-connect-btn-div').style.display = 'none';
                        document.getElementById('purchase-btn-div').style.display = 'block';
                    }
                }
            }
        } else {
            // Profile page logic
            var walletaddy = document.getElementById("wallet-add").getAttribute("saved-address");
            let savedwallet = document.getElementById("wallet-add").getAttribute("address-status");
            
            document.getElementById('walletinfo-div').style.display = "block";
            
            if (savedwallet !== "1" || walletaddy === "" || walletaddy === null) {
                 document.getElementById("wallet-add").value = userAddress;
                 document.getElementById('saved-add').style.display = "none";
                 document.getElementById('unsaved-add').style.display = "block";
            } else {
                 if (userAddress.toLowerCase() !== walletaddy.toLowerCase()) {
                    let changestatus = document.getElementById("wallet-add").getAttribute("changestatus");
                    if (changestatus !== "1") {
                        document.getElementById("tonconn-div").style.display = "flex";
                        swal("Alert!!", "Wallet Address Mismatch, Please Update Wallet Address", "info");
                    } else {
                        document.getElementById("wallet-add").value = userAddress;
                    }
                    document.getElementById('saved-add').style.display = "none";
                    document.getElementById('unsaved-add').style.display = "block";
                } else {
                    document.getElementById("wallet-add").value = walletaddy;
                    document.getElementById('saved-add').style.display = "block";
                    document.getElementById('unsaved-add').style.display = "none";
                }
            }
        }
        
        // Fetch balance
        checkwalletbalance();
    }

    window.startTransactions = async function(amount) {
        var page_name = document.getElementById("page-file-name").getAttribute("page-name");
        var transref = $('[name="transref"]').val();
        var amounttopay = $("#amounttopay").val();
        
        if (typeof window.ethereum === 'undefined' || !userAddress) {
             swal("Alert!!", "Wallet is not connected", "error");
             $('#transpinbtn').click();
             return;
        }

        const parsedAmount = parseFloat(amount);
        if (isNaN(parsedAmount) || parsedAmount <= 0) {
            swal("Alert!!", "Invalid Amount", "error");
            $('#transpinbtn').click();
            return;
        }

        const provider = new ethers.providers.Web3Provider(window.ethereum);
        const signer = provider.getSigner();
        
        // Note: Ethers.js v5 syntax
        try {
            const txParams = {
                to: TARGETADDRESS,
                value: ethers.utils.parseEther(amount.toString())
            };

            // Add data/memo for AssetChain/EVM
            // Converting text to hex for data field
            let memo = "";
            if (page_name === "buy-airtime") {
                memo = amounttopay + "N Airtime Purchased (" + transref + ")";
            } else if (page_name === "buy-data") {
                memo = amounttopay + "N Data Purchased (" + transref + ")";
            } else if (page_name === "buy-datapins") {
                memo = amounttopay + "N Data Pin Purchased (" + transref + ")";
            } else if (page_name === "wallet-transfer") {
                 memo = amounttopay + "N Wallet Transfer (" + transref + ")";
            } else {
                memo = "Payment Ref: " + transref;
            }
            
            const utf8Encode = new TextEncoder();
            const hexData = "0x" + Array.from(utf8Encode.encode(memo)).map(b => b.toString(16).padStart(2, '0')).join('');
            txParams.data = hexData;

            const txResponse = await signer.sendTransaction(txParams);
            console.log('Transaction sent:', txResponse);
            
            swal({
                title: '<h3 class="text-center mt-4"><i class="fa fa-3x fa-spinner fa-spin" aria-hidden="true"></i></h3>',
                text: 'Transaction sent. Waiting for confirmation...',
                allowOutsideClick: false,
                showConfirmButton: false,
                 html: true
            });

            const receipt = await txResponse.wait();
            console.log('Transaction confirmed:', receipt);
            
            const txHash = receipt.transactionHash;
            // const explorerLink = `https://scan.assetchain.org/tx/${txHash}`; // Adjust explorer URL
            
            if (receipt.status === 1) {
                // Populate hidden form fields for backend verification if needed
                let onchain_data = `
                    <input type="hidden" name="target_address" value="${TARGETADDRESS}" hidden />
                    <input type="text" name="tx_hash" value="${txHash}" hidden />
                    <input type="text" name="user_address" value="${userAddress}" hidden />
                    <input type="text" name="amount_paid" value="${amount}" hidden />
                `;
                $("#transaction-data").html(onchain_data);

                 if (page_name === "buy-airtime" || page_name === "buy-data" || page_name === "buy-datapins" || page_name === "buy-alpha-plan" || page_name === "wallet-transfer") {
                    swal({
                        title: '<h3 class="text-center mt-4"><i class="fa fa-3x fa-spinner fa-spin" aria-hidden="true"></i></h3>',
                        text: 'Transaction confirmed. Please wait... <h5> <i style="color:orange;"><br> <br> If this is taking longer than expected, your transaction may be refunded. Please remain patient.</i></h5>',
                         allowOutsideClick: false,
                        showConfirmButton: false,
                        html: true
                    });
                    setTimeout(() => {
                        $('#thetranspin').val(5);
                        $('#transpinbtn').click();
                    }, 500);
                } else {
                     $('#thetranspin').val(5);
                     $('#transpinbtn').click();
                }
            } else {
                swal("Alert!!", "Transaction failed on chain.", "error");
            }

        } catch (error) {
            console.error('Transaction error:', error);
             let reason = error.message || "Transaction failed";
             if(reason.includes("user rejected")){
                 reason = "User rejected transaction";
             }
            swal("Alert!!", "Failed to send transaction: " + reason, "error");
            $('#transpinbtn').click();
        }
    }
</script>
<!-- TON Connect JS CODE END--->