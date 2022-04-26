<?php
// Connect to database
require_once('/xampp/htdocs/travelHK.com/dbConnect.php');

// Include required phpmailer files
require 'lib/phpMailer/PHPMailer.php';
require 'lib/phpMailer/SMTP.php';
require 'lib/phpMailer/Exception.php';

// Define name sapces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Session start
session_start();

// Operation List
switch ($_GET['op']) {
  // itinerary management
  case 'createItinerary':
    createItinerary();
    break;
  case 'updateItinerary':
    updateItinerary();
    break;
  case 'createBooking':
    createBooking();
    break;
  case 'cancelBooking':
    cancelBooking();
    break;
  case 'updateBooking':
    updateBooking();
    break;
  case 'cancelItineraryBooking':
    cancelItineraryBooking();
    break;

  // tour group management
  case 'createItinerary_tourGuide':
    createItinerary_tourGuide();
    break;
  case 'tourGuideUpdateItinerary':
    tourGuideUpdateItinerary();
    break;
  case 'createTourGroup': // create tour group in planner
    createTourGroup();
    break;
  case 'createTourGroupInList': // in the itinerary list create tour group
    createTourGroupInList();
    break;
  case 'updateTourGroup':
    updateTourGroup();
    break;
  case 'finishTourGroup':
    finishTourGroup();
    break;
  case 'cancelTourGroup':
    cancelTourGroup();
    break;

  // driver booking management
  case 'acceptDriverBooking':
    acceptDriverBooking();
    break;
  case 'finishDriverBooking';
    finishDriverBooking();
    break;

  // General user tour group management
  case 'cancelJoinTourGroup':
    cancelJoinTourGroup();
    break;
}

function createItinerary() {

  // Get the database connection variable
  global $conn;

  $user_email = "test@gmail.com"; //$_SESSION['user_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";

  $rs = mysqli_query($conn, $sql);
  $action_rd = mysqli_fetch_assoc($rs);

  // get parameters value from ajax
  $attraction_id = $_POST['attraction'];
  $startTimes = $_POST['startTime'];
  $endTimes = $_POST['endTime'];

  // get itinerary subject
  $chineseName = $_POST['chi-name'];
  $englishName = $_POST['eng-name'];

  // get booking details
  $bookingDate = $_POST['bookingDate'];
  $bookingTime = $_POST['bookingTime'];
  $people_num = $_POST['peopleNum'];
  $pick_address = $_POST['pickAddress'];
  $drop_address = $_POST['dropAddress'];

  // insert new itinerary into itinerary table
  $sql = "INSERT INTO `itinerary` (
            `itinerary_id`,
            `create_datetime`,
            `status`,
            `account_id`,
            `itinerary_chinese_name`,
            `itinerary_english_name`
          ) VALUES (
              NULL,
              current_timestamp(),
              '{$_GET['status']}',
              '{$action_rd['account_id']}',
              '{$chineseName}',
              '{$englishName}'
            )";

  if (mysqli_query($conn, $sql)) {

    // get the newest itinerary's id
    $sql = "SELECT `itinerary_id` FROM `itinerary` WHERE `account_id` = '{$action_rd['account_id']}' ORDER BY `itinerary_id` DESC LIMIT 1";
    $rs = mysqli_query($conn, $sql);

    if ($rs) {

      $itinerary_rd = mysqli_fetch_assoc($rs);
      $sql = "INSERT INTO `itinerary_schedule` (`itinerary_id`, `attraction_id`, `start_time`, `end_time`) VALUES ";

      // assemble the sql insert statement elements
      for ($i = 0; $i < count($attraction_id); $i++) {
        $sql .= "('{$itinerary_rd['itinerary_id']}', '{$attraction_id[$i]}', '{$startTimes[$i]}', '{$endTimes[$i]}')";

        if ($i < count($attraction_id) - 1) {
          $sql .= ",";
        }
      }
      
      if (mysqli_query($conn, $sql)) {

        if ($_GET['driver'] == "1" || $_GET['tourGuide'] == "1") {

          // insert data into itinerary_booking table
          $sql = "INSERT INTO `itinerary_booking` (
            `booking_id`,
            `itinerary_id`,
            `account_id`,
            `drive_service`,
            `tourguide_service`,
            `start_date`,
            `start_time`,
            `people_num`,
            `start_address`,
            `end_address`,
            `status`,
            `driver_id`,
            `tourguide_id`,
            `create_datetime`
          ) VALUES (
              NULL,
              '{$itinerary_rd['itinerary_id']}',
              '{$action_rd['account_id']}',
              '{$_GET['driver']}',
              '{$_GET['tourGuide']}',
              '{$bookingDate}',
              '{$bookingTime}',
              '{$people_num}',
              '{$pick_address}',
              '{$drop_address}',
              0,
              NULL,
              NULL,
              current_timestamp()
            )";

            if (mysqli_query($conn, $sql)) {

              // Response success json
              echo json_encode(array('success' => true));

            } else {
              // Response fail json
              echo json_encode(array('success' => false));
            }
        } else {
          // Response success json
          echo json_encode(array('success' => true));
        }
      } else {
        // Response fail json
        echo json_encode(array('success' => false));
      }
    } else {
      // Response fail json
      echo json_encode(array('success' => false));
    }
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

// update itinerary without any service requests before
function updateItinerary() {
  // Get the database connection variable
  global $conn;

  // get the itinerary id
  $itinerary_id = $_GET['id'];

  // get parameters value from ajax
  $attraction_id = $_POST['attraction'];
  $startTimes = $_POST['startTime'];
  $endTimes = $_POST['endTime'];

  // get itinerary subject
  $chineseName = $_POST['chi-itinerary-name'];
  $englishName = $_POST['eng-itinerary-name'];

  // update itinerary statement
  $sql = "UPDATE `itinerary`
            SET `itinerary_chinese_name` = '{$chineseName}', 
                `itinerary_english_name` = '{$englishName}',
                `last_update` = current_timestamp()
            WHERE `itinerary_id` = '{$itinerary_id}'";

  // update record on database
  if (mysqli_query($conn, $sql)) {
    // delete itinerary_schedule statement
    $sql = "DELETE FROM `itinerary_schedule` WHERE `itinerary_id` = '{$itinerary_id}'";

    // remove old data on database
    if (mysqli_query($conn, $sql)) {
      // insert new itinerary into itinerary table
      $sql = "INSERT INTO `itinerary_schedule` (
        `itinerary_id`,
        `attraction_id`,
        `start_time`,
        `end_time`
      ) VALUES ";

      // assemble the sql insert statement elements
      for ($i = 0; $i < count($attraction_id); $i++) {
        $sql .= "('{$itinerary_id}', '{$attraction_id[$i]}', '{$startTimes[$i]}', '{$endTimes[$i]}')";

        if ($i < count($attraction_id) - 1) {
          $sql .= ",";
        }
      }

      // insert new records
      if (mysqli_query($conn, $sql)) {
        // Response success json
        echo json_encode(array('success' => true));
      } else {
        // Response fail json
        echo json_encode(array('success' => false));
      }
    } else {
      // Response fail json
      echo json_encode(array('success' => false));
    }
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

// insert new booking
function createBooking() {
  // Get the database connection variable
  global $conn;

  // get the itinerary id
  $itinerary_id = $_GET['id'];

  $user_email = "test@gmail.com"; //$_SESSION['user_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  // get services value
  if (isset($_POST['driverService'])) {
    $driverService = 1;
  } else {
    $driverService = 0;
  }

  // get services value
  if (isset($_POST['tourguideService'])) {
    $tourguideService = 1;
  } else {
    $tourguideService = 0;
  }

  // get booking details
  $bookingDate = $_POST['booking-date'];
  $bookingTime = $_POST['booking-time'];
  $people_num = $_POST['people-num'];
  $pick_address = $_POST['pick-address'];
  $drop_address = $_POST['drop-address'];

  $sql = "INSERT INTO `itinerary_booking` (
    `itinerary_id`,
    `account_id`,
    `drive_service`,
    `tourguide_service`,
    `start_date`,
    `start_time`,
    `people_num`,
    `start_address`,
    `end_address`,
    `status`,
    `create_datetime`
  ) VALUES (
    '{$itinerary_id}',
    '{$account_rd['account_id']}',
    '{$driverService}',
    '{$tourguideService}',
    '{$bookingDate}',
    '{$bookingTime}',
    '{$people_num}',
    '{$pick_address}',
    '{$drop_address}',
    0,
    current_timestamp()
  )";

  // insert new records
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

// cancel booking data
function cancelBooking(){
  // Get the database connection variable
  global $conn;

  // get the booking id
  $booking_id = $_GET['id'];

  $sql = "UPDATE `itinerary_booking` SET `status` = 3 WHERE `booking_id` = '{$booking_id}'";

  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
    
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  // Close the database
  mysqli_close($conn);
}

// update itinerary booking
function updateBooking() {
  // Get the database connection variable
  global $conn;

  // get the itinerary id
  $booking_id = $_GET['id'];

  if (isset($_POST['driverService'])) {
    $drive_service = 1;
  } else {
    $drive_service = 0;
  }

  if (isset($_POST['tourguideService'])) {
    $tourguide_service = 1;
  } else {
    $tourguide_service = 0;
  }

  // get booking details
  $bookingDate = $_POST['booking-date'];
  $bookingTime = $_POST['booking-time'];
  $people_num = $_POST['people-num'];
  $pick_address = $_POST['pick-address'];
  $drop_address = $_POST['drop-address'];

  // update itinerary booking sql
  $sql = "UPDATE `itinerary_booking` SET
                  `drive_service` = '{$drive_service}', 
                  `tourguide_service` = '{$tourguide_service}',
                  `start_date` = '{$bookingDate}', 
                  `start_time` = '{$bookingTime}', 
                  `people_num` = '{$people_num}',
                  `start_address` = '{$pick_address}',
                  `end_address` = '{$drop_address}' WHERE `booking_id` = '{$booking_id}'";

  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

// cancel booking in the member center
function cancelItineraryBooking() {
  global $conn;

  $sql = "UPDATE `itinerary_booking` SET `status` = 3 WHERE `booking_id` = {$_POST['booking-id']} ";

  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }

  mysqli_close($conn);
}

// tourguide create itinerary service
function createItinerary_tourGuide() {
  // Get the database connection variable
  global $conn;

  $user_email = $_SESSION['guide_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";

  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  // get parameters value from ajax
  $attraction_id = $_POST['attraction'];
  $startTimes = $_POST['startTime'];
  $endTimes = $_POST['endTime'];

  // get itinerary subject
  $chineseName = $_POST['chi-itinerary-name'];

  // insert new itinerary into itinerary table
  $sql = "INSERT INTO `itinerary` (
            `status`,
            `account_id`,
            `itinerary_chinese_name`
          ) VALUES (
              0,
              '{$account_rd['account_id']}',
              '{$chineseName}'
            )";

  if (mysqli_query($conn, $sql)) {

    // get the newest itinerary's id
    $sql = "SELECT `itinerary_id` FROM `itinerary` WHERE `account_id` = '{$account_rd['account_id']}' ORDER BY `itinerary_id` DESC LIMIT 1";
    $rs = mysqli_query($conn, $sql);

    if ($rs) {

      $itinerary_rd = mysqli_fetch_assoc($rs);
      $sql = "INSERT INTO `itinerary_schedule` (`itinerary_id`, `attraction_id`, `start_time`, `end_time`) VALUES ";

      // assemble the sql insert statement elements
      for ($i = 0; $i < count($attraction_id); $i++) {
        $sql .= "('{$itinerary_rd['itinerary_id']}', '{$attraction_id[$i]}', '{$startTimes[$i]}', '{$endTimes[$i]}')";

        if ($i < count($attraction_id) - 1) {
          $sql .= ",";
        }
      }
      
      if (mysqli_query($conn, $sql)) {
        // Response success json
        echo json_encode(array('success' => true));

      } else {
        // Response fail json
        echo json_encode(array('success' => false));
      }
    } else {
      // Response fail json
      echo json_encode(array('success' => false));
    }
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

function createTourGroup() {
  // Get the database connection variable
  global $conn;

  // get account id
  $user_email = $_SESSION['guide_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  $attraction_id = $_POST['attraction'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];

  // insert new itinerary into itinerary table
  $sql = "INSERT INTO `itinerary` (
    `status`,
    `account_id`,
    `itinerary_chinese_name`
  ) VALUES (
      0,
      '{$account_rd['account_id']}',
      '{$_POST['chi-itinerary-name']}'
    )";

  // Execute the sql
  if (mysqli_query($conn, $sql)) {

    // get the newest itinerary's id
    $sql = "SELECT `itinerary_id` FROM `itinerary` WHERE `account_id` = '{$account_rd['account_id']}' ORDER BY `itinerary_id` DESC LIMIT 1";
    $rs = mysqli_query($conn, $sql);
    $itinerary_rd = mysqli_fetch_assoc($rs);

    // insert new records
    if ($rs) {

      // insert new itinerary into itinerary table
      $sql = "INSERT INTO `itinerary_schedule` (
        `itinerary_id`,
        `attraction_id`,
        `start_time`,
        `end_time`
      ) VALUES ";

      // assemble the sql insert statement elements
      for ($i = 0; $i < count($attraction_id); $i++) {
        $sql .= "('{$itinerary_rd['itinerary_id']}', '{$attraction_id[$i]}', '{$startTime[$i]}', '{$endTime[$i]}')";

        if ($i < count($attraction_id) - 1) {
          $sql .= ",";
        }
      }

      // insert records to itinerary_schedule table
      if (mysqli_query($conn, $sql)) {

        if (isset($_POST['tourgroup-status'])) {
          if ($_POST['tourgroup-status'] == 4) {
            $status = 4;
          } else {
            $status = 5;
          }
        }

        $sql = "INSERT INTO `tourguide_tourgroup` (
          `itinerary_id`,
          `account_id`,
          `subject`,
          `description`,
          `fee`,
          `start_date`,
          `start_time`,
          `max_people`,
          `start_address`,
          `end_address`,
          `joined_people`,
          `status`,
          `cutoff_date`
        ) VALUES (
          '{$itinerary_rd['itinerary_id']}',
          '{$account_rd['account_id']}',
          '{$_POST['tourgroup-subject']}',
          '{$_POST['description']}',
          '{$_POST['tourgroup-fee']}',
          '{$_POST['tourgroup-date']}',
          '{$_POST['tourgroup-time']}',
          '{$_POST['max-people']}',
          '{$_POST['start-address']}',
          '{$_POST['end-address']}',
          0,
          '{$status}',
          '{$_POST['cut-off-date']}'
        );";

        // insert record to tourguide_tourgroup table
        if (mysqli_query($conn, $sql)) {
          // Response success json
          echo json_encode(array('success' => true));
        } else {
          // Response fail json
          echo json_encode(array('success' => false));
        }
        
      } else {
        // Response fail json
        echo json_encode(array('success' => false));
      }
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason' => mysqli_error($conn)
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

// create tourgroup in the itinerary list
function createTourGroupInList() {
  // Get the database connection variable
  global $conn;

  // get account id
  $user_email = $_SESSION['guide_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  if (isset($_POST['tourgroup-status'])) {
    if ($_POST['tourgroup-status'] == 4) {
      $status = 4;
    } else {
      $status = 5;
    }
  }

  $sql = "INSERT INTO `tourguide_tourgroup` (
    `itinerary_id`,
    `account_id`,
    `subject`,
    `description`,
    `fee`,
    `start_date`,
    `start_time`,
    `max_people`,
    `start_address`,
    `end_address`,
    `joined_people`,
    `status`,
    `cutoff_date`
  ) VALUES (
    '{$_POST['itinerary_id']}',
    '{$account_rd['account_id']}',
    '{$_POST['tourgroup-subject']}',
    '{$_POST['description']}',
    '{$_POST['tourgroup-fee']}',
    '{$_POST['tourgroup-date']}',
    '{$_POST['tourgroup-time']}',
    '{$_POST['max-people']}',
    '{$_POST['start-address']}',
    '{$_POST['end-address']}',
    0,
    '{$status}',
    '{$_POST['cut-off-date']}'
  );";

  // insert record to tourguide_tourgroup table
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  // Close the database
  mysqli_close($conn);
}

function updateTourGroup() {
  // Get the database connection variable
  global $conn;

  if (isset($_POST['tourgroup-status'])) {
    if ($_POST['tourgroup-status'] == 4) {
      $status = 4;
    } else {
      $status = 5;
    }
  }

  $sql = "UPDATE `tourguide_tourgroup` SET
              `subject`          = '{$_POST['tourgroup-subject']}',
              `description`      = '{$_POST['description']}',
              `fee`              = '{$_POST['tourgroup-fee']}',
              `start_date`       = '{$_POST['tourgroup-date']}',
              `start_time`       = '{$_POST['tourgroup-time']}',
              `max_people`       = '{$_POST['max-people']}',
              `start_address`    = '{$_POST['start-address']}',
              `end_address`      = '{$_POST['end-address']}',
              `status`           = '{$status}',
              `last_update`      = current_timestamp(),
              `cutoff_date`      = '{$_POST['cut-off-date']}'
            WHERE `tourgroup_id` = '{$_POST['tourgroup_id']}';";

  // insert record to tourguide_tourgroup table
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  // Close the database
  mysqli_close($conn);
}

function finishTourGroup() {
  global $conn;

  $tourgroup_id = $_POST['id'];

  $sql = "UPDATE `tourguide_tourgroup`
            SET `status` = 2
            WHERE `tourgroup_id` = $tourgroup_id;";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  mysqli_close($conn);
}

function cancelTourGroup() {
  global $conn;

  $tourgroup_id = $_POST['id'];

  $sql = "UPDATE `tourguide_tourgroup`
            SET `status` = 3
            WHERE `tourgroup_id` = $tourgroup_id;";
  if (mysqli_query($conn, $sql)) {
    $sql = "SELECT `group`.`tourgroup_id`, `group`.`subject`, ac.`email`
              FROM `account` `ac`
              INNER JOIN `tourgroup_member` `mem` ON `ac`.`account_id` = `mem`.`account_id`
              INNER JOIN `tourguide_tourgroup` `group` ON `mem`.`tourgroup_id` = `group`.`tourgroup_id`
              WHERE `mem`.`tourgroup_id` = $tourgroup_id;";
    $rs = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($rs)) {
      // Create instance of phpmailer
      $mail = new PHPMailer();

      // Try to sent email to applicant
      try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->Port = "587";
        $mail->Username = "ivefyp487@gmail.com";
        $mail->Password = "as102030";

        // Set sender email
        $mail->setFrom("ivefyp487@gmail.com");

        // Add recipient
        $mail->addAddress($row['email']);

        // Content
        $mail->isHTML(true);                            // Set email format to HTML
        $mail->Subject = '旅行團取消通知';
        $mail->Body    = '
        <p><b>閣下參加的' . $row['subject'] .'旅行團已取消。</b></p>';
        $mail->AltBody = '閣下參加的' . $row['subject'] .'旅行團已取消。';

        // Finally send email
        $mail->Send();
        $mail_log = 'Message has been sent';
      } catch (Exception $e) {
        $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      } finally {
        // Closing smtp connection
        $mail->smtpClose();
      }
    }

    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  mysqli_close($conn);
}

function tourGuideUpdateItinerary() {
  // Get the database connection variable
  global $conn;

  // get the itinerary id
  $itinerary_id = $_GET['id'];

  // get parameters value from ajax
  $attraction_id = $_POST['attraction'];
  $startTimes = $_POST['startTime'];
  $endTimes = $_POST['endTime'];

  // get itinerary subject
  $chineseName = $_POST['chi-itinerary-name'];

  // update itinerary statement
  $sql = "UPDATE `itinerary` SET 
                `itinerary_chinese_name` = '{$chineseName}',
                `last_update` = current_timestamp()
            WHERE `itinerary_id` = '{$itinerary_id}'";

  // upadte record on database
  if (mysqli_query($conn, $sql)) {
    // delete itinerary_schedule statement
    $sql = "DELETE FROM `itinerary_schedule` WHERE `itinerary_id` = '{$itinerary_id}'";

    // remove old data on database
    if (mysqli_query($conn, $sql)) {
      // insert new itinerary into itinerary table
      $sql = "INSERT INTO `itinerary_schedule` (
        `itinerary_id`,
        `attraction_id`,
        `start_time`,
        `end_time`
      ) VALUES ";

      // assemble the sql insert statement elements
      for ($i = 0; $i < count($attraction_id); $i++) {
        $sql .= "('{$itinerary_id}', '{$attraction_id[$i]}', '{$startTimes[$i]}', '{$endTimes[$i]}')";

        if ($i < count($attraction_id) - 1) {
          $sql .= ",";
        }
      }

      // insert new records
      if (mysqli_query($conn, $sql)) {
        // Response success json
        echo json_encode(array('success' => true));
      } else {
        // Response fail json
        echo json_encode(array('success' => false));
      }
    } else {
      // Response fail json
      echo json_encode(array('success' => false));
    }
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}

// driver accept booking
function acceptDriverBooking() {
  // Get the database connection variable
  global $conn;

  // get account id
  $user_email = $_SESSION['driver_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  $booking_id = $_GET['id'];
  $tourguide_service = $_GET['service'];
  $tourguide_id = $_GET['tid'];

  if ($tourguide_service == 1 && $tourguide_id != "") {
    $sql = "UPDATE `itinerary_booking` SET 
                      driver_id = '{$account_rd['account_id']}',
                      status = 1
                      WHERE `booking_id` = $booking_id";

  } else if ($tourguide_service == 1 && $tourguide_id == "") {
    $sql = "UPDATE `itinerary_booking` SET 
                      driver_id = '{$account_rd['account_id']}'
                      WHERE `booking_id` = $booking_id";

  } else {
    $sql = "UPDATE `itinerary_booking` SET 
                      driver_id = '{$account_rd['account_id']}',
                      status = 1
                      WHERE `booking_id` = $booking_id";
  }
  
  // insert new records
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  // Close the database
  mysqli_close($conn);
}

// Driver finish booking
function finishDriverBooking() {
  global $conn;

  $booking_id = $_POST['id'];
  $sql = "UPDATE `itinerary_booking`
            SET `status` = 2
            WHERE `booking_id` = $booking_id";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }

  mysqli_close($conn);
}

function cancelJoinTourGroup() {
  // Get the database connection variable
  global $conn;

  $tourgroup_id = $_POST['tourgroup_id'];
  $join = $_GET['join'];

  $sql = "UPDATE tourguide_tourgroup SET joined_people = joined_people - $join WHERE tourgroup_id = '$tourgroup_id';";

  // insert new records
  if (mysqli_query($conn, $sql)) {
    $sql = "DELETE FROM tourgroup_member WHERE tourgroup_id = '$tourgroup_id'";
    // insert new records
    if (mysqli_query($conn, $sql)) {
      // Response success json
      echo json_encode(array('success' => true));
    } else {
      // Response fail json
      echo json_encode(array('success' => false));
    }
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  mysqli_close($conn);
}