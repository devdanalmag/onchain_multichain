<div class="page-content header-clear-medium">

  <div class="card card-style">

    <div class="content">
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;" id="pmsgdiv">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <strong>Message:</strong> <?php echo $pmsgerror; ?> <?php echo $pmsg; ?>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
              <h4 class="box-title">Pages</h4>
              <div class="d-flex align-items-center justify-content-end">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-sm table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>JID</th>
                      <th>Disc.</th>
                      <th>DateLine</th>
                      <th>Link</th>
                      <th>Status</th>
                      <th>Finished</th>
                      <th>Price</th>
                      <th>Date & Time</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tbody>

                    <?php $cnt = 1;
                    // 1000  Follow, Plan Of N2000 For social Media tiktok
                    $result = Scustom::Checkjob();
                    while ($data = mysqli_fetch_assoc($result)): ?>
                      <tr>
                        <td> <?php echo htmlentities($cnt++); ?></td>
                        <td>Post Job</td>
                        <td><?php echo $data['tJid']; ?></td>
                        <td>
                          <?php $jdisc = $data['tNumbers'] . " " . $data['tType'] . " For Social Media " . $data['tMedia'];
                          echo $jdisc; ?>
                        </td>
                        <td><?php echo $data['tDateline']; ?> Days</td>
                        <td><?php echo $data['tLink']; ?></td>
                        <td>
                          <?php if ($data['tStatus'] == "0" || $data['tStatus'] == 0) {
                            $status = '<b style="color:green;">Active</b>';
                          }
                          if ($data['tStatus'] == "1" || $data['tStatus'] == 1) {
                            $status = '<b style="color:red;">Dectivated</b>';
                          }
                          if ($data['tStatus'] == "2" || $data['tStatus'] == 2) {
                            $status = '<b style="color:red;">Dectivated By Admin</b>';
                          }
                          if ($data['tStatus'] == "3" || $data['tStatus'] == 3) {
                            $status = '<b style="color:green;">Finished</b>';
                          }
                          echo $status; ?>
                        </td>
                        <td><?php echo $data['tDone']; ?> / <?php echo $data['tNumbers']; ?></td>
                        <td><?php echo $data['tPrice']; ?></td>
                        <td><?php echo $controller->formatDate($data['date']); ?></td>


                        <td>
                          <?php if ($data['tStatus'] == "0" || $data['tStatus'] == 0) { ?>
                            <form action="" method="POST">
                              <input type="text" value="<?php echo $data['tId']; ?>" name="jobId" hidden>
                              <button class="btn btn-info btn-sm btn-block mt-2" name="deactivatejob" type="summit"
                                style="background-color:red;">Deactivate</button>
                            </form>
                          <?php } ?>
                          <?php if ($data['tStatus'] == "1" || $data['tStatus'] == 1) { ?>
                            <form action="" method="post">
                            <input type="text" value="<?php echo $data['tId']; ?>" name="jobId" hidden>
                              <button class="btn btn-info btn-sm btn-block mt-2" name="activatejob" type="summit"
                                style="background-color:green;">Activate</button>
                            </form>
                          <?php } ?>
                          <?php if ($data['tStatus'] == "2" || $data['tStatus'] == 2) { ?>
                              <a href="contact-us" class="btn btn-info btn-sm btn-block mt-2"
                                style="background-color:blue;">Contact Admin</a>
                          <?php } ?>
                          <?php if ($data['tStatus'] == "3" || $data['tStatus'] == 3) { ?>
                              <a href="#" class="btn btn-info btn-sm btn-block mt-2"
                                style="background-color:green;">Finished</a>
                          <?php } ?>
                        </td>

                      </tr>
                    <?php endwhile; ?>

                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <!-- Add New Pages Modal -->
      <div class="modal modal-fill fade" data-backdrop="false" id="addNewPage" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border">
            <div class="modal-header bg-info">
              <h5 class="modal-title">Add New Page</h5>
              <em style="color:#b71313 !important;">Note: You Must Creat page before adding It</em>
            </div>
            <div class="modal-body">
              <form method="post" class="form-submit row">
                <div class="form-group col-6">
                  <label for="success" class="control-label">Page Name</label>
                  <div class="">
                    <input type="text" name="npname" placeholder="Page Name" class="form-control" required="required">
                  </div>
                </div>

                <div class="form-group  col-6">
                  <label for="success" class="control-label">Page Link</label>
                  <div class="">
                    <input type="text" name="nplink" placeholder="Page Link" class="form-control" required="required">
                  </div>
                </div>

                <div class="form-group col-6" id="roleDiv">
                  <label for="Status" class="control-label">Status</label>
                  <div class="">
                    <select name="npstatus" class="form-control" required="required" id="status">
                      <option value="" selected disabled>Status</option>
                      <option value="online" style="color:#000000 !important;">Online</option>
                      <option value="offline" style="color:#000000 !important;">Offline</option>
                      <option value="atwork" style="color:#000000 !important;">Atwork</option>
                      <option value="banned" style="color:#000000 !important;">Banned</option>
                      <option value="notfound" style="color:#000000 !important;">Not Found(404)</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-12">
                  <div class="d-flex justify-content-between">
                    <button type="submit" name="AddNewPage" class="btn btn-info btn-submit"><i class="fa fa-plus"
                        aria-hidden="true"></i> Add Page</button>
                    <button type="button" class="btn btn-bold btn-pure btn-secondary"
                      data-dismiss="modal">Close</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal -->
      <!-- Edit Pages Modal -->
      <div class="modal modal-fill fade" backdrop="false" id="EditPage" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border">
            <div class="modal-header bg-info">
              <h5 class="modal-title">Edit Page</h5>
            </div>
            <div class="modal-body">
              <form method="post" class="form-submit row">
                <input type="text" name="epid" class="form-control" required="required" id="edtpid" hidden>

                <div class="form-group col-6">
                  <label for="success" class="control-label">Page Name</label>
                  <div class="">
                    <input type="text" name="epname" placeholder="Page Name" class="form-control" required="required"
                      id="edtpname">
                  </div>
                </div>

                <div class="form-group  col-6">
                  <label for="success" class="control-label">Page Link</label>
                  <div class="">
                    <input type="text" name="eplink" placeholder="Page Link" class="form-control" required="required"
                      id="edtplink">
                  </div>
                </div>

                <div class="form-group col-6" id="roleDiv">
                  <label for="Status" class="control-label">Status</label>
                  <div class="">
                    <select name="epstatus" class="form-control" required="required" id="edtpstatus">
                      <option value="" selected disabled>Status</option>
                      <option value="online" style="color:#000000 !important;">Online</option>
                      <option value="offline" style="color:#000000 !important;">Offline</option>
                      <option value="atwork" style="color:#000000 !important;">Atwork</option>
                      <option value="banned" style="color:#000000 !important;">Banned</option>
                      <option value="notfound" style="color:#000000 !important;">Not Found(404)</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-12">
                  <div class="d-flex justify-content-between">
                    <button type="submit" name="update_page" class="btn btn-info btn-submit"><i class="fa fa-edit"
                        aria-hidden="true"></i>Update Page</button>
                    <button type="button" class="btn btn-bold btn-pure btn-secondary"
                      data-dismiss="modal">Close</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal -->
      <script>

        function GetId(pid, pname, plink, pstatus) {
          let edtpid = document.getElementById("edtpid");
          let edtpname = document.getElementById("edtpname");
          let edtplink = document.getElementById("edtplink");
          let edtpstatus = document.getElementById("edtpstatus");
          // Fields
          //Set the Input Value To be the ID
          // notification.classList.add("notification");
          console.log(pid);
          console.log(pname);
          edtpid.value = pid;
          edtpname.value = pname;
          edtplink.value = plink;
          edtpstatus.value = pstatus;
        }
        let msgdiv = document.getElementById('pmsgdiv');
        var pmsg = "<?php echo $pmsg; ?>";
        var msgcolor = "<?php echo $pmsgerror; ?>"
        if (pmsg !== "") {
          if (msgcolor !== "") {
            msgdiv.classList.remove("alert-success")
            msgdiv.classList.add("alert-danger")

          }
          msgdiv.style.display = 'block';
        }

      </script>
    </div>

  </div>

</div>