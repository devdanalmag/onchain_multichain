<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-header with-border">
        <h4 class="box-title">Search Transactions</h4>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form method="GET">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Keyword" name="search" aria-label="Phone Or Keyword">
          </div>
          <div class="form-group">
            <select class="form-control" name="searchfor" required>
              <option value="">Search For ..</option>
              <option value="all">All Transaction</option>
              <option value="reference">Transaction Reference</option>
              <option value="user">User Transaction</option>
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
          <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Search</button>
          </div>

        </form>
      </div>
    </div>
    <?php if (isset($_GET["search"])):
      echo $controller->createNotification1("alert-info", "<b>Showing Result For Search Key: '" . $_GET["search"] . "' For " . ucwords($_GET["searchfor"]) . " Transaction </b> "); endif; ?>

    <div class="box">
      <div class="box-header with-border d-flex justify-content-between align-items-center">
        <h4 class="box-title">Transactions</h4>
        <div class="btn-group" role="group" aria-label="tx-type-tabs">
          <a class="btn btn-outline-primary btn-sm<?php echo (!isset($_GET['tx_type']) || $_GET['tx_type'] == 'app') ? ' active' : ''; ?>"
            href="transactions?tx_type=app<?php if (isset($_GET['search'])):
              echo '&search=' . $_GET['search'] . '&searchfor=' . $_GET['searchfor']; endif; ?>">App</a>
          <a class="btn btn-outline-primary btn-sm<?php echo (isset($_GET['tx_type']) && $_GET['tx_type'] == 'dex') ? ' active' : ''; ?>"
            href="transactions?tx_type=dex<?php if (isset($_GET['search'])):
              echo '&search=' . $_GET['search'] . '&searchfor=' . $_GET['searchfor']; endif; ?>">DEX</a>
          <a class="btn btn-outline-secondary btn-sm" href="tokens">Tokens</a>
        </div>
        <a class="btn btn-info btn-sm"
          href="transactions?page=<?php echo $pageCount;
          if (isset($_GET["search"])):
            echo "&search=" . $_GET["search"] . "&searchfor=" . $_GET["searchfor"]; endif;
          if (isset($_GET['tx_type'])):
            echo "&tx_type=" . $_GET['tx_type']; endif; ?>">Next
          1000</a>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
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
                <th>Blockchain</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Token</th>
                <th>Contract</th>
                <th>Profit</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $cnt = 1;
              $results = $data;
              if ($results <> "" && $results <> 1) {
                foreach ($results as $result) { ?>
                  <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><a href="transaction-details?ref=<?php echo $result->transref; ?>"
                        class="text-info"><b><?php echo $result->transref; ?></b></a></td>
                    <td><?php echo $result->sEmail; ?></td>
                    <td><?php echo $controller->formatUserType($result->sType); ?></td>
                    <td><?php echo $result->sPhone; ?></td>
                    <td><?php echo $result->servicename; ?></td>
                    <td><?php echo $result->blockchain_name ?? 'N/A'; ?></td>
                    <td><?php echo $result->servicedesc; ?></td>
                    <td>N<?php echo $result->amount; ?></td>
                    <td><?php echo isset($result->transaction_type) ? strtoupper($result->transaction_type) : 'APP'; ?></td>
                    <td><?php echo isset($result->token_name) ? $result->token_name : ''; ?></td>
                    <td style="font-family: monospace; font-size: 12px;">
                      <?php echo isset($result->token_contract) ? $result->token_contract : ''; ?></td>
                    <td>N<?php echo $result->profit; ?></td>
                    <td><?php echo $controller->formatTransStatus($result->status); ?></td>
                    <td><?php echo $controller->formatDate($result->date); ?></td>
                  </tr>
                  <?php $cnt = $cnt + 1;
                }
              } ?>

            </tbody>
          </table>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>