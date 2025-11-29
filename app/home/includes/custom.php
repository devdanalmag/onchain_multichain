<?php
// $conn = mysqli_connect("localhost","root","","asia");
class Scustom
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
  public static function checkpage($pagelink)
  {
    // Sanitize input
    $conn = Scustom::Connectdb();
    // Prepare and bind the query
    $query = mysqli_query($conn, "SELECT * FROM `pages` WHERE  link='$pagelink'");
    if (mysqli_num_rows($query) > 0) {

      $row = mysqli_fetch_array($query);
      // Close statement and connection
      $conn->close();
      return $row['status'];
    } else {
      $conn->close();
      return 'Error: Data Not Found';
    }
  }
  public static function Listmedia()
  {
    $conn = Scustom::Connectdb();
    $sql = "SELECT * FROM `medias` ORDER BY tId";
    $result = $conn->query($sql);
    return $result;
  }
  public static function Checkjob()
  {
    $conn = Scustom::Connectdb();
    $sessionId = $_SESSION["loginId"]; // Assuming session ID is stored in $_SESSION
    $sql = "SELECT * FROM `tasks` WHERE `sId` = ? ORDER BY tId"; // Using parameterized query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sessionId); // Assuming sId is a string, change "s" to "i" if it's an integer
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;

  }
  public static function Listnumbers()
  {
    $conn = Scustom::Connectdb();
    $sql = "SELECT * FROM `medianumbers` ORDER BY id";
    $result = $conn->query($sql);
    return $result;
  }
  public static function Lisjdateline()
  {
    $conn = Scustom::Connectdb();
    $sql = "SELECT * FROM `datelines` ORDER BY id";
    $result = $conn->query($sql);
    return $result;
  }
  public static function Getmedia_Info($media)
  {
    $conn = Scustom::Connectdb();
    $query = mysqli_query($conn, "SELECT * FROM `medias` WHERE  mName='$media'");
    if (mysqli_num_rows($query) > 0) {

      $row = mysqli_fetch_array($query);
      // Close statement and connection
      $conn->close();
      return $row;
    } else {
      $conn->close();
      return 'Error: Data Not Found';
    }
  }
  public static function createPopMessage($heading, $message, $color)
  {
    //Color is green or red for success and error respectively
    $msg = '
    <div id="gen-message-box" class="menu menu-box-bottom bg-' . $color . '-dark rounded-m" data-menu-height="335" data-menu-effect="menu-over">
        <h1 class="text-center mt-4"><i class="fa fa-3x fa-times-circle scale-box color-white shadow-xl rounded-circle"></i></h1>
        <h1 class="text-center mt-3 text-uppercase color-white font-700">' . $heading . '</h1>
        <p class="boxed-text-l color-white opacity-70">
            ' . $message . '
        </p>
        <a href="#" style="display:block !important;" class="close-menu btn btn-m btn-center-l button-s shadow-l rounded-s text-uppercase font-600 bg-white color-black">Close</a>
    </div>
    ';

    return $msg;
  }
}
if (isset($_POST["postJob"])) {
  //Smedia=tiktok&jlink=hello.com&follow=on&like=on&comment=on&share=on&view=on&amount=10&jnumber=1000&dateline=on&jdateline=7&amounttopay=13000&post-job=  // $conn = Custom::Connectdb();
//   $link = "ww.median.com.ng";
  $conn = Scustom::Connectdb();
  // if (strpos($link, "median") !== false) {
//     echo "The word 'median' is present in the link.";
// } else {
//     echo "The word 'median' is not present in the link.";
// }
  $Smedia = $_POST['Smedia'];
  $jlink = $_POST['jlink'];
  $amount = $_POST['amount'];
  $jnumber = $_POST['jnumber'];
  $amounttopay = $_POST['amounttopay'];
  $postpin = $_POST['transkey'];
  $transref = $_POST['transref'];
  $userId = $_SESSION["loginId"];
  $checkSql = "SELECT * FROM `subscribers` WHERE `sId` = ?";
  $checkStmt = $conn->prepare($checkSql);
  $checkStmt->bind_param("s", $userId);
  $checkStmt->execute();
  $checkResult = $checkStmt->get_result();
  if ($checkResult->num_rows > 0) {
    // Fetch the row from the result
    $row1 = $checkResult->fetch_assoc();
    $thepin = $row1['sPin'];
    // Check if the pin is correct
    if ($row1['sPinStatus'] == "1" || $row1['sPinStatus'] == 1) {
      $postpin = $thepin;
    }
    // Check if the pin is correct
    if ($thepin == $postpin) {
      // Check Is there Value or String In Smedia
      if ($Smedia !== "") {
        // Check If The SMedia Name Exist In DB
        $checkSql = "SELECT * FROM `medias` WHERE `mName` = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $Smedia);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
          // Fetch the row from the result
          $row = $checkResult->fetch_assoc();
          // Check If the link contain the media name
          // if (strpos($jlink, $row['mName']) == true) {
            // check is there no Media type check box is selected
            if (
              !isset($_POST["follow"]) &&
              !isset($_POST["like"]) &&
              !isset($_POST["comment"]) &&
              !isset($_POST["share"]) &&
              !isset($_POST["view"]) &&
              !isset($_POST["subscribe"]) &&
              !isset($_POST["repost"])
            ) {
              // error You Did Not Select The Job Type
              $msg = Scustom::createPopMessage("Error!!", "Error You Did Not Select The Job Type.", "red");

            } else {
              // Declear the all variables
              $followP = 0;
              $likeP = 0;
              $commentP = 0;
              $shareP = 0;
              $viewP = 0;
              $subscribeP = 0;
              $repostP = 0;
              $myprice = 0;
              $pricebfdate = 0;
              $lastprice = 0;
              $priceamount = (int) $amount;
              $jobnumber = (int) $jnumber;
              $myamounttopay = (int) $amounttopay;
              // Check The Check Boxes For Job Type if Is Found Initialize The One In Db

              $likepost = "";
              $followpost = "";
              $commentpost = "";
              $sharepost = "";
              $viewpost = "";
              $subscribepost = "";
              $repostpost = "";

              if (isset($_POST["follow"])) {
                $followpost = " Follow,";
                $followP = (int) $row['followPrice'];
              }
              if (isset($_POST["like"])) {
                $likepost = " Like,";
                $likeP = (int) $row['likePrice'];
              }
              if (isset($_POST["comment"])) {
                $commentpost = " Comment,";
                $commentP = (int) $row['commentPrice'];
              }
              if (isset($_POST["share"])) {
                $sharepost = " Share,";
                $shareP = (int) $row['sharePrice'];
              }
              if (isset($_POST["view"])) {
                $viewpost = " View,";
                $viewP = (int) $row['viewPrice'];
              }
              if (isset($_POST["subscribe"])) {
                $subscribepost = " Subscribe,";
                $subscribeP = (int) $row['subscribePrice'];
              }
              if (isset($_POST["repost"])) {
                $repostpost = " Repost,";
                $repostP = (int) $row['repostPrice'];
              }
              // Calculate the only Media Type prices in DB
              $myprice = $followP + $likeP + $commentP + $shareP + $viewP + $subscribeP + $repostP;
              // If the Posted One found is thesame with the calculated one in DB
              if ($myprice == $priceamount) {
                // Check The Maximum and the Minimun Numbers In DB
                $numbersquery = mysqli_query($conn, "SELECT * FROM `medianumbers`  WHERE id='1'");
                $numbersrow = mysqli_fetch_assoc($numbersquery);
                $dbJnumbersmin = (int) $numbersrow['min'];
                $dbJnumbersmax = (int) $numbersrow['max'];
                // Check if the Posted number is In range with the one in DB
                if ($jobnumber >= $dbJnumbersmin && $jobnumber <= $dbJnumbersmax) {
                  // Calculate the price before Date line Mean The Final Price If without Date Line
                  $pricebfdate = $priceamount * $jobnumber;
                  // Check If The Dateline check box and the input field is posted
                  if (isset($_POST["dateline"]) && isset($_POST["jdateline"])) {
                    $jdateline = $_POST['jdateline'];
                    // sellect from database dateline
                    $datequery = mysqli_query($conn, "SELECT * FROM `datelines`  WHERE  `days`='$jdateline'");
                    if (mysqli_num_rows($datequery) > 0) {
                      $daterow = mysqli_fetch_array($datequery);
                      // calculate the dateline price
                      $dateprice = (int) $daterow['price'];
                      $pricebfdate += $dateprice * $jobnumber;
                      if ($pricebfdate == $myamounttopay) {
                        // Execute the prepared statement
                        $walletbalance = (int) $row1['sWallet'];
                        if ($pricebfdate > $walletbalance) {
                          $msg = Scustom::createPopMessage("Error!!", "Insufficient Balance job price $pricebfdate wallet balance $walletbalance.", "red");
                        } else {
                          // Post The Job Into DB
                          $Jtypepost = $likepost . $followpost . $commentpost . $sharepost . $viewpost . $subscribepost . $repostpost;
                          $profit = 0;
                          $status = 2;
                          $jdateliename = $daterow["name"];
                          $oldbal = $row1['sWallet'];

                          $newbal = (int) $row1['sWallet'] - $pricebfdate;
                          $date = date("Y-m-d-H-i-s");
                          $servicename = "Post Job";
                          $servicedesc = "Purchase Post Job $jnumber $Jtypepost Plan Of N$pricebfdate For social Media $Smedia Link $jlink Dateline $jdateline $jdateliename";
                          // add intransactions Table
                          $insertSql = "INSERT INTO `transactions` (`sId`, `transref`, `servicename`, `servicedesc`, `amount`, `status`,`oldbal`, `newbal`,`profit`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                          $insertStmt = $conn->prepare($insertSql);
                          $insertStmt->bind_param("ssssssssss", $userId, $transref, $servicename, $servicedesc, $pricebfdate, $status, $oldbal, $newbal, $profit, $date);
                          $insertStmt->execute();
                          if ($insertStmt->affected_rows > 0) {
                            // Update the wallet balance
                            $updateSql = "UPDATE `subscribers` SET `sWallet` = ?  WHERE `sId` = ?";
                            $updateStmt = $conn->prepare($updateSql);
                            $updateStmt->bind_param("ss", $newbal, $userId);

                            // Execute the prepared statement
                            $updateStmt->execute();

                            // Check if the update was successful
                            if ($updateStmt->affected_rows > 0) {
                              // Update the transaction status to be successful
                              $status = 0;
                              $updatesql = "UPDATE `transactions` SET `status` = ? WHERE `transref` = ?";
                              $updatesqlstmt = $conn->prepare($updatesql);
                              $updatesqlstmt->bind_param("ss", $status, $transref);
                              $updatesqlstmt->execute();
                              if ($updatesqlstmt->affected_rows > 0) {
                                // Insert into Task Table
                                $jid = rand(100000, 999999);
                                $date = date("Y-m-d-H-i-s");
                                $done = 0;
                                $insertpostsql = "INSERT INTO `tasks` (`sId`, `tJid`, `tType`, `tMedia`, `tNumbers`, `tDateline`, `tLink`, `tDone`, `tStatus`, `tPrice`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
                                $insertpoststmt = $conn->prepare($insertpostsql);
                                $insertpoststmt->bind_param("sssssssssss", $userId, $jid, $Jtypepost, $Smedia, $jnumber, $jdateline, $jlink, $done, $status, $pricebfdate, $date);
                                $insertpoststmt->execute();
                                if ($insertpoststmt->affected_rows > 0) {
                                  header("Location: transaction-details?ref=$transref");
                                } else {
                                  $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin (Inserting To Task Transaction With Date Failed $conn->error)", "red");
                                }
                              } else {
                                $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin (Updating Success Transaction With date Failed)", "red");
                              }
                            } else {
                              // Error Updating Wallet Swet Transaction to be Failed
                              $status = 1;
                              $updatesql = "UPDATE `transactions` SET `status` = ? WHERE `transref` = ?";
                              $updatesqlstmt = $conn->prepare($updatesql);
                              $updatesqlstmt->bind_param("ss", $status, $transref);
                              $updatesqlstmt->execute();
                              if ($updatesqlstmt->affected_rows > 0) {
                                header("Location: transaction-details?ref=$transref");
                              } else {
                                $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin (Updating Faild Transaction Failed)", "red");
                              }                                // Now you can display $msg wherever appropriate in your HTML or output it in any other way.
                            }

                            // Close the prepared statement
                            $updateStmt->close();
                          } else {
                            // Error Inserting Transaction
                            $msg = Scustom::createPopMessage("Error!!", "Error Inserting Transaction.", "red");

                          }
                          // Assuming you have already established a database connection and stored it in $conn

                        }
                      } else {
                        $msg = Scustom::createPopMessage("Error!!", "Error Calculation Espected Price $pricebfdate Including Date-line but Foud Price $myamounttopay.", "red");
                        // Wrong Calculation From User
                      }
                    } else {
                      // Error the date does not exist
                      $msg = Scustom::createPopMessage("Error!!", "Error The date does not exist.", "red");

                    }
                  } else {
                    // Set the last amount without dateline
                    if ($pricebfdate == $myamounttopay) {
                      // Check Wallet Balance and Post The Job Into DB
                      $walletbalance = (int) $row1['sWallet'];
                      if ($pricebfdate > $walletbalance) {
                        $msg = Scustom::createPopMessage("Error!!", "Insufficient Balance job price $pricebfdate wallet balance $walletbalance.", "red");
                      } else {
                        // Post The Job Into DB
                        $Jtypepost = $likepost . $followpost . $commentpost . $sharepost . $viewpost . $subscribepost . $repostpost;
                        $profit = 0;
                        $status = 2;
                        $oldbal = $row1['sWallet'];

                        $newbal = (int) $row1['sWallet'] - $pricebfdate;
                        $date = date("Y-m-d-H-i-s");
                        $servicename = "Post Job";
                        $servicedesc = "Purchase Post Job $jnumber $Jtypepost Plan Of N$pricebfdate For social Media $Smedia Link $jlink ";
                        // If Pin Is correct add transactions
                        $insertSql = "INSERT INTO `transactions` (`sId`, `transref`, `servicename`, `servicedesc`, `amount`, `status`,`oldbal`, `newbal`,`profit`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $insertStmt = $conn->prepare($insertSql);
                        $insertStmt->bind_param("ssssssssss", $userId, $transref, $servicename, $servicedesc, $pricebfdate, $status, $oldbal, $newbal, $profit, $date);
                        $insertStmt->execute();
                        if ($insertStmt->affected_rows > 0) {
                          $updateSql = "UPDATE `subscribers` SET `sWallet` = ?  WHERE `sId` = ?";
                          $updateStmt = $conn->prepare($updateSql);
                          $updateStmt->bind_param("ss", $newbal, $userId);

                          // Execute the prepared statement
                          $updateStmt->execute();

                          // Check if the update was successful
                          if ($updateStmt->affected_rows > 0) {
                            $status = 0;
                            $updatesql = "UPDATE `transactions` SET `status` = ? WHERE `transref` = ?";
                            $updatesqlstmt = $conn->prepare($updatesql);
                            $updatesqlstmt->bind_param("ss", $status, $transref);
                            $updatesqlstmt->execute();
                            if ($updatesqlstmt->affected_rows > 0) {
                              // Insert into Task Table
                              $jdateline = "none";
                              $jid = rand(100000, 999999);
                              $date = date("Y-m-d-H-i-s");
                              $done = 0;
                              $insertpostsql = "INSERT INTO `tasks` (`sId`, `tJid`, `tType`, `tMedia`, `tNumbers`, `tDateline`, `tLink`, `tDone`, `tStatus`, `tPrice`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
                              $insertpoststmt = $conn->prepare($insertpostsql);
                              $insertpoststmt->bind_param("sssssssssss", $userId, $jid, $Jtypepost, $Smedia, $jnumber, $jdateline, $jlink, $done, $status, $pricebfdate, $date);
                              $insertpoststmt->execute();
                              if ($insertpoststmt->affected_rows > 0) {
                                header("Location: transaction-details?ref=$transref");
                              } else {
                                $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin (Inserting To Task Transaction Failed Without Date)", "red");
                              }
                            }
                          } else {
                            // Error Updating Wallet
                            $status = 1;
                            $updatesql = "UPDATE `transactions` SET `status` = ? WHERE `transref` = ?";
                            $updatesqlstmt = $conn->prepare($updatesql);
                            $updatesqlstmt->bind_param("ss", $status, $transref);
                            $updatesqlstmt->execute();
                            if ($updatesqlstmt->affected_rows > 0) {
                              header("Location: transaction-details?ref=$transref");
                            } else {
                              $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin (Updating Faild Transaction Failed Without Date)", "red");
                            }                                // Now you can display $msg wherever appropriate in your HTML or output it in any other way.
                          }

                          // Close the prepared statement
                          $updateStmt->close();
                        } else {
                          // Error Inserting Transaction
                          $msg = Scustom::createPopMessage("Error!!", "Error Inserting Transaction. (Without Dateline)", "red");

                        }
                        // Assuming you have already established a database connection and stored it in $conn

                      }
                    } else {
                      $msg = Scustom::createPopMessage("Error!!", "Calculation Error Espected Price $pricebfdate your Posted Price $myamounttopay.", "red");
                      // Wrong Calculation From User
                    }
                  }
                } else {
                  // Error Numbers Out Of Range
                  $msg = Scustom::createPopMessage("Error!!", "Error Numbers Out Of Range.", "red");

                }
              } else {
                // Error Price did not match
                $msg = Scustom::createPopMessage("Error!!", "Error S/Media Prices Price did not match.", "red");

              }
            }
          // } 
          // else {
          //   // error Link Most Contain Social Media Name
          //   $msg = Scustom::createPopMessage("Error!!", "Error Link Most Contain Social Media Name for Comfermation.", "red");

          // }

        } else {
          $msg = Scustom::createPopMessage("Error!!", "Error Selected Social Media Does Not exixst.", "red");

          // error Social Media Does Not exixst
        }
      }

    } else {
      $msg = Scustom::createPopMessage("Error!!", "Incorrect Pin, Please Try Again.", "red");
      // The Pin Is not correct
    }

  } else {
    // The user is not found in data base
    $msg = Scustom::createPopMessage("Error!!", "Unknow Error Contact Admin.", "red");

  }
}
if (isset($_POST["deactivatejob"]) || isset($_POST["activatejob"])) {
  $conn = Scustom::Connectdb();
  if (isset($_POST["deactivatejob"])) {
    $userId = $_SESSION["loginId"];
    $jobid = $_POST["jobId"];
    $status = 1;
    $updatejobsql = "UPDATE `tasks` SET `tStatus` = ? WHERE `tId` = ? AND `sId` = ?";
    $updatejobstmt = $conn->prepare($updatejobsql);
    $updatejobstmt->bind_param("sss", $status, $jobid, $userId);
    $updatejobstmt->execute();
    if ($updatejobstmt->affected_rows > 0) {
      header("Location:#");
    } else {
      $msg = Scustom::createPopMessage("Error!!", "Error Can't Update JOB Action.", "red");
    }
  }
  else if (isset($_POST["activatejob"])) {
    $userId = $_SESSION["loginId"];
    $jobid = $_POST["jobId"];
    $status = 0;
    $updatejobsql = "UPDATE `tasks` SET `tStatus` = ? WHERE `tId` = ? AND `sId` = ?";
    $updatejobstmt = $conn->prepare($updatejobsql);
    $updatejobstmt->bind_param("sss", $status, $jobid, $userId);
    $updatejobstmt->execute();
    if ($updatejobstmt->affected_rows > 0) {
      header("Location:#");
    } else {
      $msg = Scustom::createPopMessage("Error!!", "Error Can't Update JOB Action (Activation).", "red");
    }
  }
}
$pmsg = "";
$msgcolor = "";
// $amounts = "10"; // Example string representing an integer
// $intValue = (int)$amounts; // Convert the string to an integer using type casting
// echo $intValue; // Output: 10

?>