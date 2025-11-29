<div id="bdo">
</div>
<style>
    .coming-soon {
        display: block;
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
        z-index: 1;
        background-color: #f0f0f0;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        padding: 20px;
        margin: 10px 0;
        box-shadow: 0 4px 8px rgba(39, 39, 39, 0.1);
        transition: all 0.3s ease;
        /* Add a transition for smooth effect */
    }

    .darkt {
        padding-left: 40%;
    }

    .coming-soon h1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        color: rgb(110, 109, 109);
        text-align: center;
        font-weight: bold;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        text-transform: uppercase;
        font-style: italic;
        z-index: 2;
    }

    .coming-soon:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(39, 39, 39, 0.2);
        /* Add a hover effect */
    }

    @media screen and (max-width: 768px) {
        .coming-soon h1 {
            font-size: 1.5rem;
        }

        .coming-soon {
            padding: 10px;
            margin: 5px 0;
        }

        .coming-soon:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(39, 39, 39, 0.1);
        }

        .darkt {
            padding-left: 37%;
        }

    }

    @media screen and (max-width: 480px) {
        .coming-soon h1 {
            font-size: 1.2rem;
        }

        .darkt {
            padding-left: 26%;
        }

        .coming-soon {
            padding: 5px;
            margin: 2px 0;
        }

        .coming-soon:hover {
            transform: scale(1.01);
            box-shadow: 0 2px 4px rgba(39, 39, 39, 0.1);
        }


    }
</style>
<div class="page-content header-clear-medium" id="page-file-name" page-name="homepage1">
    <h1 class="p-relative">Dashboard</h1>

    <div class="wrapper d-grid gap-20">
        <!-- start welcome -->
        <div class="welcome tickets bg-white rad-10 txt-c-mobile block-mobile">
            <div class="intro p-20 d-flex space-between bg-eee">
                <div>
                    <h2 class="m-0">Welcome</h2>
                    <p class="c-grey mt-5"></p>
                </div>
                <img class="hide-mobile"
                    src="<?php echo HOME_IMAGE_LOC; ?>/2012.i605.033_design_studio-removebg-preview.png" alt="" />
            </div>
            <img  src="<?php echo HOME_IMAGE_LOC; ?>/pfp.png" alt="#" class="avatar" />

            <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <div>
                    <?php echo "Hi, " . $data->sUsername; ?> <span class="d-block c-grey fs-14 mt-10">
                        <?php echo $controller->formatUserType($data->sType); ?>
                    </span>
                </div>
                <div>
                    <b><b class="c-blue" id="Wbalance"
                            amount="" address="<?php echo $data->sTonaddress ?>">**,***</b> <i class="fa fa-solid fa-gem" style="color: #0098ea;" aria-hidden="true"></i>
                        <span
                            class="d-block c-grey fs-14 mt-10">Wallet Balance</span></b>
                </div>
                <div>
                    <i id="Ebalance" amount="<?php echo number_format($data->sRefWallet); ?>">**,***</i><span
                        class="d-block c-grey fs-14 mt-10">Point</span>
                </div>
            </div>
            <div class="txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <span class="d-block c-grey fs-14 w-fit"> <a><i onclick="hide_amount();"
                            class="fa fa-eye fa-2x show-hide" id="eye-show" style="display: none;"></i>
                        <i onclick="show_amount();" class="fa fa-eye-slash fa-2x show-hide" id="eye-hide"></i></a>
                </span>
                <span class="d-block c-grey fs-14 w-fit darkt">
                    <a href="#" data-toggle-theme class="font-17 header-icon header-icon-3 show-on-theme-dark"><i
                            class="fas fa-sun fa-2x"></i></a>
                    <a href="#" data-toggle-theme class="font-17 header-icon header-icon-3 show-on-theme-light"><i
                            class="fas fa-moon fa-2x"></i></a> </span>
                <a href="profile" class="visit d-block fs-14 bg-green c-white w-fit btn-shape">Profile</a>

                <br>
            </div>



        </div>
        <!-- end welcome -->

        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Quick Access</h2>
            <div class="d-flex txt-c gap-20 f-wrap">
                <div class="box p-20 rad-10 fs-13 c-grey" style="width: calc(100% - 10px);">
                    <a href="transactions">
                        <!-- <a href="#" onclick="showNotification('withdraw');"> -->
                        <i class="fa fa-receipt fa-4x withdraw"></i>
                        <span class="d-block c-black fw-bold fs-25">Transactions</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey" style="width: calc(100% - 10px);">
                    <a href="notifications">
                        <i class="fa fa-bell fa-4x funding"></i>
                        <span class="d-block c-black fw-bold fs-25">Notification</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey" style="width: calc(100% - 10px);">
                    <a href="referrals">
                        <i class="fa fa-users fa-4x withdraw"></i>
                        <!-- <a href="#" onclick="showNotification('withdraw');"> -->
                        <span class="d-block c-black fw-bold fs-25">Referrals</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- start Services -->
        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Active Services</h2>
            <div class="d-flex txt-c gap-20 f-wrap">

                <div class="box p-20 rad-10 fs-13 c-grey">
                    <a href="create-giveaway">
                        <i class="fa fa-gift fa-4x c-orange"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2" style="">Giveaway</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13">
                    <a href="p2p">
                        <!-- <a href="#" onclick="showNotification('withdraw');"> -->
                        <i class="fa fa-exchange fa-4x"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">P2P</span></a>
                </div>

                <div class="box p-20 rad-10 fs-13 c-grey">
                    <a href="buy-airtime">
                        <i class="fa fa-phone fa-4x c-red"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">AIRTIME</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13">
                    <a href="buy-data">
                        <i class="fa fa-wifi fa-4x c-green"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">DATA</span></a>
                </div>
            </div>
        </div>
        <!-- end services -->

        <!-- start Others -->
        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Future Services</h2>
            <div class="d-flex txt-c gap-20 f-wrap coming-soon">
                <!-- <h1>Coming Soon</h1> -->
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <a href="cable-tv">
                        <i class="fa fa-television fa-4x"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2" style="">Cable Sub.</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13">
                    <a href="electricity">
                        <!-- <a href="#" onclick="showNotification('withdraw');"> -->
                        <i class="fa fa-bolt fa-4x"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">Electricity Bill</span>
                    </a>
                </div>

                <div class="box p-20 rad-10 fs-13 c-grey">
                    <a href="exam-pins">
                        <i class="fa fa-wpforms fa-4x"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">Result Pin</span>
                    </a>
                </div>
                <div class="box p-20 rad-10 fs-13">
                    <a href="recharge-pin">
                        <i class="fa fa-credit-card fa-4x"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-2">Recharg Card</span></a>
                </div>
            </div>
        </div>
        <!-- end Others -->

        <div class="popup" id="withdraw">
            <!-- <span id="copy-alert"></span> -->
            <div class="do d-flex">
                <!-- <div class="fs-14"> -->
                <button type="button" class="btn d-block visit fs-14 bg-orange c-white w-fit btn-shape btn-bold"
                    style="width: 39%; font-size: medium; margin-left: 30%;"
                    onclick="closeNotification('withdraw');">Ok</button>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
<div class="gap-50"> <br> <br></div>