<div class="row">
						
                        <div class="col-12">
                          <div class="alert alert-info" role="alert">
                            <h4>Showing <b><?php echo ucfirst($data["service"]); ?></b> Sales Analysis From <?php echo $data["datefrom"]; ?> To <b><?php echo $data["dateto"]; ?></b></h4>
                          </div>
                        </div>

                        <div class="col-12">
                            <div class="box">

                              <div class="row no-gutters py-2">
                                <div class="col-12 col-lg-4">
                                  <div class="box-body br-1 border-light no-radius">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="fa fa-bar-chart text-primary font-size-50"></i><br>
                                        </div>
                                        <div>										
                                            <h2 class="text-primary my-0 text-right"><?php echo $data["transactions"]; ?></h2>
                                            <p class="mb-0 text-muted text-right">Transactions</p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
    
                                <div class="col-12 col-lg-4">
                                  <div class="box-body br-1 border-light no-radius">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="fa fa-area-chart text-info font-size-50"></i><br>
                                        </div>
                                        <div>										
                                              <h2 class="text-info my-0 text-right">N<?php echo $data["sales"]; ?> </h2>
                                            <p class="mb-0 text-muted text-right">Total Sales</p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
    
                                <div class="col-12 col-lg-4">
                                  <div class="box-body br-1 border-light no-radius">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="fa fa-money text-success font-size-50"></i><br>
                                        </div>
                                        <div>										
                                              <h2 class="text-success my-0 text-right">N<?php echo $data["profit"]; ?> </h2>
                                            <p class="mb-0 text-muted text-right">Total Profit</p>
                                        </div>
                                    </div>
                                  </div>
                                </div>
    
                              </div>
                            </div>
                        </div>

        </div>

        <?php include($data["service"]."-sale-analysis.php"); ?>

        <!-- Add New User Modal -->
        <div class="modal modal-fill fade" data-backdrop="false" id="filterSearch" tabindex="-1">
				  <div class="modal-dialog">
					<div class="modal-content border">
					  <div class="modal-header bg-info">
						<h5 class="modal-title">Search Filter </h5>
					</div>
					  <div class="modal-body">
					  <form  method="POST" class="form-submit row">
              
                       <div class="form-group col-12">
                        <label for="success" class="control-label">Service</label>
                        <div class="">
                        <select class="form-control" name="service" required="required" >
                            <option value="All">All Service</option>
                            <option value="Airtime">Airtime</option>
                            <option value="Data">Data Bundle</option>
                        </select>
                        </div>
                       </div>

                       <div class="form-group  col-md-6">
                        <label for="success" class="control-label">Date From</label>
                        <div class="">
                        <input type="datetime-local" name="datefrom" placeholder="Date From" class="form-control" required="required" >
                        </div>
                       </div>

                       <div class="form-group  col-md-6">
                        <label for="success" class="control-label">Date To</label>
                        <div class="">
                        <input type="datetime-local" name="dateto" placeholder="Date To" class="form-control" required="required" >
                        </div>
                       </div>
                       
                        <div class="form-group col-12">
                          <div class="d-flex justify-content-between">
                            <button type="submit" name="filterSalesResult" class="btn btn-info btn-submit"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </form>

					  </div>
					</div>
				  </div>
        </div>
        <!-- /.modal -->
                    