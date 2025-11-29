<div class="d-flex justify-content-between">
    <a class="btn btn-dark btn-block mr-2" href="exam-pin?exam=WAEC">WAEC</a> 
    <a class="btn btn-primary btn-block ml-2 mt-0" href="exam-pin?exam=NECO">NECO</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="exam-pin?exam=NABTEB">NABTEB</a>
</div>
<hr/>

<div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Exam Settings</h4>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
        
                <input type="hidden" name="exam" value="<?php echo $data->eId; ?>" />

                <div class="form-group">
                    <label for="examid" class="control-label"><?php echo $data->provider; ?> (Exam Id)</label>
                    <div class="">
                        <input type="text" name="examid" class="form-control" required="required" value="<?php echo $data->examid; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="examprice" class="control-label"><?php echo $data->provider; ?> (Exam Price)</label>
                    <div class="">
                        <input type="text" name="examprice" class="form-control" required="required" value="<?php echo $data->price; ?>">
                    </div>
                </div>

                
                <div class="form-group">
                    <label for="buying_price" class="control-label"><?php echo $data->provider; ?> (Buying Price)</label>
                    <div class="">
                        <input type="text" name="buying_price" class="form-control" required="required" value="<?php echo $data->buying_price; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="examstatus" class="control-label"><?php echo $data->provider; ?> (Status)</label>
                    <div class="">
                        <select name="examstatus" id="examstatus" class="form-control" >
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
                       <button type="submit" name="update-exam-pin-setting" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
               
              
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->