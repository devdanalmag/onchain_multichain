<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;" id="pmsgdiv">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <strong>Message:</strong> <?php echo $pmsgerror; ?> <?php echo $pmsg; ?>
</div>
<div class="data">
  <div class="col-12">
    <div class="box">
      <div class="box-header with-border d-flex align-items-center justify-content-between">
        <h4 class="box-title">Pages</h4>
        <div class="d-flex align-items-center justify-content-end">
          <a class="ml-3 btn btn-success btn-sm btn-rounded text-white" data-toggle="modal" data-target="#Newmedia">
            <i class="fa fa-plus" aria-hidden="true"></i> Add New
          </a>
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
                <th>Action</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php $cnt = 1;

              // SELECT `tId`, `mName`, `mFollow`, `mLike`, `mComment`, `mShare`, `mSubscribe`, `mView`, `followPrice`, `likePrice`, `commentPrice`, `sharePrice`, `subscribePrice`, `viewPrice` FROM `medias` WHERE 1
              $result = Custom::Listmedia();
              while ($data = mysqli_fetch_assoc($result)):
                // Medi Name And Type
                $mname = $data["mName"];
                $mfollow = $data["mFollow"];
                $mview = $data["mView"];
                $mlike = $data["mLike"];
                $mcomm = $data["mComment"];
                $msubs = $data["mSubscribe"];
                $mshare = $data["mShare"];
                $mrepost = $data["mRepost"];

                // Type Price
                $likeprice = $data["likePrice"];
                $followprice = $data["followPrice"];
                $shareprice = $data["sharePrice"];
                $subsprice = $data["subscribePrice"];
                $viewprice = $data["viewPrice"];
                $commentprice = $data["commentPrice"];
                $repostprice = $data["repostPrice"];
                ?>
                <tr>
                  <td> <?php echo htmlentities($cnt++); ?></td>
                  <td><?php echo $data['mName']; ?></td>
                  <td><a class="btn btn-info" data-toggle="modal" onclick='GetId(<?php echo $data["tId"]; ?>,"<?php echo $mname; ?>",
                                        "<?php echo $mfollow; ?>","<?php echo $mlike; ?>",
                                        "<?php echo $mcomm; ?>","<?php echo $mshare; ?>",
                                        "<?php echo $msubs; ?>","<?php echo $mview; ?>",
                                        "<?php echo $mrepost; ?>",
                                        <?php echo $likeprice; ?>,<?php echo $followprice; ?>,
                                        <?php echo $shareprice; ?>,<?php echo $subsprice; ?>,
                                        <?php echo $viewprice; ?>,<?php echo $commentprice; ?>,
                                         <?php echo $repostprice; ?>);' data-target="#Editmedia"
                      style="color:white;"><i class="fa fa-edit"></i></a></td>
                  <td><a class="btn btn-danger" data-toggle="modal" onclick='deleteMedia(<?php echo $data["tId"]; ?>);'
                      data-target="#DeletePage" style="color:white;"><i class="fa fa-trash"></i></a></td>

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

<!-- Add New Media Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="Newmedia" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Add New Media</h5>
      </div>
      <div class="modal-body">
        <form method="post" class="form-submit">

          <div class="row">
            <input type="hidden" id="newmid" name="newmid" />
            <div class="col-md-12 form-group">
              <label for="success" class="control-label">Media</label>
              <div class="">
                <input type="text" id="newmedia" placeholder="Media" name="newmedia" class="form-control"
                  required="required">
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newfollow" name="newfollow" class="form-control" onclick="checknewtype();">
                <label for="newfollow" class="control-label">Follow</label>
              </div>
            </div>
            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newlike" name="newlike" class="form-control" onclick="checknewtype();">
                <label for="newlike" class="control-label">Like</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newcomment" name="newcomment" class="form-control" onclick="checknewtype();">
                <label for="newcomment" class="control-label">Comm.</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newshare" name="newshare" class="form-control" onclick="checknewtype();">
                <label for="newshare" class="control-label">Share</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newsubscribe" name="newsubscribe" class="form-control"
                  onclick="checknewtype();">
                <label for="newsubscribe" class="control-label">Subs.</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newview" name="newview" class="form-control" onclick="checknewtype();">
                <label for="newview" class="control-label">View</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="newrepost" name="newrepost" class="form-control" onclick="checknewtype();">
                <label for="newrepost" class="control-label">Repost</label>
              </div>
            </div>
            <div class="col-md-12 form-group">
            </div>
            <div id="followpdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Follow Price</label>
              <div class="">
                <input type="number" value="0" id="followpnew" placeholder="Price" name="followpnew" class="form-control">
              </div>
            </div>

            <div id="likepdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Like Price</label>
              <div class="">
                <input type="number" value="0" id="likepnew" placeholder="Price" name="likepnew" class="form-control">
              </div>
            </div>

            <div id="commentpdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Comment Price</label>
              <div class="">
                <input type="number" value="0" id="commentpnew" placeholder="Price" name="commentpnew" class="form-control">
              </div>
            </div>

            <div id="sharepdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Share Price</label>
              <div class="">
                <input type="number" value="0" id="sharepnew" placeholder="Price" name="sharepnew" class="form-control">
              </div>
            </div>

            <div id="subscribepdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Subs. Price</label>
              <div class="">
                <input type="number" value="0" id="subscribepnew" placeholder="Price" name="subscribepnew"
                  class="form-control">
              </div>
            </div>

            <div id="viewpdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">View Price</label>
              <div class="">
                <input type="number" value="0" id="viewpnew" placeholder="Price" name="viewpnew" class="form-control">
              </div>
            </div>

            <div id="repostpdivnew" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Repost Price</label>
              <div class="">
                <input type="number" value="0" id="repostpnew" placeholder="Price" name="repostpnew" class="form-control">
              </div>
            </div>


          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <button type="submit" name="add_media" class="btn btn-info btn-submit"><i class="fa fa-save"
                  aria-hidden="true"></i>ADD Media</button>
              <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
<!-- Edit Media Modal -->
<div class="modal modal-fill fade" data-backdrop="false" id="Editmedia" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Media</h5>
      </div>
      <div class="modal-body">
        <form method="post" class="form-submit">

          <div class="row">
            <input type="hidden" id="edtmid" name="edtmid" />
            <div class="col-md-12 form-group">
              <label for="success" class="control-label">Media</label>
              <div class="">
                <input type="text" id="edtmedia" placeholder="Media" name="edtmedia" class="form-control"
                  required="required">
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtfollow" name="edtfollow" class="form-control" onclick="checktype();">
                <label for="edtfollow" class="control-label">Follow</label>
              </div>
            </div>
            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtlike" name="edtlike" class="form-control" onclick="checktype();">
                <label for="edtlike" class="control-label">Like</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtcomment" name="edtcomment" class="form-control" onclick="checktype();">
                <label for="edtcomment" class="control-label">Comm.</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtshare" name="edtshare" class="form-control" onclick="checktype();">
                <label for="edtshare" class="control-label">Share</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtsubscribe" name="edtsubscribe" class="form-control"
                  onclick="checktype();">
                <label for="edtsubscribe" class="control-label">Subs.</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtview" name="edtview" class="form-control" onclick="checktype();">
                <label for="edtview" class="control-label">View</label>
              </div>
            </div>

            <div class="col-md-2 form-group">
              <div class="">
                <input type="checkbox" id="edtrepost" name="edtrepost" class="form-control" onclick="checktype();">
                <label for="edtrepost" class="control-label">Repost</label>
              </div>
            </div>
            <div class="col-md-12 form-group">
            </div>
            <div id="followpdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Follow Price</label>
              <div class="">
                <input type="number" value="0" id="followp" placeholder="Price" name="followp" class="form-control">
              </div>
            </div>

            <div id="likepdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Like Price</label>
              <div class="">
                <input type="number" value="0" id="likep" placeholder="Price" name="likep" class="form-control">
              </div>
            </div>

            <div id="commentpdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Comment Price</label>
              <div class="">
                <input type="number" value="0" id="commentp" placeholder="Price" name="commentp" class="form-control">
              </div>
            </div>

            <div id="sharepdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Share Price</label>
              <div class="">
                <input type="number" value="0" id="sharep" placeholder="Price" name="sharep" class="form-control">
              </div>
            </div>

            <div id="subscribepdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Subs. Price</label>
              <div class="">
                <input type="number" value="0" id="subscribep" placeholder="Price" name="subscribep"
                  class="form-control">
              </div>
            </div>

            <div id="viewpdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">View Price</label>
              <div class="">
                <input type="number" value="0" id="viewp" placeholder="Price" name="viewp" class="form-control">
              </div>
            </div>

            <div id="repostpdiv" class="col-md-3 form-group" style="display:none;">
              <label for="success" class="control-label">Repost Price</label>
              <div class="">
                <input type="number" value="0" id="repostp" placeholder="Price" name="repostp" class="form-control">
              </div>
            </div>


          </div>

          <div class="form-group">
            <div class="d-flex justify-content-between">
              <button type="submit" name="update_media" class="btn btn-info btn-submit"><i class="fa fa-save"
                  aria-hidden="true"></i> Update Media</button>
              <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
<script>

  function GetId(id, name, follow, like, comment, share, subscribe, view, repost, likeprice, followprice, shareprice, subsprice, viewprice, commentprice, repostprice) {
    let edtid = document.getElementById("edtmid");
    let media = document.getElementById("edtmedia");
    let followck = document.getElementById("edtfollow");
    let likeck = document.getElementById("edtlike");
    let commck = document.getElementById("edtcomment");
    let subsck = document.getElementById("edtsubscribe");
    let viewck = document.getElementById("edtview");
    let repostck = document.getElementById("edtrepost");
    let shareck = document.getElementById("edtshare");

    let followpf = document.getElementById("followp");
    let likepf = document.getElementById("likep");
    let commpf = document.getElementById("commentp");
    let subspf = document.getElementById("subscribep");
    let viewpf = document.getElementById("viewp");
    let repostpf = document.getElementById("repostp");
    let sharepf = document.getElementById("sharep");
    edtid.value = id;
    media.value = name;
    followck.checked = +follow;
    likeck.checked = +like;
    commck.checked = +comment;
    shareck.checked = +share;
    subsck.checked = +subscribe;
    viewck.checked = +view;
    repostck.checked = +repost;

    followpf.value = followprice;
    likepf.value = likeprice;
    commpf.value = commentprice;
    subspf.value = subsprice;
    viewpf.value = viewprice;
    repostpf.value = repostprice;
    sharepf.value = shareprice;
    checktype();
    checktype();
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
  function checktype() {
    let followck = document.getElementById("edtfollow");
    let likeck = document.getElementById("edtlike");
    let commck = document.getElementById("edtcomment");
    let subsck = document.getElementById("edtsubscribe");
    let viewck = document.getElementById("edtview");
    let repostck = document.getElementById("edtrepost");
    let shareck = document.getElementById("edtshare");

    let followpf = document.getElementById("followp");
    let likepf = document.getElementById("likep");
    let commpf = document.getElementById("commentp");
    let subspf = document.getElementById("subscribep");
    let viewpf = document.getElementById("viewp");
    let repostpf = document.getElementById("repostp");
    let sharepf = document.getElementById("sharep");

    let followpfdiv = document.getElementById("followpdiv");
    let likepfdiv = document.getElementById("likepdiv");
    let commpfdiv = document.getElementById("commentpdiv");
    let subspfdiv = document.getElementById("subscribepdiv");
    let viewpfdiv = document.getElementById("viewpdiv");
    let repostpfdiv = document.getElementById("repostpdiv");
    let sharepfdiv = document.getElementById("sharepdiv");

    if (followck.checked) {
      followpfdiv.style.display = "inline";
    }
    else {
      followpfdiv.style.display = "none";
      followpf.value = 0;
    }
    if (likeck.checked) {
      likepfdiv.style.display = "inline";
    }
    else {
      likepfdiv.style.display = "none";
      likepf.value = 0;
    }
    if (commck.checked) {
      commpfdiv.style.display = "inline";
    }
    else {
      commpfdiv.style.display = "none";
      commpf.value = 0;
    }
    if (shareck.checked) {
      sharepfdiv.style.display = "inline";
    }
    else {
      sharepfdiv.style.display = "none";
      sharepf.value = 0;
    } 
    if (subsck.checked) {
      subspfdiv.style.display = "inline";
    }
    else {
      subspfdiv.style.display = "none";
    subspf.value = 0;
    }
    if (viewck.checked) {
      viewpfdiv.style.display = "inline";
    }
    else {
      viewpfdiv.style.display = "none";
      viewpf.value = 0;
    }
    if (repostck.checked) {
      repostpfdiv.style.display = "inline";
    }
    else {
      repostpfdiv.style.display = "none";
      repostpf.value = 0;
    }
  }

function checknewtype() {
    let followck = document.getElementById("newfollow");
    let likeck = document.getElementById("newlike");
    let commck = document.getElementById("newcomment");
    let subsck = document.getElementById("newsubscribe");
    let viewck = document.getElementById("newview");
    let repostck = document.getElementById("newrepost");
    let shareck = document.getElementById("newshare");

    let followpf = document.getElementById("followpnew");
    let likepf = document.getElementById("likepnew");
    let commpf = document.getElementById("commentpnew");
    let subspf = document.getElementById("subscribepnew");
    let viewpf = document.getElementById("viewpnew");
    let repostpf = document.getElementById("repostpnew");
    let sharepf = document.getElementById("sharepnew");

    let followpfdiv = document.getElementById("followpdivnew");
    let likepfdiv = document.getElementById("likepdivnew");
    let commpfdiv = document.getElementById("commentpdivnew");
    let subspfdiv = document.getElementById("subscribepdivnew");
    let viewpfdiv = document.getElementById("viewpdivnew");
    let repostpfdiv = document.getElementById("repostpdivnew");
    let sharepfdiv = document.getElementById("sharepdivnew");

    if (followck.checked) {
      followpfdiv.style.display = "inline";
    }
    else {
      followpfdiv.style.display = "none";
      followpf.value = 0;
    }
    if (likeck.checked) {
      likepfdiv.style.display = "inline";
    }
    else {
      likepfdiv.style.display = "none";
      likepf.value = 0;
    }
    if (commck.checked) {
      commpfdiv.style.display = "inline";
    }
    else {
      commpfdiv.style.display = "none";
      commpf.value = 0;
    }
    if (shareck.checked) {
      sharepfdiv.style.display = "inline";
    }
    else {
      sharepfdiv.style.display = "none";
      sharepf.value = 0;
    } 
    if (subsck.checked) {
      subspfdiv.style.display = "inline";
    }
    else {
      subspfdiv.style.display = "none";
    subspf.value = 0;
    }
    if (viewck.checked) {
      viewpfdiv.style.display = "inline";
    }
    else {
      viewpfdiv.style.display = "none";
      viewpf.value = 0;
    }
    if (repostck.checked) {
      repostpfdiv.style.display = "inline";
    }
    else {
      repostpfdiv.style.display = "none";
      repostpf.value = 0;
    }
  }
</script>