<div class="d-flex justify-content-between">
    <a class="btn btn-success btn-block mr-2" href="api-setting">General Setting</a>
    <a class="btn btn-primary btn-block ml-2 mt-0" href="monnify-setting">Monnify Setting</a>
    <a class="btn btn-info btn-block ml-4 mt-0" href="paystack-setting">Paystack Setting</a>
</div>
<hr />

<div class="row">
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>Note: </strong> <br /> This is a restricted area. You need to obtain an access code to perform this operation. Before adding any link here please study the api documentation or contact Topupmate Technology Admin for assistance.
        </div>
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
                <h4 class="box-title">Manage Api Links</h4>
                <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addnewapi">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="example3" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Value</th>
                                <th>Type</th>
                                <th>Action</th>
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
                                        <td><?php echo $result->name; ?> </td>
                                        <td><?php echo $result->value; ?></td>
                                        <td><?php echo $result->type; ?></td>
                                        <td>
                                            <a href="#" onclick="editApi('<?php echo $result->aId; ?>','<?php echo $result->name; ?>','<?php echo $result->value; ?>','<?php echo $result->type; ?>')" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>
                                            <a href="#" onclick="deleteApi(<?php echo $result->aId; ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                            <?php $cnt = $cnt + 1;
                                }
                            } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.box-header -->
<!-- <div class="box-body">
        
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label for="success" class="control-label">Api Provider Name</label>
                    <div class="">
                    <input type="text" name="providername" placeholder="Api Provider Name" class="form-control" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Api Url</label>
                    <div class="">
                    <input type="text" name="providerurl" placeholder="Api Url" class="form-control" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="success" class="control-label">Service</label>
                    <div class="">
                        <select name="service" class="form-control" required>
                            <option value="">Select Service</option>
                            <option value="Wallet">Wallet</option>
                            <option value="Airtime">Airtime</option>
                            <option value="Data">Data</option>
                            <option value="CableVer">Cable Verification</option>
                            <option value="Cable">Cable</option>
                            <option value="ElectricityVer">Electricity Verification</option>
                            <option value="Electricity">Electricity</option>
                            <option value="Exam">Exam</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="">
                       <button type="submit" name="add-new-api-details" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Details</button>
                    </div>
                </div>
        </form>
        </div> -->
<!-- /.box-body -->
<!-- Add Category Modal -->
<div class="modal fade" data-backdrop="false" id="addnewapi" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Add New API</h5>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">

                        <div class="col-md-12 form-group">
                            <label for="success" class="control-label">Access Code</label>
                            <div class="">
                                <input type="number" name="code" placeholder="Access Code" class="form-control" required />
                            </div>
                            <?php echo "AP" . date("Hymd") . date("d"); ?>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="success" class="control-label">Name</label>
                            <div class="">
                                <input type="text" name="providername" placeholder="Api Provider Name" class="form-control" required />
                            </div>
                        </div>


                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Type</label>
                            <div class="">
                                <select name="service" class="form-control" required>
                                    <option value="" disabled>Select Service</option>
                                    <option value="Wallet">Wallet</option>
                                    <option value="Airtime">Airtime</option>
                                    <option value="Data">Data</option>
                                    <option value="CableVer">Cable Verification</option>
                                    <option value="Cable">Cable</option>
                                    <option value="ElectricityVer">Electricity Verification</option>
                                    <option value="Electricity">Electricity</option>
                                    <option value="Exam">Exam</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Value / Links</label>
                            <div class="">
                                <input type="text" name="providerurl" placeholder="Api Url" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="add-new-api-details" class="btn btn-info btn-submit"><i class="fa fa-plus" aria-hidden="true"></i> Add API</button>
                            <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="false" id="editApi" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Edit API</h5>
            </div>
            <div class="modal-body">
            <form method="post" class="form-submit">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="success" class="control-label">Name</label>
                            <div class="">
                                <input type="text" id="eprovidername" name="eprovidername" placeholder="Api Provider Name" class="form-control" required />
                            </div>
                        </div>
                        <input type="hidden" id="apiid" name="apiid" />
                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Type</label>
                            <div class="">
                                <select id="eservice" name="eservice" class="form-control" required>
                                    <option value="" disabled>Select Service</option>
                                    <option value="Wallet">Wallet</option>
                                    <option value="Airtime">Airtime</option>
                                    <option value="Data">Data</option>
                                    <option value="CableVer">Cable Verification</option>
                                    <option value="Cable">Cable</option>
                                    <option value="ElectricityVer">Electricity Verification</option>
                                    <option value="Electricity">Electricity</option>
                                    <option value="Exam">Exam</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="success" class="control-label">Value / Links</label>
                            <div class="">
                                <input type="text" id="eproviderurl" name="eproviderurl" placeholder="Api Url" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                        <button type="submit" name="update-api" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update API</button>
                        <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- </div> -->
<!-- /.box -->