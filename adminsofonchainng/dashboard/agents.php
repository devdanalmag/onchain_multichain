<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
              <h4 class="box-title">All Agents</h4>
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
			                <th>Last Activity</th>
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
                            <td><?php echo $result->sWallet;?></td>
                            <td><?php echo $controller->formatDate($result->sLastActivity);?></td>
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




