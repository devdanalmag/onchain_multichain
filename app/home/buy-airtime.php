<div class="page-content header-clear-medium" id="page-file-name" page-name="buy-airtime">

    <div class="card card-style">

        <div class="content">

            <p class="mb-0 text-center font-600 color-highlight">Airtime For All Network</p>
            <h1 class="text-center">Buy Airtime</h1>

            <div class="row text-center mb-2">

                <a href="javascript:selectNetworkByIcon('MTN');" class="col-3 mt-2">
                    <span class="icon icon-l rounded-xl  py-2 px-2 select-item " id="mtnspan" style="background:#f2f2f2;">
                        <img src="../../assets/images/icons/mtn.png" id="mtnimg" style="width :45px; height:45px;" />
                    </span>
                </a>

                <a href="javascript:selectNetworkByIcon('AIRTEL');" class="col-3 mt-2">
                    <span class="icon icon-l rounded-xl  py-2 px-2 selected-item " id="airtelspan" style="background:#f2f2f2;">
                        <img src="../../assets/images/icons/airtel.png" id="airtelimg" style="width :45px; height:45px;" />
                    </span>
                </a>

                <a href="javascript:selectNetworkByIcon('GLO');" class="col-3 mt-2">
                    <span class="icon icon-l rounded-xl  py-2 px-2" id="glospan" style="background:#f2f2f2;">
                        <img src="../../assets/images/icons/glo.png" id="gloimg" style="width :45px; height:45px;" />
                    </span>
                </a>

                <a href="javascript:selectNetworkByIcon('9MOBILE');" class="col-3 mt-2">
                    <span class="icon icon-l rounded-xl py-2 px-2" id="9mobilespan" style="background:#f2f2f2;">
                        <img src="../../assets/images/icons/9mobile.png" id="9mobileimg" style="width :45px; height:45px;" />
                    </span>
                </a>


            </div>
            <hr />
            <!-- <div class="d-flex">
                <h5 style="background:<?php echo $sitecolor; ?>; color:#ffffff; padding:9px;  margin-right:5px;">Code: </h5>
                <marquee direction="left" scrollamount="5" style="background:#f2f2f2; padding:3px; border-radius:5rem;">
                    <h5 class="py-2">
                        [MTN] - *556# - [Airtel] - *123# - [Glo] - *124# - [9Mobile] - *232#
                    </h5>
                </marquee>
            </div>
            <hr /> -->

            <form method="post" class="airtimeForm" id="airtimeForm" action="buy-airtime">
                <fieldset>

                    <div class="input-style input-style-always-active has-borders mb-4" hidden>
                        <label for="networkid" class="color-theme opacity-80 font-700 font-12" hidden>Network</label>
                        <select id="networkid" name="network" hidden>
                            <option value="" disabled="" selected="">Select Network</option>
                            <?php foreach ($data as $network) : if ($network->networkStatus == "On") : ?>
                                    <option value="<?php echo $network->nId; ?>" networkname="<?php echo $network->network; ?>" vtu="<?php echo $network->vtuStatus; ?>" sharesell="<?php echo $network->sharesellStatus; ?>"><?php echo $network->network; ?></option>
                            <?php endif;
                            endforeach; ?>
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>



                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="networktype" class="color-theme opacity-80 font-700 font-12">Type</label>
                        <select id="networktype" name="networktype">
                            <option value="VTU">VTU</option>
                            <!-- <option value="Share And Sell">Share And Sell</option> -->
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>


                    <div class="input-style input-style-always-active has-borders validate-field mb-4">
                        <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                        <input type="number" onkeyup="verifyNetwork()" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required />
                    </div>

                    <p id="verifyer"></p>


                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                        <input type="number" name="amount" placeholder="Amount" value="" class="round-small" id="airtimeamount" required />
                        <em style="color:red;  opacity: 80%; font-size: 10px; display: none;" id="amountwarning" countdown="false">Ammount Must Be > 100</em>

                    </div>

                    <div class="input-style input-style-always-active has-borders validate-field mb-4">
                        <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                        <input name="ton-to-pay" type="hidden" id="ton-to-pay" value="" hidden />
                        <input type="number" name="amounttopay" placeholder="Amount To Pay" tontopay="" value="" class="round-small" id="amounttopay" readonly required />
                        <u class="pricetopay"><em> <b id="amounttopayinton">0.00 $TON</b> <i class="fa fa-spinner" aria-hidden="true" hidden> <i id="countdown" hidden>0</i></i></em></u>
                    </div>

                    <div class="input-style input-style-always-active has-borders validate-field mb-4">
                        <label for="discount" class="color-theme opacity-80 font-700 font-12">Discount</label>
                        <input type="text" name="discount" placeholder="Discount" value="" class="round-small" id="discount" readonly required />
                    </div>

                    <div class="form-check icon-check">
                        <input class="form-check-input" type="checkbox" name="ported_number" id="ported_number">
                        <label class="form-check-label" for="ported_number">Disable Number Validator</label>
                        <i class="icon-check-1 fa fa-square color-gray-dark font-16"></i>
                        <i class="icon-check-2 fa fa-check-square font-16 color-highlight"></i>
                    </div>

                    <input name="transref" type="hidden" value="<?php echo $transRef; ?>" />
                    <input name="transkey" id="transkey" type="hidden" />
                    <input type="text" value="ton" id="blockchainselect" hidden />
                    <div id="transaction-data">
                        <!-- <input type="text" value="" id="ton-viewer-link-field" hidden /> -->
                    </div>
                    <input type="hidden" name="" id="walletdatainfo" connection="" saved-address="<?php echo $data3->sTonaddress ?>" address-status="<?php echo $data3->tonaddstatus; ?>">
                    <div class="form-button" id="purchase-btn-div" style="display: none;">
                        <button type="submit" id="airtime-btn" name="purchase-airtime" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                            Buy Airtime
                        </button>
                        <span id="fetch-price" style="width: 100%; display: none;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s" onclick="gettonPrice()" hidden>
                            Get Price
                        </span>
                    </div>

                    <div class="form-button" id="ton-connect-btn-div" style="display: none;">
                        <div id="ton-connect" style="display: grid;    align-items: center; justify-content: center; flex-wrap: wrap;">

                        </div>
                    </div>
                    <br>
                    <b id="disconnect-wallet-btn" style="display: flex;    align-items: center; justify-content: center; flex-wrap: wrap; cursor:pointer; " onclick="disconnectWallets()">Disconnect?</b>

                </fieldset>
            </form>
        </div>

    </div>

</div>