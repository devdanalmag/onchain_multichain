
<div class="d-flex justify-content-between">
    <a class="btn btn-success btn-block mr-2" href="api-setting">General Setting</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="monnify-setting">Monnify Setting</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="paystack-setting">Paystack Setting</a>
</div>
<hr/>
<div class="row">
<div class="col-12">
    
    <div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Monnify API Settings</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label for="success" class="control-label">Monnify Api Key</label>
                    <div class="">
                    <input type="text" name="monifyApi" value="<?php echo $controller->getConfigValue($data,"monifyApi"); ?>" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Monnify Secret Key</label>
                    <div class="">
                    <input type="text" name="monifySecrete" value="<?php echo $controller->getConfigValue($data,"monifySecrete"); ?>" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Monnify Contract Address</label>
                    <div class="">
                    <input type="text" name="monifyContract" value="<?php echo $controller->getConfigValue($data,"monifyContract"); ?>" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Wallet Topup Charges (In Percentage %)</label>
                    <div class="">
                    <input type="text" name="monifyCharges" pattern="^\d*(\.\d{0,3})?$" value="<?php echo $controller->getConfigValue($data,"monifyCharges"); ?>" class="form-control" required="required">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="success" class="control-label">Monnify Activation</label>
                    <div class="">
                        <select name="monifyStatus" class="form-control" required="required">
                        <?php if($controller->getConfigValue($data,"monifyStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Wema Bank Activation</label>
                    <div class="">
                        <select name="monifyWeStatus" class="form-control" required="required">
                        <?php if($controller->getConfigValue($data,"monifyWeStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Moniepoint Bank Activation</label>
                    <div class="">
                        <select name="monifyMoStatus" class="form-control" required="required">
                        <?php if($controller->getConfigValue($data,"monifyMoStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Starling Bank Activation</label>
                    <div class="">
                        <select name="monifySaStatus" class="form-control" required="required">
                        <?php if($controller->getConfigValue($data,"monifySaStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Fidelity Bank Activation</label>
                    <div class="">
                        <select name="monifyFeStatus" class="form-control" required="required">
                        <?php if($controller->getConfigValue($data,"monifyFeStatus") == "On"): ?>
                            <option value="On" selected>On</option>
                            <option value="Off">Off</option>
                        <?php else: ?>
                            <option value="On">On</option>
                            <option value="Off" selected>Off</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>
                    
                    

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="update-monnify-config" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
</div>
</div>



