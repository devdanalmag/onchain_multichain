
<div class="row">
<div class="col-12">
    
    <div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Credit/Debit User Wallet</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label for="success" class="control-label">User Email</label>
                    <div class="">
                    <input type="text" name="email" value="<?php echo $data; ?>" class="form-control" readonly required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Action</label>
                    <div class="">
                    <select name="action" class="form-control" required="required">
                        <option value="">Select Action</option>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Amount</label>
                    <div class="">
                    <input type="number" name="amount" placeholder="Amount" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Reason For Action</label>
                    <div class="">
                    <input type="text" name="reason" placeholder="Reason" class="form-control" required="required">
                    </div>
                </div>
                

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="credit-debit-user" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Wallet</button>
                       <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                    </div>
                </div>
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
</div>
</div>



