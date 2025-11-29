<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">Subscribers</h4>
              <div class="d-flex align-items-center justify-content-end">
              <a class="btn btn-info btn-sm btn-rounded" href="subscribers?page=<?php echo $pageCount; ?>">Next 1000</a> 
               <a class="ml-3 btn btn-success btn-sm btn-rounded text-white" data-toggle="modal" data-target="#addNewUser">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Name</th>
			                <th>Phone</th>
			                <th>Email</th>
			                <th>Wallet</th>
			                <th>Account</th>
			                <th>Status</th>
			                <th>Reg Date</th>
			                <th>Last Activity</th>
			                <th>Action</th>
			            </tr>
					</thead>
					<tbody>
					
					<?php 
                        $cnt=1; $results=$data;
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo $result->sLname . " " . $result->sFname;?></td>
                            <td><?php echo $result->sPhone;?></td>
                            <td><?php echo $result->sEmail;?></td>
                            <td>N<?php echo number_format($result->sWallet);?></td>
                            <td><?php echo $controller->formatUserType($result->sType);?></td>
                            <td><?php echo $controller->formatStatus($result->sRegStatus);?></td>
                            
                            <td><?php echo $controller->formatDate($result->sRegDate);?></td>
                            <td><?php echo $controller->formatDate($result->sLastActivity);?></td>
                            <td>
                                <a href="credit-user?apo=<?php echo urlencode(base64_encode($result->sEmail)); ?>" class="btn btn-success btn-sm btn-block">Credit Or Debit</a>
                                <a href="subscriber-details?apo=<?php echo urlencode(base64_encode($result->sId)); ?>" class="btn btn-info btn-sm btn-block mt-2">View User</a>
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

<!-- Add New User Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="addNewUser" tabindex="-1">
				  <div class="modal-dialog">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Add New Subscriber</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit row">
                       <div class="form-group col-6">
                        <label for="success" class="control-label">First Name</label>
                        <div class="">
                        <input type="text" name="fname" placeholder="First Name" class="form-control" required="required" >
                        </div>
                       </div>

                       <div class="form-group  col-6">
                        <label for="success" class="control-label">Last Name</label>
                        <div class="">
                        <input type="text" name="lname" placeholder="Last Name" class="form-control" required="required" >
                        </div>
                       </div>
                       
                       <div class="form-group  col-6">
                        <label for="success" class="control-label">Email</label>
                        <div class="">
                        <input type="email" name="email" placeholder="Email" class="form-control" required="required" >
                        </div>
                       </div>

                       <div class="form-group  col-6">
                        <label for="success" class="control-label">Phone</label>
                        <div class="">
                        <input type="number" name="phone" placeholder="Phone" class="form-control" required="required" >
                        </div>
                       </div>

                       <div class="form-group  col-6">
                        <label for="success" class="control-label">Password</label>
                        <div class="">
                        <input type="text" name="password" placeholder="Password" class="form-control" required="required" >
                        </div>
                       </div>
                       
                       <div class="form-group col-6" id="roleDiv">
                        <label for="state" class="control-label">State</label>
                        <div class="">
                        <select name="state" class="form-control" required="required" id="state">
                        <option value="" selected disabled>State</option>
                              <option value="Abuja FCT" style="color:#000000 !important;">Abuja FCT</option>
                              <option value="Abia" style="color:#000000 !important;">Abia</option>
                              <option value="Adamawa" style="color:#000000 !important;">Adamawa</option>
                              <option value="Akwa Ibom" style="color:#000000 !important;">Akwa Ibom</option>
                              <option value="Anambra" style="color:#000000 !important;">Anambra</option>
                              <option value="Bauchi" style="color:#000000 !important;">Bauchi</option>
                              <option value="Bayelsa" style="color:#000000 !important;">Bayelsa</option>
                              <option value="Benue" style="color:#000000 !important;">Benue</option>
                              <option value="Borno" style="color:#000000 !important;">Borno</option>
                              <option value="Cross River" style="color:#000000 !important;">Cross River</option>
                              <option value="Delta" style="color:#000000 !important;">Delta</option>
                              <option value="Ebonyi" style="color:#000000 !important;">Ebonyi</option>
                              <option value="Edo" style="color:#000000 !important;">Edo</option>
                              <option value="Ekiti" style="color:#000000 !important;">Ekiti</option>
                              <option value="Enugu" style="color:#000000 !important;">Enugu</option>
                              <option value="Gombe" style="color:#000000 !important;">Gombe</option>
                              <option value="Imo" style="color:#000000 !important;">Imo</option>
                              <option value="Jigawa" style="color:#000000 !important;">Jigawa</option>
                              <option value="Kaduna" style="color:#000000 !important;">Kaduna</option>
                              <option value="Kano" style="color:#000000 !important;">Kano</option>
                              <option value="Katsina" style="color:#000000 !important;">Katsina</option>
                              <option value="Kebbi" style="color:#000000 !important;">Kebbi</option>
                              <option value="Kogi" style="color:#000000 !important;">Kogi</option>
                              <option value="Kwara" style="color:#000000 !important;">Kwara</option>
                              <option value="Lagos" style="color:#000000 !important;">Lagos</option>
                              <option value="Nassarawa" style="color:#000000 !important;">Nassarawa</option>
                              <option value="Niger" style="color:#000000 !important;">Niger</option>
                              <option value="Ogun" style="color:#000000 !important;">Ogun</option>
                              <option value="Ondo" style="color:#000000 !important;">Ondo</option>
                              <option value="Osun" style="color:#000000 !important;">Osun</option>
                              <option value="Oyo" style="color:#000000 !important;">Oyo</option>
                              <option value="Plateau" style="color:#000000 !important;">Plateau</option>
                              <option value="Rivers" style="color:#000000 !important;">Rivers</option>
                              <option value="Sokoto" style="color:#000000 !important;">Sokoto</option>
                              <option value="Taraba" style="color:#000000 !important;">Taraba</option>
                              <option value="Yobe" style="color:#000000 !important;">Yobe</option>
                              <option value="Zamfara" style="color:#000000 !important;">Zamfara</option>
                        </select>
                        </div>
                       </div>
                       
                        <div class="form-group col-12">
                          <div class="d-flex justify-content-between">
                            <button type="submit" name="add-new-subscriber" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Subscriber</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->




