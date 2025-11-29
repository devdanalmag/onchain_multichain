<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title"><b>General Analysis</b></h4>
			  <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#filterSearch">
				  <i class="fa fa-search" aria-hidden="true"></i> Search
			  </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-sm table-bordered table-striped">
					<tbody>
					
                        <tr>
                            <td>
                                <i class="fa fa-area-chart text-info font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Successful <br/> Transactions</b></h4> 
                                <h2 class="text-info"><?php echo $data["successful"]; ?></h2>
                            </td>

                            <td>
                                <i class="fa fa-area-chart text-danger font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Failed <br/> Transactions</b></h4> 
                                <h2 class="text-danger"><?php echo $data["failed"]; ?></h2>
                            </td>
                            
                        </tr>


                        <tr>
                            <td>
                                <i class="fa fa-phone text-primary font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Airtime <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["airtimeSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["airtimeTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-phone text-success font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Airtime <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["airtimeProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["airtimeTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <i class="fa fa-wifi text-primary font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Data <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["dataSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["dataTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-wifi text-success font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Data <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["dataProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["dataTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <i class="fa fa-barcode text-primary font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Data Pin <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["dataPinSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["dataPinTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-barcode text-success font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Data Pin <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["dataPinProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["dataPinTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <i class="fa fa-tv text-primary font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Cable TV <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["cableSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["cableTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-tv text-success font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Cable TV <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["cableProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["cableTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <i class="fa fa-bolt text-primary font-size-50"></i><br><br/>
                                <h4 class="text-dark"><b>Electricity <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["electricitySales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["electricityTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-bolt text-success font-size-50"></i><br><br/>
                                <h4 class="text-dark"><b>Electricity <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["electricityProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["electricityTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <i class="fa fa-graduation-cap text-primary font-size-50"></i><br><br/>
                                <h4 class="text-dark"><b>Exam Pin <br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["examSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["examTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <i class="fa fa-graduation-cap text-success font-size-50"></i><br><br>
                                <h4 class="text-dark"><b>Exam Pin <br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["examProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["examTransactions"]; ?> Transactions)</b></h4> 
                            </td>
                            
                        </tr>

						
					</tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>

                    