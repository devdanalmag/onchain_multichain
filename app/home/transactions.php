<div class="page-content header-clear-medium">
        
        <div class="card card-style">
            <div class="content">
                <h4>Transactions</h4>
                <p>
                    Your last 100 transactions. <br/>
                    <b class="text-danger">Click on the transaction to view details.</b>
                </p>
                <form method="GET" class="the-submit-form">
                     <div class="form-group">
                      <input type="text" class="form-control" placeholder="Keyword" name="search" aria-label="Phone Or Keyword">
                     </div>
                     <div class="form-group mt-2">
                      <select class="form-control" name="searchfor" required>
                          <option value="">Search For ..</option>
                          <option value="all">All Transaction</option>
                          <option value="reference">Transaction Reference</option>
                          <option value="wallet">Wallet Transaction</option>
                          <option value="monnify">Monnify Transaction</option>
                          <option value="paystack">Paystack Transaction</option>
                          <option value="airtime">Airtime Transaction</option>
                          <option value="data">Data Transaction</option>
                          <option value="cable">Cable Tv Transaction</option>
                          <option value="exam">Exam Pin Transaction</option>
                          <option value="electricity">Electricity Transaction</option>
                      </select>
                     </div>
                     <div class="form-group mt-2">
                      <button class="btn btn-primary the-form-btn" type="submit"><i class="fa fa-search"></i> Search</button>
                     </div>
                     
                </form>
                 <?php if(isset($_GET["search"])): echo "<b class='text-info'>Showing Result For Search Key: '".$_GET["search"]."' </b>"; endif; ?>
            </div>
        </div>

        <div class="card card-style p-3">
            <?php if(!empty($data)){ $i=1; foreach($data as $list){   ?>
           
                <a href="transaction-details?ref=<?php echo $list->transref; ?>" class="d-flex">
                    <div class="align-self-center">
                        <?php if($list->servicename == "Airtime"): ?>
                        <span class="icon icon-s gradient-green color-white rounded-sm shadow-xxl"><i class="fa fa-phone font-15"></i></span>
                        <?php elseif($list->servicename == "Data"): ?>
                        <span class="icon icon-s gradient-blue color-white rounded-sm shadow-xxl"><i class="fa fa-wifi font-15"></i></span>
                        <?php elseif($list->servicename == "Cable TV"): ?>
                        <span class="icon icon-s gradient-brown color-white rounded-sm shadow-xxl"><i class="fa fa-tv font-15"></i></span>
                        <?php elseif($list->servicename == "Electricity Bill"): ?>
                        <span class="icon icon-s gradient-yellow color-white rounded-sm shadow-xxl"><i class="fa fa-bolt font-15"></i></span>
                        <?php elseif($list->servicename == "Exam Pin"): ?>
                        <span class="icon icon-s gradient-green color-white rounded-sm shadow-xxl"><i class="fa fa-graduation-cap font-15"></i></span>
                        <?php elseif($list->servicename == "Cable TV"): ?>
                        <span class="icon icon-s gradient-blue color-white rounded-sm shadow-xxl"><i class="fa fa-tv font-15"></i></span>
                        <?php elseif($list->servicename == "Wallet Transfer"): ?>
                        <span class="icon icon-s gradient-pink color-white rounded-sm shadow-xxl"><i class="fa fa-arrow-up font-15"></i></span>
                        <?php elseif($list->servicename == "Referral Bonus"): ?>
                        <span class="icon icon-s gradient-pink color-white rounded-sm shadow-xxl"><i class="fa fa-user font-15"></i></span>
                        <?php elseif($list->servicename == "Referral Debit"): ?>
                        <span class="icon icon-s gradient-pink color-white rounded-sm shadow-xxl"><i class="fa fa-user font-15"></i></span>
                        <?php elseif($list->servicename == "Refund"): ?>
                        <span class="icon icon-s gradient-pink color-white rounded-sm shadow-xxl"><i class="fa fa-undo font-15"></i></span>
                        <?php else: ?>
                        <span class="icon icon-s gradient-pink color-white rounded-sm shadow-xxl"><i class="fa fa-list font-15"></i></span>
                        <?php endif; ?>
                    </div>
                    <div class="align-self-center">
                        <h5 class="ps-3 mb-n1 font-15"><?php echo $list->servicename; ?></h5>
                        <h6 class="ps-3 font-12 mt-3 color-theme opacity-70"><?php echo $list->servicedesc; ?></h6>
                        <span class="ps-3 font-10 color-theme opacity-70"><?php echo "Ref: ".$list->transref; ?></span>
                    </div>
                    <div class="ms-auto text-end align-self-center">
                        <h5 class="color-theme font-15 font-700 d-block mb-n1">N<?php echo $list->amount; ?></h5>
                        <?php if($list->status == 0 || $list->status == 9): ?>
                        <span class="color-green-dark font-10"><?php echo $controller->formatDate2($list->date); ?> <i class="fa fa-check-circle"></i></span>
                        <?php elseif($list->status == 5 || $list->status == 2): ?>
                        <span class="color-blue-dark font-10"><?php echo $controller->formatDate2($list->date); ?> <i class="fa fa-exclamation-circle"></i></span>
                        <?php else: ?>
                        <span class="color-red-dark font-10"><?php echo $controller->formatDate2($list->date); ?> <i class="fa fa-exclamation-circle"></i></span>
                        <?php endif; ?>
                     </div>
                </a>
                <div class="divider my-3"></div>
            
            <?php $i++; }}  else {echo "<h3 class='text-danger'>No Transaction To Display</h3>";} ?>
        </div>
        <div class="card card-style">
            <div class="content">
                <div class="d-flex justify-content-between">
                    <h5>Transactions</h5>
                    <a class="btn btn-primary btn-sm" href="transactions?page=<?php echo $pageCount; if(isset($_GET["search"])): echo "&search=".$_GET["search"]."&searchfor=".$_GET["searchfor"]; endif; ?>"><b>Next 100</b></a>
                </div>
             </div>
        </div>

        
</div>

