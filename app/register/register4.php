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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">    
<link rel="manifest" href="../assets/scripts/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
<link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
<style>
    #lga option{color:#000000 !important;}
    #ward option{color:#000000 !important;}
</style>
<style>
    body{background-image:url("../../assets/img/bg.jpg");  background-repeat: no-repeat; background-size: cover;}
    .card{background: transparent; margin:20px;}
    .form-control{
        background-color: #fafafa !important; 
        border-radius: 5rem !important;
        padding-left: 50px !important;
    }

    .form-control:focus{
        background-color: #ffffff !important; 
    }

    .input-style i{
        padding-left: 20px !important;
    }
    .btn{
        border-radius: 5rem !important;
    }
</style>
</head>
    
<body class="theme-light">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
    
    
    <div class="page-content mt-3">
        
    <div style="display:flex; justify-content:center; align-content:center;">
    <div class="card card-style" style="min-width:450px; padding:20px;">
            <div class="content">

                
                <div class="text-center">
                    <h1 class="font-30 mb-3 mt-3 text-white">Register</h1>
                    <p class="mb-3 text-white">Enter your credentials below to create a free account</p>
                
                </div>
                
                <form id="reg-form" method="post">
                <div class="px-2">
                    <div id="regDiv">
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-user"></i>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required />
                        <label for="name" class="color-highlight">First Name</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-user"></i>
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required />
                        <label for="name" class="color-highlight">Last Name</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-phone"></i>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" required readonly />
                        <label for="phone" class="color-highlight">Phone Number</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-at"></i>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" readonly />
                        <label for="email" class="color-highlight">Email</label>
                        <em>(required)</em>
                    </div>

                    <input id="account" name="account" type="hidden" value="1" />
                    
                    <a id="next-btn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Continue
                    </a>
                    
                    </div>

                    <div id="nextregDiv" style="display:none;">
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-map"></i>
                        <select class="form-control" id="state" name="state" required  >
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
                        <em>(required)</em>
                    </div>
                    
                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required readonly/>
                        <label for="password" class="color-highlight">Password</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required readonly/>
                        <label for="cpassword" class="color-highlight">Confirm Password</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-lock"></i>
                        <input type="number" class="form-control" id="transpin" name="transpin" placeholder="Pin" required />
                        <label for="transpin" class="color-highlight">Transaction Pin</label>
                        <em>(required)</em>
                    </div>

                    <div class="input-style  no-borders has-icon mb-4">
                        <i class="fa fa-user-plus"></i>
                        <input type="number" value="<?php if(isset($_GET["referral"])): echo $_GET["referral"]; endif; ?>" class="form-control" id="referal" name="referal" placeholder="Referal" />
                        <label for="referal" class="color-highlight">Referral</label>
                        <em>(required)</em>
                    </div>
                    
                    <button type="submit" id="submit-btn" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Register
                    </button>

                    </div>

                    
                    
                    <div class="row pt-3 mb-3">
                        <div class="col-12 text-center font-15 mt-2">
                            <a class="text-white" href="../login/">Already Have An Account, <b>Login Now</b></a>
                        </div>
                    </div>

                    <div class="col-12 text-center font-15 mt-3">
                            <a class="text-white"<b>Licensed By Almag Tech</b></a>
                    </div>

                </div>
                </form>
                
            </div>
        </div>
        </div>
        
             
        
    </div>
    <!-- Page content ends here-->
    
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="../assets/scripts/custom.js"></script>

<script type="text/javascript">
$("document").ready(function(){

    //Enable Form Input
    $("#email").click(function(){$(this).removeAttr("readonly"); });
    $("#phone").click(function(){$(this).removeAttr("readonly"); });
    $("#password").click(function(){$(this).removeAttr("readonly"); });
    $("#cpassword").click(function(){$(this).removeAttr("readonly"); });

    //Next Btn
    $("#next-btn").click(function(){
        
        $msg="";
        
        $('#next-btn').removeClass("gradient-highlight");
        $('#next-btn').addClass("btn-secondary");
        $('#next-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
        
        if($("#account").val() == "" || $("#account").val() == " "){$msg="Please Select Account Type.";}
        if($("#email").val() == "" || $("#email").val() == " "){$msg="Please Enter Email.";}
        if($("#phone").val() == "" || $("#phone").val() == " "){$msg="Please Enter Phone Number.";}
        if($("#lname").val() == "" || $("#lname").val() == " "){$msg="Please Enter Last Name.";}
        if($("#fname").val() == "" || $("#fname").val() == " "){$msg="Please Enter First Name.";}
        
        
        

        if($msg != ""){
            
            swal("Alert!!",$msg,"info");

            $('#next-btn').removeClass("btn-secondary");
            $('#next-btn').addClass("gradient-highlight");
            $('#next-btn').html("Continue");
            
            return;
        }

        $("#regDiv").hide();
        $("#nextregDiv").show();

    });


    //Registration Form
    $('#reg-form').submit(function(e){
            e.preventDefault();
            $msg=""; 
            if($("#password").val().length > 15){$msg="Password should not be more than 15 character.";}
            if($("#password").val().length < 8){$msg="Password should be at least 8 character.";}
            if($("#password").val() == $("#phone").val()){$msg="You can't use your phone number as password.";}
            if($("#password").val() == "" || $("#password").val() == " "){$msg="Please Enter Password.";}
            if($("#state").val() == "" || $("#state").val() == " "){$msg="Please Select State.";}
            if(($("#password").val()) != ($("#cpassword").val())){$msg="Password Is Different From Confirm Password.";}
            


            if($msg != ""){swal("Alert!!",$msg,"info");  $msg=""; return; }
            
            $('#submit-btn').removeClass("gradient-highlight");
            $('#submit-btn').addClass("btn-secondary");
            $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?register',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"Registration Succesfull","success");
                        setTimeout(function(){
                            location.replace('../home/')
                        },1000)
                    }else if(resp == 1){
                        swal('Alert!!',"Email & Phone Number Already Exist.","error");
                        $("#nextregDiv").hide(); $("#regDiv").show();
                    }
                    else if(resp == 2){
                        swal('Alert!!',"Email Already Exist.","error");
                        $("#nextregDiv").hide(); $("#regDiv").show();
                   }
                    else if(resp == 3){
                        swal('Alert!!',"Phone Number Already Exist.","error");
                        $("#nextregDiv").hide(); $("#regDiv").show();
                   }
                   else{
                        swal('Alert!!',"Unknow Error, Please Contact Admin","error");
                   }

                   $('#submit-btn').removeClass("btn-secondary");
                   $('#submit-btn').addClass("gradient-highlight");
                   $('#submit-btn').html("Register");

                   $('#next-btn').removeClass("btn-secondary");
                   $('#next-btn').addClass("gradient-highlight");
                   $('#next-btn').html("Register");

                }
            })
        });
});
</script>

</body>
</html>
