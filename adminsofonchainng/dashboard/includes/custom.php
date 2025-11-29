<?php
// $conn = mysqli_connect("localhost","root","","asia");
class Custom
{
  public static function Connectdb()
  {
    $conn = new mysqli("localhost", "onchainc_admin", "onchainc_admin", "onchainc_db");
    if (!$conn) {
      $alert = "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
      return $conn;
    }
  }
  public static function Listpage()
  {
    $conn = Custom::Connectdb();
    $sql = "SELECT * FROM `pages` ORDER BY id";
    $result = $conn->query($sql);
    return $result;
  }
  public static function Listmedia()
  {
    $conn = Custom::Connectdb();
    $sql = "SELECT * FROM `medias` ORDER BY tId";
    $result = $conn->query($sql);
    return $result;
  }

}
$pmsg = "";
$pmsgerror = "";
if (isset($_POST['update_page'])) {
  // Sanitize and get the updated values from POST data
  $conn = Custom::Connectdb();
  $id = $_POST['epid'];
  $name = $_POST['epname'];
  $link = $_POST['eplink'];
  $status = $_POST['epstatus'];
  if (!endsWith($link, '.php')) {
    $link .= '.php';
  }
  // Prepare and bind the UPDATE query
  $stmt = $conn->prepare("UPDATE `pages` SET `name` = ?, `link` = ?, `status` = ? WHERE `id` = ?");
  $stmt->bind_param("sssi", $name, $link, $status, $id);

  // Execute the UPDATE query
  if ($stmt->execute()) {
    // Updated successfully, send JSON response
    $datareturn = array(
      'name' => $name,
      'link' => $link,
      'status' => $status
    );
    $pmsg = "Page Update Successfully";
    // echo json_encode($datareturn);
  } else {
    $pmsg = "error Failed to update Page " . $stmt->error;
    $pmsgerror = "error";
    // echo json_encode(array('error' => 'Failed to update data'));
  }

  // Close the statement
  $stmt->close();
  $conn->close();
}


if (isset($_POST['AddNewPage'])) {
  // Sanitize and get the updated values from POST data
  $conn = Custom::Connectdb();
  $nname = $_POST['npname'];
  $nlink = $_POST['nplink'];
  $nstatus = $_POST['npstatus'];

  // Check if $nname or $nlink already exist in the database
  $checkSql = "SELECT * FROM pages WHERE `name` = ? OR `link` = ?";
  $checkStmt = $conn->prepare($checkSql);
  $checkStmt->bind_param("ss", $nname, $nlink);
  $checkStmt->execute();
  $checkStmt->store_result();
  $numRows = $checkStmt->num_rows;

  if ($numRows > 0) {
    // $nname or $nlink already exist, send an alert
    $pmsg = "Page Name or Page Link already exist";
    $pmsgerror = "error";
  } else {
    if (!endsWith($nlink, '.php')) {
      $nlink .= '.php';
    }
    // Prepare and bind the INSERT query
    $sql = "INSERT INTO pages (`name`, `link`, `status`) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nname, $nlink, $nstatus);

    // Execute the INSERT query
    if ($stmt->execute()) {
      // Inserted successfully, send JSON response
      $pmsg = "Page Add Successfully";
    } else {
      $pmsg = "Failed to Add page " . $sql . "<br>" . $conn->error;
      $pmsgerror = "error";
    }

    // Close the statement
    $stmt->close();
  }

  // Close the check statement and connection
  $checkStmt->close();
  $conn->close();
}
if (isset($_POST['update_media'])) {
  // Sanitize and get the updated values from POST data
  $conn = Custom::Connectdb();
  // Medi Name And Type
  $id = $_POST["edtmid"];
  $name = $_POST["edtmedia"];
  $follow = 0;//$_POST["edtfollow"];
  $view = 0;//$_POST["edtview"];
  $like = 0; //$_POST["edtlike"];
  $comm = 0; //$_POST["edtcomment"];
  $subs = 0; //$_POST["edtsubscribe"];
  $share = 0;//$_POST["edtshare"];
  $repost = 0;//$_POST["edtrepost"];

  if (isset($_POST["edtfollow"])) {
    $follow = 1;
  }
  if (isset($_POST["edtview"])) {
    $view = 1;
  }
  if (isset($_POST["edtcomment"])) {
    $comm = 1;
  }
  if (isset($_POST["edtshare"])) {
    $share = 1;
  }
  if (isset($_POST["edtlike"])) {
    $like = 1;
  }
  if (isset($_POST["edtsubscribe"])) {
    $subs = 1;
  }
  if (isset($_POST["edtrepost"])) {
    $repost = 1;
  }
  // Type Price
  $likeprice = $_POST["likep"];
  $followprice = $_POST["followp"];
  $shareprice = $_POST["sharep"];
  $subsprice = $_POST["subscribep"];
  $viewprice = $_POST["viewp"];
  $commentprice = $_POST["commentp"];
  $repostprice = $_POST["repostp"];
  // Prepare and bind the UPDATE query
  $stmt = $conn->prepare("UPDATE `medias` SET `mName`=?,`mFollow`=?,`mLike`=?,
  `mComment`=?,`mShare`=?,`mSubscribe`=?,`mView`=?,`mRepost`=?,`followPrice`=?,
  `likePrice`=?,`commentPrice`=?,`sharePrice`=?,`subscribePrice`=?,`viewPrice`=?,
  `repostPrice`=? WHERE `tId` = ?");
  $stmt->bind_param(
    "ssssssssssssssss",
    $name,
    $follow,
    $like,
    $comm,
    $share,
    $subs,
    $view,
    $repost,
    $followprice,
    $likeprice,
    $commentprice,
    $shareprice,
    $subsprice,
    $viewprice,
    $repostprice,
    $id
  );

  // Execute the UPDATE query
  if ($stmt->execute()) {
    // Updated successfully, send JSON response
    $pmsg = "Media Update Successfully";
    // echo json_encode($datareturn);
  } else {
    $pmsg = "error Failed to update Media " . $stmt->error;
    $pmsgerror = "error";
    // echo json_encode(array('error' => 'Failed to update data'));
  }

  // Close the statement
  $stmt->close();
  $conn->close();
}
if (isset($_POST['add_media'])) {
  // Sanitize and get the updated values from POST data
  $conn = Custom::Connectdb();
  // Medi Name And Type
  $name = $_POST["newmedia"];
  $follow = 0;//$_POST["edtfollow"];
  $view = 0;//$_POST["edtview"];
  $like = 0; //$_POST["edtlike"];
  $comm = 0; //$_POST["edtcomment"];
  $subs = 0; //$_POST["edtsubscribe"];
  $share = 0;//$_POST["edtshare"];
  $repost = 0;//$_POST["edtrepost"];

  if (isset($_POST["newfollow"])) {
    $follow = 1;
  }
  if (isset($_POST["newview"])) {
    $view = 1;
  }
  if (isset($_POST["newcomment"])) {
    $comm = 1;
  }
  if (isset($_POST["newshare"])) {
    $share = 1;
  }
  if (isset($_POST["newlike"])) {
    $like = 1;
  }
  if (isset($_POST["newsubscribe"])) {
    $subs = 1;
  }
  if (isset($_POST["newrepost"])) {
    $repost = 1;
  }
  // Type Price
  $likeprice = $_POST["likepnew"];
  $followprice = $_POST["followpnew"];
  $shareprice = $_POST["sharepnew"];
  $subsprice = $_POST["subscribepnew"];
  $viewprice = $_POST["viewpnew"];
  $commentprice = $_POST["commentpnew"];
  $repostprice = $_POST["repostpnew"];
  // Prepare and bind the UPDATE query
  $sql = "INSERT INTO `medias` (`mName`,`mFollow`,`mLike`,
  `mComment`,`mShare`,`mSubscribe`,`mView`,`mRepost`,`followPrice`,
  `likePrice`,`commentPrice`,`sharePrice`,`subscribePrice`,`viewPrice`,
  `repostPrice`) VALUES (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "sssssssssssssss",
    $name,
    $follow,
    $like,
    $comm,
    $share,
    $subs,
    $view,
    $repost,
    $followprice,
    $likeprice,
    $commentprice,
    $shareprice,
    $subsprice,
    $viewprice,
    $repostprice
  );

  // Execute the UPDATE query
  if ($stmt->execute()) {
    // Updated successfully, send JSON response
    $pmsg = "Media Add Successfully";
    // echo json_encode($datareturn);
  } else {
    $pmsg = "error Failed to add Media " . $stmt->error;
    $pmsgerror = "error";
    // echo json_encode(array('error' => 'Failed to update data'));
  }

  // Close the statement
  $stmt->close();
  $conn->close();
}
function endsWith($phpex, $needle)
{
  return substr($phpex, -strlen($needle)) === $needle;
}
?>