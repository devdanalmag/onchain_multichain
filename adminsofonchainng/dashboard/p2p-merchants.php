<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
                <h4 class="box-title">All Plans</h4>
                <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addMerchant">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand/Company Name</th>
                                <th>Username</th>
                                <th>whatsapp No.</th>
                                <th>Coins</th>
                                <th>Prices</th>
                                <th>Limit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $cnt = 1;
                            $results = $data[0];
                            if ($results <> "" && $results <> 1) {
                                foreach ($results as $result) {   ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo $result->mBrand; ?> </td>
                                        <td><?php echo $result->mUsername; ?></td>
                                        <td><?php echo $result->mWhatsapp; ?></td>
                                        <td><?php echo $result->mCoins; ?></td>
                                        <td><?php echo $result->mPrice; ?></td>
                                        <td><?php echo $result->mLimit; ?></td>
                                        <td><?php echo $controller->formatstatuses($result->mStatus); ?></td>

                                        <td>
                                            <a href="merchant-details?mapo=<?php echo urlencode(base64_encode($result->mId)); ?>&apo=<?php echo urlencode(base64_encode($result->sId)); ?>" class="btn btn-info btn-sm btn-block mt-2">View/Edit</a>
                                        </td>
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
<!-- <input type="number" id="merchantPhone" value="" >  -->
<!-- <button type="button" onclick="getMerchantByPhone()"></button> -->
<!-- Add Category Modal -->
<div class="modal fade" data-backdrop="false" id="addMerchant" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Add Merchant</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="success" class="control-label">Phone Number</label>
                            <div class="">
                                <input type="text" placeholder="Phone Number" name="mphone" id="merchantPhone" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="">
                                <button type="button" name="" onclick="getMerchantByPhone()" class="btn btn-info"><i class="fa fa-user" aria-hidden="true"></i> Get Data</button>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Username</label>
                            <div class="">
                                <input type="text" id="mUsername" placeholder="Username" name="mUsername" class="form-control" required="required" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Email</label>
                            <div class="">
                                <input type="email" id="mEmail" placeholder="Email Adress" name="mEmail" class="form-control" required="required" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Company/Brand Name</label>
                            <div class="">
                                <input type="text" placeholder="Brand Name" name="mBname" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Whatsapp Number</label>
                            <div class="">
                                <input type="number" placeholder="Whatsapp Number" name="mWnumber" class="form-control" required="required">
                            </div>
                        </div>

                                            <div class="form-group col-md-6">
                        <label for="success" class="control-label">Action</label>
                        <div class="">
                            <select class="form-control" name="mStatus" required>
                                <option value="0" >BUY</option>
                                <option value="1" >SELL</option>
                                <option value="2" >BUY & SELL</option>
                            </select>
                        </div>
                    </div>

                    </div>
                    <?php
                    // Initialize variables with proper error handling
                    // Check if $data[2] exists before looping
                    if (!empty($data[1])) {
                        foreach ($data[1] as $mydata) {
                            if ($mydata->status <> 1) continue;
                    ?>
                            <div class="form-group col-md-8 row">
                                <div class="col-md-4 form-group">
                                    <div class="form-check">
                                        <input type="checkbox"
                                            id="<?= htmlspecialchars($mydata->Symbol) ?>"
                                            name="coins[]"
                                            value="<?= $mydata->cId ?>"
                                            class="form-check-input"
                                            onclick="checkcoin();">
                                        <label for="<?= htmlspecialchars($mydata->Symbol) ?>" class="form-check-label">
                                            <?= htmlspecialchars($mydata->Symbol) ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group" id="limit_<?= $mydata->cId ?>" style="display: none;">
                                    <label for="limit_<?= $mydata->cId ?>" class="form-label">Limit</label>
                                    <input type="text"
                                        id="limit_<?= $mydata->cId ?>"
                                        name='limits[<?= $mydata->cId ?>]'
                                        value=""
                                        class="form-control"
                                        >
                                </div>
                                <div class="col-md-4 form-group" id="price_<?= $mydata->cId ?>_div" style="display: none;">
                                    <label for="price_<?= $mydata->cId ?>" class="form-label">Price</label>
                                    <input type="text"
                                        id="price_<?= $mydata->cId ?>"
                                        name='prices[<?= $mydata->cId ?>]'
                                        value=""
                                        class="form-control"
                                        >
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="alert alert-warning">No coin data available</div>';
                    }
                    ?>
                    <input type="text" id="sId" name="sId" hidden>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="add-merchant" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add Merchant</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->