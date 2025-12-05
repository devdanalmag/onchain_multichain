<?php 
include_once("includes/header.php"); 
?>

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Error Logs
        <small>System Error Logs</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Error Logs</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">System Error Log Content</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-success btn-sm" onclick="location.reload();">
                  <i class="fa fa-refresh"></i> Reload Log
                </button>
              </div>
            </div>
            
            <div class="box-body">
              <?php
              // Define log file path relative to this file or absolute
              // Based on user request: c:\xampp\htdocs\onchain_multichain\log_error\error_log.txt
              $logFilePath = __DIR__ . '/../../log_error/error_log.txt';
              
              $logContent = "Log file not found or empty.";
              if (file_exists($logFilePath)) {
                  $logContent = file_get_contents($logFilePath);
                  if (empty($logContent)) {
                      $logContent = "Log file is empty.";
                  }
              }
              ?>
              
              <div class="form-group">
                <label for="errorLogContent">Full Log Content (Read-Only)</label>
                <textarea class="form-control" id="errorLogContent" rows="20" readonly style="font-family: monospace; background-color: #f5f5f5; font-size: 12px; white-space: pre;"><?php echo htmlspecialchars($logContent); ?></textarea>
              </div>
              
            </div>
            
            <div class="box-footer">
               <p class="text-muted">Path: <?php echo htmlspecialchars($logFilePath); ?></p>
            </div>
            
          </div>
        </div>
      </div>
    </section>
</div>

<?php include_once("includes/footer.php"); ?>