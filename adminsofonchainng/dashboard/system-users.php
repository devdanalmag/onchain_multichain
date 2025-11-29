<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">System Users</h4>
			  <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addNewUser">
				  <i class="fa fa-plus" aria-hidden="true"></i> Add New User
			  </a>
            </div> 
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Fullname</th>
			                <th>Role</th>
			                <th>Username</th>
			                <th>Password</th>
			                <th>Status</th>
			                <th>Action</th>
						</tr>
					</thead>
					<tbody>
					
					<?php 
                        $cnt=1; $results=$data;
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                          <td><?php echo htmlentities($cnt);?></td>
                          <td><?php echo htmlentities($result->sysName);?></td>
                          <td>
                          <?php 
                            if($result->sysRole == 1){echo "Super Admin"; }
                            if($result->sysRole == 2){echo "Asst. Admin"; }
                           ?>
                          </td>
                          <td><?php echo htmlentities($result->sysUsername);?></td>
                          <td>
                          <input style="border: 0px; background-color: transparent;" type="password" id="key<?php echo $cnt; ?>" value="<?php echo htmlentities($result->sysToken);?>" disabled />
						  <div><b class="text-primary" id="opt<?php echo $cnt; ?>" onclick="showKey('<?php echo $cnt; ?>')" > Show Password</b></div>
						  
                          </td>
                          <td>
                          <?php if($result->sysStatus == 0){echo "<b class='text-success'>Active</b>"; }
                           else{echo "<b class='text-danger'>Blocked</b>";} ?>
                          </td>
                          <td>
						  <?php if($result->sysStatus == 0){?>
                          	<a href="#" onclick="blockUser(<?php echo $result->sysId;?>,<?php echo $result->sysStatus;?>)" class="btn btn-danger"><i class="fa fa-edit" title="Edit Record"></i> Block User</a> 
						  <?php } else {?>
                          	<a href="#" onclick="blockUser(<?php echo $result->sysId;?>,<?php echo $result->sysStatus;?>)" class="btn btn-primary"><i class="fa fa-edit" title="Edit Record"></i> Activate User</a> 
						  <?php } ?>
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
						<h5 class="modal-title">Add New System User</h5>
					</div>
					  <div class="modal-body">
					  <form  method="post" class="form-submit">
                       <div class="form-group">
                        <label for="success" class="control-label">Fullname</label>
                        <div class="">
                        <input type="text" pattern="[A-Za-z',.:@_() ]{1,100}" title="Only Aplhanumeric Values Are Accepted" name="name" class="form-control" required="required" id="success">
                        </div>
                       </div>
                       
                       <div class="form-group">
                        <label for="success" class="control-label">Username</label>
                        <div class="">
                        <input type="text" pattern="[A-Za-z',.:@_() 0-9]{1,100}" title="Only Aplhanumeric Values Are Accepted" name="username" class="form-control" required="required" id="success">
                        </div>
                       </div>
                       
                       <div class="form-group">
                        <label for="success" class="control-label">Password</label>
                        <div class="">
                        <input type="password" name="password" class="form-control" required="required" id="success">
                        </div>
                       </div>
                       
                       <div class="form-group" id="roleDiv">
                        <label for="roleOption" class="control-label">User Role</label>
                        <div class="">
                        <select name="role" class="form-control" required="required" id="roleOption">
                          <option value="1">Super Admin</option>
                          <option value="2">Asst. Admin</option>
                        </select>
                        </div>
                       </div>
                       
                        <div class="form-group">
                          <div class="d-flex justify-content-between">
                            <button type="submit" name="add-new-user" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </form>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->

<!-- Add New User Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="d" tabindex="-1">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title">Add New System User</h5>
						<button type="button" class="close" data-dismiss="modal">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<p>Your content comes here</p>
						<br><br><br><br><br><br>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-bold btn-pure btn-primary float-right">Save changes</button>
					  </div>
					</div>
				  </div>
</div>
<!-- /.modal -->


