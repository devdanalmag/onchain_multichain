

<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">Alpha Price List</h4>
            <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addAlphaTopup">
              <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Buying Price</th>
			                <th>Selling Price</th>
			                <th>Agent Price</th>
			                <th>Vendor Price</th>
			              
			                <th>Action</th>
						</tr>
					</thead>
					<tbody>
					
					<?php 
                        $cnt=1; $results=$data;
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo $result->buyingPrice; ?></td>
                            <td><?php echo $result->sellingPrice; ?></td>
                            <td><?php echo $result->agent; ?></td>
                            <td><?php echo $result->vendor; ?></td>
                            
                            <td>
                                <a href="#" onclick="editAlphaTopup('<?php echo base64_encode($result->alphaId); ?>','<?php echo $result->buyingPrice; ?>','<?php echo $result->sellingPrice; ?>','<?php echo $result->agent; ?>','<?php echo $result->vendor; ?>')" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                <a href="#" onclick="deleteAlphaTopup('<?php echo base64_encode($result->alphaId); ?>')" class="btn btn-danger"><i class="fa fa-delete"></i>Delete</a> 
                                
						                </td>
                        </tr>
                        <?php $cnt=$cnt+1;}} ?>
						
					</tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="addAlphaTopup" tabindex="-1">
				  <div class="modal-dialog">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Add New Apha Topup</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit">

                        <div class="form-group">
                            <label for="success" class="control-label">Buying Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Buying Price" name="bprice" class="form-control" required="required" id="success">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Selling Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Selling Price" name="sprice" class="form-control" required="required" id="success">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Agent Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Agent Price" name="agent" class="form-control" required="required" id="success">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Vendor Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Vendor Price" name="vendor" class="form-control" required="required" id="success">
                            </div>
                        </div>

                       

                       <div class="form-group">
                        <div class="d-flex justify-content-between">
                           <button type="submit" name="add-alpha-topup" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add </button>
						   <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
						</div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->

<!-- Edit Category Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="editAlphaTopup" tabindex="-1">
				  <div class="modal-dialog">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Edit Discount</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit">

                      <input type="hidden" name="alphaid" id="alphaid" />
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Buying Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="You Buy" name="buying" class="form-control" required="required" id="buying">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="success" class="control-label">Selling Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="You Sell" name="selling" class="form-control" required="required" id="selling">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Agent Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Agent Price" name="agent" class="form-control" required="required" id="agentp">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="success" class="control-label">Vendor Price</label>
                            <div class="">
                            <input type="text" pattern="[0-9]*\.?[0-9]*" placeholder="Vendor Price" name="vendor" class="form-control" required="required" id="vendorp">
                            </div>
                        </div>

                       <div class="form-group">
                        <div class="d-flex justify-content-between">
                           <button type="submit" name="update-alpha-topup" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Discount</button>
						   <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
						</div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->


