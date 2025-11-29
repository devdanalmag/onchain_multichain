<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
              <h4 class="box-title">Messages</h4>
			</div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
			                <th>Subject</th>
			                <th>Message</th>
			                <th>Name</th>
			                <th>Contact</th>
			                <th>Date Posted</th>
			                <th>Action</th>
						</tr>
					</thead>
					<tbody>
					 
					<?php 
                        $cnt=1; $results=$data;
                        if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                        <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($result->subject);?></td>
                            <td><?php echo htmlentities($result->message);?></td>
                            <td><?php echo htmlentities($result->name);?></td>
                            <td><?php echo htmlentities($result->contact);?></td>
                            <td><?php echo $controller->formatDate($result->dPosted);?></td>
                            <td>
                                <a href="#" onclick="deleteMessage(<?php echo $result->msgId;?>)" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a> 
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




