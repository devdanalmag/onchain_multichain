<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css"> 
    <link rel="stylesheet" href="../others/lineawesome/css/line-awesome.min.css"> 
    <link rel="stylesheet" href="../others/css/register.css?v=1.0.0">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
    <style>
        .container-fluid .top{background-color: <?php echo $color; ?> !important;}
        .bottom h2{color: <?php echo $color; ?> !important;}
    </style>
</head>
<body>

       
        
    
    <div class="container-fluid">
        <div class="top">
            <!-- <img src="./img/Live-Background.svg" alt=""> -->
                <h1>Register</h1>
        </div>
       
           
            
            <div class="bottom">
                <h2><?php echo strtoupper($name); ?></h2>
                <p>Hello there, register to access all our services!</p>

                <form id="reg-form" method="post">
                    <div id="regDiv">
                        <div class="form-group">
                            <i class="la la-user"></i> &nbsp &nbsp
                            <label for="">First Name</label> <br>
                            <input type="text" name="fname" id="fname" class="form-control"  placeholder="First Name" required>
                        </div> 

                        <div class="form-group">
                            <i class="la la-user"></i> &nbsp &nbsp
                            <label for="">Last Name</label> <br>
                            <input type="text" name="lname" id="lname" class="form-control"  placeholder="Last Name" required>
                        </div> 
                    
                        <div class="form-group">
                            <i class="la la-phone"></i> &nbsp &nbsp
                            <label for="">Phone</label> <br>
                            <input type="number" name="phone" id="phone" class="form-control"  placeholder="Phone Number" readonly required>
                        </div> 
                        <div class="form-group">
                            <i class="la la-at"></i> &nbsp &nbsp
                            <label for="">Email</label> <br>
                            <input type="email" name="email" id="email" class="form-control"  placeholder="Email" readonly required>
                        </div>
                        
                        <div class="form-group">
                            <i class="la la-map"></i> &nbsp &nbsp
                            <label for="">State</label> <br>
                            <select class="form-control" id="state" name="state" required  >
                                <option value="" selected disabled>Seleect State</option>
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
                        </div>

                        <input id="account" name="account" type="hidden" value="1" />
        
                        <div class="form-group" >
                        <button class="btn btn-primary" id="next-btn" >Continue</button>
                        </div>
                    </div>

                    <div id="nextregDiv" style="display:none;">
                        <div class="form-group">
                            <i class="la la-lock"></i> &nbsp &nbsp
                            <label for="">Password</label> <br>
                            <input type="password" name="password" id="password" class="form-control"  placeholder="Password" readonly required />
                        </div> 
                        <div class="form-group">
                            <i class="la la-lock"></i> &nbsp &nbsp
                            <label for="">Confirm password</label> <br>
                            <input type="password" name="cpassword" id="cpassword" class="form-control"  placeholder="Confirm Password" readonly required>
                        </div>
                        <div class="form-group">
                            <i class="la la-user"></i> &nbsp &nbsp
                            <label for="">Transaction Pin</label> <br>
                            <input type="number" name="transpin" class="form-control"  placeholder="Transaction Pin" required>
                        </div>  
                        <div class="form-group">
                            <i class="la la-user-plus"></i> &nbsp &nbsp
                            <label for="">Refferal</label> <br>
                            <input type="number" name="referal" value="<?php if(isset($_GET["referral"])): echo $_GET["referral"]; endif; ?>"  class="form-control"  placeholder="who reffered you?" >
                        </div> 
        
                        <div class="form-group" >
                        <button class="btn btn-primary" type="submit" id="submit-btn">Register</button>
                        </div>
                    </div>


                </form>

                <footer class="mt-3">
                    <h5>Already Have an Account? <a href="../login/">Login</a></h5>
                    <p class="mt-2">
                        <a class="text-dark"<b>Licensed By Almag Tech</b></a>
                    </p>
                </footer>
            </div>

    </div>
    
    


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/scripts/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
        
        $('#next-btn').removeClass("btn-primary");
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
            $('#next-btn').addClass("btn-primary");
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
            
            $('#submit-btn').removeClass("btn-primary");
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
                   $('#submit-btn').addClass("btn-primary");
                   $('#submit-btn').html("Register");

                   $('#next-btn').removeClass("btn-secondary");
                   $('#next-btn').addClass("btn-primary");
                   $('#next-btn').html("Register");

                }
            })
        });
});
</script>

</body>
</html>
