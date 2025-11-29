<div class="row">
    <div class="col-12">

        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Merchant Details</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit row">

                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Brand Name</label>
                        <div class="">
                            <input type="text" name="bname" value="<?php echo $data[0]->mBrand; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Username</label>
                        <div class="">
                            <input type="text" name="username" value="<?php echo $data[0]->mUsername; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Email</label>
                        <div class="">
                            <input type="text" name="email" value="<?php echo $data[1]->sEmail; ?>" class="form-control" required="required" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">WhatsApp Phone</label>
                        <div class="">
                            <input type="number" name="wphone" value="<?php echo $data[0]->mWhatsapp; ?>" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Phone Number</label>
                        <div class="">
                            <input type="text" name="pnumber" value="<?php echo $data[0]->mPhone; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Company Logo</label>
                        <div class="">
                            <input type="text" name="blogo" value="<?php echo $data[0]->mLogo; ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Registration Date</label>
                        <div class="">
                            <input type="text" value="<?php echo $controller->formatDate($data[1]->sRegDate); ?>" class="form-control" readonly required="required">
                        </div>
                    </div>
                    <?php
                    // Initialize variables with proper error handling
                    $coinIds = isset($data[0]->mCoins) ? array_map('intval', explode(",", $data[0]->mCoins)) : [];
                    $limits = isset($data[0]->mLimit) ?  explode(",", $data[0]->mLimit) : [];
                    $prices = isset($data[0]->mPrice) ? explode(",", $data[0]->mPrice) : [];

                    // Create associative array only if we have data
                    $coinData = [];
                    if (!empty($coinIds)) {
                        for ($i = 0; $i < count($coinIds); $i++) {
                            $coinData[$coinIds[$i]] = [
                                'limit' => $limits[$i] ?? '',
                                'price' => $prices[$i] ?? ''
                            ];
                        }
                    }

                    // Check if $data[2] exists before looping
                    if (!empty($data[2])) {
                        foreach ($data[2] as $mydata) {
                            if ($mydata->status <> 1) continue;

                            $checked = in_array($mydata->cId, $coinIds) ? "checked" : "";
                            $coinLimit = $coinData[$mydata->cId]['limit'] ?? '';
                            $coinPrice = $coinData[$mydata->cId]['price'] ?? '';
                    ?>
                            <div class="form-group col-md-8 row">
                                <div class="col-md-2 form-group">
                                    <div class="form-check">
                                        <input type="checkbox"
                                            id="<?= htmlspecialchars($mydata->Symbol) ?>"
                                            name="coins[]"
                                            value="<?= $mydata->cId ?>"
                                            class="form-check-input"
                                            onclick="checkcoin();"
                                            <?= $checked ?>>
                                        <label for="<?= htmlspecialchars($mydata->Symbol) ?>" class="form-check-label">
                                            <?= htmlspecialchars($mydata->Symbol) ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2 form-group" id="limit_<?= $mydata->cId ?>" style="display: none;">
                                    <label for="limit_<?= $mydata->cId ?>" class="form-label">Limit</label>
                                    <input type="text"
                                        id="limit_<?= $mydata->cId ?>"
                                        name="limits[<?= $mydata->cId ?>]"
                                        value="<?= htmlspecialchars($coinLimit) ?>"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 form-group" id="price_<?= $mydata->cId ?>_div" style="display: none;">
                                    <label for="price_<?= $mydata->cId ?>" class="form-label">Price</label>
                                    <input type="text"
                                        id="price_<?= $mydata->cId ?>"
                                        name="prices[<?= $mydata->cId ?>]"
                                        value="<?= htmlspecialchars($coinPrice) ?>"
                                        class="form-control">
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="alert alert-warning">No coin data available</div>';
                    }
                    ?>
                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Action</label>
                        <div class="">
                            <select class="form-control" name="mAction" required>
                                <?php if ($data[0]->mAction == 0): echo '<option value="0" selected>BUY</option>';
                                else: echo '<option value="0">BUY</option>';
                                endif; ?>
                                <?php if ($data[0]->mAction == 1): echo '<option value="1" selected>SELL</option>';
                                else: echo '<option value="1">SELL</option>';
                                endif; ?>
                                <?php if ($data[0]->mAction == 2): echo '<option value="2" selected>BUY & SELL</option>';
                                else: echo '<option value="2">BUY & SELL</option>';
                                endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="success" class="control-label">Status</label>
                        <div class="">
                            <select class="form-control" name="mStatus" required>
                                <?php if ($data[0]->mStatus == 0): echo '<option value="0" selected>Active</option>';
                                else: echo '<option value="0">Active</option>';
                                endif; ?>
                                <?php if ($data[0]->mStatus == 1): echo '<option value="1" selected>Not Active</option>';
                                else: echo '<option value="1">Not Active</option>';
                                endif; ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="user" value="<?php echo base64_encode($data[0]->mId); ?>" />

                    <div class="form-group col-md-6 row">
                        <div class="">
                            <button type="submit" name="update-merchant" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
                            <a href="p2p-merchants" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>


        <div class="box mt-2">
            <div class="box-header with-border">
                <h4 class="box-title">Delete Marchant </h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="post" class="form-submit3 row">

                    <p class="text-danger col-md-12">
                        <b>Note: </b>
                        When you delete an account, all details about the user including transaction records and wallet history would be removed permanently from the system. You should only delete an account when you notice the account was registered with fake details or looks suspicious.
                    </p>

                    <div class="form-group col-md-12">
                        <div class="">
                            <button type="button" onclick="terminateMerchant('<?php echo base64_encode($data[0]->mId); ?>');" class="btn btn-danger btn-submit3"><i class="fa fa-trash" aria-hidden="true"></i> Delete Merchant</button>
                            <a href="p2p-merchants" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>

    </div>
</div>

<script>
    var checkboxes = document.querySelectorAll('input[name="coins[]"]');
    checkboxes.forEach(function(checkbox) {
        var coinId = checkbox.value;
        var limitDiv = document.getElementById('limit_' + coinId);
        var priceDiv = document.getElementById('price_' + coinId + '_div');

        if (checkbox.checked) {
            limitDiv.style.display = 'block';
            priceDiv.style.display = 'block';
        } else {
            limitDiv.style.display = 'none';
            priceDiv.style.display = 'none';
        }
    });
</script>