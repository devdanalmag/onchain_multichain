<style>
    .list-custom-small {
        --hover-color: <?php echo $sitecolor; ?>;
        --icon-bg: <?php echo $sitecolor; ?>;
        --transition-speed: 0.3s;
    }

    .list-custom-small a {
        display: flex;
        /* align-items: center; */
        padding: 0px 12px;
        border-radius: 50px;
        margin-bottom: 5px;
        text-decoration: none;
        background-color: rgba(255, 255, 255, 0.05);
        transition: all var(--transition-speed) ease;
        position: relative;
        overflow: hidden;
    }

    .list-custom-small a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: all 0.6s ease;
    }

    .list-custom-small a:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        transform: translateX(5px);
    }

    .list-custom-small a:hover::before {
        left: 100%;
    }

    .list-custom-small a.active {
        background-color: var(--hover-color) !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .list-custom-small a.active:hover span {
        color: #fff !important;
        /* text-shadow: 0 0 5px rgba(255, 255, 255, 0.3); */
    }
    .list-custom-small a i:first-child {
        width: 36px;
        height: 36px;
        line-height: 36px;
        text-align: center;
        border-radius: 50%;
        margin-right: 12px;
        background-color: var(--icon-bg);
        transition: all var(--transition-speed) ease;
        box-shadow: 0 5px 8px rgba(0.1, 0.1, 0.2, 0.2);
    }

    .list-custom-small a:hover i:first-child {
        transform: scale(1.1);
    }

    .list-custom-small a span {
        font-size: 14px;
        /* color: #fff; */
        flex-grow: 1;
        transition: all var(--transition-speed) ease;
    }

    .list-custom-small a:hover span {
        color: var(--hover-color) !important;
        /* text-shadow: 0 0 5px rgba(255, 255, 255, 0.3); */
    }

    .list-custom-small a i.fa-angle-right {
        transition: all var(--transition-speed) ease;
        color: rgba(255, 255, 255, 0.6);
    }

    .list-custom-small a:hover i.fa-angle-right {
        transform: translateX(5px);
        color: #fff;
    }

    /* Animation for list items */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .list-custom-small a {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    /* Delay animations for each item */
    .list-custom-small a:nth-child(1) {
        animation-delay: 0.1s;
    }

    .list-custom-small a:nth-child(2) {
        animation-delay: 0.2s;
    }

    .list-custom-small a:nth-child(3) {
        animation-delay: 0.3s;
    }

    .list-custom-small a:nth-child(4) {
        animation-delay: 0.4s;
    }

    .list-custom-small a:nth-child(5) {
        animation-delay: 0.5s;
    }

    .list-custom-small a:nth-child(6) {
        animation-delay: 0.6s;
    }

    .list-custom-small a:nth-child(7) {
        animation-delay: 0.7s;
    }

    .list-custom-small a:nth-child(8) {
        animation-delay: 0.8s;
    }

    .list-custom-small a:nth-child(9) {
        animation-delay: 0.9s;
    }

    .list-custom-small a:nth-child(10) {
        animation-delay: 1.0s;
    }

    .list-custom-small a:nth-child(11) {
        animation-delay: 1.1s;
    }
</style>

<div class="mt-4"></div>
<div class="list-group list-custom-small list-menu">
    <?php if ($title == "Homepage") { ?>
        <a href="./" class="active">
            <i class="fas fa-home color-white"></i>
            <span class="color-white">Home</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } else { ?>
        <a href="./">
            <i class="fas fa-home color-white"></i>
            <span>Home</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } ?>
    <!-- <?php if ($title == "Fund Wallet") { ?>
        <a href="fund-wallet" class="active">
            <i class="fa fa-arrow-up color-white"></i>
            <span class="color-white">Fund Wallet</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } else { ?>
        <a href="fund-wallet">
            <i class="fa fa-arrow-up color-white"></i>
            <span>Fund Wallet</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } ?>
    <?php if ($title == "Wallet Transfer") { ?>
        <a href="transfer" class="active">
            <i class="fa fa-arrow-down color-white"></i>
            <span class="color-white">Wallet Transfer</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } else { ?>
        <a href="transfer">
            <i class="fa fa-arrow-down color-white"></i>
            <span>Wallet Transfer</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } ?> -->
    <!-- <?php if ($title == "My Jobs") { ?>
        <a href="my-jobs" class="active">
            <i class="fa fa-book color-white"></i>
            <span class="color-white">My Jobs</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } else { ?>
        <a href="my-jobs">
            <i class="fa fa-book color-white"></i>
            <span>My Jobs</span>
            <i class="fa fa-angle-right"></i>
        </a>
    <?php } ?> -->

    <!-- <a href="history">
        <i class="fa fa-history color-white"></i>
        <span>Task History</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="task">
        <i class="fa fa-tasks color-white"></i>
        <span>Task</span>
        <i class="fa fa-angle-right"></i>
    </a> -->
    <?php if ($title == "P2p") { ?>
    <a href="p2p" class="active">
        <i class="fa fa-exchange color-white"></i>
        <span class="color-white">P2P Section</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <?php } else { ?>
    <a href="p2p">
        <i class="fa fa-exchange color-white"></i>
        <span>P2P Section</span>
        <i class="fa fa-angle-right"></i>   
    </a>
    <?php } ?>

<?php if ($title == "Buy Data") { ?>
<a href="buy-data" class="active">
    <i class="fa fa-wifi color-white"></i>
    <span class="color-white">Data</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="buy-data">
    <i class="fa fa-wifi color-white"></i>
    <span>Data</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Buy Airtime") { ?>
<a href="buy-airtime" class="active">
    <i class="fa fa-phone color-white"></i>
    <span class="color-white">Airtime</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="buy-airtime">
    <i class="fa fa-phone color-white"></i>
    <span>Airtime</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Cable Tv") { ?>
<a href="cable-tv" class="active">
    <i class="fa fa-television color-white"></i>
    <span class="color-white">Cable Subscription</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="cable-tv">
    <i class="fa fa-television color-white"></i>
    <span>Cable Subscription</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Electricity") { ?>
<a href="electricity" class="active">
    <i class="fa fa-bolt color-white"></i>
    <span class="color-white">Electricity Bills</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="electricity">
    <i class="fa fa-bolt color-white"></i>
    <span>Electricity Bills</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Exam Pins") { ?>
<a href="exam-pins" class="active">
    <i class="fa fa-check-square-o color-white"></i>
    <span class="color-white">Result Checker</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="exam-pins">
    <i class="fa fa-check-square-o color-white"></i>
    <span>Result Checker</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Transactions") { ?>
<a href="transactions" class="active">
    <i class="fa fa-receipt color-white"></i>
    <span class="color-white">Transactions</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="transactions">
    <i class="fa fa-receipt color-white"></i>
    <span>Transactions</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Notifications") { ?>
<a href="notifications" class="active">
    <i class="fa fa-list color-white"></i>
    <span class="color-white">Notifications</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="notifications">
    <i class="fa fa-list color-white"></i>
    <span>Notifications</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Profile") { ?>
<a href="profile" class="active">
    <i class="fa fa-user color-white"></i>
    <span class="color-white">Profile</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="profile">
    <i class="fa fa-user color-white"></i>
    <span>Profile</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>

<?php if ($title == "Referrals") { ?>
<a href="referrals" class="active">
    <i class="fa fa-users color-white"></i>
    <span class="color-white">Referrals</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } else { ?>
<a href="referrals">
    <i class="fa fa-users color-white"></i>
    <span>Referrals</span>
    <i class="fa fa-angle-right"></i>
</a>
<?php } ?>
    <a href="logout">
        <i class="fa fa-lock color-white"></i>
        <span>Logout</span>
        <i class="fa fa-angle-right"></i>
    </a>
</div>