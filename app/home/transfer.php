<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            
            <div class="content">
                <p class="mb-0 text-center font-600 color-highlight">Transfer Funds</p>
                <h1 class="text-center">Transfer</h1>
                
                <form method="post" class="transferForm" id="transferForm" action="transfer">
                        <fieldset>

                            <div class="input-style input-style-always-active has-borders mb-4">
                                <label for="transfertype" class="color-theme opacity-80 font-700 font-12">Transfer Type</label>
                                <select id="transfertype" name="transfertype" required>
                                    <!--option value="" disabled="" selected="">Select Transfer</option-->
                                    <!--option value="wallet-wallet">Wallet To Wallet</option-->
                                    <option value="referral-wallet" selected>Referral To Wallet</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                                
                            <input name="transkey" id="transkey" type="hidden" />
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4" id="walletreceiver">
                                <label for="email" class="color-theme opacity-80 font-700 font-12">Receiver Email</label>
                                <input type="email" name="email" placeholder="Email"  id="walletreceiverinput" class="round-small" />
                            </div>
                            
                           
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amount" class="color-theme opacity-80 font-700 font-12">Amount</label>
                                <input type="number" name="amount" placeholder="Amount" value="" class="round-small" id="wallettransferamount"  required  />
                            </div>
                            
                            <div class="input-style input-style-always-active has-borders validate-field mb-4">
                                <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay</label>
                                <input type="text" name="amounttopay" placeholder="Amount To Pay" value="" class="round-small" id="amounttopay"  required readonly  />
                            </div>

                            <div class="d-none" id="wallettowalletcharges"><?php echo $data->wallettowalletcharges; ?></div>
                            <p class="text-danger"><b>Note: </b> Wallet To Wallet Fund Transfer Attracts A Charges Of N<?php echo $data->wallettowalletcharges; ?> Only.</p>
                          
                            <div class="form-button">
                            <button type="submit" id="transfer-btn" name="perform-transfer" style="width: 100%;" class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                                   Continue
                            </button>
                            </div>
                        </fieldset>
                    </form>        
            </div>

        </div>

</div>





