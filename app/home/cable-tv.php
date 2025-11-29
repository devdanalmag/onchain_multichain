<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Cable TV Subscription</p>
                <h1 class="text-center">Cable TV</h1>
                <p class="text-danger text-center">You can contact DSTV/GOtv's customers care unit on 01-2703232/08039003788 or the toll free lines: 08149860333, 07080630333, and 09090630333 for assistance. <br/> STARTIMES's customers care unit on (094618888, 014618888)</p>

                <div class="row text-center mb-2">
                    
                    <div  class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                        <a href="javascript:selectExamByIcon('DSTV');">
                            <img src="../../assets/images/icons/dstv.png" width="60" height="50" />
                        </a>
                        </span>
                    </div>

                    <div  class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                        <a href="javascript:selectExamByIcon('GOTV');">
                            <img src="../../assets/images/icons/gotv.png" width="70" height="50" />
                        </a>
                        </span>
                    </div>

                    <div  class="col-4 mt-2">
                        <span class="icon icon-l rounded-sm py-2 px-2" style="background:#f2f2f2;">
                        <a href="javascript:selectExamByIcon('STARTIMES');">
                            <img src="../../assets/images/icons/startimes.png" width="60" height="50" />
                        </a>
                        </span>
                    </div>
                    
                    
                </div>
                
                <hr/>

                <form method="post" class="verifycableplanForm" id="verifycableplanForm" action="confirm-cable-tv">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="cableid" class="color-theme opacity-80 font-700 font-12">Provider</label>
                                <select id="cableid" name="provider" required>
                                    <option value="" disabled="" selected="">Select Provider</option>
                                    <?php foreach($data AS $provider): if($provider->providerStatus == "On"): ?>
                                        <option value="<?php echo $provider->cId; ?>" providername="<?php echo $provider->provider; ?>"><?php echo $provider->provider; ?></option>
                                    <?php endif; endforeach; ?>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <input type="hidden" name="cabledetails" id="cabledetails" />

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="cableplan" class="color-theme opacity-80 font-700 font-12">Plan</label>
                                <select id="cableplan" name="cableplan" required></select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay" readonly required  />
                            </div>

                            
                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="subtype" class="color-theme opacity-80 font-700 font-12">Subscription Type</label>
                                <select id="subtype" name="subtype" required>
                                    <option value="" disabled="" selected="">Select Type</option>
                                    <option value="change">Change</option>
                                    <option value="renew">Renew</option>
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
                                <label for="phone" class="color-theme opacity-80 font-700 font-12">IUC Number</label>
                                <input type="number" name="iucnumber" placeholder="IUC Number" value="" class="round-small" required  />
                            </div>

                            <!-- 7528061720 -->
                            <!-- 01831375068 -->

                            <p id="verifyer"></p>

                            
                            <div class="form-button">
                            <button type="submit" id="cable-btn" name="verify-cable-sub" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Continue
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





