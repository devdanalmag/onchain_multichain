<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
            <p class="mb-0 text-center font-600 color-highlight">Electricity Payment</p>
                <h1 class="text-center">Electricity Bill</h1>
                
                <form method="post" class="electricityForm" id="electricityForm" action="electricity">
                        <fieldset>

                            <input type="hidden" name="provider" value="<?php echo $data->provider; ?>" />
                            <input type="hidden" name="amount" value="<?php echo $data->amount; ?>" />
                            <input type="hidden" name="meternumber" value="<?php echo $data->meternumber; ?>" />
                            <input type="hidden" name="phone" value="<?php echo $data->phone; ?>" />
                            <input type="hidden" name="metertype" value="<?php echo $data->metertype; ?>" />
                        
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="p" class="color-theme opacity-80 font-700 font-12">Payment For</label>
                                <input type="text" id="electricitydetails" value="<?php echo $data->electricitydetails; ?>" class="round-small" disabled  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="metertype" class="color-theme opacity-80 font-700 font-12">Meter Type</label>
                                <input type="text"  placeholder="Type" value="<?php echo $data->metertype; ?>" class="round-small" id="metertype" disabled  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                                <input type="number"  placeholder="Phone Number" value="<?php echo $data->phone; ?>" class="round-small" id="phone" disabled  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="meternumber" class="color-theme opacity-80 font-700 font-12">Meter Number</label>
                                <input type="number"  placeholder="Meter Number" value="<?php echo $data->meternumber; ?>" class="round-small" id="meternumber" disabled  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label class="color-theme opacity-80 font-700 font-12">Customer Name</label>
                                <input type="text"  placeholder="Customer Name" value="<?php echo $data2; ?>" class="round-small"  disabled  />
                            </div>

                            <p id="verifyer" class="text-danger"><b><?php echo (strpos($data2,"Could Not") !== false) ? "Note: ".$data2 : ""; ?></b></p>


                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="text" placeholder="Amount" value="<?php echo $data->amount; ?>" class="round-small" id="amount" readonly disabled  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" placeholder="Amount To Pay" value="<?php echo $data->amounttopay; ?>" class="round-small" id="amounttopay" readonly disabled  />
                            </div>

                            <input name="transkey" id="transkey" type="hidden" />
                            
                            <p class="text-danger">
                                <b>
                                    Please Confirm That The Above Details Are Correct Before You Click On Purchase
                                </b>
                            </p>
                            <div class="form-button">
                            <button type="submit" id="electricity-btn" name="purchase-electricity" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Purchase Unit
                            </button>
                            <a href="#" data-back-button style="width: 100%;" class="btn btn-full btn-l font-600 font-15 btn-dark mt-4 rounded-s">
                                   Go Back
                            </a>

                            <!-- 30530021655 -->
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





