<?php

require_once("includes/route.php");
if (!isset($_SESSION['acces_allowed']) || $_SESSION['acces_allowed'] != true) {
  // If the session variable 'allowed' is not set or is not true, redirect to the login page
  // header("Location:access.php");
  require_once("access.php");
  // echo "<script>window.location.href='access.php';</script>";
  exit();
}
?>
<?php
define("HOME_IMAGE_LOC", "../../assets/home-img");
require_once("includes/custom.php");

?>
<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/img/favicon.png">
  <link rel="stylesheet" type="text/css" href="../assets/scripts/sweetalert/sweetalert.css">
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png" />
  <title><?php echo $title; ?></title>
  <?php include_once("includes/cssFiles.php"); ?>
  <style>
    .bt-hovering:hover {
      color: white;
    }

    .input-image {
      /* position: fixed; */
      /* right: 31px; */
      /* top: 32.5%; */
      /* transform: translateY(-50%); */
      width: 70px;
      height: 60px;
      margin-bottom: -2%;
    }

    .tonconnectdiv {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 7px;
    }

    .btn {
      /* color: white !important; */
      /* background-image: linear-gradient(to bottom, #5D9CEC, #4A89DC) !important; */
      font-weight: bold !important;
      font-family: Arial, Helvetica, sans-serif !important;
    }


    /* * {
      box-sizing: border-box;
    } */

    /* *:before,
    *:after {
      content: "";
      position: absolute;
    } */

    .notification {
      left: -7px !important;
    }

    .pricetopay {
      color: rgb(21, 136, 251);
      margin-left: 10%;
    }

    .pricetopay em {
      opacity: 80%;
      font-size: 12px;
      font-weight: bold;
    }

    .mya {
      display: grid;
      grid-template-rows: 1fr min-content;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      background-image: linear-gradient(to bottom, #5D9CEC, #4A89DC) !important;
      background: transparent;
      color: #fff;
      /* border: 3px solid; */
      border-radius: 50px;
      padding: 0.8rem 1rem;
      font: 20px "Margarine", sans-serif;
      outline: none;
      cursor: pointer;
      position: relative;
      transition: 0.2s ease-in-out;
      letter-spacing: 1px;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .mya:hover {
      background-image: linear-gradient(to bottom, #4A89DC, #5D9CEC) !important;
      color: #fff;
    }

    .button__wrapper {
      display: inline-block;
      position: relative;
      width: 200px;
      height: 55px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .button-pulse a {
      background: var(--bg-color);
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 2;
    }

    .button-pulse .button__wrapper:hover .pulsing:before {
      animation: pulsing 0.2s linear infinite;
    }

    .button-pulse .button__wrapper:hover .pulsing:after {
      animation: pulsing1 0.2s linear infinite;
    }

    .pulsing {
      width: 99%;
      height: 99%;
      border-radius: 50px;
      z-index: 1;
      position: relative;

    }

    .pulsing:before,
    .pulsing:after {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      border: inherit;
      top: 0;
      left: 0;
      z-index: 0;
      background: #fff;
      border-radius: inherit;
      animation: pulsing 2s linear infinite;
    }

    .pulsing:after {
      content: "";
      position: absolute;
      animation: pulsing1 2s linear infinite;
    }



    @keyframes pulsing {
      0% {
        background-color: rgba(93, 168, 229, 0.62);
        opacity: 1;
        transform: scaleY(1) scaleX(1);
      }

      20% {
        opacity: 0.5;
      }

      70% {
        opacity: 0.2;
        transform: scaleY(1.8) scaleX(1.4);
      }

      80% {
        opacity: 0;
        transform: scaleY(1.8) scaleX(1.4);
      }

      90% {
        opacity: 0;
        transform: scaleY(1) scaleX(1);
      }
    }

    @keyframes pulsing1 {
      0% {
        background-color: rgba(93, 168, 229, 0.62);
        opacity: 1;
        transform: scaleY(1) scaleX(1);
      }

      20% {
        opacity: 0.5;
      }

      70% {
        opacity: 0.2;
        transform: scaleY(1.3) scaleX(1.15);
      }

      80% {
        opacity: 0;
        transform: scaleY(1.3) scaleX(1.15);
      }

      90% {
        opacity: 0;
        transform: scaleY(1) scaleX(1);
      }
    }

    @media (prefers-color-scheme: dark) {
      body {
        background-color: #121212;
        color: white;
      }

      /* More overrides here... */
    }
  </style>
</head>

<body class="theme-light">

  <?php if ($title <> "Print Data Pin"): ?>
    <div id="preloader">
      <div class="spinner-border color-highlight" role="status"></div>
    </div>
  <?php endif; ?>

  <div id="page">
    <div class="page d-flex">
      <div class="content w-full">
        <?php if ($title <> "Print Data Pin"): ?>
          <div class="head header-fixed p-10 between-flex">
            <div class="p-relative">
              <?php if ($title == "Homepage") { ?>
                <a href="#" class="font-17 header-icon header-icon-1"><i class="fas fa-home"></i></a>
              <?php } else { ?>
                <a href="#" data-back-button class="font-17 header-icon header-icon-1"><i
                    class="fas fa-chevron-left"></i></a>
              <?php } ?>
            </div>
            <!-- <div class="p-relative"> -->
            <!-- <a href="post-job" type="button"
                            class="btn p-10 bg-blue c-white w-fit btn-shape btn-bold bt-hovering"
                            style="width: 30%; padding: 1.2%; font-size: medium;"> Post
                            Job</a> -->

            <div class="button__wrapper button-pulse">
              <div class="pulsing">
                <a href="p2p" class="mya" type="button">
                  P2P Exchange</a>
              </div>
            </div>
            <div class="icons d-flex align-center">
              <a href="notifications" class="font-17 header-icon header-icon-4"><i class="fas fa-envelope"></i><span
                  class="badge bg-red-dark">1</span></a>
            </div>
          </div>
          <!-- Page Nav Title Header -->
          <!-- <div class="header header-fixed header-logo-center">
            <a href="./" class="header-title"><?php echo $sitename; ?></a>

            <a href="notifications" class="font-17 header-icon header-icon-4"><i class="fas fa-envelope"></i><span class="badge bg-red-dark">1</span></a>
            <a href="#" data-toggle-theme class="font-17 header-icon header-icon-3 show-on-theme-dark"><i class="fas fa-sun"></i></a>
            <a href="#" data-toggle-theme class="font-17 header-icon header-icon-3 show-on-theme-light"><i class="fas fa-moon"></i></a>
        </div> -->

          <!-- Page Footer -->
          <?php
          include_once("includes/footer.php");
          ?>
        <?php endif; ?>



        <!-- Page content start here-->
        <?php
        if (Scustom::checkpage($page) == 'online') {
          include($page);
        } else {
          $reason = Scustom::checkpage($page);
          if (Scustom::checkpage($page) == 'atwork') {
            $reason = 'Under Maitenance';
          }
          if (Scustom::checkpage($page) == 'notfound') {
            $reason = 'No Longer Available';
          }
        ?>
          <div class="page-content header-clear-medium">
            <div class="card card-style">
              <div class="content">
                <h1 class="text-center">Sorry This Page Is <?php echo $reason; ?> </h1>
                <h5 class="text-center"><a href="./">Back Home</a></h5>
                <em class="text-center">Note: we will notify you soon when the page is back</em>
              </div>
            </div>
          </div><?php
              }
                ?>
        <!-- Page content ends here-->
      </div>
    </div>
    <!-- Notification Message -->
    <?php echo $msg; ?>

    <!-- Notification Message -->

    <!-- Models -->

    <button id="continue-transaction-prompt-btn" data-menu="continue-transaction-prompt" class="d-none"></button>
    <button id="continue-transaction-in-wallet-prompt-btn" data-menu="continue-transaction-in-wallet-prompt" class="d-none"></button>
    <button id="p2p-prompt-btn" data-menu="p2p-prompt" class="d-none"></button>

    <!-- Verify transaction Prompt Model -->
    <div id="continue-transaction-prompt" class="menu menu-box-modal rounded-m" data-menu-height="350"
      data-menu-width="300">
      <h1 class="text-center mt-4"><i
          class="fa fa-3x fa-info-circle scale-box color-blue-dark shadow-xl rounded-circle"></i></h1>
      <h3 class="text-center mt-3 font-700">Are you sure?</h3>
      <p class="boxed-text-xl" id="continue-transaction-prompt-msg"></p>
      <div class="row mb-0 me-3 ms-3">
        <div class="col-6">
          <a href="#"
            class="btn close-menu btn-full btn-m color-red-dark border-red-dark font-600 rounded-s">No</a>
        </div>
        <div class="col-6">
          <?php if ($pinstatus == 0): ?>
            <a href="#" data-menu="pin-modal"
              class="btn btn-full btn-m color-green-dark border-green-dark font-600 rounded-s">Yes</a>
          <?php else: ?>
            <!-- <a href="#" onclick="$('#thetranspin').val(5); $('#transpinbtn').click();" -->
            <a href="#" onclick="Sendtransaction();"
              class="btn btn-full btn-m color-green-dark border-green-dark font-600 rounded-s">Yes</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- P2P Prompt Model -->
    <div id="p2p-prompt" class="menu menu-box-modal rounded-m" data-menu-height="300"
      data-menu-width="350" style="overflow: auto;">
      <h1 class="text-center mt-4"><i
          class="fa fa-3x fa-whatsapp scale-box color-green-dark shadow-xl rounded-circle"></i></h1>
      <h3 class="text-center mt-3 font-700"></h3>
      <p class="boxed-text-xl" id="p2p-prompt-msg"></p>
      <div class="row mb-0 me-3 ms-3 justify-content-center">
        <div class="col-6 mb-3 text-center">
          <a href="#" data-menu="p2p-prompt"
            class="btn close-menu btn-full btn-m color-blue-light border-blue-light font-600 rounded-s">
            Live Chat <i class="fa fa-clock-o fa-lg"></i> <em>(Soon)</em>
          </a>
        </div>
        <div class="col-6 text-center">
          <a id="w-contact-btn" target="_blank"
            class="btn btn-full btn-m color-green-dark border-green-dark font-600 rounded-s">
            WhatsApp Chat <i class="fa fa-whatsapp fa-lg"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Contineu transaction in you Wallet Prompt Model -->
    <div id="continue-transaction-in-wallet-prompt" class="menu menu-box-modal rounded-m" data-menu-height="200"
      data-menu-width="400" style="display: none;">
      <br>
      <h3 class="text-center mt-3 font-700" id="continue-transaction-in-wallet-prompt-text">Continue In Your Wallet</h3>
      <h1 class="text-center mt-4"><i
          class="fa fa-3x fa-spinner fa-spin" aria-hidden="true"></i></h1>
      <a href="#" id="myautoclick"></a>
    </div>

    <!-- Confirm Trasaction Pin Model -->
    <div id="pin-modal" class="menu menu-box-modal rounded-m bg-theme" data-menu-width="300" data-menu-height="350">
      <div class="menu-title">
        <p class="color-highlight">Confirm Transaction </p>
        <h1 class="font-800">Continue?</h1>
        <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
      </div>

      <div class="content">
        <div class="divider mt-n2"></div>

        <div class="row mb-0">
          <div class="col-12">
            <div class="input-style input-style-always-active has-borders mb-4">
              <label for="form1" class="color-highlight">Transaction Pin</label>
              <input type="number" id="thetranspin" maxlength="4" class="form-control" placeholder="1234"
                required>
            </div>
          </div>
        </div>
        <button action-btn="" id="transpinbtn" style="width:100%"
          class="close-menu btn btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-s">Continue</button>
      </div>
    </div>

    <!-- Agent Account Upgrade Model -->
    <div id="agent-upgrade-modal" class="menu menu-box-modal rounded-m bg-theme" data-menu-width="300"
      data-menu-height="450">
      <div class="menu-title">
        <p class="color-highlight">Confirm Transaction </p>
        <h1 class="font-800">Upgrade</h1>
        <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
      </div>

      <div class="content">
        <div class="divider mt-n2"></div>
        <div id="agent-upgrade-msg" class="text-danger mb-3">
          You are about to upgrade to an Agent Account.
          You can view our pricing page for details about the discounts available for Agents.
          <br /> You would be charged a total of
          N<?php echo (is_object($data3)) ? $data3->agentupgrade : "0"; ?> for this service.
          <?php if ($pinstatus == 0) {
            echo "To continue, enter your transaction pin below.";
          } ?>
        </div>
        <form action="./" method="POST">
          <div class="row mb-0">
            <?php if ($pinstatus == 0): ?>
              <div class="col-12">
                <div class="input-style input-style-always-active has-borders mb-4">
                  <input type="password" name="kpin" maxlength="4" class="form-control" placeholder="1234"
                    required>
                  <label for="form1" class="color-highlight">Transaction Pin</label>
                </div>
              </div>
            <?php else: ?>
              <input type="hidden" name="kpin" value="0000" />
            <?php endif; ?>
          </div>
          <button type="submit" name="upgrade-to-agent" id="agent-upgrade-btn" style="width:100%"
            class="btn btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-s">Continue</button>
        </form>
      </div>
    </div>

    <!-- Vendor Account Upgrade Model -->
    <div id="vendor-upgrade-modal" class="menu menu-box-modal rounded-m bg-theme" data-menu-width="300"
      data-menu-height="450">
      <div class="menu-title">
        <p class="color-highlight">Confirm Transaction </p>
        <h1 class="font-800">Enter Pin</h1>
        <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
      </div>

      <div class="content">
        <div class="divider mt-n2"></div>
        <div id="vendor-upgrade-msg" class="text-danger mb-3">
          You are about to upgrade to a Vendor Account.
          You can view our pricing page for details about the discounts available for Vendors.
          <br /> You would be charged a total of
          N<?php echo (is_object($data3)) ? $data3->vendorupgrade : "0"; ?> for this service.
          To continue, enter your transaction pin below.
        </div>
        <form action="./" method="POST">
          <div class="row mb-0">
            <div class="col-12">
              <div class="input-style input-style-always-active has-borders mb-4">
                <input type="password" name="kpin" maxlength="4" class="form-control" placeholder="1234"
                  required>
                <label for="form1" class="color-highlight">Transaction Pin</label>
              </div>
            </div>
          </div>
          <button type="submit" name="upgrade-to-vendor" id="vendor-upgrade-btn" style="width:100%"
            class="btn btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-s">Continue</button>
        </form>
      </div>
    </div>





    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-width="280" data-menu-active="nav-pages">
      <?php include("../menu/menu-main.php"); ?>
    </div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="../menu/menu-share.php"
      data-menu-height="370"></div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="../menu/menu-colors.php"
      data-menu-height="480"></div>


  </div>

  <!-- Remove or comment out the network-blocking script below if you want all JS/CSS/icons to work properly -->
  <!--
  <script>
    // Save original functions
    const originalFetch = window.fetch;
    const originalXHR = window.XMLHttpRequest;
    const originalWebSocket = window.WebSocket;

    // Block fetch
    window.fetch = () => {
      console.warn("Fetch blocked temporarily");
      return Promise.reject("Network requests blocked for 5 seconds");
    };

    // Block XMLHttpRequest (XHR)
    window.XMLHttpRequest = function() {
      console.warn("XHR blocked temporarily");
      return {
        open: () => {},
        send: () => {},
        abort: () => {},
        addEventListener: () => {}
      };
    };

    // Block WebSocket
    window.WebSocket = function() {
      console.warn("WebSocket blocked temporarily");
      return {
        close: () => {},
        send: () => {},
        addEventListener: () => {}
      };
    };

    // Restore original functions after 5 seconds
    setTimeout(() => {
      window.fetch = () => {
        return originalFetch.apply(this, arguments);
      };
      window.fetch = originalFetch;
      window.XMLHttpRequest = originalXHR;
      window.WebSocket = originalWebSocket;
      console.log("Network requests are now unblocked");
    }, 5000); // 5 seconds
  </script>
  -->

  <?php include_once("includes/jsFiles.php"); ?>
  <?php include_once("includes/chainscript.php"); ?>

  <!-- Now load the script -->
  <script src="https://onchain.com.ng/Tonconnects/tonconnect-ui.min.js"></script>
  <!-- Add html2canvas from CDN -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://telegram.org/js/telegram-web-app.js"></script>

</body>

</html>