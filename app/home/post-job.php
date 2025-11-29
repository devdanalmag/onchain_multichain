<div class="page-content header-clear-medium">

    <div class="card card-style">

        <div class="content">
            <h1 class="text-center">POST JOB</h1>
            <hr />
            <div class="row text-center mb-2">

                <span href="" class="col-3 mt-2">
                    <span class="icon icon-l rounded-sm py-2 px-2 select-item " id="mtnspan"
                        style="background:#f2f2f2;">
                        <img src="<?php echo HOME_IMAGE_LOC; ?>/tiktok_logo.png" id="mtnimg"
                            style="width :45px; height:45px;" />
                    </span>
                </span>

                <span href="" class="col-3 mt-2">
                    <span class="icon icon-l rounded-sm py-2 px-2 selected-item " id="airtelspan"
                        style="background:#f2f2f2;">
                        <img src="<?php echo HOME_IMAGE_LOC; ?>/ig_logo.png" id="mtnimg"
                            style="width :45px; height:45px;" />
                    </span>
                </span>

                <span href="" class="col-3 mt-2">
                    <span class="icon icon-l rounded-sm py-2 px-2" id="glospan" style="background:#f2f2f2;">
                        <img src="<?php echo HOME_IMAGE_LOC; ?>/youtube_logo.png" id="mtnimg"
                            style="width :45px; height:45px;" />
                    </span>
                </span>

                <span href="" class="col-3 mt-2">
                    <span class="icon icon-l rounded-sm py-2 px-2" id="9mobilespan" style="background:#f2f2f2;">
                        <img src="<?php echo HOME_IMAGE_LOC; ?>/fb_logo.png" id="mtnimg"
                            style="width :45px; height:45px;" />
                    </span>
                </span>


            </div>

            <form id="postjobForm" method="post" action="">
                <fieldset>
                    <!-- <p id="verifyer"></p> -->
                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="datagroup" class="color-theme opacity-80 font-700 font-12"><?php

                        ?>Select Media</label>
                        <select id="Smedia" name="Smedia" required onchange="handleOptionChange(this)">
                            <?php
                            $result = Scustom::Listmedia();
                            if ($result->num_rows > 0) { ?>
                                <option value="" selected disabled>Select Media</option>
                                <?php while ($row = $result->fetch_assoc()) {
                                    // Media Name and Type
                                    $mname = $row["mName"];
                                    $mfollow = $row["mFollow"];
                                    $mview = $row["mView"];
                                    $mlike = $row["mLike"];
                                    $mcomm = $row["mComment"];
                                    $msubs = $row["mSubscribe"];
                                    $mshare = $row["mShare"];

                                    // Type Prices
                                    $likeprice = $row["likePrice"];
                                    $followprice = $row["followPrice"];
                                    $shareprice = $row["sharePrice"];
                                    $subsprice = $row["subscribePrice"];
                                    $viewprice = $row["viewPrice"];
                                    $commentprice = $row["commentPrice"];

                                    ?>
                                    <option value="<?php echo $mname; ?>" data-mfollow="<?php echo $mfollow; ?>"
                                        data-mlike="<?php echo $mlike; ?>" data-mcomm="<?php echo $mcomm; ?>"
                                        data-mshare="<?php echo $mshare; ?>" data-msubs="<?php echo $msubs; ?>"
                                        data-mview="<?php echo $mview; ?>" data-likeprice="<?php echo $likeprice; ?>"
                                        data-followprice="<?php echo $followprice; ?>"
                                        data-shareprice="<?php echo $shareprice; ?>" data-subsprice="<?php echo $subsprice; ?>"
                                        data-viewprice="<?php echo $viewprice; ?>"
                                        data-commentprice="<?php echo $commentprice; ?>">
                                        <?php echo ucwords($mname); ?>
                                    </option>
                                <?php } ?>
                            <?php } else { ?>
                                <option value="" disabled>No Option Available</option>
                            <?php } ?>
                        </select>

                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                    <u style="color:blue;">Note: <em>To copy the job link go to share copy link
                            and paste it here 👇 Link most contain Media Name</em></u>
                    <br>
                    <b style="color:red;">Warning!!!❌❗❗: <em>VERIFY THE LINK BEFORE PASTING IF YOU PUT WRONG LINK</em>
                        🤦‍♂️🤦‍♀️😢 if you need more information contact Admin</b>
                    <br>
                    <em>&ThinSpace;</em>
                    <div class="input-style input-style-always-active has-borders validate-field mb-4">
                        <label for="jlink" class="color-theme opacity-80 font-700 font-12">Job Link</label>
                        <input type="text" name="jlink" placeholder="Past Link" value="" class="round-small" id="jlink"
                            required />
                    </div>
                    <div class="widgets">
                        <div class="control d-flex">
                            <div style="display:none;" id="followdiv">
                                <input type="checkbox" name="follow" id="followck" onclick="Getprice('follow');" />
                                <label for="followck">Follow</label>
                            </div>
                            <div style="display:none;" id="likediv">
                                <input type="checkbox" name="like" id="likeck" onclick="Getprice('like');" />
                                <label for="likeck">Like</label>
                            </div>
                        </div>

                        <div class="control d-flex">
                            <div style="display:none;" id="commendtdiv">
                                <input type="checkbox" name="comment" id="commentck" onclick="Getprice('comment');" />
                                <label for="commentck">Comment</label>
                            </div>
                            <div style="display:none;" id="subsdiv">
                                <input type="checkbox" name="subscribe" id="subsck" onclick="Getprice('subscribe');" />
                                <label for="subsck">Subscribe</label>
                            </div>
                        </div>

                        <div class="control d-flex">
                            <div style="display:none;" id="sharediv">
                                <input type="checkbox" name="share" id="shareck" onclick="Getprice('share');" />
                                <label for="shareck">Share</label>
                            </div>
                            <div style="display:none;" id="viewdiv">
                                <input type="checkbox" name="view" id="viewck" onclick="Getprice('view');" />
                                <label for="viewck">View </label>
                            </div>
                        </div>

                    </div>
                    <!-- <br> -->
                    <input type="text" id="amount" name="amount" hidden>
                    <!-- <br> -->
                    <i style="color:red;">Note: <em>Numbers are for all type e.g: if you select like and share and you
                            select 1000 numbers it means 1000 likes and 1000 shares</em></i>
                    <br>
                    <em>&ThickSpace;</em>
                    <div class="input-style input-style-always-active has-borders mb-4">
                        <label for="datagroup" class="color-theme opacity-80 font-700 font-12">Numbers</label>
                        <select id="Jobnumbers" name="jnumber" onchange="calculateAmount();" required>
                            <?php $result1 = Scustom::Listnumbers();
                            if ($result1->num_rows > 0) { ?>
                                <option value="" disabled selected>Select Number</option>
                                <?php while ($row = $result1->fetch_assoc()) {
                                    // Medi Name And Typ
                                    $minS = $row["min"];
                                    $maxS = $row["max"];
                                    $addplusS = $row["addplus"];
                                    $min = (int) $minS; // Convert the string to an integer using type casting
                                    $max = (int) $maxS; // Convert the string to an integer using type casting
                                    $addplus = (int) $addplusS; // Convert the string to an integer using type casting
                            
                                    ?>
                                    <?php for ($i = $min; $i <= $max; $i += $addplus) {
                                        echo "<option value='$i'>$i</option>";
                                    } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <option value="" disabled><?php ?>No Option Available</option>
                            <?php } ?>
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                    <br>
                    <a href="#" onclick="showJobprice();"
                        class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">View Prices</a> <br>
                    <div class="widgets">
                        <div class="control d-flex">
                            <input type="checkbox" name="dateline" id="dtline" onclick="ShowDateLine();" />
                            <label for="dtline">Use DATE-LINE</label>
                        </div>

                    </div>
                    <br>
                    <div style="display:none;" class="input-style input-style-always-active has-borders mb-4"
                        id="jdatelinediv">
                        <label for="jdateline" class="color-theme opacity-80 font-700 font-12">Days</label>
                        <select id="jdateline" name="jdateline" onchange="calculateAmount();">
                            <?php $result2 = Scustom::Lisjdateline();
                            if ($result2->num_rows > 0) { ?>
                                <option value="" disabled selected>Select Days</option>
                                <?php while ($row = $result2->fetch_assoc()) {
                                    // Medi Name And Typ
                                    ///////
                                    $name = $row["name"];
                                    $daysS = $row["days"];
                                    $priceS = $row["price"];

                                    $days = (int) $daysS; // Convert the string to an integer using type casting
                                    $price = (int) $priceS; // Convert the string to an integer using type casting
                            
                                    echo "<option value='$days' price='$price'>$days $name +$price ₦ per(1000)</option>";
                                } ?>
                            <?php } else { ?>
                                <option value="" disabled><?php ?>No Option Available</option>
                            <?php } ?>
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check disabled valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                    <br>

                    <div class="input-style input-style-always-active has-borders validate-field mb-4">
                        <label for="amounttopay" class="color-theme opacity-80 font-700 font-12">Amount To Pay
                            (₦)</label>
                        <input type="text" name="amounttopay" placeholder="Amount To Pay" class="round-small"
                            id="amounttopay" value="" readonly required />
                    </div>
                    <input name="transref" type="text" value="<?php echo $transRef; ?>" />
                    <input name="transkey" id="transkey" type="text" />
                    <div class="form-button">
                        <button type="submit" id="job-btn" name="postJob" style="width: 100%;"
                            class="btn btn-full btn-l font-600 font-15 gradient-highlight mt-4 rounded-s">
                            Submit
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>

</div>
<script>
    // $("#jamounttopay").rem("value")
    // $("#followdiv").css("display", "none");
    // $("#likediv").css("display", "none");
    // $("#commendtdiv").css("display", "none");
    // $("#subsdiv").css("display", "none");
    // $("#sharediv").css("display", "none");
    // $("#viewdiv").css("display", "none");
    //     Conver String to Int
    //     let str = "123";
    // let num = parseInt(str);
    // .addEventListener('click', handleClick);
    // Function to add options to lga select
    // document.getElementById("Jobnumbers").addEventListener('change', calculateAmount);
    // const selectElement = document.getElementById('jdateline');

    // Attach an event listener to listen for change events
    // selectElement.addEventListener('change', function() {
    //   // Get the selected option

    // });
    function calculateAmount() {
        var numbers = document.getElementById("Jobnumbers").value;
        var amounts = document.getElementById("amount").value;
        // var dateline = document.getElementById("jdateline").getAttribute("price");
        var amountprice = parseInt(amounts);
        var numbersprice = parseInt(numbers);
        var calcprice = amountprice * numbersprice; // Convert values to integers and add them

        var selectElement = document.getElementById('jdateline');

        // Get the selected option
        var selectedOption = selectElement.options[selectElement.selectedIndex];

        // Get the price attribute of the selected option
        var optionPrice = parseInt(selectedOption.getAttribute('price'));
        // alert(optionPrice);
        // Display the price in the console or anywhere else you want
        // console.log('Selected Option Price:', price);(
        var lastprice = optionPrice / 1;
        if (!document.getElementById("dtline").checked) {
            optionPrice = 0;
        }
        if (optionPrice > 0) {

            calcprice += lastprice * numbersprice;
        }

        if (calcprice > 0) {
            // calcprice = calcprice + parseInt(dateline);
            document.getElementById("amounttopay").value = calcprice;
        }
        else {
            document.getElementById("amounttopay").value = 0;
        }

    }
    function Getprice(type) {
        var allprice = 0;
        var followprice = 0;
        var likeprice = 0, shareprice = 0, commentprice = 0, viewprice = 0, subsprice = 0;

        // if (type === "follow") {
        if (document.getElementById("followck").checked) {
            followprice = document.getElementById("followck").getAttribute("price");
        }
        else {
            followprice = 0;
        }
        if (document.getElementById("viewck").checked) {
            viewprice = document.getElementById("viewck").getAttribute("price");
        }
        else {
            viewprice = 0;
        }
        if (document.getElementById("shareck").checked) {
            shareprice = document.getElementById("shareck").getAttribute("price");
        }
        else {
            shareprice = 0;
        }

        if (document.getElementById("commentck").checked) {
            commentprice = document.getElementById("commentck").getAttribute("price");
        }
        else {
            commentprice = 0;
        }

        if (document.getElementById("subsck").checked) {
            subsprice = document.getElementById("subsck").getAttribute("price");
        }
        else {
            subsprice = 0;
        }
        // }
        // if (type === "like") {
        if (document.getElementById("likeck").checked) {
            likeprice = document.getElementById("likeck").getAttribute("price");
        }
        else {
            likeprice = 0;
        }
        // }
        allprice =
            +followprice
            +
            +viewprice
            +
            +subsprice
            +
            +likeprice
            +
            +commentprice
            +
            +shareprice;
        document.getElementById("amount").setAttribute("value", allprice);
        calculateAmount();
    }
    function sGetinfo(name, follow, like, comment, share, subscribe, view, likeprice, followprice, shareprice, subsprice, viewprice, commentprice) {
        document.getElementById("followck").checked = false;
        document.getElementById("subsck").checked = false;
        document.getElementById("likeck").checked = false;
        document.getElementById("commentck").checked = false;
        document.getElementById("viewck").checked = false;
        document.getElementById("shareck").checked = false;

        if (follow === '1' || follow === 1) {
            document.getElementById("followdiv").style.display = "block";
            if (document.getElementById("subsck").checked === true) {
                document.getElementById("subsck").checked = false;
            }
            document.getElementById("followck").setAttribute("price", followprice);
            document.getElementById("amounttopay").setAttribute("value", 0);

        }
        else if (follow === '0') {
            document.getElementById("followdiv").style.display = "none";
        }

        if (like === '1') {
            document.getElementById("likediv").style.display = "block";
            document.getElementById("likeck").setAttribute("price", likeprice)

        }
        else if (like === '0') {
            document.getElementById("likediv").style.display = "none";
        }

        if (comment === '1') {
            document.getElementById("commendtdiv").style.display = "block";
            document.getElementById("commentck").setAttribute("price", commentprice)

        }
        else if (comment === '0') {
            document.getElementById("commendtdiv").style.display = "none";
        }

        if (subscribe === '1') {
            document.getElementById("subsdiv").style.display = "block";
            if (document.getElementById("followck").checked === true) {
                document.getElementById("followck").checked = false;
            }
            document.getElementById("subsck").setAttribute("price", subsprice)
            document.getElementById("amounttopay").setAttribute("value", 0);

        }
        else if (subscribe === '0') {
            document.getElementById("subsdiv").style.display = "none";
        }

        if (share === '1') {
            document.getElementById("sharediv").style.display = "block";
            document.getElementById("shareck").setAttribute("price", shareprice)

        }
        else if (share === '0') {
            document.getElementById("sharediv").style.display = "none";
        }

        if (view === '1') {
            document.getElementById("viewdiv").style.display = "block";
            document.getElementById("viewck").setAttribute("price", viewprice)

        }
        else if (view === '0') {
            document.getElementById("viewdiv").style.display = "none";
        }
        document.getElementById("amount").setAttribute("value", 0);
        document.getElementById("amounttopay").value = 0;
    }
    function ShowDateLine() {
        if (document.getElementById("dtline").checked) {
            document.getElementById("jdatelinediv").style.display = "block";
            document.getElementById("jdateline").required = true;
            return true;
        }
        else {
            document.getElementById("jdatelinediv").style.display = "none";
            document.getElementById("jdateline").required = false;
            document.getElementById("jdateline").value = "";
            calculateAmount();

        }
    }

    function handleOptionChange(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    if (!selectedOption.value) return; // Exit if no valid option is selected

    const mname = selectedOption.value;
    const mfollow = selectedOption.getAttribute("data-mfollow");
    const mlike = selectedOption.getAttribute("data-mlike");
    const mcomm = selectedOption.getAttribute("data-mcomm");
    const mshare = selectedOption.getAttribute("data-mshare");
    const msubs = selectedOption.getAttribute("data-msubs");
    const mview = selectedOption.getAttribute("data-mview");

    const likeprice = parseFloat(selectedOption.getAttribute("data-likeprice"));
    const followprice = parseFloat(selectedOption.getAttribute("data-followprice"));
    const shareprice = parseFloat(selectedOption.getAttribute("data-shareprice"));
    const subsprice = parseFloat(selectedOption.getAttribute("data-subsprice"));
    const viewprice = parseFloat(selectedOption.getAttribute("data-viewprice"));
    const commentprice = parseFloat(selectedOption.getAttribute("data-commentprice"));

    // Call the sGetinfo function with the selected values
    sGetinfo(mname, mfollow, mlike, mcomm, mshare, msubs, mview, likeprice, followprice, shareprice, subsprice, viewprice, commentprice);
}

</script>