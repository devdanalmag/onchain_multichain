<?php
if (isset($_GET['referral'])) {
    $referral = $_GET['referral'];
} else {
    $referral = "";
}
if (isset($_SESSION['loginId'])) {
    echo "<script>window.location.href='../home/';</script>";
}
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/animation.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/scripts/sweetalert/sweetalert.css">
    <link rel="manifest" href="../assets/scripts/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
    <style>
        #lga option {
            color: #000000 !important;
        }

        #ward option {
            color: #000000 !important;
        }
    </style>
    <style>
        .card {
            background: rgba(0, 0, 0, 0.5);
            margin: 20px;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.5) !important;
            border-radius: 5rem !important;
            padding: 25px !important;
            padding-left: 50px !important;
        }

        .form-control:focus {
            background-color: #f2f2f2 !important;
        }

        .input-style i {
            padding-left: 20px !important;
        }

        .btn {
            border-radius: 5rem !important;
        }
    </style>
</head>

<body class="theme-light">
    <!-- Loading -->
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">



        <div class="page-content mt-3">

            <div style="display:flex; justify-content:center; align-content:center;">
                <div class="card card-style login-box">
                    <div class="content">

                        <div class="text-center">
                            <div class="pb-3 pt-3">
                                <img src="../../assets/img/logodark.png" class="img-fluid" width="250" />
                            </div>
                            <h1 class="font-30 mb-3" style="color:#f2f2f2;">Register</h1>
                            <p class="mb-3 color-highlight">Enter your credentials below to create a free account</p>

                        </div>


                        <form id="reg-form" method="post">
                            <div class="px-2">
                                <!-- <div id="regDiv"> -->
                                <div class="user-box">
                                    <input type="text" id="username" name="username" required />
                                    <label for="username">Username <em style="color:red;">*</em></label>

                                </div>

                                <div class="user-box">
                                    <input type="email" id="email" name="email" required />
                                    <label for="email">Email <em style="color:red;">*</em></label>
                                </div>

                                <div class="user-box">
                                    <input type="password" id="password" name="password" required readonly />
                                    <label for="password">Password <em style="color:red;">*</em></label>
                                </div>

                                <div class="user-box">
                                    <input type="password" id="cpassword" name="cpassword" required readonly />
                                    <label for="cpassword">Confirm Password <em style="color:red;">*</em></label>
                                </div>
                                <input id="account" name="account" type="hidden" value="1" />

                                <div class="user-box">
                                    <input type="text" value="<?php echo $referral; ?>" id="referal" name="referal" />
                                    <label for="referal">Referral</label>
                                </div>


                                <button class="mybt" type="submit" id="submit-btn" style="width: 100%;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    Register
                                </button>
                                <div class="row pt-5 mb-3">
                                    <div class="col-12 text-center font-15">
                                        <a class="text-white" href="../recovery/">Already Has Account ? Login</a>
                                    </div>
                                    <div class="col-12 text-center font-15 mt-2" style="visibility: hidden;">
                                        <a class="text-white" href="../register/"> Already Has Account ? Login </a>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>



        </div>
        <!-- Page content ends here-->


    </div>
    <script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="../assets/scripts/jquery.min.js"></script> -->
    <script src="../assets/scripts/jquery-3.3.1/jquery-3.3.1.min.js"></script>
    <script src="../assets/scripts/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/scripts/sweetalert/jquery.sweet-alert.custom.js"></script>

    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script type="text/javascript" src="../assets/scripts/custom.js"></script>

    <script type="text/javascript">
        $("document").ready(function() {

            //Enable Form Input
            $("#email").click(function() {
                $(this).removeAttr("readonly");
            });
            $("#password").click(function() {
                $(this).removeAttr("readonly");
            });
            $("#cpassword").click(function() {
                $(this).removeAttr("readonly");
            });

            //Registration Form
            $('#reg-form').submit(function(e) {
                e.preventDefault();
                $msg = "";
                if ($("#account").val() == "" || $("#account").val() == " ") {
                    $msg = "Please Select Account Type.";
                }
                if ($("#email").val() == "" || $("#email").val() == " ") {
                    $msg = "Please Enter Email.";
                }
                if ($("#username").val() == "" || $("#username").val() == " ") {
                    $msg = "Please Enter Username.";
                }
                if ($("#password").val().length > 15) {
                    $msg = "Password should not be more than 15 character.";
                }
                if ($("#password").val().length < 8) {
                    $msg = "Password should be at least 8 character.";
                }
                if ($("#password").val() == $("#username").val()) {
                    $msg = "You can't use your Username as password.";
                }
                if ($("#password").val() == "" || $("#password").val() == " ") {
                    $msg = "Please Enter Password.";
                }
                if (($("#password").val()) != ($("#cpassword").val())) {
                    $msg = "Password Is Different From Confirm Password.";
                }


                if ($msg != "") {
                    swal("Alert!!", $msg, "info");
                    let _inner = '<span></span><span></span><span></span><span></span><div style="margin-left: 33%;">Register</div>'
                    $('#next-btn').html(_inner);
                    $msg = "";
                    return;
                }

                $('#submit-btn').removeClass("gradient-highlight");
                // $('#submit-btn').addClass("btn-secondary");
                document.getElementById("submit-btn").disabled = true;
                $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Processing ...');

                $.ajax({
                    url: '../home/includes/route.php?register',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function(resp) {
                        console.log(resp);
                        if (resp == 0) {
                            swal('Alert!!', "Registration Succesfull", "success");
                            setTimeout(function() {
                                location.replace('../home/')
                            }, 10)
                        } else if (resp == 1) {
                            swal('Alert!!', "Email & Username Already Exist.", "error");
                        } else if (resp == 2) {
                            swal('Alert!!', "Email Already Exist.", "error");
                        } else if (resp == 3) {
                            swal('Alert!!', "Username Already Exist.", "error");
                        } else if (resp == 4) {
                            swal('Alert!!', "DATABASE ERROR.", "error");
                        } else if (resp == 5) {
                            swal('Alert!!', "Invalid Referral", "error");
                        } else if (resp == 6) {
                            swal('Alert!!', "Referral Account Is Not Activated", "error");
                        } else {
                            swal('Alert!!', "Unknow Error, Please Contact Support", "error");
                        }

                        // $('#submit-btn').removeClass("btn-secondary");
                        // $('#submit-btn').addClass("gradient-highlight");
                        // $('#submit-btn').html('Register');
                        let _inner = '<span></span><span></span><span></span><span></span>Register'
                        $('#submit-btn').html(_inner);

                        let _inner1 = '<span></span><span></span><span></span><span></span>Continue'
                        $('#next-btn').html(_inner1);
                        document.getElementById("submit-btn").disabled = false;
                        // $('#next-btn').removeClass("btn-secondary");
                        // $('#next-btn').addClass("gradient-highlight");
                        // $('#next-btn').html('<div style="margin-left: 33%;">Continue</div>');

                    }
                })
            });
        });
    </script>
</body>

</html>