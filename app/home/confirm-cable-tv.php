<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Cable TV Subscription</p>
                <h1 class="text-center">Cable TV</h1>
                
                <form method="post" class="cableplanForm" id="cableplanForm" action="cable-tv">
                        <fieldset>

                            <input type="hidden" name="provider" value="<?php echo $data->provider; ?>" />
                            <input type="hidden" name="cableplan" value="<?php echo $data->cableplan; ?>" />
                            <input type="hidden" name="iucnumber" value="<?php echo $data->iucnumber; ?>" />
                            <input type="hidden" name="phone" value="<?php echo $data->phone; ?>" />
                            <input type="hidden" name="subtype" value="<?php echo $data->subtype; ?>" />
                        
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="p" class="color-theme opacity-80 font-700 font-12">Plan</label>
                                <input type="text" id="cabledetails" value="<?php echo $data->cabledetails; ?>" class="round-small" disabled  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" placeholder="Amount To Pay" value="<?php echo $data->amounttopay; ?>" class="round-small" id="amounttopay" readonly disabled  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Subscription Type</label>
                                <input type="text"  placeholder="Type" value="<?php echo $data->subtype; ?>" class="round-small" disabled  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Phone Number</label>
                                <input type="number"  placeholder="PhoneNumber" value="<?php echo $data->phone; ?>" class="round-small" disabled  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">IUC Number</label>
                                <input type="number"  placeholder="IUC Number" value="<?php echo $data->iucnumber; ?>" class="round-small" id="iucnumber" disabled  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label class="color-theme opacity-80 font-700 font-12">Customer Name</label>
                                <input type="text"  placeholder="Customer Name" value="<?php echo $data2; ?>" class="round-small"  disabled  />
                            </div>

                            <p id="verifyer" class="text-danger"><b><?php echo (strpos($data2,"Could Not") !== false) ? "Note: ".$data2 : ""; ?></b></p>

                            

                            <input name="transkey" id="transkey" type="hidden" />
                            
                            <p class="text-danger">
                                <b>
                                    Please Confirm That The Above Details Are Correct Before You Click On Purchase
                                </b>
                            </p>
                            <div class="form-button">
                            <button type="submit" id="cable-btn" name="purchase-cable-sub" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Purchase Plan
                            </button>
                            <a href="#" data-back-button style="width: 100%;" class="btn btn-full btn-l font-600 font-15 btn-dark mt-4 rounded-s">
                                   Go Back
                            </a>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





