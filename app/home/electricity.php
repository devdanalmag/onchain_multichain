<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Electricity Payment</p>
                <h1 class="text-center">Electricity Bill</h1>

                <div class="row text-center mb-2">
                    
                    <a href="javascript:selectExamByIcon('Abuja  Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/aedc.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Eko Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/ekedc.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Kaduna Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/kaduna.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Kano Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/kedco.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Jos Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/jos.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Ikeja Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/ikeja.png?v=1" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Ibadan Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/ibedc.png" width="45" height="45" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('Port Harcourt Electric');" class="col-3 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/phedc.png?v=1" width="45" height="45" />
                        </span>
                    </a>
                    
                    
                </div>
                
                <hr/>
                
                <form method="post" class="verifyelectricityplanForm" id="verifyelectricityplanForm" action="confirm-electricity">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="electricityid" class="color-theme opacity-80 font-700 font-12">Provider</label>
                                <select id="electricityid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->eId; ?>" providername="<?php echo $provider->provider; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <input type="hidden" name="electricitydetails" id="electricitydetails" />


                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="metertype" class="color-theme opacity-80 font-700 font-12">Meter Type</label>
                                <select id="metertype" name="metertype" required>
                                    <option value="" disabled="" selected="">Select Type</option>
                                    <option value="prepaid">Prepaid</option>
                                    <option value="postpaid">Postpaid</option>
                                 </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
 
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">Customer Phone Number</label>
                                <input type="number" name="phone" placeholder="Phone Number" value="" class="round-small" id="phone" required  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="meternumber" class="color-theme opacity-80 font-700 font-12">Meter Number</label>
                                <input type="number" name="meternumber" placeholder="Meter Number" value="" class="round-small" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="meteramount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="text" name="amount" placeholder="Amount" value="" class="round-small" id="meteramount"  required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            <!-- 30530021655 -->

                            <p class="text-danger">
                                <b>Note: </b> Transaction attracts a service charges of N<span id="electricitycharges"><?php echo $data2->electricitycharges; ?></span> only.
                                <br/>
                                <b>Note: </b> Minimum Unit Purchase Is N1000.
                            </p>

                            <div class="form-button">
                            <button type="submit" id="electricity-btn" name="verify-meter-no" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Continue
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





