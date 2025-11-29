<!DOCTYPE html>
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
        :root {
            --primary: #4285F4;
            --primary-light: #E8F0FE;
            --text: #3C4043;
            --text-light: #5F6368;
            --border: #abaeb6;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 6px 16px rgba(66, 133, 244, 0.2);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        body {
            background-color: #F8FAFD;
            color: var(--text);
            display: flex;
            min-height: 100vh;
            perspective: 1000px;
        }

        .login-container {
            display: flex;
            width: 90%;
            max-width: 900px;
            margin: auto;
            background: rgba(216, 216, 216, 0.793);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transform-style: preserve-3d;
            transition: var(--transition);
        }

        .login-container:hover {
            transform: translateY(-5px) rotateX(1deg);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .illustration {
            flex: 1;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(66, 133, 244, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            transform: translateZ(-50px);
        }

        .illustration img {
            max-width: 100%;
            height: auto;
            transform: translateZ(20px);
            transition: var(--transition);
        }

        .illustration:hover img {
            transform: translateZ(40px) scale(1.05);
        }

        .login-form {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transform-style: preserve-3d;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 40px;
            transform: translateZ(30px);
        }

        .logo {
            height: 40px;
            transition: var(--transition);
        }

        .logo:hover {
            transform: translateZ(10px) scale(1.05);
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
            text-align: center;
            transform: translateZ(25px);
        }

        .subtitle {
            color: var(--text-light);
            margin-bottom: 32px;
            font-size: 16px;
            text-align: center;
            transform: translateZ(20px);
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
            transform-style: preserve-3d;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-light);
            transform: translateZ(15px);
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 16px;
            transition: var(--transition);
            background: white;
            transform-style: preserve-3d;
            transform: translateZ(0);
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
            transform: translateZ(10px);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 8px;
            transform-style: preserve-3d;
            transform: translateZ(0);
        }

        .btn:hover {
            background: #3367D6;
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px) translateZ(15px);
        }

        .btn:active {
            transform: translateY(0) translateZ(5px);
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 16px;
            transform: translateZ(15px);
        }

        .link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
            transform: translateZ(0);
        }

        .link:hover {
            text-decoration: underline;
            transform: translateZ(5px);
        }

        /* 4D Effects */
        .form-group::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
            z-index: -1;
        }

        .form-group:focus-within::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                perspective: 500px;
            }

            .login-container {
                flex-direction: column;
                width: 95%;
                margin: 20px auto;
            }

            .illustration {
                padding: 30px 20px;
                display: none;
                /* Hide illustration on mobile */
            }

            .login-form {
                padding: 40px 30px;
            }

            .logo-container {
                margin-bottom: 30px;
            }

            .logo {
                height: 36px;
            }

            h1 {
                font-size: 24px;
            }

            /* Reduced 3D effects on mobile for performance */
            .login-container:hover {
                transform: translateY(-3px);
            }

            input:focus {
                transform: translateZ(5px);
            }

            .btn:hover {
                transform: translateY(-2px) translateZ(5px);
            }
        }

        @media (max-width: 480px) {
            .login-form {
                padding: 30px 20px;
            }

            .links {
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="illustration">
            <!-- Illustration of people collaborating -->
            <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="People collaborating">
        </div>
        <div class="login-form">
            <div class="logo-container">
                <img src="https://via.placeholder.com/150x40/4285F4/FFFFFF?text=AppLogo" alt="App Logo" class="logo">
            </div>

            <div class="text-center">
                <h2 class="mb-3 mt-5" id="accountname">Welcome Back</h2>
                <h1 class="font-25 mb-3 subtitle" id="accountname2">Login To <br /> <?php echo strtoupper($name); ?></h1>
            </div>

            <form id="login-form" method="post">
                <div class="form-group" id="usernamediv">
                    <label for="username">Username</label>
                    <input type="username" id="username" placeholder="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password <em style="color:red;">*</em></label>
                    <input type="password" id="password" name="password" placeholder="" required readonly>
                </div>

                <button  type="submit" id="submit-btn" class="btn">Login</button>

                <div class="links">
                    <a href="#" class="link">Forgot Password?</a>
                    <a href="#" class="link">Create Account</a>
                </div>
            </form>
        </div>
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