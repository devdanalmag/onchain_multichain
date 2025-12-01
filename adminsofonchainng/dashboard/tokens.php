<?php $admin = new AdminModel(); $controller = new AdminModel(); $tokens = $admin->getAllTokens(); ?>
<div class="row">
  <div class="col-12">
    <div class="box">
      <div class="box-header with-border d-flex justify-content-between align-items-center">
        <h4 class="box-title">Manage Tokens</h4>
      </div>
      <div class="box-body">
        <form method="post">
          <div class="form-group">
            <label>Token Name</label>
            <input type="text" name="token_name" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Contract Address</label>
            <input type="text" name="token_contract" class="form-control" placeholder="0x..." required />
          </div>
          <div class="form-group">
            <label>Decimals</label>
            <input type="number" name="token_decimals" class="form-control" min="1" max="36" required />
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="is_active" class="form-control"><option value="1">Active</option><option value="0">Disabled</option></select>
          </div>
          <button type="submit" name="save_token" class="btn btn-primary">Save Token</button>
        </form>
        <?php if(isset($_POST['save_token'])){ $res=$admin->upsertToken(null, $_POST['token_name'], $_POST['token_contract'], $_POST['token_decimals'], $_POST['is_active']); echo '<div class="alert '.($res['status']=='success'?'alert-success':'alert-danger').'">'.($res['status']=='success'?'Saved':'Error: '.$res['msg']).'</div>'; $tokens=$admin->getAllTokens(); } ?>
        <hr/>
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped">
            <thead><tr><th>ID</th><th>Name</th><th>Contract</th><th>Decimals</th><th>Status</th><th>Updated</th></tr></thead>
            <tbody>
              <?php if($tokens){ foreach($tokens as $t){ ?>
              <tr>
                <td><?php echo $t->token_id; ?></td>
                <td><?php echo htmlspecialchars($t->token_name); ?></td>
                <td style="font-family: monospace; font-size: 12px;"><?php echo htmlspecialchars($t->token_contract); ?></td>
                <td><?php echo $t->token_decimals; ?></td>
                <td><?php echo $t->is_active?'Active':'Disabled'; ?></td>
                <td><?php echo $t->updated_at; ?></td>
              </tr>
              <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
