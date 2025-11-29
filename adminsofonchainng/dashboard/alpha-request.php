<div class="row">
    <div class="col-12">
        <div class="box">
        <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">Pending Requests </h4>
            <a class="btn btn-success btn-rounded text-white" href="alpha-topup">
              <i class="fa fa-eye" aria-hidden="true"></i> Price List
            </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Ref</th>
			                <th>Description</th>
			                <th>Date</th>
			                <th>Action</th>
			            </tr>
					</thead>
					<tbody>
					
					<?php 
                        $cnt=1; $results=$data;
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo $cnt; ?></td>
							<td><?php echo $result->transref; ?></td>
                            <td><?php echo $result->servicedesc; ?></td>
                            <td><?php echo $controller->formatDate($result->date); ?></td>
                            <td>
                                <a href="#" onclick="confirmAlphaTopupOrder(<?php echo $result->tId;?>)" class="btn btn-success">Complete</a> 
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



