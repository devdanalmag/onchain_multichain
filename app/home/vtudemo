<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                
                <p class="mb-0 text-center font-600 color-highlight">Airtime For All Network</p>
                <h1 class="text-center">Buy Airtime</h1>

                <div class="row text-center mb-2">
                    
                    <a href="javascript:selectNetworkByIcon('MTN');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/mtn.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectNetworkByIcon('AIRTEL');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/airtel.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectNetworkByIcon('GLO');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/glo.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectNetworkByIcon('9MOBILE');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/9mobile.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    
                </div>
                <hr/>
                <div class="d-flex">
                    <h5 style="background:<?php echo $sitecolor; ?>; color:#ffffff; padding:9px;  margin-right:5px;">Code: </h5>
                    <marquee direction="left" scrollamount="5" style="background:#f2f2f2; padding:3px; border-radius:5rem;">
                        <h5 class="py-2">
                        [MTN] - *556# - [Airtel] - *123# - [Glo] - *124# - [9Mobile] - *232#
                        </h5>
                    </marquee>
                </div>
                <hr/>
                
                <form method="post" class="airtimeForm" id="airtimeForm" action="buy-airtime">
                        <fieldset>
 
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="networkid" class="color-theme opacity-80 font-700 font-12">Network</label>
                                <select id="networkid" name="network">
                                    <option value="" disabled="" selected="">Select Network</option>
                                    <?php foreach($data AS $network): if($network->networkStatus == "On"): ?>
                                        <option value="<?php echo $network->nId; ?>" networkname="<?php echo $network->network; ?>" vtu="<?php echo $network->vtuStatus; ?>" sharesell="<?php echo $network->sharesellStatus; ?>"><?php echo $network->network; ?></option>
                                    <?php endif; endforeach; ?>
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
                                    <option value="Share And Sell">Share And Sell</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

 
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                                <input type="number" onkeyup="verifyNetwork()" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required  />
                            </div>

                            <p id="verifyer"></p>

                            
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="airtimeamount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="number" name="amount" placeholder="Amount" value="" class="round-small" id="airtimeamount" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="number" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="discount" class="color-theme opacity-80 font-700 font-12">Discount</label>
                                <input type="text" name="discount" placeholder="Discount" value="" class="round-small" id="discount" readonly required  />
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
                            <button type="submit" id="airtime-btn" name="purchase-airtime" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Buy Airtime
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>



