<div class="row">
    <div class="col-12">

        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Transaction Details</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


                <ul class="list-group">
                    <li class="list-group-item">
                        <b>Transaction No:</b> <?php echo $data->transref; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Service:</b><?php echo $data->servicename; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Description:</b> <?php echo $data->servicedesc; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Amount:</b>N<?php echo $data->amount; ?>
                    </li>
                    <!-- <li class="list-group-item">
                        <b>Old Balance:</b>
                        N<?php echo $data->oldbal; ?>
                    </li> -->
                    <li class="list-group-item">
                        <b>Transaction Hash:</b>
                        <?php echo $data->txhash; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Sender Wallet:</b>
                        <?php echo $data->senderaddress; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Target Wallet:</b>
                        <?php echo $data->targetaddress; ?>
                    </li>
                    <li class="list-group-item">
                        <b>Ton Amount:</b>
                        <?php echo $data->nanoton; ?>
                    </li>
                    <!-- <li class="list-group-item">
                        <b>New Balance:</b>
                        N<?php echo $data->newbal; ?>
                    </li> -->
                    <li class="list-group-item">
                        <b>Status:</b>
                        <?php echo $controller->formatTransStatus($data->status); ?>
                    </li>
                    <li class="list-group-item">
                        <b>Date:</b>
                        <?php echo $controller->formatDate($data->date); ?>
                    </li>
                    <li class="list-group-item">
                        <b>By User:</b>
                        <?php echo $data->sFname . "(" . $data->sEmail . ")"; ?>
                    </li>
                    <li class="list-group-item">
                        <td colspan="2">
                            <form method="POST">
                                <b>Change Transaction Status:</b>
                                <select name="transstatus" class="form-control mt-2">
                                    <option value="">Change Status</option>
                                    <option value="0">Successful</option>
                                    <option value="10">Successful & Debit</option>
                                    <option value="1">Failed</option>
                                    <option value="11">Failed & Refund</option>
                                </select>
                                <input type="hidden" name="trans" value="<?php echo base64_encode($_GET['ref']); ?>" />
                                <input type="hidden" name="user" value="<?php echo base64_encode($data->sId); ?>" />
                                <input type="hidden" name="amount" value="<?php echo base64_encode($data->amount); ?>" />
                                <button name="update-trans-status" class="btn btn-danger mt-2">Update Status</button>
                            </form>

                    </li>


                </ul>

                <br />
                <a href="transactions" class="btn btn-success btn-block"><i class="fa fa-home" aria-hidden="true"></i> Back To Transactions</a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>