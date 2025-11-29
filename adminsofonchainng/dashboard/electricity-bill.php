<div class="d-flex justify-content-between">
    <a class="btn btn-dark btn-block mr-2" href="electricity-bill?electricity=IE">IE</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="electricity-bill?electricity=EKEDC">EKEDC</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=KEDCO">KEDCO</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=PHEDC">PHEDC</a>
</div>
<div class="d-flex justify-content-between mt-2">
    <a class="btn btn-dark btn-block mr-2" href="electricity-bill?electricity=JED">JED</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="electricity-bill?electricity=IBEDC">IBEDC</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=KEDC">KEDC</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=AEDC">AEDC</a>
</div>
<div class="d-flex justify-content-between mt-2">
    <a class="btn btn-dark btn-block mr-2" href="electricity-bill?electricity=YOLA">YOLA</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="electricity-bill?electricity=BENIN">BENIN</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=ENUGU">ENUGU</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="electricity-bill?electricity=KEDCO">KT</a>
</div>
<hr/>

<div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Electricity Settings</h4>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
        
                <input type="hidden" name="electricity" value="<?php echo $data->eId; ?>" />

                <div class="form-group">
                    <label for="electricityid" class="control-label"><?php echo $data->provider; ?> (Electricity Id)</label>
                    <div class="">
                        <input type="text" name="electricityid" class="form-control" required="required" value="<?php echo $data->electricityid; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="electricitystatus" class="control-label"><?php echo $data->provider; ?> (Status)</label>
                    <div class="">
                        <select name="electricitystatus" id="electricitystatus" class="form-control" >
                           <?php  if($data->providerStatus == "On"): ?>
                                <option value="On" selected>Enable</option>
                                <option value="Off">Disable</option>
                            <?php else: ?>
                                <option value="On">Enable</option>
                                <option value="Off" selected>Disable</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="">
                       <button type="submit" name="update-electricity-bill-setting" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
               
              
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->