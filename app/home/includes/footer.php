<style>
        .footer-bar-6 {
                --primary-color: <?php echo $sitecolor; ?>;
                --icon-size: 22px;
                --animation-speed: 0.3s;
                position: fixed;
                bottom: 0;
                width: 100%;
                display: flex;
                justify-content: space-around;
                align-items: center;
                background: rgba(25, 25, 25, 0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0px 0px 5px 5px rgba(0, 0, 0, 0.42);
                padding: 8px 0;
                z-index: 1000;
                /* border-radius: 100px; */
        }

        .footer-bar-6 a {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: #aaa;
                padding: 8px 12px;
                border-radius: 12px;
                transition: all var(--animation-speed) ease;
                position: relative;
                overflow: hidden;
        }

        .footer-bar-6 a::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 3px;
                background: var(--primary-color);
                transition: all var(--animation-speed) ease;
                border-radius: 3px;
        }

        .footer-bar-6 a:hover {
                color: #fff;
                transform: translateY(-5px);
        }

        .footer-bar-6 a:hover::after {
                width: 60%;
                content: '';
                width: 35px;
                /* height: 6px; */
                position: absolute;

                bottom: 5px;
                background: var(--primary-color);
                /* border-radius: 50%; */
                transition: all var(--animation-speed) ease;
                /* width: 60%; */
                color: var(--primary-color);
                z-index: 99;
        }

        .footer-bar-6 a i {
                font-size: var(--icon-size);
                margin-bottom: 4px;
                transition: all var(--animation-speed) ease;
        }

        .footer-bar-6 a:hover i {
                color: var(--primary-color);
                transform: scale(1.2);
        }

        .footer-bar-6 a span {
                font-size: 12px;
                font-weight: 500;
                transition: all var(--animation-speed) ease;
                font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif !important;
        }

        .footer-bar-6 a:hover span {
                color: var(--primary-color);
        }

        /* WhatsApp button special styling */
        .footer-bar-6 a img {
                width: 30px;
                height: 30px;
                transition: all var(--animation-speed) ease;
                filter: grayscale(30%);
        }

        .footer-bar-6 a:hover img {
                transform: scale(1.2) rotate(5deg);
                filter: grayscale(0%) drop-shadow(0 0 5px rgba(37, 211, 102, 0.5));
        }

        /* Active state */
        .footer-bar-6 a.active {
                color: var(--primary-color);
        }

        .footer-bar-6 a.active::after {
                content: '';
                width: 35px;
                /* height: 6px; */
                position: absolute;

                bottom: 5px;
                background: var(--primary-color);
                /* border-radius: 50%; */
                transition: all var(--animation-speed) ease;
                /* width: 60%; */
                color: var(--primary-color);
                z-index: 99;
        }

        /* Bounce animation for active item */
        @keyframes bounce {

                0%,
                100% {
                        transform: translateY(0);
                }

                50% {
                        transform: translateY(-8px);
                }
        }

        .footer-bar-6 a.active i {
                animation: bounce 0.8s ease infinite;
                color: var(--primary-color);
        }

        /* Pulse animation for WhatsApp */
        @keyframes pulse {
                0% {
                        transform: scale(1);
                }

                50% {
                        transform: scale(1.1);
                }

                100% {
                        transform: scale(1);
                }
        }

        .footer-bar-6 a[href="contact-us"]:hover img {
                animation: pulse 1.5s ease infinite;
        }
</style>

<div id="footer-bar" class="footer-bar-6">
        <a href="#" data-menu="menu-main">
                <i class="fa fa-bars"></i>
                <span>Menu</span>
        </a>
        <?php if ($title == "Buy Airtime") { ?>
                <a href="buy-airtime" class="active">
                        <i class="fa fa-phone"></i>
                        <span>Airtime</span>
                </a>
        <?php } else { ?>
                <a href="buy-airtime">
                        <i class="fa fa-phone"></i>
                        <span>Airtime</span>
                </a>
        <?php } ?>
        <?php if ($title == "Buy Data") { ?>
                <a href="buy-data" class="active">
                        <i class="fa fa-wifi"></i>
                        <span>Data</span>
                </a>
        <?php } else { ?>
                <a href="buy-data">
                        <i class="fa fa-wifi"></i>
                        <span>Data</span>
                </a>
        <?php } ?>
        <?php if ($title == "Profile") { ?>
                <a href="profile" class="active">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                </a>
        <?php } else { ?>
                <a href="profile">
                        <i class="fa fa-user"></i>
                        <span>Profile</span>
                </a>
        <?php } ?>
</div>