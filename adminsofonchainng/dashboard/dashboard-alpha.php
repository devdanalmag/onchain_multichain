<div class="row">
						
					
<div class="col-12">
    <div class="box">
      <div class="row no-gutters py-2">
        <div class="col-12 col-lg-4">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-chain text-info font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-info my-0 text-right">N<?php echo $data[1]["walletOneBalance"]; ?></h2>
                    <p class="mb-0 text-muted text-right">Wallet Balance</p>
                    <p class="mb-0 text-dark text-right">(<b><?php echo $data[1]["walletOneProvider"]; ?></b>)</p>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-chain text-info font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-info my-0 text-right">N<?php echo $data[1]["walletTwoBalance"]; ?> </h2>
                    <p class="mb-0 text-muted text-right">Wallet Balance</p>
                    <p class="mb-0 text-dark text-right">(<b><?php echo $data[1]["walletTwoProvider"]; ?></b>)</p>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-chain text-info font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-info my-0 text-right">N<?php echo $data[1]["walletThreeBalance"]; ?> </h2>
                    <p class="mb-0 text-muted text-right">Wallet Balance</p>
                    <p class="mb-0 text-dark text-right">(<b><?php echo $data[1]["walletThreeProvider"]; ?></b>)</p>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
</div>

<div class="col-12">
    <div class="box">
      <div class="row no-gutters py-2">
        
        <div class="col-12 col-lg-3">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-money text-success font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-success my-0 text-right">N<?php echo number_format($data[0]["uwCount"]); ?> </h2>
                    <p class="mb-0 text-muted text-right">User</p>
                    <p class="mb-0 text-dark text-right">(Wallet)</p>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-money text-success font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-success my-0 text-right">N<?php echo number_format($data[0]["awCount"]); ?></h2>
                    <p class="mb-0 text-muted text-right">Agent</p>
                    <p class="mb-0 text-dark text-right">(Wallet)</p>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-money text-success font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-success my-0 text-right">N<?php echo number_format($data[0]["vwCount"]); ?></h2>
                    <p class="mb-0 text-muted text-right">Vendors</p>
                    <p class="mb-0 text-dark text-right">(Wallet)</p>
                </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3">
          <div class="box-body br-1 border-light no-radius">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="fa fa-money text-success font-size-50"></i><br>
                </div>
                <div>										
                      <h2 class="text-success my-0 text-right">N<?php echo number_format($data[0]["rwCount"]); ?></h2>
                    <p class="mb-0 text-muted text-right">Referrals</p>
                    <p class="mb-0 text-dark text-right">(Wallet)</p>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>
</div>

<div class="col-md-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <?php echo $data[0]["sCount"]; ?> <small>Subscribers</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-primary">Users</span></p>
                </div>
                <div class="fa fa-user text-primary font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"><?php echo $data[0]["aCount"]; ?> <small>Agents</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-primary">Users</span></p>
                </div>
                <div class="fa fa-users text-primary font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"><?php echo $data[0]["vCount"]; ?> <small>Vendors</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-primary">Users</span></p>
                </div>
                <div class="fa fa-users text-primary font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <?php echo $data[0]["rCount"]; ?> <small>Referrals</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-primary">Referrals</span></p>
                </div>
                <div class="fa fa-group text-primary font-size-30"></div>
            </div>
        </div>
    </div>
</div>



<div class="col-12 col-lg-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <?php echo $data[0]["alphaCount"]; ?> <small>Alpha</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-danger">Alpha Request</span></p>
                </div>
                <div class="fa fa-list-alt text-danger font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <?php echo $data[0]["tCount"]; ?> <small>Tran</small></h2>
                    <p class="text-muted mb-0"><span class="badge badge-danger">Transactions</span></p>
                </div>
                <div class="fa fa-list-alt text-danger font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<!-- Traffic Sta -->
<div class="col-12 col-lg-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <b><?php echo $data[0]["mCount"]; ?> <small>Unread</small> </b></h2>
                    <p class="text-muted mb-0"><span class="badge badge-danger">Message</span></p>
                </div>
                <div class="fa fa-envelope text-danger font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-lg-3">
    <div class="box">
        <div class="box-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="">
                    <h2 class="mb-2"> <b><?php echo $data[0]["visitCount"]; ?> <small>Visit Today</small> </b></h2>
                    <p class="text-muted mb-0"><span class="badge badge-danger">Total Visit Today</span></p>
                </div>
                <div class="fa fa-eye text-danger font-size-30"></div>
            </div>
        </div>
    </div>
</div>

<!-- Traffic Sta -->
<div class="col-md-12">
    <div class="box">
        <div class="box-body bg-info text-white">
        <h5 class="box-title"><b>Last 50 Transactions</b></h5>
        </div>
        <!-- /.box-header -->
        <div class="">
        <div class="table-responsive">
<table id="example1" class="table table-sm table-bordered table-striped">
<thead>
    <tr>
        <th>#</th>
        <th>Ref Id</th>
        <th>User</th>
        <th>User Type</th>
        <th>Phone</th>
        <th>Service</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
</thead>
<tbody>

<?php 
    $cnt=1; $results=$data[0]["transactions"];
    if($results <> "" && $results <> 1){foreach($results as $result){   ?>
    <tr>
        <td><?php echo htmlentities($cnt);?></td>
        <td><a href="transaction-details?ref=<?php echo $result->transref; ?>" class="text-info"><b><?php echo $result->transref; ?></b></a></td>
        <td><?php echo $result->sEmail;?></td>
        <td><?php echo $controller->formatUserType($result->sType);?></td>
        <td><?php echo $result->sPhone;?></td>
        <td><?php echo $result->servicename;?></td>
        <td><?php echo $result->servicedesc;?></td>
        <td>N<?php echo $result->amount;?></td>
        <td><?php echo $controller->formatTransStatus($result->status); ?></td>
        <td><?php echo $controller->formatDate($result->date);?></td>
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
