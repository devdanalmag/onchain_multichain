<?php session_start(); if(isset($_SESSION['sysId'])){header("Location:dashboard/");} require_once("dashboard/includes/auto_loader.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <link href="../assets/vendor_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/vendor_components/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/vendor_components/sweetalert/sweetalert.css" rel="stylesheet" />
    <style>
        body{background:linear-gradient(#000099,#3333ff); background-image:url("../assets/img/bg.jpg");   background-position:center center;-webkit-background-size:cover;-moz-background-size:cover;background-size:cover;-o-background-size:cover;background-repeat:no-repeat;background-attachment:fixed}#loginContainerContent{margin-top:10vh;margin-bottom:10px;text-align:left;color:#000;font-weight:600;}.brand_logo_container{padding:10px}.brand_logo{height:150px;width:155px;border-radius:50%;border:2px solid #fff;text-align:center}.position{max-width:500px;height:auto;margin:auto;position:relative}.user_card{background:rgba(255,255,255,.9); padding:30px;  box-shadow:0 4px 8px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19);-webkit-box-shadow:0 4px 8px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19);-moz-box-shadow:0 4px 8px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19);border-radius:30px; color:#000}h3{color:#000;text-align:left;font-weight:600}.loginbtn{border-radius:30px;}
    </style>
</head>

<body >

<div class="container">
<div id="loginContainerContent">
            <div  class="position user_card">
            <div>
                <div align="center" class="brand_logo_container"><img src="../assets/img/lock.gif" alt="Logo" class="brand_logo" /></div>
                <h3 class="text-center">ADMINISTRATOR</h3><hr/>
                <form id="login-form" method="post">
                    <div class="text-center">
                    
                    <div class="form-group mb-3">
                     <input type="text" name="username"  maxlength="20" class="form-control" placeholder="Username" required />
                    </div>
                    
                    <div class="form-group mb-3">
                      <input type="password" name="password" maxlength="15" class="form-control" placeholder="Password" required />
                    </div>
                                            
                    <div class="form-group">            
                        <button class="btn loginbtn btn-primary btn-lg btn-block" type="submit" name="login" id="loginbtn"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>               
                    </div>  
                    </div>
                </form>
    </div>
    </div>
</div>
</div>
<script src="../assets/vendor_components/jquery-3.3.1/jquery-3.3.1.min.js"></script>
<script src="../assets/vendor_components/sweetalert/sweetalert.min.js"></script>
<script>
    $("document").ready(function(){

        //Login Check For Admininstrator
        $('#login-form').submit(function(e){
		e.preventDefault()
		$('#loginbtn').addClass("disabled");
		$('#loginbtn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
		
		$.ajax({
			url:'dashboard/includes/route.php?login',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
                console.log(resp);
				if(resp == 0){
					swal('Alert!!',"Login Succesfull","success");
					setTimeout(function(){
						location.replace('dashboard/')
					},100)
				}else if(resp == 1){
					swal('Alert!!',"Incorrect Username or Password","error");
                    $('#loginbtn').removeClass("disabled");
		            $('#loginbtn').html('<i class="fa fa-sign-in" aria-hidden="true"></i> Login');
				}
                else if(resp == 2){
					swal('Alert!!',"Sorry, Your Account Has Been Blocked, Please Contact Admin","error");
                    $('#loginbtn').removeClass("disabled");
		            $('#loginbtn').html('<i class="fa fa-sign-in" aria-hidden="true"></i> Login');
				}
                else{
					swal('Alert!!',"Unknow Error, Please Contact Admin","error");
                    $('#loginbtn').removeClass("disabled");
		            $('#loginbtn').html('<i class="fa fa-sign-in" aria-hidden="true"></i> Login');
				}
			},
			error:function(resp){
			        console.log(resp);
			        swal('Alert!!',"Server Error, Please Contact Admin","error");
                    $('#loginbtn').removeClass("disabled");
		            $('#loginbtn').html('<i class="fa fa-sign-in" aria-hidden="true"></i> Login');
			}
		})
	})

    });
</script>
</body>

</html>