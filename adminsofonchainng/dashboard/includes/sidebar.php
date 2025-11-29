<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
		
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <a href="<?php echo $urlAddon; ?>dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
        
        <?php if(AdminController::$role == 1) : ?>
        <li>
          <a href="<?php echo $urlAddon; ?>system-users">
            <i class="fa fa-user-secret"></i> <span>System Users</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
        <?php endif; ?>

        <li>
          <a href="<?php echo $urlAddon; ?>subscribers">
            <i class="fa fa-users"></i> <span>Subscribers</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <li>
          <a href="<?php echo $urlAddon; ?>credit-user-account">
            <i class="fa fa-user-plus"></i> <span>Credit User</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <?php if(AdminController::$role == 1 || AdminController::$role == 2) : ?>
        <li>
          <a href="<?php echo $urlAddon; ?>all-services">
            <i class="fa fa-list"></i> <span>Services</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
        <?php endif; ?>

        <li>
          <a href="<?php echo $urlAddon; ?>transactions">
            <i class="fa fa-money"></i> <span>Transactions</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <li>
          <a href="<?php echo $urlAddon; ?>sale-analysis">
            <i class="fa fa-area-chart"></i> <span>Sales Analysis</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
        
        <li>
          <a href="<?php echo $urlAddon; ?>send-email">
            <i class="fa fa-envelope"></i> <span>Send Email</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <li>
          <a href="<?php echo $urlAddon; ?>notifications">
            <i class="fa fa-info"></i> <span>Notifications</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
        
        <li>
          <a href="<?php echo $urlAddon; ?>messages">
            <i class="fa fa-wechat"></i> <span>Message</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

  
        <li>
          <a href="<?php echo $urlAddon; ?>earning-setting">
            <i class="fa fa-money"></i> <span>Earning Setting</span>
		      	<span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
       


        <li>
          <a href="<?php echo $urlAddon; ?>site-setting">
            <i class="fa fa-cog"></i> <span>Site Settings</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <li>
          <a href="<?php echo $urlAddon; ?>api-setting">
            <i class="fa fa-plug"></i> <span>API Settings</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>


        <li>
          <a href="<?php echo $urlAddon; ?>manage-account">
            <i class="fa fa-user"></i> <span>Manage Account</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>

        <li>
          <a href="<?php echo $urlAddon; ?>logout">
            <i class="fa fa-lock"></i> <span>Logout</span>
			      <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>			
        </li>
    </ul>
    </section>
  </aside>