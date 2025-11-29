
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
          <h4 class="box-title">Contact Details</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label for="success" class="control-label">Phone Number</label>
                    <div class="">
                    <input type="text" name="phone" value="<?php echo $data->phone; ?>" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Email</label>
                    <div class="">
                    <input type="text" name="email" value="<?php echo $data->email; ?>" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Whatsapp No</label>
                    <div class="">
                    <input type="text" name="whatsapp" value="<?php echo $data->whatsapp; ?>" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Whatsapp Group Link</label>
                    <div class="">
                    <input type="text" name="whatsappgroup" value="<?php echo $data->whatsappgroup; ?>" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Instagram Link</label>
                    <div class="">
                    <input type="text" name="instagram" value="<?php echo $data->instagram; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Facebook Link</label>
                    <div class="">
                    <input type="text" name="facebook" value="<?php echo $data->facebook; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Twitter Link</label>
                    <div class="">
                    <input type="text" name="twitter" value="<?php echo $data->twitter; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Telegram Username</label>
                    <div class="">
                    <input type="text" name="telegram" value="<?php echo $data->telegram; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="update-contact-setting" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
</div>
</div>



