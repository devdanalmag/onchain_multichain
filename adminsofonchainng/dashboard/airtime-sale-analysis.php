<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title"><b>Airtime Sales Analysis</b></h4>
			  <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#filterSearch">
				  <i class="fa fa-search" aria-hidden="true"></i> Search
			  </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">
				  <table class="table table-sm table-bordered table-striped text-center">
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
                                <img src="../../assets/images/icons/mtn.png" class="sale-icon" />
                                <h4 class="text-dark"><b>MTN Airtime<br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["mtnSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["mtnTransactions"]; ?> Transactions)</b></h4> 
                                
                            </td>

                            <td>
                                <img src="../../assets/images/icons/mtn.png" class="sale-icon" />
                                <h4 class="text-dark"><b>MTN Airtime<br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["mtnProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["mtnTransactions"]; ?> Transactions)</b></h4>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <img src="../../assets/images/icons/airtel.png" class="sale-icon" />
                                <h4 class="text-dark"><b>Airtel Airtime<br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["airtelSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["airtelTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <img src="../../assets/images/icons/airtel.png" class="sale-icon" />
                                <h4 class="text-dark"><b>Airtel Airtime<br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["airtelProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["airtelTransactions"]; ?> Transactions)</b></h4>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <img src="../../assets/images/icons/glo.png" class="sale-icon" />
                                <h4 class="text-dark"><b>Glo Airtime<br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["gloSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["gloTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <img src="../../assets/images/icons/glo.png" class="sale-icon" />
                                <h4 class="text-dark"><b>Glo Airtime<br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["gloProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["gloTransactions"]; ?> Transactions)</b></h4>
                            </td>
                            
                        </tr>

                        <tr>
                            <td>
                                <img src="../../assets/images/icons/9mobile.png" class="sale-icon" />
                                <h4 class="text-dark"><b>9mobile Airtime<br/> Sales</b></h4> 
                                <h2 class="text-primary">N<?php echo $data["9mobileSales"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["9mobileTransactions"]; ?> Transactions)</b></h4> 
                            </td>

                            <td>
                                <img src="../../assets/images/icons/9mobile.png" class="sale-icon" />
                                <h4 class="text-dark"><b>9mobile Airtime<br/> Profit</b></h4> 
                                <h2 class="text-success">N<?php echo $data["9mobileProfit"]; ?></h2>
                                <h4 class="text-dark"><b>(<?php echo $data["9mobileTransactions"]; ?> Transactions)</b></h4>
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

