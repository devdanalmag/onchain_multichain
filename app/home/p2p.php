<style>
    /* Crypto table styles */
    .crypto-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: rgba(255, 255, 255, 0.1);
        /* border-radius: 10px; */
        overflow: hidden;
        /* box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); */
        margin-bottom: 15px;
    }

    .crypto-table thead th {
        background: linear-gradient(90deg, #4e54c8, #8f94fb);
        color: white;
        padding: 12px 15px !important;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 12px;
        margin: auto;
    }

    .crypto-table tbody tr {
        transition: all 0.3s ease;
    }

    .crypto-table tbody tr:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    .crypto-table td {
        padding: 5px 1px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .crypto-table tbody tr:last-child td {
        border-bottom: none;
    }

    .coin-name {
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .coin-icon {
        width: 24px;
        height: 24px;
        margin-right: 8px;
        border-radius: 50%;
        object-fit: cover;
    }

    .price-up {
        color: #4ade80;
    }

    .price-down {
        color: #f87171;
    }

    .limit {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        display: inline-block;
    }

    .table-header {
        position: relative;
    }

    .table-header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
    }

    .bt-buy-sell {
        background-image: linear-gradient(to right, green, red) !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .bt-buy-sell:hover {
        background-image: linear-gradient(to left, #4ADCB3, #EC5D5D) !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .bt-buy {
        background-color: green !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .bt-buy:hover {
        background-color: #4ADCB3 !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .bt-sell {
        background-color: red !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .bt-sell:hover {
        background-color: #EC5D5D !important;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }
</style>

<h1 class="p-relative" style="margin-top: 60px;">P2P Merchants</h1>
<!-- end head -->
<div class="friends d-grid m-20 gap-20">
    <?php
    // Example coin meta data (id => [name, icon, price_class])
    $coinMeta = [
        1 => ['name' => 'Sidra', 'icon' => 'sidra-logo.png', 'price_class' => 'price-up'],
        2 => ['name' => 'PI',    'icon' => 'pi-logo.png',    'price_class' => 'price-up'],
        3 => ['name' => 'USDT',  'icon' => 'usdt-logo.svg',  'price_class' => 'price-down'],
        4 => ['name' => 'TON',   'icon' => 'ton.png',        'price_class' => 'price-up'],
        // Add more coins as needed
    ];
    if (!empty($data)) {
        foreach ($data as $mydata) {
            // Parse merchant's coins, limits, and prices
            $coinIds = isset($mydata->mCoins) ? array_map('intval', explode(",", $mydata->mCoins)) : [];
            $limits  = isset($mydata->mLimit) ? explode(",", $mydata->mLimit) : [];
            $prices  = isset($mydata->mPrice) ? explode(",", $mydata->mPrice) : [];

    ?>
            <div class="friend bg-white rad-6 p-20 p-relative " id="page-file-name" page-name="p2p">
                <div class="txt-c">
                    <h4 class="m-0"><?= htmlspecialchars($mydata->mBrand) ?></h4>
                    <div class="rad-half mt-10 mb-10" style="width: 70px; height: 70px; background-color: #0000; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 50px; margin: 0 auto; background-image: url('<?php echo HOME_IMAGE_LOC; ?>/backed.png'); background-size: cover;">
                        <?php if (empty($mydata->mBrand)): ?>
                            <img src="<?php echo HOME_IMAGE_LOC; ?>/backed.png" alt="Vendor" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <?= strtoupper(substr(htmlspecialchars($mydata->mBrand), 0, 1)) ?>
                        <?php endif; ?>
                    </div> <br> @<?= htmlspecialchars($mydata->mUsername) ?><i class="fa" style="color:blue;"><img src="<?php echo HOME_IMAGE_LOC; ?>/badge.png" alt="" style="width: 15px;"></i></h6>
                </div>
                <div class="icons fs-14 p-relative">
                    <table class="table crypto-table">
                        <thead>
                            <tr>
                                <th class="table-header">Coin</th>
                                <th class="table-header">Limit</th>
                                <th class="table-header">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($coinIds as $i => $coinId) {
                                // Find coin status from $data2
                                $coinStatus = 0;
                                if (isset($data2) && is_array($data2)) {
                                    foreach ($data2 as $coinRow) {
                                        if (isset($coinRow->cId) && intval($coinRow->cId) == $coinId) {
                                            $coinStatus = isset($coinRow->status) ? intval($coinRow->status) : 0;
                                            break;
                                        }
                                    }
                                }
                                if ($coinStatus !== 1) continue;
                                if (!isset($coinMeta[$coinId])) continue;
                                $coin = $coinMeta[$coinId];
                                $limit = isset($limits[$i]) ? htmlspecialchars($limits[$i]) : '';
                                $price = isset($prices[$i]) ? htmlspecialchars($prices[$i]) : '';
                                $priceClass = $coin['price_class'];
                                // Format price if numeric
                                if (is_numeric($price) && $price !== '') {
                                    $price = '₦' . number_format($price);
                                } elseif ($price === '' || strtolower($price) === 'ask') {
                                    $price = 'Ask';
                                }
                            ?>
                                <tr>
                                    <td>
                                        <div class="coin-name">
                                            <img src="<?php echo HOME_IMAGE_LOC . '/' . $coin['icon']; ?>" alt="" class="coin-icon">
                                            <?= htmlspecialchars($coin['name']) ?>
                                        </div>
                                    </td>
                                    <td><span class="limit"><?= $limit ?></span></td>
                                    <td class="<?= $priceClass ?>"><?= $price ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="mb-10">
                        <span>Contact: <i class="fa fa-whatsapp"></i>WhatsApp</span>
                    </div>
                </div>
                <div class="info between-flex fs-13">
                    <span class="c-grey"><i class="fa fa-thumbs-down "></i> &ThickSpace; <i class="fa fa-solid fa-thumbs-up"></i></span>
                    <div class="">
                        <?php
                        // Determine action text and button class
                        $actionText = '';
                        $buttonClass = '';
                        if ($mydata->mAction == 0) {
                            $actionText = 'Buy';
                            $buttonClass = 'bt-buy';
                        } elseif ($mydata->mAction == 1) {
                            $actionText = 'Sell';
                            $buttonClass = 'bt-sell';
                        } elseif ($mydata->mAction == 2) {
                            $actionText = 'Buy/Sell';
                            $buttonClass = 'bt-buy-sell';
                        } else {
                            $actionText = 'Sell';
                            $buttonClass = 'bt-sell';
                        }

                        // WhatsApp number (replace with actual merchant number if available)
                        if (isset($mydata->mWhatsapp)) {
                            $number = preg_replace('/\D/', '', $mydata->mWhatsapp);
                            if (strpos($number, '0') === 0) {
                                $whatsappNumber = '234' . substr($number, 1);
                            } else {
                                $whatsappNumber = $number;
                            }
                        } else {
                            $number = preg_replace('/\D/', '', $mydata->mPhone);
                            if (strpos($number, '0') === 0) {
                                $whatsappNumber = '234' . substr($number, 1);
                            } else {
                                $whatsappNumber = $number;
                            }
                        }
                        // WhatsApp message
                        $waMessage = rawurlencode("Hello, I am interested in {$actionText}ing assets from you via Onchain.com.ng. Please provide more details.");

                        // WhatsApp link
                        $waLink = "https://wa.me/{$whatsappNumber}?text={$waMessage}";
                        ?>
                        <a class="<?= $buttonClass ?> c-white btn-shape" onclick="getP2PAction('<?= $waLink ?>');" href="#"><?= $actionText ?><?php if ($mydata->mAction == 2) { ?> <i class="fa fa-exchange"></i><?php } ?></a>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <?php echo "No P2P Merchants found"; ?>
    <?php } ?>
</div>
<div class="gap-50"> <br> <br></div>