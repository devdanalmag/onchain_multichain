<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">All Plans</h4>
			  <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addCablePlans">
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
			                <th>Plan</th>
			                <th>Plan Id</th>
			                <th>Price</th>
			                <th>User</th>
			                <th>Agent</th>
			                <th>Vendor</th>
			                <th>Action</th>
			                <th>Action</th>
						</tr>
					</thead>
					<tbody>
					
					<?php 
                        $cnt=1; $results=$data[0];
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo $result->name; ?> (<?php echo $result->provider; ?>) (<?php echo $result->day; ?> Days)</td>
                            <td><?php echo $result->planid; ?></td>
                            <td>N <?php echo $result->price; ?></td>
                            <td>N <?php echo $result->userprice; ?></td>
                            <td>N <?php echo $result->agentprice; ?></td>
                            <td>N <?php echo $result->vendorprice; ?></td>
                            <td>
                                <a href="#" onclick="editCablePlanDetails('<?php echo $result->cpId; ?>','<?php echo $result->cableprovider; ?>','<?php echo $result->name; ?>','<?php echo $result->planid; ?>','<?php echo $result->day; ?>','<?php echo $result->price; ?>','<?php echo $result->userprice; ?>','<?php echo $result->agentprice; ?>','<?php echo $result->vendorprice; ?>')" class="btn btn-primary"><i class="fa fa-edit"></i></a> 
						    </td>
                            <td>
                                <a href="#" onclick="deleteCablePlan(<?php echo $result->cpId;?>)" class="btn btn-danger"><i class="fa fa-trash"></i></a> 
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
<div class="modal fade" data-backdrop="false" id="addCablePlans" tabindex="-1">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Add New Plan</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit">
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <label for="success" class="control-label">Provider</label>
                                <div class="">
                                <select name="provider" class="form-control" id="default" required="required">
                                <option value="">Select Provider</option>
                                <?php $results=$data[1]; if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                                    <option value="<?php echo $result->cableid; ?>" ><?php echo $result->provider; ?></option>
                                <?php }} ?>
                                </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Name</label>
                                <div class="">
                                <input type="text" placeholder="Name" name="planname" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Plan Id</label>
                                <div class="">
                                <input type="number" placeholder="Plan Id" name="planid" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Duration In Days</label>
                                <div class="">
                                <input type="number" placeholder="Days" name="duration" class="form-control" required="required" >
                                </div>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Buying Price</label>
                                <div class="">
                                <input type="number" placeholder="Price" name="price" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">User Price</label>
                                <div class="">
                                <input type="number" placeholder="User Price" name="userprice" class="form-control" required="required" >
                                </div>
                            </div>


                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">Agent Price</label>
                                <div class="">
                                <input type="number" placeholder="Agent Price" name="agentprice" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">Vendor Price</label>
                                <div class="">
                                <input type="number" placeholder="Vendor Price" name="vendorprice" class="form-control" required="required" >
                                </div>
                            </div>
                            </div>

                            <div class="form-group">
                            <div class="d-flex justify-content-between">
                            <button type="submit" name="add-cable-plan" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Plan</button>
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
<div class="modal fade" data-backdrop="false" id="editCablePlan" tabindex="-1">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Edit Plan</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit">

                      <div class="row">
                            <input type="hidden" id="plan" name="plan" />
                            <div class="col-md-12 form-group">
                                <label for="success" class="control-label">Provider</label>
                                <div class="">
                                <select name="provider" class="form-control" id="provider" required="required">
                                <option value="">Select Provider</option>
                                <?php $results=$data[1]; if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                                    <option value="<?php echo $result->cableid; ?>" ><?php echo $result->provider; ?></option>
                                <?php }} ?>
                                </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Name</label>
                                <div class="">
                                <input type="text" id="planname" placeholder="Name" name="planname" class="form-control" required="required" >
                                </div>
                            </div>

                            
                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Plan Id</label>
                                <div class="">
                                <input type="number"  id="planid" placeholder="Plan Id" name="planid" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Duration In Days</label>
                                <div class="">
                                <input type="number" id="duration" placeholder="Days" name="duration" class="form-control" required="required" >
                                </div>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                <label for="success" class="control-label">Buying Price</label>
                                <div class="">
                                <input type="number" id="price" placeholder="Price" name="price" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">User Price</label>
                                <div class="">
                                <input type="number" id="userprice" placeholder="User Price" name="userprice" class="form-control" required="required" >
                                </div>
                            </div>


                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">Agent Price</label>
                                <div class="">
                                <input type="number" id="agentprice" placeholder="Agent Price" name="agentprice" class="form-control" required="required" >
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="success" class="control-label">Vendor Price</label>
                                <div class="">
                                <input type="number" id="vendorprice" placeholder="Vendor Price" name="vendorprice" class="form-control" required="required" >
                                </div>
                            </div>

                            </div>

                       <div class="form-group">
                        <div class="d-flex justify-content-between">
                           <button type="submit" name="update-cable-plan" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Plan</button>
						   <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
						</div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->


