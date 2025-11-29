function _copy(text) {
    // Create a textarea element to hold the text to be copied
    var myalert = document.getElementById('copy-alert');
    var textarea = document.createElement("textarea");
    textarea.value = text;
    textarea.style.position = "fixed"; // Make it invisible and move it off-screen
    textarea.style.opacity = 0;
    document.body.appendChild(textarea);

    // Select the text inside the textarea
    textarea.select();

    try {
        // Execute the copy command
        var successful = document.execCommand('copy');
        var msg = successful ? 'Copied successfully!' : 'Unable to copy!';
        // myalert.style.color = '#22c55e';
        // myalert.innerHTML = "hello";
        alert(msg);
        console.log(msg);
    } catch (err) {
        console.error('Error copying text:', err);
    }

    // Remove the textarea from the DOM
    document.body.removeChild(textarea);
}

function showNotification(id) {
    event.preventDefault();
    var notification = document.getElementById(id);
    var bdo = document.getElementById('bdo');
    // notification.classList.add("notification");
    notification.classList.remove("fade-out");
    notification.classList.add("fade-in");
    // var theid = document.getElementById('theid');
    notification.style.display = 'inline';
    // bdo.style.backgroundColor = '#86454580';
    // if (id === 'fund') {
    bdo.classList.add("bdo");
    // }
    if (id === 'withdraw') {
        notification.style.top = '65%';
        bdo.style.backgroundColor = '#a84139d2';

    }
    if (id === 'fund') {
        bdo.style.backgroundColor = '#b1a9a8d2';
    }
}

function closeNotification(id) {
    var notification = document.getElementById(id);
    notification.classList.remove("fade-in");
    notification.classList.add("fade-out");
    setTimeout(() => {
        notification.style.display = 'none';
        bdo.classList.remove("bdo");
    }, 500);
    //  
}

function check(id) {
    var _link = "";
    if (id === "follow-tik") {
        _link = "tiktok";
    }
    if (id === "follow-twi") {
        _link = "twitter";
    }
    if (id === "follow-ig") {
        _link = "instagram";
    }
    if (id === "follow-yb") {
        _link = "youtube";
    }
    //   document.getElementById(mid).addEventListener("click", function () {
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    if (isMobile) {
        // Check if TikTok app is installed
        window.location.href = _link + "://";

        setTimeout(function() {
            // If TikTok app is not found, open link in browser
            window.location.href = "https://www." + _link + ".com";
        }, 3000); // 3 seconds timeout for TikTok app to launch
    } else {
        // Open link in new tab for non-mobile devices
        window.open("https://www." + _link + ".com", "_blank");
    }
}

function showedit(id) {
    var f_uname = document.getElementById("fname");
    var Tik_uname = document.getElementById("uname");
    var Twi_uname = document.getElementById("phone");
    var Y_ = document.getElementById("email");
    var the_div = document.getElementById("edit");
    // Fields
    var fullname = document.getElementById("fullname");
    var username = document.getElementById("username");
    var phoneno = document.getElementById("phoneno");
    var adminemail = document.getElementById("adminemail");
    var usertype = document.getElementById("usertype");
    var rcdiv = document.getElementById('rcemail');
    var U_bt = document.getElementById('udtbt');
    U_bt.setAttribute('value', id);
    // U_bt.value = id;
    bdo.classList.add("bdo");
    //Set the Input Value To be the ID
    // notification.classList.add("notification");
    //     $.ajax({
    //       url: "./checkdata.php",
    //       type: "POST",
    //       data: {
    //         uid: id
    //       },
    //       dataType: "json",
    //       success: function (datareturn) {
    //         console.log(datareturn);
    //         fullname.value = `${datareturn.fullname}`;
    //         username.value = `${datareturn.username}`;
    //         phoneno.value = `${datareturn.phone}`;
    //         adminemail.value = `${datareturn.email}`;
    //         usertype.value = `${datareturn.type}`;
    //         if(usertype.value === 'admin'){
    //           rcdiv.style.display = "block";
    //         }
    //   else{
    //       rcdiv.style.display = "none";
    //   }
    //       },
    //     });
    the_div.classList.remove("fade-out");
    the_div.classList.add("fade-in");
    the_div.style.display = "block";

}

function shows() {
    var E_bt = document.getElementById('edtbt');
    var U_bt = document.getElementById('udtbt');

    E_bt.style.display = "none";
    U_bt.style.display = "initial";
    fullname.disabled = false;
    username.disabled = false;
    phoneno.disabled = false;
    adminemail.disabled = false;
    usertype.disabled = false;
}

function showmail() {
    var usertype = document.getElementById("usertype");
    var rcdiv = document.getElementById('rcemail');

    if (usertype.value === 'admin') {
        rcdiv.style.display = "block";
    } else {
        rcdiv.style.display = "none";

    }
}

function closeedit() {
    var the_div = document.getElementById("edit");
    the_div.classList.remove("fade-in");
    the_div.classList.add("fade-out");
    setTimeout(() => {
        the_div.style.display = "none";
        var E_bt = document.getElementById('edtbt');
        var U_bt = document.getElementById('udtbt');
        U_bt.style.display = "none";
        E_bt.style.display = "initial";

        bdo.classList.remove("bdo");
    }, 500);
}
// function checkRequiredFields() {
//     var isAdminDivOpen = document.getElementById('adminDiv').style.display === 'block';
//     var emailField = document.getElementById('mails');
//     var passwordField = document.getElementById('pass');

//     emailField.required = isAdminDivOpen;
//     passwordField.required = isAdminDivOpen;
// }