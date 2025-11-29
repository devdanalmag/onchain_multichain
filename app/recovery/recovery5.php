<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="stylesheet" href="../others/lineawesome/css/line-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
    <link rel="stylesheet" href="../others/css/forgetpassword.css?v=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
    <style type="text/css">#verCon{display: none;} #keyCon{display: none;}</style>
    <style>
        .container-fluid .top{background-color: <?php echo $color; ?> !important;}
        .bottom h2{color: <?php echo $color; ?> !important;}
    </style>

</head>
<body>

       
        
    
    <div class="container-fluid">
        <div class="top">
            <!-- <img src="../others/img/Live-Background.svg" alt=""> -->
                <h1>Forget Password</h1>
        </div>
       
           
            
            <div class="bottom">
                <h2><?php echo strtoupper($name); ?></h2>
                <p id="msgcon">Please Enter the email account associated with your account and we'll send you the reset instructions!</p>

                <form id="emailCon" method="post">
                    
                    <div class="form-group">
                        <i class="la la-at"></i> &nbsp &nbsp
                        <label for="">Email</label> <br>
                        <input type="email" name="email" id="email" class="form-control"  placeholder="Enter your email" required>
                    </div> 
      
                    <div class="form-group" >
                       <button class="btn btn-primary" id="submit-btn" type="submit"><b>Recover</b></button>
                    </div>
                    
                </form>

                <form id="verCon" method="post">
                    
                    <div class="form-group">
                        <input type="hidden" name="email" id="veremail" />
                        <input type="number" id="vercode" name="code" class="form-control"  placeholder="Code" required>
                    </div> 
      
                    <div class="form-group" >
                       <button class="btn btn-primary" type="submit" id="submit-btn2"><b>Continue</b></button>
                    </div>

                </form>

                <form name="chngpwd" id="keyCon">
                    
                    <div class="form-group">
                        <i class="la la-lock"></i> &nbsp &nbsp
                        <label for="">New Password</label> <br>
                        <input type="password" id="password" name="password"class="form-control"  placeholder="Enter Password" required>
                    </div> 

                    <div class="form-group">
                        <i class="la la-lock"></i> &nbsp &nbsp
                        <label for="">Confirm Password</label> <br>
                        <input type="password" id="password2" name="password2"  class="form-control"  placeholder="Confirm Password" required>
                    </div>

                    <input type="hidden" id="keyemail" name="email" />
		            <input type="hidden" id="keycode" name="code" />
      
                    <div class="form-group" >
                       <button class="btn btn-primary" type="submit" id="submit-btn3"><b>Update Password</b></button>
                    </div>


                </form>

                <footer class="mt-3">
                <h5>Already Have an Account?  &nbsp <a href="../login/">Login Now</a></h5>
                <h5>Don't Have An Account, <a href="../register/">Create Account</a></h5>

            </footer>
            </div>

            

    </div>
    
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $("document").ready(function(){
    //Enable Form Input
    $("#email").click(function(){$(this).removeAttr("readonly"); });
    $("#password").click(function(){$(this).removeAttr("readonly"); });
    $("#password2").click(function(){$(this).removeAttr("readonly"); });

    

    //Check If Email Exist And Send Verification Code
    $('#emailCon').submit(function(e){
            e.preventDefault()
            $('#submit-btn').removeClass("btn-primary");
            $('#submit-btn').addClass("btn-secondary");
            $('#submit-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?get-user-code',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"A Verification Code Have Been Sent To Your Email Address, Please Check And Provide The Code To Continue.","success");
                        $("#emailCon").hide();
			            $("#verCon").show();
                        $("#veremail").val($("#email").val());
                    }else if(resp == 1){
                        swal('Alert!!',"Email Not Found, Please Verify Your Email And Try Again.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                $('#submit-btn').removeClass("btn-secondary");
                $('#submit-btn').addClass("btn-primary");
                $('#submit-btn').html("Recover Password");

                }
            })
        });

        //Verify Email Code And Allow Password Update
        $('#verCon').submit(function(e){
            e.preventDefault()
            $('#submit-btn2').removeClass("btn-primary");
            $('#submit-btn2').addClass("btn-secondary");
            $('#submit-btn2').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?verify-user-code',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"Code Verified, Please Enter Your New Password Below.","success");
                        $("#emailCon").hide();
                        $("#verCon").hide();
                        $("#keyCon").show();
                        $("#keyemail").val($("#email").val());
			            $("#keycode").val($("#vercode").val());
                    }else if(resp == 1){
                        swal('Alert!!',"Incorrect Code Provided, Please Verify Details And Try Again.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                $('#submit-btn2').removeClass("btn-secondary");
                $('#submit-btn2').addClass("btn-primary");
                $('#submit-btn2').html("Verify Code");

                }
            })
        });

        //Update User Password``````````
        $('#keyCon').submit(function(e){
            e.preventDefault()
            
            //Validate Password
            $msg=""; 
            if($("#password").val() != $("#password2").val()){$msg="New Password & Retyped Password Don't Match.";}
            if($("#password").val().length > 15){$msg="Password should not be more than 15 character.";}
            if($("#password").val().length < 8){$msg="Password should be at least 8 character.";}

            if($msg != ""){swal("Alert!!",$msg,"info");  $msg=""; return; }

            $('#submit-btn2').removeClass("btn-primary");
            $('#submit-btn2').addClass("btn-secondary");
            $('#submit-btn2').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
            $.ajax({
                url:'../home/includes/route.php?update-user-pass',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    console.log(resp);
                    if(resp == 0){
                        swal('Alert!!',"Password Updated Successfully, You Can Now Login With Your Details.","success");
                        $("#verCon").hide();
                        $("#keyCon").hide();
                        $("#emailCon").show();
                        $("#emailCon")[0].reset();
                        $("#keyCon")[0].reset();
                        $("#verCon")[0].reset();
                    }else if(resp == 1){
                        swal('Alert!!',"Unable To Update Password, Please Try Again Later.","error");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support.","error");
                    }

                $('#submit-btn2').removeClass("btn-secondary");
                $('#submit-btn2').addClass("btn-primary");
                $('#submit-btn2').html("Verify Code");

                }
            })
        });

    });
    
   
	



</script>
</body>
</html>
