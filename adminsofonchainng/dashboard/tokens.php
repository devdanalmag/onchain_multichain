<?php
$tokens = $data;
$adminModel = new AdminModel();
$blockchains = $adminModel->getAllBlockchains();
?>
<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-header with-border d-flex align-items-center justify-content-between">
        <h4 class="box-title">Token Management</h4>
        <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addTokenModal">
          <i class="fa fa-plus" aria-hidden="true"></i> Add New
        </a>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="example1" class="table table-sm table-bordered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Blockchain</th>
                <th>Contract Address</th>
                <th>Decimals</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($tokens && $tokens <> 1) {
                $cnt = 1;
                foreach ($tokens as $t) {
                  $chainName = "Unknown";
                  foreach ($blockchains as $b) {
                    if ($b->id == $t->chain_id) {
                      $chainName = $b->name;
                      break;
                    }
                  }
                  ?>
                  <tr>
                    <td><?php echo $cnt++; ?></td>
                    <td><?php echo htmlspecialchars($t->token_name); ?></td>
                    <td><?php echo htmlspecialchars($chainName); ?></td>
                    <td style="font-family: monospace; font-size: 11px;"><?php echo htmlspecialchars($t->token_contract); ?>
                    </td>
                    <td><?php echo $t->token_decimals; ?></td>
                    <td>
                      <?php echo $t->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Disabled</span>'; ?>
                    </td>
                    <td>
                      <div class="btn-group">
                        <button
                          onclick="editToken('<?php echo $t->token_id; ?>','<?php echo $t->token_name; ?>','<?php echo $t->token_contract; ?>','<?php echo $t->token_decimals; ?>','<?php echo $t->chain_id; ?>','<?php echo $t->is_active; ?>')"
                          class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                        <button onclick="deleteToken('<?php echo $t->token_id; ?>')" class="btn btn-danger btn-sm"><i
                            class="fa fa-trash"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php }
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addTokenModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Add New Token</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-submit">
          <div class="form-group">
            <label>Blockchain</label>
            <select name="chain_id" class="form-control" required>
              <option value="">Select Blockchain</option>
              <?php foreach ($blockchains as $b) { ?>
                <option value="<?php echo $b->id; ?>"><?php echo $b->name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Token Name</label>
            <input type="text" name="token_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Contract Address</label>
            <input type="text" name="token_contract" class="form-control" placeholder="0x..." required>
          </div>
          <div class="form-group">
            <label>Decimals</label>
            <input type="number" name="token_decimals" class="form-control" value="18" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control">
              <option value="1">Active</option>
              <option value="0">Disabled</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" name="add-token" class="btn btn-info btn-submit">Add Token</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTokenModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Edit Token</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" class="form-submit">
          <input type="hidden" name="token_id" id="edit_token_id">
          <div class="form-group">
            <label>Blockchain</label>
            <select name="chain_id" id="edit_token_chain_id" class="form-control" required>
              <?php foreach ($blockchains as $b) { ?>
                <option value="<?php echo $b->id; ?>"><?php echo $b->name; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Token Name</label>
            <input type="text" name="token_name" id="edit_token_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Contract Address</label>
            <input type="text" name="token_contract" id="edit_token_contract" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Decimals</label>
            <input type="number" name="token_decimals" id="edit_token_decimals" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="is_active" id="edit_token_is_active" class="form-control">
              <option value="1">Active</option>
              <option value="0">Disabled</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update-token" class="btn btn-primary btn-submit">Update Token</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>