<?php require_once("includes/route.php"); ?>
<?php
include("includes/custom.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="<?php echo $assetsLoc; ?>/img/favicon.png">

  <title><?php echo $title; ?> | Admin Dashboard</title>

  <!--Css Files -->
  <?php include_once("includes/cssFiles.php"); ?>

</head>

<body class="hold-transition skin-blue light-sidebar sidebar-mini">
  <div class="wrapper">

    <!--Header Navigation -->
    <?php include_once("includes/header.php"); ?>

    <!--Page Side Navigation Bar-->
    <?php include_once("includes/sidebar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!--Page Title -->
      <section class="content-header">
        <?php if ($title == "Dashboard") {
          echo '<h1><b>Hi ' . ucwords(AdminController::$adminName) . '</b></h1>';
        } else {
          echo '<h1>' . $title . '</h1>';
        } ?>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"><i class="ti-dashboard"></i></a></li>
          <li class="breadcrumb-item active"><?php echo $title; ?></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <?php echo $msg; ?>
        <?php include($page); ?>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!--Footer -->
    <?php include_once("includes/footer.php"); ?>

  </div>
  <!-- ./wrapper -->


  <!--Javascript Files -->
  <?php include_once("includes/jsFiles.php"); ?>
  <script>
    // ************************************************************************************************
    //  Helpers
    // ************************************************************************************************

    //Editor For Posts
    if ($('#editor') != undefined) {
      $('#editor').summernote({
        minHeight: 300, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true // set focus to editable area after initializing summernote
      });
    }


    //Show That Form Is Been Processed
    $(".form-submit").on("submit", function () {
      $(".btn-submit").addClass("disabled");
      $(".btn-submit").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
    });

    $(".form-submit2").on("submit", function () {
      $(".btn-submit2").addClass("disabled");
      $(".btn-submit2").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
    });


    $(".form-submit3").on("submit", function () {
      $(".btn-submit3").addClass("disabled");
      $(".btn-submit3").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
    });

    $(".form-submit4").on("submit", function () {
      $(".btn-submit4").addClass("disabled");
      $(".btn-submit4").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
    });



    //Validate Password & Confirm Password
    function validateInput() {
      if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        $("#inputDiv").removeClass("has-success");
        $("#inputDiv").addClass("has-danger");
        document.chngpwd.confirmpassword.focus();

      } else {
        $("#inputDiv").removeClass("has-danger");
        $("#inputDiv").addClass("has-success");
      }
    }


    // ************************************************************************************************
    //  System Users
    // ************************************************************************************************

    //Show Hidden Key
    function showKey(key) {
      $("#key" + key).attr("type", "text");
      $("#opt" + key).attr("onclick", "closeKey('" + key + "')");
    }


    //Hide Displayed Key
    function closeKey(key) {
      $("#key" + key).attr("type", "password");
      $("#opt" + key).attr("onclick", "showKey('" + key + "')");
    }

    //Resert User Api Key
    function resetUserApi(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to reset this user Api Key?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?reset-user-api-key", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "API Key Reset Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Reset API Key, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "API Key Not Changed", "error");
        }
      });
    }

    //Delete User Details And Account
    function terminateUserAccount(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this account?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-user-account", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "User Account Deleted Succesfully", "success");
              setTimeout(function () {
                window.location.href = "subscribers";
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Account, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Account Not Deleted", "error");
        }
      });
    }

    function getMerchantByPhone() {
      phone = document.getElementById("merchantPhone").value;
      if (phone === "") {
        swal("Error", "Please Enter A Phone Number", "error");
        return false;
      }
      $.post("includes/route.php?get-merchant-by-phone", {
        phone: phone
      }, function (res) {
        var resp = JSON.parse(res);
        if (resp !== 1 || resp != "1") {
          // console.log(resp);
          if (resp['sRegStatus'] != 0 || resp['sRegStatus'] != "0") {
            console.log(resp);
            swal("Error", "User Account Is Not Activated", "error");
            return false;
          }
          if (resp['sType'] != 2 || resp['sType'] != "2") {
            swal("Error", "User Must Upgrade His Account To Level 2", "error");
            return false;
          }
          document.getElementById("mUsername").value = resp['sUsername'];
          document.getElementById("mEmail").value = resp['sEmail'];
          document.getElementById("sId").setAttribute("value", resp["sId"]);
        } else {
          document.getElementById("mUsername").value = "";
          document.getElementById("mEmail").value = "";
          document.getElementById("sId").setAttribute("value", "");
          swal("Error!", "Account Not Found, Please Try Again Later", "error");
          return false;
        }
      });
    }

    function checkcoin() {
      var checkboxes = document.querySelectorAll('input[name="coins[]"]');
      checkboxes.forEach(function (checkbox) {
        var coinId = checkbox.value;
        var limitDiv = document.getElementById('limit_' + coinId);
        var priceDiv = document.getElementById('price_' + coinId + '_div');

        if (checkbox.checked) {
          limitDiv.style.display = 'block';
          priceDiv.style.display = 'block';
          document.getElementById('limit_' + coinId).querySelector('input').required = true;
          document.getElementById('price_' + coinId + '_div').querySelector('input').required = true;
        } else {
          limitDiv.style.display = 'none';
          priceDiv.style.display = 'none';
          document.getElementById('limit_' + coinId).querySelector('input').required = false;
          document.getElementById('price_' + coinId + '_div').querySelector('input').required = false;
        }
      });
    }
    function terminateMerchant(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this Merchant?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-merchant", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Merchant Account Deleted Succesfully", "success");
              setTimeout(function () {
                window.location.href = "p2p-merchants";
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Account, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Account Not Deleted", "error");
        }
      });
    }
    //Activate/Block Admin User
    function blockUser(id, status) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to change the status of this user?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?block-user", {
            id: id,
            status: status
          }, function (res) {

            if (res == 0) {
              swal("Success", "User Status Updated Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Update User Status, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Status Not Changed)", "error");
        }
      });
    }


    // ************************************************************************************************
    //  Airtime Discount
    // ************************************************************************************************

    //Edit Airtime Discount 
    function editAirtimeDiscount(networkid, network, networktype, buyat, user, agent, vendor) {
      $("#networkid").val(networkid);
      $("#network").val(network);
      $("#networktype").val(networktype);
      $("#buyat").val(buyat);
      $("#userpay").val(user);
      $("#agentpay").val(agent);
      $("#vendorpay").val(vendor);
      $("#editAirtimeDicount").modal("show");
    }

    function editAlphaTopup(alphaid, buying, selling, agent, vendor) {
      $("#alphaid").val(alphaid);
      $("#buying").val(buying);
      $("#selling").val(selling);
      $("#agentp").val(agent);
      $("#vendorp").val(vendor);
      $("#editAlphaTopup").modal("show");
    }

    //Delete Alpha Topup
    function deleteAlphaTopup(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this record",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-alpha-topup", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Alpha Topup Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Alpha Topup, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Alpha Topup Not Deleted)", "error");
        }
      });
    }

    // ************************************************************************************************
    // Data Plan Management
    // ************************************************************************************************

    //Edit Data Plan
    function editDataPlanDetails(plan, network, dataname, datatype, planid, duration, price, userprice, agentprice, vendorprice) {
      $("#plan").val(plan);
      $("#network").val(network);
      $("#datatype").val(datatype);
      $("#planid").val(planid);
      $("#duration").val(duration);
      $("#price").val(price);
      $("#userprice").val(userprice);
      $("#agentprice").val(agentprice);
      $("#vendorprice").val(vendorprice);
      $("#dataname").val(dataname);
      $("#editDataPlan").modal("show");
    }


    //Edit Data Plan
    function editApi(Apiid, name, value, type) {
      $("#apiid").val(Apiid);
      $("#eprovidername").val(name);
      $("#eproviderurl").val(value);
      $("#eservice").val(type);
      $("#editApi").modal("show");
    }

    // Get API from Bilalsadasub and N3data
    function GenerateApi() {
      $("#GenerateApi").modal("show");
    }

    function getApi() {
      var username = document.getElementById("myapiusername").value;
      var password = document.getElementById("myapipassword").value;
      if (username === "" || password === "") {
        $("#GenerateApi").modal("hide");
        swal("Error", "Please Fill All Fields", "error");
        return false;
      }
      Apikey = btoa(username + ":" + password);
      console.log(Apikey);
      document.getElementById("apitokendiv").style.display = "flex";
      document.getElementById("theapitoken").value = Apikey;
    }

    function copyapiToClipboard() {
      url = document.getElementById("theapitoken");
      if (url === "") {
        swal("Error", "No API Key To Copy", "error");
        return false;
      }
      var $temp = $("<input>");
      $("body").append($temp);
      url.select();
      document.execCommand("copy");
      $temp.remove();
      swal("Success!!", "Copied To Clipboard Successfully", "success");
    }
    //Delete Data Plan
    function deleteDataPlan(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this data plan?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-data-plan", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Plan Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Plan, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Plan Not Deleted)", "error");
        }
      });
    }
    // Delete Social Media 
    function deleteMedia(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this Media?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/custom.php?delete-media", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Media Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Media, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "MEDIA Not Deleted :)", "error");
        }
      });
    }

    // Delete Social Media 
    function deleteApi(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this API provider?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-api", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "API Provider Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete API Provider, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "API Provider Not Deleted :)", "error");
        }
      });
    }

    //Edit Data Pin
    function editDataPinDetails(pin, network, dataname, datatype, planid, duration, price, userprice, agentprice, vendorprice) {
      $("#pin").val(pin);
      $("#network").val(network);
      $("#datatype").val(datatype);
      $("#planid").val(planid);
      $("#duration").val(duration);
      $("#price").val(price);
      $("#userprice").val(userprice);
      $("#agentprice").val(agentprice);
      $("#vendorprice").val(vendorprice);
      $("#dataname").val(dataname);
      $("#editDataPlan").modal("show");
    }

    //Delete Data Plan
    function deleteDataPin(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this data pin?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-data-pin", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Data Pin Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Data Pin, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Data Pin Not Deleted)", "error");
        }
      });
    }

    // ************************************************************************************************
    // Cable Plan Management
    // ************************************************************************************************

    //Edit Cable Plan
    function editCablePlanDetails(plan, provider, planname, planid, duration, price, userprice, agentprice, vendorprice) {
      $("#plan").val(plan);
      $("#provider").val(provider);
      $("#planid").val(planid);
      $("#duration").val(duration);
      $("#price").val(price);
      $("#userprice").val(userprice);
      $("#agentprice").val(agentprice);
      $("#vendorprice").val(vendorprice);
      $("#planname").val(planname);
      $("#editCablePlan").modal("show");
    }

    //Delete Cable Plan
    function deleteCablePlan(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this cable subscription plan?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-cable-plan", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Plan Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Plan, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Plan Not Deleted)", "error");
        }
      });
    }

    // ************************************************************************************************
    //  Delete Notification
    // ************************************************************************************************

    function deleteNotification(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this notification?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-notification", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Notification Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Notification, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Notification Not Deleted)", "error");
        }
      });
    }

    // ************************************************************************************************
    //  Messages
    // ************************************************************************************************

    //Delete Contact Message
    function deleteMessage(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this message?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?delete-message", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Message Deleted Succesfully", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Delete Message, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Message Not Deleted)", "error");
        }
      });
    }

    // ************************************************************************************************
    //  Alpha Topup Management
    // ************************************************************************************************

    // ************************************************************************************************
    //  Blockchain & Token Management
    // ************************************************************************************************

    function editBlockchain(id, chain_key, name, rpc_url, explorer_url, native_symbol, chain_id, chain_id_hex, is_active) {
      $("#edit_id").val(id);
      $("#edit_chain_key").val(chain_key);
      $("#edit_name").val(name);
      $("#edit_rpc_url").val(rpc_url);
      $("#edit_explorer_url").val(explorer_url);
      $("#edit_native_symbol").val(native_symbol);
      $("#edit_chain_id").val(chain_id);
      $("#edit_chain_id_hex").val(chain_id_hex);
      $("#edit_is_active").val(is_active);
      $("#editBlockchainModal").modal("show");
    }

    function deleteBlockchain(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this blockchain? This may affect tokens linked to it.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.get("includes/route.php?delete-blockchain", {
            id: id
          }, function (res) {
            var resp = JSON.parse(res);
            if (resp.status == 'success') {
              swal("Success", "Blockchain Deleted Successfully", "success");
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              swal("Error!", resp.msg || "Unable To Delete Blockchain", "error");
            }
          });
        } else {
          swal("Cancelled", "Action Cancelled", "error");
        }
      });
    }

    function editToken(id, name, contract, decimals, chain_id, is_active) {
      $("#edit_token_id").val(id);
      $("#edit_token_name").val(name);
      $("#edit_token_contract").val(contract);
      $("#edit_token_decimals").val(decimals);
      $("#edit_token_chain_id").val(chain_id);
      $("#edit_token_is_active").val(is_active);
      $("#editTokenModal").modal("show");
    }

    function deleteToken(id) {
      swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete this token?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.get("includes/route.php?delete-token", {
            id: id
          }, function (res) {
            var resp = JSON.parse(res);
            if (resp.status == 'success') {
              swal("Success", "Token Deleted Successfully", "success");
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              swal("Error!", resp.msg || "Unable To Delete Token", "error");
            }
          });
        } else {
          swal("Cancelled", "Action Cancelled", "error");
        }
      });
    }

    //Alpha Topup Management
    function confirmAlphaTopupOrder(id) {
      swal({
        title: "Are you sure?",
        text: "You are expected to credit the user before completing this transaction. Are you sure you want to complete this transaction?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      }, function (isConfirm) {
        if (isConfirm) {
          $.post("includes/route.php?complete-alpha-order", {
            id: id
          }, function (res) {

            if (res == 0) {
              swal("Success", "Transaction Succesfully Closed", "success");
              setTimeout(function () {
                $url = window.location.href;
                window.location.href = $url;
              }, 1000);
            } else {
              swal("Error!", "Unable To Complete Transaction, Please Try Again Later", "error");
            }
          });
        } else {
          swal("Cancelled", "Transaction Not Completed)", "error");
        }
      });
    }
  </script>
</body>

</html>