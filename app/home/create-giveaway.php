<div class="page-content header-clear-medium">

    <div class="card card-style">

        <div class="content">

            <p class="mb-0 text-center font-600 color-highlight">Create your own giveaway to your family/fiends</p>
            <h1 class="text-center">Create Giveaway</h1>

            <div class="row text-center mb-2">

                <span href="" class="col-3 mt-2">
                    <span class="icon icon-l rounded-sm py-2 px-2 select-item " id="mtnspan"
                        style="background:#f2f2f2; margin-left: 195%; ">
                        <img src="../../assets/images/icons/give.svg" id="mtnimg" style="width :100px; height:100px;" />
                    </span>
                </span>
            </div>
        </div>
        <hr />
        <form method="post" class="creategiveawayForm" id="creategiveawayForm" action="buy-giveaway">
            <fieldset>
                <div class="input-style input-style-always-active has-borders mb-4">
                    <label for="giveawaytype" class="color-theme opacity-80 font-700 font-12">Type</label>
                    <select id="giveawaytype" name="giveawaytype">
                        <option value="" selected disabled>Select Type</option>
                        <option value="privategiveaway">Private Giveaway</option>
                        <option value="publicgiveaway">Public Giveaway</option>
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                    <label for="whattype" class="color-theme opacity-80 font-700 font-12">What?</label>
                    <select id="whattype" name="whattype">
                        <option value="" selected disabled>Select</option>
                        <option value="airtime">Airtime</option>
                        <option value="data">Data </option>
                        <!-- <option value="cash">Cash</option> -->
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                    <label for="networkid" class="color-theme opacity-80 font-700 font-12">Chose Network's</label>
                    <select id="networkid" name="network">
                        <option value="" disabled="" selected="">Select Network</option>
                        <option value="allnetwork">All NETWORK's</option>
                        <?php foreach ($data as $network):
                            if ($network->networkStatus == "On"): ?>
                                <option value="<?php echo $network->nId; ?>" networkname="<?php echo $network->network; ?>"
                                    sme="<?php echo $network->smeStatus; ?>" gifting="<?php echo $network->giftingStatus; ?>"
                                    corporate="<?php echo $network->corporateStatus; ?>"><?php echo $network->network; ?> User's
                                    Only</option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="datagroup" class="color-theme opacity-80 font-700 font-12">Data Type</label>
                        <select id="datagroup" name="datagroup">
                            <option value="">Select Type</option>
                            <option value="SME">SME</option>
                            <option value="Gifting">Gifting</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>

                <div class="input-style input-style-always-active has-borders validate-field mb-4" id="numberdiv"
                    style="display:none;">
                    <label for="numberInput" row="2" class="color-theme opacity-80 font-700 font-12">Phone
                        Number</label>
                    <textarea type="text" name="phone" placeholder="Phone Number" value="" class="round-small"
                        id="numberInput" onpaste="handlePaste(event)"></textarea>
                </div>

                <!-- <div class="input-style input-style-always-active has-borders validate-field mb-4" id="uiddiv"
                    style="display:none;">
                    <label for="useruid" row="2" class="color-theme opacity-80 font-700 font-12">User's UID</label>
                    <textarea type="text" name="useruid" placeholder="UID" value="" class="round-small" id="useruid"
                        onpaste="handlePasteuid(event)"></textarea>
                </div> -->

                <div class="input-style input-style-always-active has-borders mb-4" id="datatypediv"
                    style="display:none;">
                    <label for="datatype" class="color-theme opacity-80 font-700 font-12">Data Type</label>
                    <select id="datatype" name="datatype" onchange="checkthedata()">
                        <option value="" selected disabled>Select Type</option>
                        <option value="SME_CG">SME & Corporate MTN & AIRTEL</option>
                        <!-- <option value="Gifting">Special </option>
                        <option value="Corporate">Corporate</option> -->
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4" id="airtimetypediv"
                    style="display:none;">
                    <label for="datatype" class="color-theme opacity-80 font-700 font-12">Airtime Type</label>
                    <select id="datatype" name="datatype" onchange="checkthedata()">
                        <option value="" selected disabled>Select Type</option>
                        <option value="SME_CG">SME & Corporate MTN & AIRTEL</option>
                        <!-- <option value="Gifting">Special </option>
                        <option value="Corporate">Corporate</option> -->
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>

                <div class="input-style input-style-always-active has-borders mb-4">
                    <label for="dataplan" class="color-theme opacity-80 font-700 font-12">Data Package</label>
                    <select id="dataplan" name="dataplan" required></select>
                    <span><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <div class="input-style input-style-always-active has-borders validate-field mb-4">
                    <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                    <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small"
                        id="amounttopay" readonly required />
                </div>

                <div class="form-check icon-check">
                    <input class="form-check-input" type="checkbox" name="ported_number" id="ported_number">
                    <label class="form-check-label" for="ported_number">Disable Number Validator</label>
                    <i class="icon-check-1 fa fa-square color-gray-dark font-16"></i>
                    <i class="icon-check-2 fa fa-check-square font-16 color-highlight"></i>
                </div>

                <input name="transref" type="hidden" value="<?php echo $transRef; ?>" />
                <input name="transkey" id="transkey" type="hidden" />


                <div class="form-button">
                    <button type="submit" id="data-btn" name="purchase-data" style="width: 100%;"
                        class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                        Buy Data
                    </button>
                </div>
            </fieldset>
        </form>
    </div>

</div>

</div>