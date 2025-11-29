<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
				<div class="text-center mb-3"><img src="../../assets/images/alpha.png" width="200" /></div>
                <form method="post" class="alphaplanForm" id="alphaplanForm" action="alpha-topup">
                        <fieldset>

                            

                           <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="alphaplan" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <select id="alphaplan" name="alphaplan">
                                    <option value="">Select Amount</option>
                                    <?php if(!empty($data)): foreach($data AS $plan): ?>
                                    <option value="<?php echo $plan->buyingPrice; ?>" plan="<?php echo $plan->buyingPrice; ?>" user="<?php echo $plan->sellingPrice; ?>" agent="<?php echo $plan->agent; ?>"  vendor="<?php echo $plan->vendor; ?>"><?php echo $plan->buyingPrice; ?></option>
                                    <?php endforeach; endif; ?>
                                    
                                 </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                                <input type="number" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required  />
                            </div>

                            <p id="verifyer"></p>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" 
									   value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            <input name="transref" type="hidden" value="<?php echo $transRef; ?>" />
                            <input name="transkey" id="transkey" type="hidden" />

                            
                            <div class="form-button">
                            <button type="submit" id="alpha-plan-btn" name="purchase-alpha-topup" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Send Order
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>



