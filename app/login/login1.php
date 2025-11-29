<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/animation.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/scripts/sweetalert/sweetalert.css">

    <link rel="manifest" href="../assets/scripts/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
    <?php if (isset($_SESSION['loginId'])) {
        echo "<script>window.location.href='../home/';</script>";
    } ?>
    <style>
        body {
            background: linear-gradient(#141e30, #243b55);
        }

        .card {
            background: rgba(0, 0, 0, 0.5);
            margin: 20px;
        }

        .form-control {
            background-color: #fafafa !important;
            border-radius: 5rem !important;
            padding: 25px !important;
            padding-left: 50px !important;
        }

        .form-control:focus {
            background-color: #ffffff !important;
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

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">



        <div class="page-content mt-3">

            <div style="display:flex; justify-content:center; align-content:center;">
                <div class="card card-style login-box">
                    <div class="content">

                        <div class="text-center">
                            <h2 class="mb-3 text-white mt-5" id="accountname">Welcome Back</h2>
                            <h1 class="font-25 mb-3 text-white" id="accountname2">Login To <br /> <?php echo strtoupper($name); ?></h1>
                        </div>

                        <form id="login-form" method="post">
                            <div class="px-2">
                                <div class="user-box" id="usernamediv">
                                    <input type="text" id="username" style="font-size: large;" name="username" placeholder="" required readonly />
                                    <label for="username">Username or Email <em style="color:red;">*</em>
                                    </label>
                                </div>
                                <div class="user-box">
                                    <input type="password" id="password" name="password" placeholder="" required readonly>
                                    <label for="password">Password <em style="color:red;">*</em></label>
                                    <!-- </div> -->
                                </div>
                                <button class="mybt" type="submit" id="submit-btn" style="width: 100%;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    Login
                                </button>
                                <div class="row pt-5 mb-3">
                                    <div class="col-12 text-center font-15">
                                        <a class="text-white" href="../recovery/">Forget Password? Recover It</a>
                                    </div>
                                    <div class="col-12 text-center font-15 mt-2">
                                        <a class="text-white" href="../register/">New User? Create Account</a>
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

    <script type="text/javascript" src="../assets/scripts/custom.js"></script>

    <script type="text/javascript">
        $("document").ready(function() {

            //Save username Number
            checkIfusernameNumberSaved();

            //Enable Form Input
            $("#username").click(function() {
                $(this).removeAttr("readonly");
            });
            $("#password").click(function() {
                $(this).removeAttr("readonly");
            });

            //Registration Form
            $('#login-form').submit(function(e) {
                e.preventDefault()
                $('#submit-btn').removeClass("gradient-highlight");
                document.getElementById("submit-btn").disabled = true;
                // $('#submit-btn').addClass("btn-secondary");
                $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');

                $.ajax({
                    url: '../home/includes/route.php?login',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function(resp) {
                        console.log(resp);
                        if (resp == 0) {
                            $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Pls Wait ...');
                            $('#submit-btn').attr("disabled", "");
                            swal('Alert!!', "Login Succesfull", "success");
                            setTimeout(function() {
                                location.replace('../home/')
                            }, 10)
                        } else if (resp == 1) {
                            swal('Alert!!', "Incorrect Login Details, Please Try Again.", "error");
                        } else if (resp == 2) {
                            swal('Alert!!', "Sorry, Your Account Have Been Blocked. Please Contact Team For Futher Support.", "error");
                        } else {
                            swal('Alert!!', "Unknow Error, Please Contact Team", "error");
                        }
                        let _inner = '<span></span><span></span><span></span><span></span><div style="width: 100%;">Login</div>'
                        $('#submit-btn').html(_inner);
                        document.getElementById("submit-btn").disabled = false;
                    }
                })
            });

        });

        function checkIfusernameNumberSaved() {
            $name = atob(unescape(getCookie("loginName")));
            if ($name != null && $name != "") {
                let msg = '<p class="mb-3"><a href="javascript:showNumber();"><b class="text-white">Change Login Account?</b></a></p>';
                $("#accountname2").after(msg);
                $("#accountname").append(" " + $name + "!");
                $("#usernamediv").hide();
                $("#username").val($name);
            }
        }

        function showNumber() {
            $("#usernamediv").show();
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
    </script>

</body>
</html>