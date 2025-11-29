<div class="d-flex justify-content-between">
    <a class="btn btn-dark btn-block mr-2" href="site-setting">General Setting</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="contact-setting">Contact Setting</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="network-setting">Network Setting</a>
</div>
<hr/>

<div class="row">
<div class="col-12">
    
    <div class="box">
        <div class="box-header with-border">
         
            <div class="d-flex justify-content-between mt-2">
                <a class="mr-2" href="network-setting?network=MTN"><img src="../../assets/images/mtn.png" class="img-fluid" style="width:80px;" /></a> 
                <a class="mr-2" href="network-setting?network=AIRTEL"><img src="../../assets/images/airtel.png" class="img-fluid" style="width:80px;" /></a> 
                <a class="mr-2" href="network-setting?network=GLO"><img src="../../assets/images/glo.png" class="img-fluid" style="width:80px;" /></a> 
                <a class="mr-2" href="network-setting?network=9MOBILE"><img src="../../assets/images/9mobile.png" class="img-fluid" style="width:80px;" /></a> 
            </div> 
        </div>

        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit row">
        <div class="col-md-12">
            <h5><b><?php echo $_GET["network"]; ?> Network Status</b></h5>
            <div class="alert alert-info">Use This Section To Enable or Disable A Network Service.</div>
            <hr/>
        </div>
        <?php foreach($data AS $network): if($network->network == $_GET["network"]): ?>
                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> General (All)</label>
                    <div class="">
                        <select name="general" class="form-control" required="required">
                        <?php if($network->networkStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group  col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Airtime (VTU)</label>
                    <div class="">
                        <select name="vtuStatus" class="form-control" required="required">
                        <?php if($network->vtuStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif;  ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Airtime (Share & Sell)</label>
                    <div class="">
                        <select name="sharesellStatus" class="form-control" required="required">
                        <?php if($network->sharesellStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif;  ?>
                        </select>
                    </div>
                </div>

                

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> SME</label>
                    <div class="">
                        <select name="sme" class="form-control" required="required">
                        <?php if($network->smeStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif;  ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Gifting</label>
                    <div class="">
                        <select name="gifting" class="form-control" required="required">
                        <?php  if($network->giftingStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Corporate</label>
                    <div class="">
                        <select name="corporate" class="form-control" required="required">
                        <?php if($network->corporateStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Recharge Card</label>
                    <div class="">
                        <select name="airtimepin" class="form-control" required="required">
                        <?php if($network->airtimepinStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif;  ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Data Pin</label>
                    <div class="">
                        <select name="datapin" class="form-control" required="required">
                        <?php if($network->datapinStatus == "On"): ?>
                            <option value="On" selected>Enable</option>
                            <option value="Off">Disable</option>
                        <?php else: ?>
                            <option value="On">Enable</option>
                            <option value="Off" selected>Disable</option>
                        <?php endif;  ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr/>
                    <h5><b><?php echo $_GET["network"]; ?> Network ID</b></h5>
                    <div class="alert alert-danger">Use This Section To Change The Network ID Of A Service.</div>
                    <hr/>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> General ID</label>
                    <div class="">
                        <input type="number" name="networkid" value="<?php echo $network->networkid; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> SME ID</label>
                    <div class="">
                        <input type="number" name="smeId" value="<?php echo $network->smeId; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Gifting ID</label>
                    <div class="">
                        <input type="number" name="giftingId" value="<?php echo $network->giftingId; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Corporate ID</label>
                    <div class="">
                        <input type="number" name="corporateId" value="<?php echo $network->corporateId; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> VTU ID</label>
                    <div class="">
                        <input type="number" name="vtuId" value="<?php echo $network->vtuId; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="success" class="control-label"><?php echo $_GET["network"]; ?> Share & Sell ID</label>
                    <div class="">
                        <input type="number" name="sharesellId" value="<?php echo $network->sharesellId; ?>" class="form-control" placeholder="SME ID" required />
                    </div>
                </div>

                <input type="hidden" name="network" value="<?php echo $network->nId; ?>" />

                <div class="form-group col-md-12">
                    <div class="">
                       <button type="submit" name="update-network-setting" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
        <?php endif; endforeach; ?>
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
</div>
</div>



