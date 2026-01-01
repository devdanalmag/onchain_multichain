<?php $blockchains = $data; ?>
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border d-flex align-items-center justify-content-between">
                <h4 class="box-title">Blockchain Management</h4>
                <a class="btn btn-success btn-rounded text-white" data-toggle="modal" data-target="#addBlockchainModal">
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
                                <th>Chain ID</th>
                                <th>Symbol</th>
                                <th>RPC URL</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($blockchains && $blockchains <> 1) {
                                $cnt = 1;
                                foreach ($blockchains as $b) { ?>
                                    <tr>
                                        <td><?php echo $cnt++; ?></td>
                                        <td><?php echo htmlspecialchars($b->name); ?></td>
                                        <td><?php echo $b->chain_id; ?> (<?php echo $b->chain_id_hex; ?>)</td>
                                        <td><?php echo htmlspecialchars($b->native_symbol); ?></td>
                                        <td style="font-size: 11px;"><?php echo htmlspecialchars($b->rpc_url); ?></td>
                                        <td><?php echo $b->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Disabled</span>'; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button
                                                    onclick="editBlockchain('<?php echo $b->id; ?>','<?php echo $b->chain_key; ?>','<?php echo $b->name; ?>','<?php echo $b->rpc_url; ?>','<?php echo $b->explorer_url; ?>','<?php echo $b->native_symbol; ?>','<?php echo $b->chain_id; ?>','<?php echo $b->chain_id_hex; ?>','<?php echo $b->is_active; ?>')"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                <button onclick="deleteBlockchain('<?php echo $b->id; ?>')"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
<div class="modal fade" id="addBlockchainModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Add New Blockchain</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Chain Key (e.g. base, bsc)</label>
                            <input type="text" name="chain_key" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Name (e.g. Base Mainnet)</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>RPC URL</label>
                            <input type="url" name="rpc_url" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Explorer URL</label>
                            <input type="url" name="explorer_url" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Native Symbol</label>
                            <input type="text" name="native_symbol" class="form-control" placeholder="ETH" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Chain ID (Decimal)</label>
                            <input type="number" name="chain_id" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Chain ID (Hex)</label>
                            <input type="text" name="chain_id_hex" class="form-control" placeholder="0x..." required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add-blockchain" class="btn btn-info btn-submit">Add
                            Blockchain</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editBlockchainModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Blockchain</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-submit">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Chain Key</label>
                            <input type="text" name="chain_key" id="edit_chain_key" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>RPC URL</label>
                            <input type="url" name="rpc_url" id="edit_rpc_url" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Explorer URL</label>
                            <input type="url" name="explorer_url" id="edit_explorer_url" class="form-control">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Native Symbol</label>
                            <input type="text" name="native_symbol" id="edit_native_symbol" class="form-control"
                                required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Chain ID (Decimal)</label>
                            <input type="number" name="chain_id" id="edit_chain_id" class="form-control" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Chain ID (Hex)</label>
                            <input type="text" name="chain_id_hex" id="edit_chain_id_hex" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="is_active" id="edit_is_active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update-blockchain" class="btn btn-primary btn-submit">Update
                            Blockchain</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>