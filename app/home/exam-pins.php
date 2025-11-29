<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Exam Checker</p>
                <h1 class="text-center">Exam Pins</h1>

                <div class="row text-center mb-2">
                    
                    <a href="javascript:selectExamByIcon('WAEC');" class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/waec.png" width="60" height="50" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('NECO');" class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/neco.png" width="50" height="50" />
                        </span>
                    </a>
                    
                    <a href="javascript:selectExamByIcon('NABTEB');" class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                            <img src="../../assets/images/icons/nabteb.png" width="60" height="50" />
                        </span>
                    </a>
                    
                    
                </div>
                
                <hr/>
                
                <form method="post" class="exampinForm" id="exampinForm" action="exam-pins">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="examid" class="color-theme opacity-80 font-700 font-12">Exam Type</label>
                                <select id="examid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->eId; ?>" providername="<?php echo $provider->provider; ?>" providerprice="<?php echo $provider->price; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                                
                            <input name="transkey" id="transkey" type="hidden" />
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="quantity" class="color-theme opacity-80 font-700 font-12">Quantity</label>
                                <input type="number" id="examquantity" name="quantity" placeholder="Quantity" value="" class="round-small" required  />
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amount" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amount" placeholder="Amount" value="" class="round-small" id="amounttopay"  required readonly  />
                            </div>

                          
                            <div class="form-button">
                            <button type="submit" id="exampin-btn" name="purchase-exam-pin" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Purchase Pin
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





