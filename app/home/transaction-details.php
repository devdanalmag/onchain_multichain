<div class="page-content header-clear-medium" id="page-file-name" page-name="transaction-details">
    <div class="card card-style" style="position: relative; overflow: hidden;" id="receipt-content">
        <!-- Background image with low opacity -->
        <?php if (isset($_GET["receipt"])): ?>
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                    background-image: url('../../assets/img/favicon.png');
                    background-size: cover; 
                    background-attachment: fixed;
                    background-position: center;
                    opacity: 0.05; /* Adjust opacity (0.1 = 10%) */
                    z-index: 2;">
            </div>
        <?php endif; ?>

        <div class="content" style="position: relative; z-index: 1;">
            <?php if ($data->status == 0) { ?>
                <div class="text-center"><img src="../../assets/images/icons/success.png" style="width:150px; height:150px;" /></div>
            <?php } else if ($data->status == 2 || $data->status == 5) { ?>
                <div class="text-center"><img src="../../assets/images/icons/penddig.png" style="width:150px; height:150px;" /></div>
            <?php } else if ($data->status == 9) { ?>
                <div class="text-center"><img src="../../assets/images/icons/refund.png" style="height:150px;" /></div>
            <?php } else { ?>
                <div class="text-center"><img src="../../assets/images/icons/failed.png" style="width:200px; height:200px;" /></div><?php } ?>
            <p class="mb-0 font-600 color-highlight text-center">Transaction Details</p>
            <h1 class="text-center">Transaction
                <?php if ($data->status == 0) {
                    echo "Successful";
                } elseif ($data->status == 2 || $data->status == 5) {
                    echo "Processing";
                } elseif ($data->status == 9) {
                    echo "Refunded";
                } else {
                    echo "Failed";
                } ?>
            </h1>
            <table class="table table-bordered">
                <tr>
                    <td><b>Transaction No:</b></td>
                    <td><?php echo $data->transref; ?></td>
                </tr>
                <tr>
                    <td><b>Service:</b></td>
                    <td><?php echo $data->servicename; ?></td>
                </tr>
                <tr>
                    <td><b>Description:</b></td>
                    <td><?php echo $data->servicedesc; ?></td>
                </tr>
                <tr>
                    <td><b>Amount:</b></td>
                    <td>N<?php echo $data->amount; ?></td>
                </tr>
                <tr>
                    <td><b>Amount in TON:</b></td>
                    <td><?php echo $data->nanoton; ?>$TON</td>
                </tr>
                <tr>
                    <td><b>Received Wallet: </b></td>
                    <td> <?php if ($data->status == 9): echo $data->targetaddress;
                            else: echo "System Wallet";
                            endif ?></td>
                </tr>
                <tr>
                    <td><b>Sender Wallet: </b></td>
                    <td> <?php if ($data->status == 9): echo "Refunding Wallet";
                            else: echo $data->senderaddress;
                            endif ?></td>
                </tr>
                <tr>
                    <td><b>Transaction Hash: </b></td>
                    <td><?php echo $data->txhash; ?></td>
                </tr>
                <tr>
                    <?php
                    function summarizeAddress($input, $start = 4, $end = 2)
                    {
                        $length = strlen($input);
                        if ($length <= $start + $end) {
                            return $input; // No need to shorten
                        }
                        return substr($input, 0, $start) . '...' . substr($input, -$end);
                    }
                    ?>
                    <td><b>View In Explorer: </b></td>
                    <td> <a href="https://tonscan.org/tx/<?php echo $data->txhash; ?>" target="_blank">Tonscan.org/tx/<?php echo summarizeAddress($data->txhash); ?> <i class="fa fa-external-link" style="font-size:24px"></i></a></td>
                </tr>
                <tr>
                    <td><b>Status:</b></td>
                    <td><?php echo $controller->formatStatus($data->status); ?></td>
                </tr>
                <tr>
                    <td><b>Date:</b></td>
                    <td><?php echo $controller->formatDate($data->date); ?></td>
                </tr>
            </table>
            <?php if (!isset($_GET["receipt"])): ?>
                <a href="transaction-details?receipt&ref=<?php echo $_GET["ref"]; ?>" class="btn btn-success btn-sm">
                    <b>View User Receipt</b>
                </a>
            <?php endif; ?>
            <?php if ($data->servicename == "Data Pin" && $data->status == 0): ?>
                <a href="view-pins?ref=<?php echo $_GET["ref"]; ?>" style="margin-left:15px;" class="btn btn-primary btn-sm">
                    <b>View Pins</b>
                </a>
            <?php endif; ?>

        </div>
    </div>
    <!-- Share Button -->
    <?php if (isset($_GET["receipt"])): ?>
        <button id="share-receipt-btn" class="btn btn-info btn-sm" style="margin-left:15px;" onclick="sharereceipt()">
            <b>Download Receipt</b>
        </button>
    <?php endif; ?>
</div>