<?php
// Connect to database
include_once("dbConnect.php");

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
    // Account management
  case 'generalUserRegister':
    register_general_user();
    break;
  case 'checkLogin':
    checkLogin();
    break;
  case 'checkStaffLogin':
    checkStaffLogin($_POST['email'], $_POST['password']);
    break;
  case 'logout':
    logout();
    break;
  case 'updateUserInfo':
    updateUserInfo($_POST['_email']);
    break;
  case 'updatePassword':
    updatePassword($_POST['__email']);
    break;

    // Admin methods
    // Account management
  case 'adminUpdateAccountDetails':
    adminUpdateAccountDetails($_GET['id']);
    break;
  case 'adminChangeAccountStatus':
    adminChangeAccountStatus();
    break;
    // Attraction management
  case 'adminCreateAttraction':
    adminCreateAttraction();
    break;
  case 'adminUpdateAttractionInfo':
    adminUpdateAttractionInfo($_GET['id']);
    break;
  case 'adminUpdateAttractionStatus':
    adminUpdateAttractionStatus($_GET['id']);
    break;
    // Restaurant management
  case 'adminCreateRestaurant':
    adminCreateRestaurant();
    break;
  case 'adminUpdateRestaurantInfo':
    adminUpdateRestaurantInfo($_GET['id']);
    break;
  case 'adminUpdateRestaurantStatus':
    adminUpdateRestaurantStatus($_GET['id']);
    break;
  case 'adminUpdateRestaurantStorefront':
    adminUpdateRestaurantStorefront($_GET['id']);
    break;
  case 'adminUpdateRestaurantBanner':
    adminUpdateRestaurantBanner($_GET['id']);
    break;
  case 'loadBookingResult':
    loadBookingResult();
    break;
  case 'getWorkingTime':
    getWorkingTime();
    break;
  case 'findBookingByDateAndTime':
    findBookingByDateAndTime();
    break;
  case 'restaurantFinishBooking':
    restaurantFinishBooking($_POST['id']);
    break;
  case 'restaurantCancelBooking':
    restaurantCancelBooking($_POST['id']);
    break;
  case 'loadBookingLayout':
    loadBookingLayout();
    break;
  case 'loadTablePlacement':
    loadTablePlacement();
    break;


    // Guesthouse management
  case 'adminCreateGuesthouse':
    adminCreateGuesthouse();
    break;
  case 'adminUpdateGuesthouseInfo':
    adminUpdateGuesthouseInfo($_GET['id']);
    break;
  case 'adminUpdateGuesthouseStatus':
    adminUpdateGuesthouseStatus($_GET['id']);
    break;
  case 'adminUpdateGuesthouseStorefront':
    adminUpdateGuesthouseStorefront($_GET['id']);
    break;
  case 'adminUpdateGuesthouseBanner':
    adminUpdateGuesthouseBanner($_GET['id']);
    break;
    // Collaboration management
  case 'adminCollabRequestControl':
    adminCollabRequestControl($_GET['id'], $_GET['type'], $_GET['action']);
    break;
  case 'adminWorkerApplicationControl':
    adminWorkerApplicationControl($_GET['id'], $_GET['type'], $_GET['action']);
    break;
  case 'adminConfirmAttractionDiscovery':
    adminConfirmAttractionDiscovery($_GET['id'], $_GET['action']);
    break;
  case 'adminConfirmRestaurantDiscovery':
    adminConfirmRestaurantDiscovery($_GET['id'], $_GET['action']);
    break;
  case 'adminConfirmGuesthouseDiscovery':
    adminConfirmGuesthouseDiscovery($_GET['id'], $_GET['action']);
    break;
    // End of admin methods

    // Collaboration request submit method
  case 'submitRestaurantRequest':
    submit_restaurant_request();
    break;
  case 'submitGusethouseRequest':
    submit_guesthouse_request();
    break;
  case 'collabUserRegister':
    collabUserRegister($_GET['type']);
    break;
  case 'siteGenerator':
    siteGenerator($_GET['type'], $_GET['account']);
    break;
  case 'completePartnerRequest':
    completePartnerRequest($_GET['id']);
    break;

    // Partner manage method
  case 'checkPartnerLogin':
    checkPartnerLogin($_GET['type']);
    break;
  case 'createRestaurant':
    createRestaurant($_GET['id']);
    break;
  case 'restaurantUpdateInfo':
    restaurantUpdateInfo($_GET['id']);
    break;
  case 'restaurantUpdateStatus':
    restaurantUpdateStatus($_GET['id']);
    break;
  case 'createGuesthouse':
    createGuesthouse($_GET['id']);
    break;
  case 'guesthouseFinishBooking':
    guesthouseFinishBooking($_POST['id']);
    break;
  case 'guesthouseCancelBooking':
    guesthouseCancelBooking($_POST['id']);
    break;

    // Worker Application
  case 'submitDriverJobApplication':
    submitDriverJobApplication();
    break;

  case 'submitTouristGuideJobApplication':
    submitTouristGuideJobApplication();
    break;

  case 'workerUserRegister':
    workerUserRegister($_GET['type']);
    break;

  case 'touristGuideAcceptBooking':
    touristGuideAcceptBooking($_GET['id']);
    break;

    // Worker methods
  case 'checkWorkerLogin':
    checkWorkerLogin($_GET['type']);
    break;

    // General user rating
  case 'restaurantRatingSubmit':
    submit_restaurantRating($_GET['id']);
    break;

  case 'attractionRatingSubmit':
    submit_attractionRating($_GET['id']);
    break;

  case 'guesthouseRatingSubmit':
    submit_guesthouseRating($_GET['id']);
    break;

    // Place discovery form submit
    // Place discovery form submit
  case 'attractiondiscoversubmit':
    attraction_discover_submit();
    break;
  case 'restaurantdiscoversubmit':
    restaurant_discover_submit();
    break;
  case 'guesthousediscoversubmit':
    guesthouse_discover_submit();
    break;

    // Reservation management
  case 'restaurantBookingRequest':
    restaurant_Booking_Request();
    break;
  case 'guesthouseBookingRequest':
    guesthouse_Booking_Request();
    break;
  case 'cancelGuesthouseBooking':
    cancelGuesthouseBooking();
    break;
  case 'cancelRestaurantBooking':
    cancelRestaurantBooking();
    break;

    // Tour group registration
  case 'submitTourGroupRegistration':
    submitTourGroupRegistration($_POST['tourGroupId'], $_POST['applicantId'], $_POST['contactNumber'], $_POST['numberOfPeople']);
    break;

    // save Restaurant table Layout
  case 'saveRestaurantLayout':
    saveRestaurantLayout();
    break;


    // Log
  case 'attractionEventLogGenerate':
    attractionEventLogGenerate($_GET['user_id'], $_GET['item_id'], $_GET['event_type'], $_GET['custom_weight']);
    break;

  default:
    echo json_encode(array(
      'success' => false,
      'reason' => "Unknown function or not exist."
    ));
    break;
}

/////////////////////////////////////////////////////////////////////

// Add a new General User (General User Register)
function register_general_user()
{
  // Get the database connection variable
  global $conn;

  // Check if the email address is repeated in database
  $query = "SELECT * FROM account WHERE `email` = '{$_POST['r_email']}';";
  $rs = mysqli_query($conn, $query);
  if (mysqli_num_rows($rs) > 0) {
    // Response fail and reason json
    echo json_encode(array(
      'success' => 'false',
      'reason'  => '重複的電郵地址，請重新輸入。'
    ));

    // Close the database
    mysqli_close($conn);

    // Leave the function
    exit();
  }

  // Check if the nickname is repeated in database
  $query = "SELECT * FROM account WHERE `nickname` = '{$_POST['r_nickname']}';";
  $rs = mysqli_query($conn, $query);
  if (mysqli_num_rows($rs) > 0) {
    // Response fail and reason json
    echo json_encode(array(
      'success' => 'false',
      'reason'  => '重複的暱稱，請重新輸入。'
    ));

    // Close the database
    mysqli_close($conn);

    // Leave the function
    exit();
  }

  // Save the register information
  $sql = "INSERT INTO account (
        `email`,
        `password`,
        `firstname`,
        `lastname`,
        `nickname`,
        `gender`,
        `phone_number`,
        `birth_year`,
        `birth_month`,
        `icon_path`,
        `type_id`,
        `status`,
        `registration_time`
        ) VALUES (
          '{$_POST['r_email']}',
          '{$_POST['r_psw']}',
          '',
          '',
          '{$_POST['r_nickname']}',
          '{$_POST['r_gender']}',
          '{$_POST['r_phoneNo']}',
          '{$_POST['r_birth_year']}',
          '{$_POST['r_birth_month']}',
          '',
          '1',
          '1',
          NOW()
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // ===== Saving image =====
    $id = $conn->insert_id;

    // Save the Tour Guide Selfie image
    $target_dir = "data/account/general/$id/";
    // Create the directory if not exists
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    // Store the user image
    // $target_file = $target_dir . basename('avatar.jpg');
    // move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
    $img = $_POST['avatar'];
    $target_dir = "data/account/general/$id/";
    $target_file = $target_dir . basename($id . '.jpg');

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $target_dir . "icon.png";

    file_put_contents($file, $data);

    // Response success json
    echo json_encode(array(
      'success' => true
    ));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }
  // Close the database
  mysqli_close($conn);
}



// ----------------------------------------------------------------







// Check the user login
function checkLogin()
{
  // Get the database connection variable
  global $conn;

  // Get the login information
  $email = $_POST['email'];
  $psw   = $_POST['psw'];

  // Set the sql statement to search
  $sql = "SELECT * FROM account
            WHERE `email` = '$email'
              AND `type_id` = 1;";
  $rs = mysqli_query($conn, $sql);

  if (mysqli_num_rows($rs) > 0) {
    $rd = mysqli_fetch_assoc($rs);

    // Check the account status
    if ($rd['status'] == 1) {
      // The account is normal
      // Check the password is valid
      if ($rd['password'] == $psw) {
        // Valid
        $_SESSION['user_id']       = $rd['account_id'];
        $_SESSION['user_email']    = $rd['email'];
        $_SESSION['user_nickname'] = $rd['nickname'];

        echo json_encode(array(
          'success' => true
        ));
      } else {
        // Invalid password
        echo json_encode(array(
          'success' => false,
          'reason'  => 'password invalid'
        ));
      }
    } else if ($rd['status'] == 0) {
      // The account is freezed
      echo json_encode(array(
        'success' => false,
        'reason'  => 'freezed'
      ));
    } else {
      // The account is deleted
      echo json_encode(array(
        'success' => false,
        'reason'  => 'not exist'
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => 'not exist'
    ));
  }

  // Close the database
  mysqli_close($conn);
}

// Check the staff login (Not done...)
function checkStaffLogin($email, $password)
{
  // Get the database connection variable
  global $conn;

  if (isset($_POST['login'])) {
    $sql = "SELECT * FROM `account`
              WHERE `email` = '$email'
                AND `type_id` = '0'
                AND `status` = '1';";
    $rs = mysqli_query($conn, $sql);

    if (mysqli_num_rows($rs) > 0) {
      $rd = mysqli_fetch_assoc($rs);

      // Verify the password
      if ($rd['password'] == $password) {
        // Save the login information to SESSION
        $_SESSION['admin_id']            = $rd['account_id'];
        $_SESSION['admin_email']         = $rd['email'];
        $_SESSION['admin_nickname']      = $rd['nickname'];
        $_SESSION['admin_iconPath']      = $rd['icon_path'];

        // Close the database
        mysqli_close($conn);

        // Redirect to homepage
        header('Location: admin/dashboard.php');
      } else {
        // Close the database
        mysqli_close($conn);

        // Redirect to homepage
        header('Location: admin/index.php');
      }
    } else {
      header('Location: admin/index.php');
    }
  } else {
    echo "Error";
  }
}

function adminUpdateAccountDetails($id)
{
  // Get the database connection variable
  global $conn;

  $sql = "UPDATE account
            SET `firstname` = '$_POST[firstname]',
                `lastname` = '$_POST[lastname]',
                `nickname` = '$_POST[nickname]',
                `gender` = '$_POST[gender]',
                `phone_number` = '$_POST[phone_number]',
                `birth_year` = '$_POST[birth_year]',
                `birth_month` = '$_POST[birth_month]'
            WHERE `account_id` = $id;";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

function adminChangeAccountStatus()
{
  global $conn;

  $sql = "UPDATE `account`
            SET `status` = {$_POST['status']}
            WHERE `account_id` = {$_POST['id']};";
  // echo $sql;
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

// Insert the new attraction record
function adminCreateAttraction()
{
  // Get the database connection variable
  global $conn;

  // Save the register information
  $sql = "INSERT INTO `attraction` (
        `attraction_chinese_name`,
        `attraction_english_name`,
        `description`,
        `district`,
        `chinese_address`,
        `english_address`,
        `phone_number`,
        `website`,
        `email`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `latitude`,
        `longitude`,
        `create_datetime`,
        `status`
        ) VALUES (
        '{$_POST['chi-name']}',
        '{$_POST['eng-name']}',
        '',
        '{$_POST['district']}',
        '{$_POST['chi-address']}',
        '{$_POST['eng-address']}',
        '{$_POST['phoneNumber']}',
        '{$_POST['website']}',
        '{$_POST['email']}',
        '00:00 - 00:00',
        '00:00 - 00:00',
        '00:00 - 00:00',
        '0',
        '0',
        NOW(),
        0
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the attraction id
    $attractionID = $conn->insert_id;

    // Save the attraction type to database
    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `attraction_type` (
                `attraction_id`,
                `type_id`) VALUES (
                    '$attractionID',
                    '$type');";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the equipment to database
    if (isset($_POST['equipment'])) {
      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `attraction_equipment` (
                  `attraction_id`,
                  `equipment_id`) VALUES (
                      '$attractionID',
                      '$equipment');";
        if (!mysqli_query($conn, $sql)) {
          // Response fail json
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id' => $attractionID
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function adminUpdateAttractionInfo($id)
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "UPDATE `attraction` SET
          `attraction_chinese_name` = '{$_POST['chi-name']}',
          `attraction_english_name` = '{$_POST['eng-name']}',
          `district`                = '{$_POST['district']}',
          `chinese_address`         = '{$_POST['chi-address']}',
          `english_address`         = '{$_POST['eng-address']}',
          `phone_number`            = '{$_POST['phoneNumber']}',
          `website`                 = '{$_POST['website']}',
          `email`                   = '{$_POST['email']}',
          `weekday_business_hours`  = '$weekday',
          `weekend_business_hours`  = '$weekend',
          `holiday_business_hours`  = '$holiday',
          `latitude`                = '{$_POST['latitude']}',
          `longitude`               = '{$_POST['longitude']}'
          WHERE `attraction_id`     = '$id';";
  if (mysqli_query($conn, $sql)) {
    // Handle the attraction type information
    // Delete all old data -> Insert all form data

    // Attraction type
    $sql = "DELETE FROM `attraction_type`
              WHERE `attraction_id` = '$id';";
    mysqli_query($conn, $sql);

    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `attraction_type` (
                `attraction_id`,
                `type_id`
                ) VALUES (
                  '$id',
                  '$type'
                );";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Equipment
    if (isset($_POST['equipment'])) {
      $sql = "DELETE FROM `attraction_equipment`
                WHERE `attraction_id` = '$id';";
      mysqli_query($conn, $sql);

      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `attraction_equipment` (
                `attraction_id`,
                `equipment_id`
                ) VALUES (
                  '$id',
                  '$equipment'
                );";
        if (!mysqli_query($conn, $sql)) {
          // Response fail json
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      }
    } else {
      $sql = "DELETE FROM `attraction_equipment`
                WHERE `attraction_id` = '$id';";
      mysqli_query($conn, $sql);
    }

    // Success
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

function adminUpdateAttractionStatus($id)
{
  // Get the database connection variable
  global $conn;

  switch ($_POST['status']) {
    case "Hidden":
      $status = 0;
      $newStatus = "隱藏";
      break;
    case "Public":
      $status = 1;
      $newStatus = "公開";
      break;
  }
  $sql = "UPDATE `attraction`
            SET `status` = '$status'
            WHERE `attraction_id` = '$id';";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true,
      'newStatus' => $newStatus
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

// Insert the new restaurant record
function adminCreateRestaurant()
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if dayoff
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  //Save the restaurant information
  $sql = "INSERT INTO `restaurant` (
        `restaurant_chinese_name`,
        `restaurant_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_seats`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$_POST['chi-name']}',                 -- `Restaurant_Chinese_Name`
        '{$_POST['eng-name']}',                 -- `Restaurant_English_Name`
        '{$_POST['district']}',                 -- `District`
        '{$_POST['chi-address']}',              -- `Chinese_Address`
        '{$_POST['eng-address']}',              -- `English_Address`
        '{$_POST['latitude']}',                 -- `Latitude`
        '{$_POST['longitude']}',                -- `Longitude`
        '{$_POST['phoneNumber']}',              -- `phone_number`
        '{$_POST['email']}',                    -- `email`
        '{$_POST['seats']}',                    -- `Number_of_Seats`
        '$weekday',                             -- `Weekday_Business_Hours`
        '$weekend',                             -- `Weekend_Business_Hours`
        '$holiday',                             -- `Holiday_Business_Hours`
        NOW(),                                  -- `Submit_DateTime`
        '0',                                    -- `Status`
        '1'                                     -- `Partner_ID`
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the restaurant id
    $restaurantID = $conn->insert_id;

    // Save the cuisine to database
    $cuisines = $_POST['cuisine'];
    foreach ($cuisines as $cuisine) {
      $sql = "INSERT INTO `restaurant_cuisine` (
                `restaurant_id`,
                `cuisine_id`) VALUES (
                    '$restaurantID',
                    '$cuisine');";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the type to database
    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `restaurant_type` (
                `restaurant_id`,
                `type_id`) VALUES (
                    '$restaurantID',
                    '$type');";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the payment methods to database
    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `restaurant_payment_method` (
                `restaurant_id`,
                `method_id`) VALUES (
                    '$restaurantID',
                    '$method');";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the equipments to database
    if (isset($_POST['equipment'])) {
      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `restaurant_equipment` (
                    `restaurant_id`,
                    `equipment_id`) VALUES (
                        '$restaurantID',
                        '$equipment');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id' => $restaurantID
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function adminUpdateRestaurantInfo($id)
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "UPDATE `restaurant` SET
          `restaurant_chinese_name`     = '{$_POST['chi-name']}',
          `restaurant_english_name`     = '{$_POST['eng-name']}',
          `district`                    = '{$_POST['district']}',
          `chinese_address`             = '{$_POST['chi-address']}',
          `english_address`             = '{$_POST['eng-address']}',
          `latitude`                    = '{$_POST['latitude']}',
          `longitude`                   = '{$_POST['longitude']}',
          `phone_number`                = '{$_POST['phoneNumber']}',
          `email`                       = '{$_POST['email']}',
          `number_of_seats`             = '{$_POST['seats']}',
          `weekday_business_hours`      = '$weekday',
          `weekend_business_hours`      = '$weekend',
          `holiday_business_hours`      = '$holiday'
          WHERE `restaurant_id`         = '$id';";
  if (mysqli_query($conn, $sql)) {
    // Handle the restaurant cuisine information
    // Delete all old data -> Insert all form data

    // Cuisine
    $sql = "DELETE FROM `restaurant_cuisine`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $cuisines = $_POST['cuisine'];
    foreach ($cuisines as $cuisine) {
      $sql = "INSERT INTO `restaurant_cuisine` (
                `restaurant_id`,
                `cuisine_id`
                ) VALUES (
                  '$id',
                  '$cuisine'
                );";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Type
    $sql = "DELETE FROM `restaurant_type`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `restaurant_type` (
                `restaurant_id`,
                `type_id`
                ) VALUES (
                  '$id',
                  '$type'
                );";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Payment Method
    $sql = "DELETE FROM `restaurant_payment_method`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `restaurant_payment_method` (
                `restaurant_id`,
                `method_id`
                ) VALUES (
                  '$id',
                  '$method'
                );";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Equipment
    if (isset($_POST['equipment'])) {
      $sql = "DELETE FROM `restaurant_equipment`
                WHERE `restaurant_id` = '$id';";
      mysqli_query($conn, $sql);

      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `restaurant_equipment` (
                `restaurant_id`,
                `equipment_id`
                ) VALUES (
                  '$id',
                  '$equipment'
                );";
        if (!mysqli_query($conn, $sql)) {
          // Response fail json
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      }
    } else {
      $sql = "DELETE FROM `restaurant_equipment`
                WHERE `restaurant_id` = '$id';";
      mysqli_query($conn, $sql);
    }

    // Success
    echo json_encode(array(
      'success' => true
    ));
  } else {
    // Fail
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

function adminUpdateRestaurantStatus($id)
{
  // Get the database connection variable
  global $conn;

  switch ($_POST['status']) {
    case "Hidden":
      $status = 0;
      $newStatus = "隱藏";
      break;
    case "Open":
      $status = 1;
      $newStatus = "營業中";
      break;
    case "Closed":
      $status = 2;
      $newStatus = "已結業";
      break;
  }
  $sql = "UPDATE `restaurant`
            SET `status` = '$status'
            WHERE `restaurant_id` = '$id';";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true,
      'newStatus' => $newStatus
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

function adminUpdateRestaurantStorefront($id)
{
  // Get the database connection variable
  global $conn;

  // Upload image only if no errors
  if (empty($error)) {
    // Save the storefront image
    $target_dir = "data/site/restaurant/$id/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('storefront.jpg');
    move_uploaded_file($_FILES["storefront"]["tmp_name"], $target_file);

    echo json_encode(array(
      'success' => true
    ));
  }
}

function adminUpdateRestaurantBanner($id)
{
  // Upload image only if no errors
  if (empty($error)) {
    // Save the banner image
    $target_dir = "data/site/restaurant/$id/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('banner.jpg');
    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file);

    echo json_encode(array(
      'success' => true
    ));
  }
}

// Admin guesthouse management
function adminCreateGuesthouse()
{
  // Get the database connection variable
  global $conn;

  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  //Save the guesthouse information
  $sql = "INSERT INTO `guesthouse` (
        `guesthouse_chinese_name`,
        `guesthouse_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_rooms`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$_POST['chi-name']}',
        '{$_POST['eng-name']}',
        '{$_POST['district']}',
        '{$_POST['chi-address']}',
        '{$_POST['eng-address']}',
        0,
        0,
        '{$_POST['phoneNumber']}',
        '{$_POST['email']}',
        '{$_POST['rooms']}',
        '$weekday',
        '$weekend',
        '$holiday',
        NOW(),
        0,
        null
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the guesthouse id
    $guesthouseId = $conn->insert_id;

    // Save the payments to database
    if (isset($_POST['payment'])) {
      $payments = $_POST['payment'];
      foreach ($payments as $payment) {
        $sql = "INSERT INTO `guesthouse_payment_method` (
                    `guesthouse_id`,
                    `method_id`) VALUES (
                        '$guesthouseId',
                        '$payment');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Save the equipments to database
    if (isset($_POST['equipment'])) {
      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `guesthouse_equipment` (
                    `guesthouse_id`,
                    `equipment_id`) VALUES (
                        '$guesthouseId',
                        '$equipment');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id' => $guesthouseId
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function adminUpdateGuesthouseInfo($id)
{
  // Get the database connection variable
  global $conn;

  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "UPDATE `guesthouse` SET
          `guesthouse_chinese_name`     = '{$_POST['chi-name']}',
          `guesthouse_english_name`     = '{$_POST['eng-name']}',
          `district`                    = '{$_POST['district']}',
          `chinese_address`             = '{$_POST['chi-address']}',
          `english_address`             = '{$_POST['eng-address']}',
          `latitude`                    = '{$_POST['latitude']}',
          `longitude`                   = '{$_POST['longitude']}',
          `phone_number`                = '{$_POST['phoneNumber']}',
          `email`                       = '{$_POST['email']}',
          `number_of_rooms`             = '{$_POST['rooms']}',
          `weekday_business_hours`      = '$weekday',
          `weekend_business_hours`      = '$weekend',
          `holiday_business_hours`      = '$holiday'
          WHERE `guesthouse_id`         = '$id';";
  if (mysqli_query($conn, $sql)) {
    // Delete all old data -> Insert all form data

    // Payment Method
    $sql = "DELETE FROM `guesthouse_payment_method`
              WHERE `guesthouse_id` = '$id';";
    mysqli_query($conn, $sql);

    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `guesthouse_payment_method` (
                `guesthouse_id`,
                `method_id`
                ) VALUES (
                  '$id',
                  '$method'
                );";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Equipment
    if (isset($_POST['equipment'])) {
      $sql = "DELETE FROM `guesthouse_equipment`
                WHERE `guesthouse_id` = '$id';";
      mysqli_query($conn, $sql);

      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `guesthouse_equipment` (
                `guesthouse_id`,
                `equipment_id`
                ) VALUES (
                  '$id',
                  '$equipment'
                );";
        if (!mysqli_query($conn, $sql)) {
          // Response fail json
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      }
    } else {
      $sql = "DELETE FROM `guesthouse_equipment`
                WHERE `guesthouse_id` = '$id';";
      mysqli_query($conn, $sql);
    }

    // Success
    echo json_encode(array(
      'success' => true
    ));
  } else {
    // Fail
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

function adminUpdateGuesthouseStatus($id)
{
  // Get the database connection variable
  global $conn;

  switch ($_POST['status']) {
    case "Hidden":
      $status = 0;
      $newStatus = "隱藏";
      break;
    case "Open":
      $status = 1;
      $newStatus = "營業中";
      break;
    case "Closed":
      $status = 2;
      $newStatus = "已結業";
      break;
  }
  $sql = "UPDATE `guesthouse`
            SET `status` = '$status'
            WHERE `guesthouse_id` = '$id';";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true,
      'newStatus' => $newStatus
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }

  // Close the database
  mysqli_close($conn);
}

function adminUpdateGuesthouseStorefront($id)
{
  // Upload image only if no errors
  if (empty($error)) {
    // Save the storefront image
    $target_dir = "data/site/guesthouse/$id/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('storefront.jpg');
    move_uploaded_file($_FILES["storefront"]["tmp_name"], $target_file);

    echo json_encode(array(
      'success' => true
    ));
  }
}

function adminUpdateGuesthouseBanner($id)
{
  // Upload image only if no errors
  if (empty($error)) {
    // Save the banner image
    $target_dir = "data/site/guesthouse/$id/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('banner.jpg');
    move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file);

    echo json_encode(array(
      'success' => true
    ));
  }
}

// Update the collab request status
function adminCollabRequestControl($id, $type, $action)
{
  // Get the database connection variable
  global $conn;

  if ($type == "restaurant") {
    // Restaurant Partner Request
    $sql = "SELECT *
              FROM `restaurant_partner_request`
              WHERE `request_id` = '$id';";
    $rs = mysqli_query($conn, $sql);
    $rc = mysqli_fetch_assoc($rs);

    if ($action == "accept") {
      // Accept the request
      $sql = "UPDATE `restaurant_partner_request`
                SET `status` = 3
                WHERE `request_id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['contact_email']);

          //Content
          $mail->isHTML(true);                            // Set email format to HTML
          $mail->Subject = '你的餐廳合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>通過</b></p>
          <p>請到以下網址進行您的「餐廳管理員」帳戶註冊:</p>
          <p>http://127.0.0.1/zh-hk/collaboration/collab_restaurant_register.php?id=' . $id;
          $mail->AltBody = '審核結果: 通過 -- 請到以下網址進行您的餐廳管理員帳戶註冊: http://127.0.0.1/zh-hk/collaboration/collab_restaurant_register.php?id=' . $id;
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'message' => '申請已接受！'
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } else if ($action == "reject") {
      // Reject the request
      $sql = "UPDATE `restaurant_partner_request`
                SET `status` = 5
                WHERE `request_id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['contact_email']);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = '你的餐廳合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>拒絕</b></p>
          <p>如有需要請與我們的客戶服務員聯絡</p>';
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'message' => '申請已拒絕！'
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));

        // Close the database
        mysqli_close($conn);
      }
    }
  } else if ($type == "guesthouse") {
    // Guesthouse Partner Request
    $sql = "SELECT *
              FROM `guesthouse_partner_request`
              WHERE `request_id` = '$id';";
    $rs = mysqli_query($conn, $sql);
    $rc = mysqli_fetch_assoc($rs);

    if ($action == "accept") {
      // Accept the request
      $sql = "UPDATE `guesthouse_partner_request`
                SET `status` = 3
                WHERE `request_id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['contact_email']);

          //Content
          $mail->isHTML(true);                            // Set email format to HTML
          $mail->Subject = '你的民宿合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>通過</b></p>
          <p>請到以下網址進行您的「民宿管理員」帳戶註冊:</p>
          <p>http://127.0.0.1/zh-hk/collaboration/collab_guesthouse_register.php?id=' . $id;
          $mail->AltBody = '審核結果: 通過 -- 請到以下網址進行您的民宿管理員帳戶註冊: http://127.0.0.1/zh-hk/collaboration/collab_guesthouse_register.php?id=' . $id;
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'message' => '申請已接受！'
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } else if ($action == "reject") {
      // Reject the request
      $sql = "UPDATE `guesthouse_partner_request`
                SET `status` = 5
                WHERE `request_id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['contact_email']);

          //Content
          $mail->isHTML(true);               //Set email format to HTML
          $mail->Subject = '你的民宿合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>拒絕</b></p>
          <p>如有需要請與我們的客戶服務員聯絡</p>';
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'message' => '申請已拒絕！'
        ));
      }
    }
  } else {
    echo json_encode(array(
      'success' => 'false',
      'reason'  => 'Error: Unknown request type.'
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function adminWorkerApplicationControl($id, $type, $action)
{
  // Get the database connection variable
  global $conn;

  if ($type == "driver") {
    // Get the application information
    $sql = "SELECT *
              FROM `driver_application`
              WHERE `id` = '$id';";
    $rs = mysqli_query($conn, $sql);
    $rc = mysqli_fetch_assoc($rs);

    // Restaurant Partner Request
    if ($action == "accept") {
      // Accept the request
      $sql = "UPDATE `driver_application`
                SET `status` = 3
                WHERE `id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['email']);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = '你的餐廳合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>通過</b></p>
          <p>請到以下網址進行您的「司機」帳戶註冊:</p>
          <p>http://127.0.0.1/zh-hk/application/driver/register.php?id=' . $id;
          $mail->AltBody = '審核結果: 通過 -- 請到以下網址進行您的「司機」帳戶註冊: http://127.0.0.1/travelhk.com/collab_restaurant_register.php?id=' . $id;
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'mail_log' => $mail_log
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } else if ($action == "reject") {
      // Reject the request
      $sql = "UPDATE `driver_application`
                SET `status` = 5
                WHERE `request_id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['email']);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = '你的餐廳合作夥伴申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>拒絕</b></p>
          <p>如有需要請與我們的客戶服務員聯絡</p>';
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array('success' => true));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));

        // Close the database
        mysqli_close($conn);
      }
    }
  } else if ($type == "tourist_guide") {
    // Get the application information
    $sql = "SELECT *
              FROM `tourist_guide_application`
              WHERE `id` = '$id';";
    $rs = mysqli_query($conn, $sql);
    $rc = mysqli_fetch_assoc($rs);

    if ($action == "accept") {
      // Accept the request
      $sql = "UPDATE `tourist_guide_application`
                SET `status` = 3
                WHERE `id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['email']);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = '你的導遊工作申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>通過</b></p>
          <p>請到以下網址進行您的「導遊」帳戶註冊:</p>
          <p>http://127.0.0.1/zh-hk/application/tourist_guide/register.php?id=' . $id;
          $mail->AltBody = '審核結果: 通過 -- 請到以下網址進行您的「導遊」帳戶註冊: http://127.0.0.1/zh-hk/application/tourist_guide/register.php?id=' . $id;

          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'mail_log' => $mail_log
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } else if ($action == "reject") {
      // Reject the request
      $sql = "UPDATE `tourist_guide_application`
                SET `status` = 5
                WHERE `id` = '$id';";

      // Save to database
      if (mysqli_query($conn, $sql)) {
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
          $mail->addAddress($rc['email']);

          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = '你的導遊工作申請審核已完成!';
          $mail->Body    = '
          <p>審核結果: <b>拒絕</b></p>
          <p>如有需要請與我們的客戶服務員聯絡</p>';
          // Finally send email
          $mail->Send();
          $mail_log = 'Message has been sent';
        } catch (Exception $e) {
          $mail_log = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } finally {
          // Closing smtp connection
          $mail->smtpClose();
        }

        // Response success json
        echo json_encode(array('success' => true));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));

        // Close the database
        mysqli_close($conn);
      }
    }
  } else {
    echo json_encode(array(
      'success' => 'false',
      'reason'  => 'Error: Unknown application type.'
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function adminConfirmAttractionDiscovery($id, $action)
{
  global $conn;

  if ($action == 'accept') {
    // Change the status to Approved
    $sql = "UPDATE `attraction_discover`
              SET `status` = 2
              WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      // Get the form details
      $sql = "SELECT * FROM `attraction_discover`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $details = mysqli_fetch_assoc($rs);

      // Get the attraction type
      $sql = "SELECT * FROM `attraction_discover_type`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $types = mysqli_fetch_assoc($rs);

      // Get the attraction payment method
      $sql = "SELECT * FROM `attraction_discover_payment_method`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $methods = mysqli_fetch_assoc($rs);

      // Add new attraction
      $sql = "INSERT INTO `attraction` (
        `attraction_chinese_name`,
        `attraction_english_name`,
        `description`,
        `district`,
        `chinese_address`,
        `english_address`,
        `phone_number`,
        `email`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `latitude`,
        `longitude`,
        `create_datetime`,
        `status`
        ) VALUES (
        '{$details['attraction_chinese_name']}',
        '{$details['attraction_english_name']}',
        '',
        '{$details['district']}',
        '{$details['chinese_address']}',
        '{$details['english_address']}',
        '{$details['phone_number']}',
        '{$details['email']}',
        '{$details['weekday_business_hours']}',
        '{$details['weekend_business_hours']}',
        '{$details['holiday_business_hours']}',
        '0',
        '0',
        NOW(),
        0
        );";
      if (mysqli_query($conn, $sql)) {
        // Get the attraction id
        $attractionID = $conn->insert_id;

        // Add attraction type
        foreach ($types as $type) {
          $sql = "INSERT INTO `attraction_type` (
                    `attraction_id`,
                    `type_id`) VALUES (
                        '$attractionID',
                        '$type');";
          if (!mysqli_query($conn, $sql)) {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'title' => 'Error!',
              'html' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Add attraction payment method
        if (count($methods) > 0) {
          foreach ($methods as $method) {
            $sql = "INSERT INTO `attraction_payment_method` (
                      `attraction_id`,
                      `method_id`) VALUES (
                          '$attractionID',
                          '$method');";
            if (!mysqli_query($conn, $sql)) {
              // Response fail json
              echo json_encode(array(
                'success' => false,
                'title' => 'Error!',
                'html' => mysqli_error($conn)
              ));
            }
          } // End foreach()
        }
        echo json_encode(array(
          'success' => true,
          'title' => '完成',
          'html' => '已新增景點，請前往景點編輯器完成餘下的資料。',
          'btn' => '前往編輯',
          'id' => $attractionID
        ));
      } else {
        echo json_encode(array(
          'success' => false,
          'title' => 'Error!',
          'html' => mysqli_error($conn)
        ));
      }
    }
  } else if ($action == 'reject') {
    // Change the status to Rejected
    $sql = "UPDATE `attraction_discover`
    SET `status` = 3
    WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      echo json_encode(array(
        'success' => true,
        'title' => '完成',
        'html' => '已拒絕這景點申請。',
        'btn' => '完成'
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'title' => 'Error!',
      'html' => 'Unknown action.'
    ));
  }
  // Close the database connection
  mysqli_close($conn);
}

function adminConfirmRestaurantDiscovery($id, $action)
{
  global $conn;

  if ($action == 'accept') {
    // Change the status to Approved
    $sql = "UPDATE `restaurant_discover`
              SET `status` = 2
              WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      // Get the form details
      $sql = "SELECT * FROM `restaurant_discover`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $details = mysqli_fetch_assoc($rs);

      // Get the restaurant cuisine
      $sql = "SELECT * FROM `restaurant_discover_cuisine`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $cuisines = mysqli_fetch_assoc($rs);

      // Get the restaurant type
      $sql = "SELECT * FROM `restaurant_discover_type`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $types = mysqli_fetch_assoc($rs);

      // Get the restaurant payment method
      $sql = "SELECT * FROM `restaurant_discover_payment_method`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $methods = mysqli_fetch_assoc($rs);

      // Add new restaurant
      $sql = "INSERT INTO `restaurant` (
        `restaurant_chinese_name`,
        `restaurant_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$details['restaurant_chinese_name']}',
        '{$details['restaurant_english_name']}',
        '{$details['district']}',
        '{$details['chinese_address']}',
        '{$details['english_address']}',
        '0',
        '0',
        '{$details['phone_number']}',
        '{$details['email']}',
        '{$details['weekday_business_hours']}',
        '{$details['weekend_business_hours']}',
        '{$details['holiday_business_hours']}',
        NOW(),
        0,
        null
        );";
      if (mysqli_query($conn, $sql)) {
        // Get the restaurant id
        $restaurantID = $conn->insert_id;

        // Add restaurant cuisine
        foreach ($cuisines as $cuisine) {
          $sql = "INSERT INTO `restaurant_cuisine` (
                    `restaurant_id`,
                    `cuisine_id`) VALUES (
                      '$restaurantID',
                      '$cuisine');";
          if (!mysqli_query($conn, $sql)) {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'title' => 'Error!',
              'html' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Add restaurant type
        foreach ($types as $type) {
          $sql = "INSERT INTO `restaurant_type` (
                    `restaurant_id`,
                    `type_id`) VALUES (
                        '$restaurantID',
                        '$type');";
          if (!mysqli_query($conn, $sql)) {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'title' => 'Error!',
              'html' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Add restaurant payment method
        if (count($methods) > 0) {
          foreach ($methods as $method) {
            $sql = "INSERT INTO `restaurant_payment_method` (
                      `restaurant_id`,
                      `method_id`) VALUES (
                          '$restaurantID',
                          '$method');";
            if (!mysqli_query($conn, $sql)) {
              // Response fail json
              echo json_encode(array(
                'success' => false,
                'title' => 'Error!',
                'html' => mysqli_error($conn)
              ));
            }
          } // End foreach()
        }
        echo json_encode(array(
          'success' => true,
          'title' => '完成',
          'html' => '已新增景點，請前往景點編輯器完成餘下的資料。',
          'btn' => '前往編輯',
          'id' => $restaurantID
        ));
      } else {
        echo json_encode(array(
          'success' => false,
          'title' => 'Error!',
          'html' => mysqli_error($conn)
        ));
      }
    }
  } else if ($action == 'reject') {
    // Change the status to Rejected
    $sql = "UPDATE `restaurant_discover`
    SET `status` = 3
    WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      echo json_encode(array(
        'success' => true,
        'title' => '完成',
        'html' => '已拒絕這餐廳申請。',
        'btn' => '完成'
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'title' => 'Error!',
      'html' => 'Unknown action.'
    ));
  }
  // Close the database connection
  mysqli_close($conn);
}

function adminConfirmGuesthouseDiscovery($id, $action)
{
  global $conn;

  if ($action == 'accept') {
    // Change the status to Approved
    $sql = "UPDATE `guesthouse_discover`
              SET `status` = 2
              WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      // Get the form details
      $sql = "SELECT * FROM `guesthouse_discover`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $details = mysqli_fetch_assoc($rs);

      // Get the guesthouse payment method
      $sql = "SELECT * FROM `guesthouse_discover_payment_method`
                WHERE `id` = $id";
      $rs = mysqli_query($conn, $sql);
      $methods = mysqli_fetch_assoc($rs);

      // Add new guesthouse
      $sql = "INSERT INTO `guesthouse` (
        `guesthouse_chinese_name`,
        `guesthouse_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_rooms`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$details['guesthouse_chinese_name']}',
        '{$details['guesthouse_english_name']}',
        '{$details['district']}',
        '{$details['chinese_address']}',
        '{$details['english_address']}',
        0,
        0,
        '{$details['phone_number']}',
        '{$details['email']}',
        '{$details['number_of_rooms']}',
        '{$details['weekday_business_hours']}',
        '{$details['weekend_business_hours']}',
        '{$details['holiday_business_hours']}',
        NOW(),
        0,
        null
        );";
      if (mysqli_query($conn, $sql)) {
        // Get the restaurant id
        $guesthouseID = $conn->insert_id;

        // Add restaurant payment method
        if (count($methods) > 0) {
          foreach ($methods as $method) {
            $sql = "INSERT INTO `guesthouse_payment_method` (
                      `guesthouse_id`,
                      `method_id`) VALUES (
                          '$guesthouseID',
                          '$method');";
            if (!mysqli_query($conn, $sql)) {
              // Response fail json
              echo json_encode(array(
                'success' => false,
                'title' => 'Error!',
                'html' => mysqli_error($conn)
              ));
            }
          } // End foreach()
        }
        echo json_encode(array(
          'success' => true,
          'title' => '完成',
          'html' => '已新增民宿，請前往民宿編輯器完成餘下的資料。',
          'btn' => '前往編輯',
          'id' => $guesthouseID
        ));
      } else {
        echo json_encode(array(
          'success' => false,
          'title' => 'Error!',
          'html' => mysqli_error($conn)
        ));
      }
    }
  } else if ($action == 'reject') {
    // Change the status to Rejected
    $sql = "UPDATE `restaurant_discover`
    SET `status` = 3
    WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
      echo json_encode(array(
        'success' => true,
        'title' => '完成',
        'html' => '已拒絕這餐廳申請。',
        'btn' => '完成'
      ));
    }
  } else {
    echo json_encode(array(
      'success' => false,
      'title' => 'Error!',
      'html' => 'Unknown action.'
    ));
  }
  // Close the database connection
  mysqli_close($conn);
}

// Logout the account (Clear $SESSION)
function logout()
{
  session_destroy();

  // Redirect to homepage
  header('Location: index.php');
}

// Update the user information
function updateUserInfo($email)
{
  // Get the database connection variable
  global $conn;

  $sql = "UPDATE account
            SET `firstname`      = '$_POST[_firstname]',
                `lastname`       = '$_POST[_lastname]',
                `nickname`        = '$_POST[_nickname]',
                `gender`          = '$_POST[_gender]',
                `phone_number`    = '$_POST[_phoneNumber]',
                `birth_year`      = '$_POST[_birthYear]',
                `birth_month`     = '$_POST[_birthMonth]'
            WHERE `email` = '$email';";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

// Update the user Password
function updatePassword($email)
{
  // Get the database connection variable
  global $conn;

  $sql = "UPDATE account
                SET `password` = '$_POST[_newPassword]'
                WHERE `email` = '$email';
            ";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

// Add a new restaurant collab request
function submit_restaurant_request()
{
  // Get the database connection variable
  global $conn;

  // Upload image only if no errors
  if (empty($error)) {
    // Handle the business hours if closed
    $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
    if ($weekday == "23:59 - 23:59") {
      $weekday = "closed";
    } else if ($weekday == "00:00 - 00:00") {
      $weekday = "24 Hours";
    }
    $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
    if ($weekend == "23:59 - 23:59") {
      $weekend = "closed";
    } else if ($weekend == "00:00 - 00:00") {
      $weekend = "24 Hours";
    }
    $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
    if ($holiday == "23:59 - 23:59") {
      $holiday = "closed";
    } else if ($holiday == "00:00 - 00:00") {
      $holiday = "24 Hours";
    }


    //Save the register information
    $sql = "INSERT INTO `restaurant_partner_request` (
            `restaurant_chinese_name`,
            `restaurant_english_name`,
            `district`,
            `chinese_address`,
            `english_address`,
            `restaurant_phone_number`,
            `number_of_seats`,
            `weekday_business_hours`,
            `weekend_business_hours`,
            `holiday_business_hours`,
            `contact_email`,
            `contact_name`,
            `submit_datetime`,
            `response_datetime`,
            `status`,
            `responder_staff_id`,
            `partner_id`
            ) VALUES (
                '{$_POST['chi-restaurant-name']}',      -- `Restaurant_Chinese_Name`
                '{$_POST['eng-restaurant-name']}',      -- `Restaurant_English_Name`
                '{$_POST['district']}',                 -- `District`
                '{$_POST['chi-address']}',              -- `Chinese_Address`
                '{$_POST['eng-address']}',              -- `English_Address`
                '{$_POST['restaurant-phone-number']}',  -- `Restaurant_Phone_Number`
                '{$_POST['seats']}',                    -- `Number_of_Seats`
                '$weekday',                             -- `Weekday_Business_Hours`
                '$weekend',                             -- `Weekend_Business_Hours`
                '$holiday',                             -- `Holiday_Business_Hours`
                '{$_POST['contact-email']}',            -- `Contact_Email`
                '{$_POST['contact-name']}',             -- `Contact_Name`
                NOW(),                                  -- `Submit_DateTime`
                null,                                   -- `Response_DateTime`
                '1',                                    -- `Status`
                null,                                   -- `Responder_Staff_ID`
                '1'                                     -- `Partner_ID`
            );";

    // Save to database
    if (mysqli_query($conn, $sql)) {
      // Get the request id
      $requestID = $conn->insert_id;

      // Save the storefront image
      $target_dir = "data/collab_request/restaurant/$requestID/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename('storefront.jpg');
      move_uploaded_file($_FILES["storefront"]["tmp_name"], $target_file);

      // Save the cuisine to database
      $cuisines = $_POST['cuisine'];
      foreach ($cuisines as $cuisine) {
        $sql = "INSERT INTO `restaurant_partner_request_cuisine` (
                    `request_id`,
                    `cuisine_id`) VALUES (
                        '$requestID',
                        '$cuisine');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()

      // Save the type to database
      $types = $_POST['type'];
      foreach ($types as $type) {
        $sql = "INSERT INTO `restaurant_partner_request_type` (
                    `request_id`,
                    `type_id`) VALUES (
                        '$requestID',
                        '$type');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()

      // Save the payment methods to database
      $methods = $_POST['payment'];
      foreach ($methods as $method) {
        $sql = "INSERT INTO `restaurant_partner_request_payment_method` (
                    `request_id`,
                    `method_id`) VALUES (
                        '$requestID',
                        '$method');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()

      // Save the equipments to database
      if (isset($_POST['equipment'])) {
        $equipments = $_POST['equipment'];
        foreach ($equipments as $equipment) {
          $sql = "INSERT INTO `restaurant_partner_request_equipment` (
                      `request_id`,
                      `equipment_id`) VALUES (
                          '$requestID',
                          '$equipment');";
          if (!mysqli_query($conn, $sql)) {
            echo json_encode(array(
              'success' => false,
              'reason' => mysqli_error($conn)
            ));
          }
        } // End foreach()
      }

      // Response success json
      echo json_encode(array(
        'success' => true
      ));
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason' => mysqli_error($conn)
      ));
    }
  }
  // Close the database
  mysqli_close($conn);
}

// Add a new guest house collab request
function submit_guesthouse_request()
{
  // Get the database connection variable
  global $conn;

  // Upload image only if no errors
  if (empty($error)) {
    // Handle the business hours if closed
    $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
    if ($weekday == "23:59 - 23:59") {
      $weekday = "closed";
    } else if ($weekday == "00:00 - 00:00") {
      $weekday = "24 Hours";
    }
    $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
    if ($weekend == "23:59 - 23:59") {
      $weekend = "closed";
    } else if ($weekend == "00:00 - 00:00") {
      $weekend = "24 Hours";
    }
    $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
    if ($holiday == "23:59 - 23:59") {
      $holiday = "closed";
    } else if ($holiday == "00:00 - 00:00") {
      $holiday = "24 Hours";
    }

    //Save the register information
    $sql = "INSERT INTO `guesthouse_partner_request` (
            `guesthouse_chinese_name`,
            `guesthouse_english_name`,
            `district`,
            `chinese_address`,
            `english_address`,
            `guesthouse_phone_number`,
            `guesthouse_email`,
            `number_of_rooms`,
            `weekday_business_hours`,
            `weekend_business_hours`,
            `holiday_business_hours`,
            `contact_email`,
            `contact_name`,
            `submit_datetime`,
            `response_datetime`,
            `status`,
            `responder_staff_id`,
            `partner_id`
            ) VALUES (
                '{$_POST['chi-guesthouse-name']}',
                '{$_POST['eng-guesthouse-name']}',
                '{$_POST['district']}',
                '{$_POST['chi-address']}',
                '{$_POST['eng-address']}',
                '{$_POST['guesthouse-phone-number']}',
                '{$_POST['guesthouse-email']}',
                '{$_POST['rooms']}',
                '$weekday',
                '$weekend',
                '$holiday',
                '{$_POST['contact-email']}',
                '{$_POST['contact-name']}',
                NOW(),
                null,
                '1',
                null,
                null
            );";

    // Save to database
    if (mysqli_query($conn, $sql)) {
      // Get the request id
      $requestID = $conn->insert_id;

      // Save the storefront image
      $target_dir = "data/collab_request/guesthouse/$requestID/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename('storefront.jpg');
      move_uploaded_file($_FILES["storefront"]["tmp_name"], $target_file);

      // Save the room image
      $target_dir = "data/collab_request/guesthouse/$requestID/";
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename('room.jpg');
      move_uploaded_file($_FILES["room"]["tmp_name"], $target_file);

      // Save the payment methods to database
      $methods = $_POST['payment'];
      foreach ($methods as $method) {
        $sql = "INSERT INTO `guesthouse_partner_request_payment_method` (
                    `request_id`,
                    `method_id`) VALUES (
                        '$requestID',
                        '$method');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()

      // Save the equipments to database
      if (isset($_POST['equipment'])) {
        $equipments = $_POST['equipment'];
        foreach ($equipments as $equipment) {
          $sql = "INSERT INTO `guesthouse_partner_request_equipment` (
                      `request_id`,
                      `equipment_id`) VALUES (
                          '$requestID',
                          '$equipment');";
          if (!mysqli_query($conn, $sql)) {
            echo json_encode(array(
              'success' => false,
              'reason' => mysqli_error($conn)
            ));
          }
        } // End foreach()
      }

      // Response success json
      echo json_encode(array(
        'success' => true
      ));
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason' => mysqli_error($conn)
      ));
    }
  }
  // Close the database
  mysqli_close($conn);
}

// Partner account register
function collabUserRegister()
{
  // Get the database connection variable
  global $conn;

  // Check if the email address is repeated in database
  $query = "SELECT * FROM account WHERE `email` = '{$_POST['collab-email']}';";
  $rs = mysqli_query($conn, $query);
  if (mysqli_num_rows($rs) > 0) {
    // Response fail and reason json
    echo json_encode(array(
      'success' => 'false',
      'reason'  => '重複的電郵地址，請重新輸入。'
    ));

    // Close the database
    mysqli_close($conn);

    // Leave the function
    exit();
  }

  // Save the register information
  $sql = "INSERT INTO account (
        `email`,
        `password`,
        `firstname`,
        `lastname`,
        `nickname`,
        `gender`,
        `phone_number`,
        `birth_year`,
        `birth_month`,
        `icon_path`,
        `type_id`,
        `status`,
        `registration_time`
        ) VALUES (
            '{$_POST['collab-email']}',
            '{$_POST['collab-psw']}',
            '{$_POST['collab-firstname']}',
            '{$_POST['collab-lastname']}',
            '',
            '{$_POST['collab-gender']}',
            '{$_POST['collab-phoneNo']}',
            '',
            '',
            '',
            '{$_GET['type']}',
            '1',
            NOW()
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    $sql = "SELECT `account_id` FROM `account` WHERE `email` = '{$_POST['collab-email']}';";
    $rs = mysqli_query($conn, $query);
    $rc = mysqli_fetch_assoc($rs);

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id'      => $rc['account_id']
    ));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

function siteGenerator($type, $id)
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  switch ($type) {
    case 'restaurant':
      $sql = "INSERT INTO `restaurant` (
        `restaurant_chinese_name`,
        `restaurant_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_seats`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
            '{$_POST['chi-name']}',                 -- `restaurant_chinese_name`
            '{$_POST['eng-name']}',                 -- `restaurant_english_name`
            '{$_POST['district']}',                 -- `district`
            '{$_POST['chi-address']}',              -- `chinese_address`
            '{$_POST['eng-address']}',              -- `english_address`
            '0',                                    -- `latitude`
            '0',                                    -- `longitude`
            '{$_POST['restaurant-phoneNo']}',       -- `phone_number`
            '',                                     -- `email`
            '{$_POST['seats']}',                    -- `number_of_seats`
            '$weekday',                             -- `weekday_business_hours`
            '$weekend',                             -- `weekend_business_hours`
            '$holiday',                             -- `holiday_business_hours`
            NOW(),                                  -- `create_datetime`
            '0',                                    -- `status`
            '$id'                                   -- `partner_id`
        );";

      // Save to database
      if (mysqli_query($conn, $sql)) {
        // Get the restaurant id
        $restaurantID = $conn->insert_id;

        // Save the cuisine to database
        $cuisines = $_POST['cuisine'];
        foreach ($cuisines as $cuisine) {
          $sql = "INSERT INTO `restaurant_cuisine` (
                    `restaurant_id`,
                    `cuisine_id`) VALUES (
                        '$restaurantID',
                        '$cuisine');";
          if (mysqli_query($conn, $sql)) {
            // Empty
          } else {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'reason' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Save the type to database
        $types = $_POST['type'];
        foreach ($types as $type) {
          $sql = "INSERT INTO `restaurant_type` (
                    `restaurant_id`,
                    `type_id`) VALUES (
                        '$restaurantID',
                        '$type');";
          if (mysqli_query($conn, $sql)) {
            // Empty
          } else {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'reason' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Save the payment methods to database
        $methods = $_POST['payment'];
        foreach ($methods as $method) {
          $sql = "INSERT INTO `restaurant_payment_method` (
                    `restaurant_id`,
                    `method_id`) VALUES (
                        '$restaurantID',
                        '$method');";
          if (mysqli_query($conn, $sql)) {
            // Empty
          } else {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'reason' => mysqli_error($conn)
            ));
          }
        } // End foreach()

        // Response success json
        echo json_encode(array('success' => true));

        // Close the database
        mysqli_close($conn);
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));

        // Close the database
        mysqli_close($conn);
      }
      break;
    case 'guesthouse':
      $sql = "INSERT INTO `guesthouse` (
        `guesthouse_chinese_name`,
        `guesthouse_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_rooms`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$_POST['chi-name']}',
        '{$_POST['eng-name']}',
        '{$_POST['district']}',
        '{$_POST['chi-address']}',
        '{$_POST['eng-address']}',
        0,
        0,
        '{$_POST['guesthouse-phoneNo']}',
        '{$_POST['email']}',
        '{$_POST['rooms']}',
        '$weekday',
        '$weekend',
        '$holiday',
        NOW(),
        0,
        $id
        );";
      // Save to database
      if (mysqli_query($conn, $sql)) {
        // Get the guesthouse id
        $guesthouseId = $conn->insert_id;

        // Save the payments to database
        if (isset($_POST['payment'])) {
          $payments = $_POST['payment'];
          foreach ($payments as $payment) {
            $sql = "INSERT INTO `guesthouse_payment_method` (
                        `guesthouse_id`,
                        `method_id`) VALUES (
                            '$guesthouseId',
                            '$payment');";
            if (!mysqli_query($conn, $sql)) {
              echo json_encode(array(
                'success' => false,
                'reason' => mysqli_error($conn)
              ));
            }
          } // End foreach()
        }

        // Save the equipments to database
        if (isset($_POST['equipment'])) {
          $equipments = $_POST['equipment'];
          foreach ($equipments as $equipment) {
            $sql = "INSERT INTO `guesthouse_equipment` (
                        `guesthouse_id`,
                        `equipment_id`) VALUES (
                            '$guesthouseId',
                            '$equipment');";
            if (!mysqli_query($conn, $sql)) {
              echo json_encode(array(
                'success' => false,
                'reason' => mysqli_error($conn)
              ));
            }
          } // End foreach()
        }

        // Response success json
        echo json_encode(array(
          'success' => true,
          'id' => $guesthouseId
        ));
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
      // Close the database
      mysqli_close($conn);
      break;
    case 'attraction':
      // Not complete
      break;
  }
}

function completePartnerRequest($id)
{
  global $conn;

  $sql = "UPDATE `guesthouse_partner_request` SET `status` = 4 WHERE `request_id` = $id";

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

// Partner login
function checkPartnerLogin($type)
{
  // Get the database connection variable
  global $conn;

  $email = $_POST['email'];
  $psw = $_POST['psw'];

  switch ($type) {
    case 'restaurant':
      $sql = "SELECT * FROM `account`
                WHERE `email` = '$email'
                  AND `type_id` = '2';";
      $rs = mysqli_query($conn, $sql);

      if (mysqli_num_rows($rs) > 0) {
        $rd = mysqli_fetch_assoc($rs);

        // Check the account status
        if ($rd['status'] == 1) {
          // The account is normal
          // Check the password is valid
          if ($rd['password'] == $psw) {
            // Save the login information to SESSION
            $_SESSION['r_id']         = $rd['account_id'];
            $_SESSION['r_email']      = $rd['email'];
            $_SESSION['r_firstname']  = $rd['firstname'];
            $_SESSION['r_lastname']   = $rd['lastname'];

            echo json_encode(array(
              'success' => true
            ));
          } else {
            // Incorrect Password
            echo json_encode(array(
              'success' => false,
              'reason' => 'password invalid'
            ));
          }
        } else {
          // The account is freezed
          echo json_encode(array(
            'success' => false,
            'reason' => 'freezed'
          ));
        }
      } else {
        // The account is deleted
        echo json_encode(array(
          'success' => false,
          'reason'  => 'not exist'
        ));
      }
      break;
    case 'guesthouse':
      $sql = "SELECT * FROM `account`
                WHERE `email` = '$email'
                  AND `type_id` = '3';";
      $rs = mysqli_query($conn, $sql);

      if (mysqli_num_rows($rs) > 0) {
        $rd = mysqli_fetch_assoc($rs);

        // Check the account status
        if ($rd['status'] == 1) {
          // The account is normal
          // Check the password is valid
          if ($rd['password'] == $psw) {
            // Save the login information to SESSION
            $_SESSION['g_id']         = $rd['account_id'];
            $_SESSION['g_email']      = $rd['email'];
            $_SESSION['g_firstname']  = $rd['firstname'];
            $_SESSION['g_lastname']   = $rd['lastname'];

            echo json_encode(array(
              'success' => true
            ));
          } else {
            // Incorrect Password
            echo json_encode(array(
              'success' => false,
              'reason' => 'password invalid'
            ));
          }
        } else {
          // The account is freezed
          echo json_encode(array(
            'success' => false,
            'reason' => 'freezed'
          ));
        }
      } else {
        // The account is deleted
        echo json_encode(array(
          'success' => false,
          'reason'  => 'not exist'
        ));
      }
      break;
  }
  // Close the database
  mysqli_close($conn);
}

function createRestaurant($id)
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "INSERT INTO `restaurant` (
    `restaurant_chinese_name`,
    `restaurant_english_name`,
    `district`,
    `chinese_address`,
    `english_address`,
    `latitude`,
    `longitude`,
    `phone_number`,
    `email`,
    `number_of_seats`,
    `weekday_business_hours`,
    `weekend_business_hours`,
    `holiday_business_hours`,
    `create_datetime`,
    `status`,
    `partner_id`
    ) VALUES (
        '{$_POST['chi-name']}',                 -- `restaurant_chinese_name`
        '{$_POST['eng-name']}',                 -- `restaurant_english_name`
        '{$_POST['district']}',                 -- `district`
        '{$_POST['chi-address']}',              -- `chinese_address`
        '{$_POST['eng-address']}',              -- `english_address`
        '0',                                    -- `latitude`
        '0',                                    -- `longitude`
        '{$_POST['phoneNo']}',                  -- `phone_number`
        '{$_POST['email']}',                    -- `email`
        '{$_POST['seats']}',                    -- `number_of_seats`
        '$weekday',                             -- `weekday_business_hours`
        '$weekend',                             -- `weekend_business_hours`
        '$holiday',                             -- `holiday_business_hours`
        NOW(),                                  -- `submit_datetime`
        '0',                                    -- `status`
        '$id'                                   -- `partner_id`
    );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the restaurant id
    $restaurantID = $conn->insert_id;

    // Save the cuisine to database
    $cuisines = $_POST['cuisine'];
    foreach ($cuisines as $cuisine) {
      $sql = "INSERT INTO `restaurant_cuisine` (
                `restaurant_id`,
                `cuisine_id`) VALUES (
                    '$restaurantID',
                    '$cuisine');";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the type to database
    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `restaurant_type` (
                `restaurant_id`,
                `type_id`) VALUES (
                    '$restaurantID',
                    '$type');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the payment methods to database
    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `restaurant_payment_method` (
                `restaurant_id`,
                `method_id`) VALUES (
                    '$restaurantID',
                    '$method');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the equipments to database
    $equipments = $_POST['equipment'];
    foreach ($equipments as $equipment) {
      $sql = "INSERT INTO `restaurant_equipment` (
                  `restaurant_id`,
                  `equipment_id`) VALUES (
                      '$restaurantID',
                      '$equipment');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id'      => $restaurantID
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function restaurantUpdateInfo($id)
{
  // Get the database connection variable
  global $conn;

  // Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "UPDATE `restaurant` SET
            `restaurant_chinese_name`     = '{$_POST['chi-name']}',
            `restaurant_english_name`     = '{$_POST['eng-name']}',
            `district`                    = '{$_POST['district']}',
            `chinese_address`             = '{$_POST['chi-address']}',
            `english_address`             = '{$_POST['eng-address']}',
            `latitude`                    = '{$_POST['latitude']}',
            `longitude`                   = '{$_POST['longitude']}',
            `phone_number`                = '{$_POST['phoneNo']}',
            `email`                       = '{$_POST['email']}',
            `number_of_seats`             = '{$_POST['seats']}',
            `weekday_business_hours`      = '$weekday',
            `weekend_business_hours`      = '$weekend',
            `holiday_business_hours`      = '$holiday'
            WHERE `restaurant_id`         = '$id';";
  if (mysqli_query($conn, $sql)) {
    // Handle the restaurant cuisine information
    // Delete all old data -> Insert all form data

    // Cuisine
    $sql = "DELETE FROM `restaurant_cuisine`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $cuisines = $_POST['cuisine'];
    foreach ($cuisines as $cuisine) {
      $sql = "INSERT INTO `restaurant_cuisine` (
                `restaurant_id`,
                `cuisine_id`
                ) VALUES (
                  '$id',
                  '$cuisine'
                );";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Type
    $sql = "DELETE FROM `restaurant_type`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `restaurant_type` (
                `restaurant_id`,
                `type_id`
                ) VALUES (
                  '$id',
                  '$type'
                );";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Payment Method
    $sql = "DELETE FROM `restaurant_payment_method`
              WHERE `restaurant_id` = '$id';";
    mysqli_query($conn, $sql);

    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `restaurant_payment_method` (
                `restaurant_id`,
                `method_id`
                ) VALUES (
                  '$id',
                  '$method'
                );";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Success
    echo json_encode(array(
      'success' => true
    ));
  } else {
    // Fail
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }
}

function restaurantUpdateStatus($id)
{
  // Get the database connection variable
  global $conn;

  switch ($_POST['status']) {
    case "Hidden":
      $status = 0;
      break;
    case "Open":
      $status = 1;
      break;
    case "Closed":
      $status = 2;
      break;
  }
  $sql = "UPDATE `restaurant`
            SET `status` = '$status'
            WHERE `restaurant_id` = '$id';";
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false,
      'reason'  => mysqli_error($conn)
    ));
  }
}

function createGuesthouse($id)
{
  // Get the database connection variable
  global $conn;

  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  //Save the guesthouse information
  $sql = "INSERT INTO `guesthouse` (
        `guesthouse_chinese_name`,
        `guesthouse_english_name`,
        `district`,
        `chinese_address`,
        `english_address`,
        `latitude`,
        `longitude`,
        `phone_number`,
        `email`,
        `number_of_rooms`,
        `weekday_business_hours`,
        `weekend_business_hours`,
        `holiday_business_hours`,
        `create_datetime`,
        `status`,
        `partner_id`
        ) VALUES (
        '{$_POST['chi-name']}',
        '{$_POST['eng-name']}',
        '{$_POST['district']}',
        '{$_POST['chi-address']}',
        '{$_POST['eng-address']}',
        0,
        0,
        '{$_POST['phoneNumber']}',
        '{$_POST['email']}',
        '{$_POST['rooms']}',
        '$weekday',
        '$weekend',
        '$holiday',
        NOW(),
        0,
        $id
        );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the guesthouse id
    $guesthouseId = $conn->insert_id;

    // Save the payments to database
    if (isset($_POST['payment'])) {
      $payments = $_POST['payment'];
      foreach ($payments as $payment) {
        $sql = "INSERT INTO `guesthouse_payment_method` (
                    `guesthouse_id`,
                    `method_id`) VALUES (
                        '$guesthouseId',
                        '$payment');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Save the equipments to database
    if (isset($_POST['equipment'])) {
      $equipments = $_POST['equipment'];
      foreach ($equipments as $equipment) {
        $sql = "INSERT INTO `guesthouse_equipment` (
                    `guesthouse_id`,
                    `equipment_id`) VALUES (
                        '$guesthouseId',
                        '$equipment');";
        if (!mysqli_query($conn, $sql)) {
          echo json_encode(array(
            'success' => false,
            'reason' => mysqli_error($conn)
          ));
        }
      } // End foreach()
    }

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id' => $guesthouseId
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function guesthouseFinishBooking($id)
{
  global $conn;

  $sql = "UPDATE `guesthouse_booking`
          SET `status` = 2
          WHERE `booking_id` = $id";

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

function guesthouseCancelBooking($id)
{
  global $conn;

  $sql = "UPDATE `guesthouse_booking`
          SET `status` = 3
          WHERE `booking_id` = $id";

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

function submitDriverJobApplication()
{
  // Get the database connection variable
  global $conn;

  if (empty($error)) {
    $sql = "INSERT INTO `driver_application` (
      `chinese_firstname`,
      `chinese_lastname`,
      `birth_year`,
      `birth_month`,
      `hkid`,
      `phone_number`,
      `email`,
      `seat`,
      `license_plate_number`,
      `status`,
      `responder_staff_id`,
      `worker_id`,
      `submit_datetime`
    ) VALUES (
      '{$_POST['chi-firstname']}',
      '{$_POST['chi-lastname']}',
      '{$_POST['birth_year']}',
      '{$_POST['birth_month']}',
      '{$_POST['hkid']}',
      '{$_POST['phone-number']}',
      '{$_POST['email']}',
      '{$_POST['seats']}',
      '{$_POST['license-plate-number']}',
      1,
      null,
      null,
      NOW()
    )";

    // Save to database
    if (mysqli_query($conn, $sql)) {
      // Get the request id
      $id = $conn->insert_id;

      // Save the Vehicle Exterior image
      $target_dir = "data/job_application/driver/$id/";

      // Create the directory if not exists
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }
      $target_file = $target_dir . basename('vehicle_exterior.jpg');
      move_uploaded_file($_FILES['vehicle-exterior']['tmp_name'], $target_file);

      $target_file = $target_dir . basename('vehicle_inside.jpg');
      move_uploaded_file($_FILES['vehicle-inside']['tmp_name'], $target_file);

      // Response success json
      echo json_encode(array(
        'success' => true
      ));
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason' => mysqli_error($conn)
      ));
    }
  }
  // Close the database
  mysqli_close($conn);
}

function workerUserRegister($type)
{
  // Get the database connection variable
  global $conn;

  // Check if the email address is repeated in database
  $query = "SELECT * FROM account WHERE `email` = '{$_POST['worker-email']}';";
  $rs = mysqli_query($conn, $query);
  if (mysqli_num_rows($rs) > 0) {
    // Response fail and reason json
    echo json_encode(array(
      'success' => false,
      'reason'  => '重複的電郵地址，請重新輸入。'
    ));
  } else {
    // Save the register information
    $sql = "INSERT INTO `account` (
      `email`,
      `password`,
      `firstname`,
      `lastname`,
      `nickname`,
      `gender`,
      `phone_number`,
      `birth_year`,
      `birth_month`,
      `icon_path`,
      `type_id`,
      `status`,
      `registration_time`
      ) VALUES (
        '{$_POST['worker-email']}',
        '{$_POST['worker-psw']}',
        '{$_POST['worker-firstname']}',
        '{$_POST['worker-lastname']}',
        '',
        '{$_POST['worker-gender']}',
        '{$_POST['worker-phoneNo']}',
        '{$_POST['worker-birth_year']}',
        '{$_POST['worker-birth_month']}',
        '',
        $type,
        1,
        NOW()
      );";

    // Save to database
    if (mysqli_query($conn, $sql)) {
      $account_id = $conn->insert_id;

      if ($type == 5) {
        $sql = "INSERT INTO `vehicle` (
          `seat`,
          `license_plate_number`,
          `worker_id`
        ) VALUES (
          '{$_POST['seats']}',
          '{$_POST['license-plate-number']}',
          '$account_id'
        )";

        if (mysqli_query($conn, $sql)) {
          $appId = $_POST['id'];

          $sql = "UPDATE `driver_application`
                    SET `status` = 4
                    WHERE `id` = $appId";
          if (mysqli_query($conn, $sql)) {
            // Response success json
            echo json_encode(array(
              'success' => true
            ));
          } else {
            // Response fail json
            echo json_encode(array(
              'success' => false,
              'reason'  => mysqli_error($conn)
            ));
          }
        }
      } else {
        $appId = $_POST['id'];

        $sql = "UPDATE `tourist_guide_application`
                  SET `status` = 4
                  WHERE `id` = $appId";
        if (mysqli_query($conn, $sql)) {
          // Response success json
          echo json_encode(array(
            'success' => true
          ));
        } else {
          // Response fail json
          echo json_encode(array(
            'success' => false,
            'reason'  => mysqli_error($conn)
          ));
        }
      }
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason'  => mysqli_error($conn)
      ));
    }
  }

  // Close the database
  mysqli_close($conn);
}

function touristGuideAcceptBooking($id)
{
  global $conn;

  $sql = "SELECT * FROM `itinerary_booking` WHERE `booking_id` = {$id}";
  $rs = mysqli_query($conn, $sql);
  $rc = mysqli_fetch_assoc($rs);

  // echo var_dump($rc);
  if ($rc['drive_service'] == 1) {
    if (is_null($rc['driver_id'])) {
      $sql = "UPDATE `itinerary_booking`
                SET `tourguide_id` = {$_SESSION['guide_id']}
                WHERE `booking_id` = {$id};";
    } else {
      $sql = "UPDATE `itinerary_booking`
                SET `tourguide_id` = {$_SESSION['guide_id']},
                `status` = 1
                WHERE `booking_id` = {$id};";
    }
  } else {
    $sql = "UPDATE `itinerary_booking`
                SET `tourguide_id` = {$_SESSION['guide_id']},
                `status` = 1
                WHERE `booking_id` = {$id};";
  }

  if (mysqli_query($conn, $sql)) {
    echo json_encode(array(
      'success' => true
    ));
  } else {
    echo json_encode(array(
      'success' => false
    ));
  }
  mysqli_close($conn);
}

function checkWorkerLogin($type)
{
  // Get the database connection variable
  global $conn;

  $email = $_POST['email'];
  $psw = $_POST['psw'];

  switch ($type) {
    case 'tourist_guide':
      $sql = "SELECT * FROM `account`
                WHERE `email` = '$email'
                  AND `type_id` = '4';";
      $rs = mysqli_query($conn, $sql);

      if (mysqli_num_rows($rs) > 0) {
        $rd = mysqli_fetch_assoc($rs);

        // Check the account status
        if ($rd['status'] == 1) {
          // The account is normal
          // Check the password is valid
          if ($rd['password'] == $psw) {
            // Save the login information to SESSION
            $_SESSION['guide_id']         = $rd['account_id'];
            $_SESSION['guide_email']      = $rd['email'];
            $_SESSION['guide_firstname']  = $rd['firstname'];
            $_SESSION['guide_lastname']   = $rd['lastname'];
            $_SESSION['guide_iconPath']   = $rd['icon_path'];

            echo json_encode(array(
              'success' => true
            ));
          } else {
            // Incorrect Password
            echo json_encode(array(
              'success' => false,
              'reason' => 'password invalid'
            ));
          }
        } else {
          // The account is freezed
          echo json_encode(array(
            'success' => false,
            'reason' => 'freezed'
          ));
        }
      } else {
        // The account is deleted
        echo json_encode(array(
          'success' => false,
          'reason'  => 'not exist'
        ));
      }
      break;
    case 'driver':
      $sql = "SELECT * FROM `account`
                WHERE `email` = '$email'
                  AND `type_id` = '5';";
      $rs = mysqli_query($conn, $sql);

      if (mysqli_num_rows($rs) > 0) {
        $rd = mysqli_fetch_assoc($rs);

        // Check the account status
        if ($rd['status'] == 1) {
          // The account is normal
          // Check the password is valid
          if ($rd['password'] == $psw) {
            // Save the login information to SESSION
            $_SESSION['driver_id']         = $rd['account_id'];
            $_SESSION['driver_email']      = $rd['email'];
            $_SESSION['driver_firstname']  = $rd['firstname'];
            $_SESSION['driver_lastname']   = $rd['lastname'];
            $_SESSION['driver_iconPath']   = $rd['icon_path'];

            echo json_encode(array(
              'success' => true
            ));
          } else {
            // Incorrect Password
            echo json_encode(array(
              'success' => false,
              'reason' => 'password invalid'
            ));
          }
        } else {
          // The account is freezed
          echo json_encode(array(
            'success' => false,
            'reason' => 'freezed'
          ));
        }
      } else {
        // The account is deleted
        echo json_encode(array(
          'success' => false,
          'reason'  => 'not exist'
        ));
      }
      break;
  }
  // Close the database
  mysqli_close($conn);
}

function submit_restaurantRating($id)
{
  // Get the database connection variable
  global $conn;
  $ckInfo = $_POST['ckInfo11'];
  $reviewtitle = $_POST['reviewtitle'];
  $mealtime = $_POST['mealtime'];
  $type_of_meal = $_POST['type_of_meal'];
  $choice1 = $_POST['choice1'];
  $choice2 = $_POST['choice2'];
  $choice3 = $_POST['choice3'];
  $choice4 = $_POST['choice4'];
  $sql = "INSERT INTO restaurant_comment (
    `account_id`,
    `restaurant_id`,
    `title`,
    `date_of_visit`,
    `dining_method`,
    `content`,
    `taste_rating`,
    `environment_rating`,
    `service_rating`,
    `hygiene_rating`,
    `create_datetime`,
    `status`
    ) VALUES (
      {$_SESSION['user_id']},
      '$id',
      '$reviewtitle',
      '$mealtime',
      '$type_of_meal',
      '$ckInfo',
      '$choice1',
      '$choice2',
      '$choice3',
      '$choice4',
      NOW(),
      '1'
    );";

  //Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array(
      'success' => true,
    ));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

function submit_attractionRating($id)
{
  // Get the database connection variable
  global $conn;
  $ckInfo = $_POST['ckInfo11'];
  $reviewtitle = $_POST['reviewtitle'];
  $mealtime = $_POST['mealtime'];
  $choice2 = $_POST['choice2'];
  $choice3 = $_POST['choice3'];
  $choice4 = $_POST['choice4'];
  $sql = "INSERT INTO attraction_comment (
  `account_id`,
  `attraction_id`,
  `title`,
  `date_of_visit`,
  `content`,
  `environment_rating`,
  `service_rating`,
  `hygiene_rating`,
  `create_datetime`,
  `status`
  ) VALUES (
    {$_SESSION['user_id']},
    '$id',
    '$reviewtitle',
    '$mealtime',
    '$ckInfo',
    '$choice2',
    '$choice3',
    '$choice4',
    NOW(),
    '1'
  );";

  //Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array(
      'success' => true,
    ));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}

function submit_guesthouseRating($id)
{
  // Get the database connection variable
  global $conn;
  $ckInfo = $_POST['ckInfo11'];
  $reviewtitle = $_POST['reviewtitle'];
  $mealtime = $_POST['mealtime'];
  $type_of_meal = $_POST['type_of_meal'];
  $choice1 = $_POST['choice1'];
  $choice2 = $_POST['choice2'];
  $choice3 = $_POST['choice3'];
  $choice4 = $_POST['choice4'];
  $sql = "INSERT INTO guesthouse_comment (
    `account_id`,
    `guesthouse_id`,
    `title`,
    `date_of_visit`,
    `dining_method`,
    `content`,
    `taste_rating`,
    `environment_rating`,
    `service_rating`,
    `hygiene_rating`,
    `create_datetime`,
    `status`
    ) VALUES (
      {$_SESSION['user_id']},
      '$id',
      '$reviewtitle',
      '$mealtime',
      '$type_of_meal',
      '$ckInfo',
      '$choice1',
      '$choice2',
      '$choice3',
      '$choice4',
      NOW(),
      '1'
    );";

  //Save to database
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array(
      'success' => true,
    ));

    // Close the database
    mysqli_close($conn);
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));

    // Close the database
    mysqli_close($conn);
  }
}


function attraction_discover_submit()
{
  // Get the database connection variable
  global $conn;
  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "INSERT INTO `attraction_discover` (
    `attraction_chinese_name`,
    `attraction_english_name`,
    `district`,
    `chinese_address`,
    `english_address`,
    `weekday_business_hours`,
    `weekend_business_hours`,
    `holiday_business_hours`,
    `website`,
    `email`,
    `phone_number`,
    `submit_date`,
    `status`
    ) VALUES (
      '{$_POST['chi-name']}',                 -- `attraction_chinese_name`
      '{$_POST['eng-name']}',                 -- `attraction_english_name`
      '{$_POST['district']}',                 -- `district`
      '{$_POST['chi-address']}',              -- `chinese_address`
      '{$_POST['eng-address']}',              -- `english_address`
      '$weekday',                             -- `weekday_business_hours`
      '$weekend',                             -- `weekend_business_hours`
      '$holiday',                             -- `holiday_business_hours`
      '{$_POST['website']}', 
      '{$_POST['phone_number']}', 
      '{$_POST['email']}',              
      NOW(),                                  -- `submit_datetime`
      1                                       -- `status`
    );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the attraction id
    $id = $conn->insert_id;

    $target_dir = "data/discovery/attraction/$id/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename('photo1.jpg');
    move_uploaded_file($_FILES['image1']['tmp_name'], $target_file);

    if ($_FILES['image2']['size'] > 0) {
      $target_file = $target_dir . basename('photo2.jpg');
      move_uploaded_file($_FILES['image2']['tmp_name'], $target_file);
    }

    if ($_FILES['image3']['size'] > 0) {
      $target_file = $target_dir . basename('photo3.jpg');
      move_uploaded_file($_FILES['image3']['tmp_name'], $target_file);
    }

    // Save the type to database
    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `attraction_discover_type` (
                `id`,
                `type_id`) VALUES (
                    '$id',
                    '$type');";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Save the payment methods to database
    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `attraction_discover_payment_method` (
                `id`,
                `method_id`) VALUES (
                    '$id',
                    '$method');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id'      => $id
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function restaurant_discover_submit()
{
  // Get the database connection variable
  global $conn;

  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "INSERT INTO `restaurant_discover` (
    `restaurant_chinese_name`,
    `restaurant_english_name`,
    `district`,
    `chinese_address`,
    `english_address`,
    `number_of_seats`,
    `weekday_business_hours`,
    `weekend_business_hours`,
    `holiday_business_hours`,
    `email`,
    `phone_number`,
    `submit_date`,
    `status`
    ) VALUES (
      '{$_POST['chi-name']}',                 -- `attraction_chinese_name`
      '{$_POST['eng-name']}',                 -- `attraction_english_name`
      '{$_POST['district']}',                 -- `district`
      '{$_POST['chi-address']}',              -- `chinese_address`
      '{$_POST['eng-address']}',              -- `english_address`
      '{$_POST['seats']}',                    -- `no of seats`
      '$weekday',                             -- `weekday_business_hours`
      '$weekend',                             -- `weekend_business_hours`
      '$holiday',                             -- `holiday_business_hours`
      '{$_POST['phone_number']}', 
      '{$_POST['email']}',              
      NOW(),                                  -- `submit_datetime`
      1                                       -- `status`
    );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the restaurant id
    $id = $conn->insert_id;

    $target_dir = "data/discovery/restaurant/$id/";

    // Create the directory if not exists
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('photo1.jpg');
    move_uploaded_file($_FILES['image1']['tmp_name'], $target_file);
    if ($_FILES['image2']['size'] > 0) {
      $target_file = $target_dir . basename('photo2.jpg');
      move_uploaded_file($_FILES['image2']['tmp_name'], $target_file);
    }
    if ($_FILES['image3']['size'] > 0) {
      $target_file = $target_dir . basename('photo3.jpg');
      move_uploaded_file($_FILES['image3']['tmp_name'], $target_file);
    }
    // Save the type to database
    $types = $_POST['type'];
    foreach ($types as $type) {
      $sql = "INSERT INTO `restaurant_discover_type` (
                `id`,
                `type_id`) VALUES (
                    '$id',
                    '$type');";
      if (!mysqli_query($conn, $sql)) {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()


    // save the cuisines to database
    $cuisines = $_POST['cuisine'];
    foreach ($cuisines as $cuisine) {
      $sql = "INSERT INTO `restaurant_discover_cuisine` (
                `id`,
                `cuisine_id`
                ) VALUES (
                  '$id',
                  '$cuisine'
                );";
      if (mysqli_query($conn, $sql)) {
        // Empty
      } else {
        // Response fail json
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    }

    // Save the payment methods to database
    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `restaurant_discover_payment_method` (
                `id`,
                `method_id`) VALUES (
                    '$id',
                    '$method');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id'      => $id
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

function guesthouse_discover_submit()
{
  // Get the database connection variable
  global $conn;

  //Handle the business hours if closed
  $weekday = $_POST['start-weekday'] . ' - ' . $_POST['end-weekday'];
  if ($weekday == "23:59 - 23:59") {
    $weekday = "closed";
  } else if ($weekday == "00:00 - 00:00") {
    $weekday = "24 Hours";
  }
  $weekend = $_POST['start-weekend'] . ' - ' . $_POST['end-weekend'];
  if ($weekend == "23:59 - 23:59") {
    $weekend = "closed";
  } else if ($weekend == "00:00 - 00:00") {
    $weekend = "24 Hours";
  }
  $holiday = $_POST['start-holiday'] . ' - ' . $_POST['end-holiday'];
  if ($holiday == "23:59 - 23:59") {
    $holiday = "closed";
  } else if ($holiday == "00:00 - 00:00") {
    $holiday = "24 Hours";
  }

  $sql = "INSERT INTO `guesthouse_discover` (
    `guesthouse_chinese_name`,
    `guesthouse_english_name`,
    `district`,
    `chinese_address`,
    `english_address`,
    `number_of_rooms`,
    `weekday_business_hours`,
    `weekend_business_hours`,
    `holiday_business_hours`,
    `email`,
    `phone_number`,
    `submit_date`,
    `status`
    ) VALUES (
      '{$_POST['chi-name']}',                 -- `guesthouse_chinese_name`
      '{$_POST['eng-name']}',                 -- `guesthouse_english_name`
      '{$_POST['district']}',                 -- `district`
      '{$_POST['chi-address']}',              -- `chinese_address`
      '{$_POST['eng-address']}',              -- `english_address`
      '{$_POST['rooms']}',                    -- `no of seats`
      '$weekday',                             -- `weekday_business_hours`
      '$weekend',                             -- `weekend_business_hours`
      '$holiday',                             -- `holiday_business_hours`
      '{$_POST['phone_number']}', 
      '{$_POST['email']}',              
      NOW(),                                  -- `submit_datetime`
      1                                       -- `status`
    );";

  // Save to database
  if (mysqli_query($conn, $sql)) {
    // Get the restaurant id
    $id = $conn->insert_id;

    $target_dir = "data/discovery/guesthouse/$id/";

    // Create the directory if not exists
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename('photo1.jpg');
    move_uploaded_file($_FILES['image1']['tmp_name'], $target_file);
    if ($_FILES['image2']['size'] > 0) {
      $target_file = $target_dir . basename('photo2.jpg');
      move_uploaded_file($_FILES['image2']['tmp_name'], $target_file);
    }
    if ($_FILES['image3']['size'] > 0) {
      $target_file = $target_dir . basename('photo3.jpg');
      move_uploaded_file($_FILES['image3']['tmp_name'], $target_file);
    }

    // Save the payment methods to database
    $methods = $_POST['payment'];
    foreach ($methods as $method) {
      $sql = "INSERT INTO `guesthouse_discover_payment_method` (
                `id`,
                `method_id`) VALUES (
                    '$id',
                    '$method');";
      if (!mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => false,
          'reason' => mysqli_error($conn)
        ));
      }
    } // End foreach()

    // Response success json
    echo json_encode(array(
      'success' => true,
      'id'      => $id
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  // Close the database
  mysqli_close($conn);
}

// tour guide application
function submitTouristGuideJobApplication()
{
  // Get the database connection variable
  global $conn;

  if (empty($error)) {
    $sql = "INSERT INTO `tourist_guide_application` (
      `chinese_firstname`,
      `chinese_lastname`,
      `birth_year`,
      `birth_month`,
      `hkid`,
      `tgid`,
      `phone_number`,
      `email`,
      `status`,
      `responder_staff_id`,
      `worker_id`,
      `submit_datetime`
    ) VALUES (
      '{$_POST['firstname']}',
      '{$_POST['lastname']}',
      '{$_POST['birth_year']}',
      '{$_POST['birth_month']}',
      '{$_POST['hkid']}',
      '{$_POST['tgid']}',
      '{$_POST['phone-number']}',
      '{$_POST['email']}',
      1,
      null,
      null,
      NOW()
    )";

    // Save to database
    if (mysqli_query($conn, $sql)) {
      // Get the request id
      $id = $conn->insert_id;

      // Save the Tour Guide Selfie image
      $target_dir = "data/job_application/tourist_guide/$id/";

      // Create the directory if not exists
      if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
      }

      // Store guide selfie image
      $target_file = $target_dir . basename('guide_selfie.jpg');
      move_uploaded_file($_FILES['guide-selfie']['tmp_name'], $target_file);

      // Store guide pass image
      $target_file = $target_dir . basename('guide_pass.jpg');
      move_uploaded_file($_FILES['guide-pass']['tmp_name'], $target_file);

      // Response success json
      echo json_encode(array(
        'success' => true
      ));
    } else {
      // Response fail json
      echo json_encode(array(
        'success' => false,
        'reason' => mysqli_error($conn)
      ));
    }
  }
  // Close the database
  mysqli_close($conn);
}

function attractionEventLogGenerate($user_id, $item_id, $event_type, $custom_weight = '')
{
  global $conn;

  if ($custom_weight == '') {
    $sql = "INSERT INTO `user_attraction_log` (
      `user_id`,
      `item_id`,
      `time`,
      `event_type`,
      `custom_weight`
    ) VALUES (
      $user_id,
      $item_id,
      NOW(),
      '{$event_type}',
      null
    );";
  } else {
    $sql = "INSERT INTO `user_attraction_log` (
      `user_id`,
      `item_id`,
      `time`,
      `event_type`,
      `custom_weight`
    ) VALUES (
      $user_id,
      $item_id,
      NOW(),
      '{$event_type}',
      $custom_weight
    );";
  }

  // Execute the sql
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

  // Close the database
  mysqli_close($conn);
}


// Restaurant Reservation request
function restaurant_Booking_Request()
{
  global $conn;

  $user_email = "test@gmail.com"; //$_SESSION['user_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  $sql = "INSERT INTO `restaurant_booking` (
    `restaurant_id`,
    `account_id`,
    `booking_date`,
    `booking_time`,
    `people`,
    `booking_subject`,
    `description`,
    `contact_name`,
    `contact_phone`,
    `contact_email`,
    `table`
    ) VALUES (
      '{$_POST['restaurant-id']}',
      '{$account_rd['account_id']}',
      '{$_POST['booking-date']}',
      '{$_POST['booking-time']}',
      '{$_POST['people']}',
      '{$_POST['booking-subject']}',
      '{$_POST['booking-description']}',
      '{$_POST['contact-name']}',
      '{$_POST['contact-number']}',
      '{$_POST['contact-email']}',
      '{$_POST['table']}'
    );";

  // Execute the sql
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

  // Close the database
  mysqli_close($conn);
}

// Guesthouse Reservation request
function guesthouse_Booking_Request()
{
  global $conn;

  $user_email = "test@gmail.com"; //$_SESSION['user_email'];
  $sql = "SELECT `account_id` FROM `account` WHERE `email` = '$user_email'";
  $rs = mysqli_query($conn, $sql);
  $account_rd = mysqli_fetch_assoc($rs);

  $sql = "INSERT INTO `guesthouse_booking` (
    `guesthouse_id`,
    `account_id`,
    `checkin_date`,
    `checkout_date`,
    `room`,
    `adult`,
    `children`,
    `description`,
    `contact_name`,
    `contact_phone`,
    `contact_email`
    ) VALUES (
      '{$_POST['guesthouse-id']}',
      '{$account_rd['account_id']}',
      '{$_POST['start-date']}',
      '{$_POST['end-date']}',
      '{$_POST['rooms']}',
      '{$_POST['adult-number']}',
      '{$_POST['child-number']}',
      '{$_POST['description']}',
      '{$_POST['contact-name']}',
      '{$_POST['contact-number']}',
      '{$_POST['contact-email']}'
    );";

  // Execute the sql
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

  // Close the database
  mysqli_close($conn);
}

function submitTourGroupRegistration($tourGroupId, $applicantId, $contactNumber, $numberOfPeople)
{
  global $conn;

  // Check the maximum of participant
  $sql = "SELECT `max_people`, `joined_people` FROM `tourguide_tourgroup` WHERE `tourgroup_id` = $tourGroupId;";
  $rs = mysqli_query($conn, $sql);
  $rc = mysqli_fetch_assoc($rs);
  $predict_participant = $numberOfPeople + $rc['joined_people'];

  // Check the duplicate registration
  $sql = "SELECT * FROM `tourgroup_member` WHERE `tourgroup_id` = $tourGroupId AND `account_id` = $applicantId;";
  $rs = mysqli_query($conn, $sql);

  if (mysqli_num_rows($rs) > 0) {
    echo json_encode(array(
      'success' => true,
      'join_success' => false,
      'reason' => 'Duplicate registration'
    ));
  } else if ($rc['joined_people'] > $rc['max_people']) {
    echo json_encode(array(
      'success' => true,
      'join_success' => false,
      'reason' => 'Registration is full'
    ));
  } else if ($predict_participant > $rc['max_people']) {
    echo json_encode(array(
      'success' => true,
      'join_success' => false,
      'reason' => 'Insufficient balance'
    ));
  } else {
    $sql = "INSERT INTO `tourgroup_member`(
              `tourgroup_id`,
              `account_id`,
              `contact_number`,
              `num_people`
              ) VALUES (
              $tourGroupId,
              $applicantId,
              $contactNumber,
              $numberOfPeople);";

    if (mysqli_query($conn, $sql)) {
      $sql = "UPDATE `tourguide_tourgroup`
                SET `joined_people` = `joined_people` + $numberOfPeople
                WHERE `tourgroup_id` = $tourGroupId;";

      if (mysqli_query($conn, $sql)) {
        echo json_encode(array(
          'success' => true,
          'join_success' => true
        ));
      } else {
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
  }

  mysqli_close($conn);
}

function cancelGuesthouseBooking()
{
  global $conn;

  $sql = "DELETE FROM `guesthouse_booking` WHERE `booking_id` = '{$_POST['booking-id']}'";

  // insert new records
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  mysqli_close($conn);
}

function cancelRestaurantBooking()
{
  global $conn;

  $sql = "DELETE FROM `restaurant_booking` WHERE `booking_id` = '{$_POST['booking-id']}'";

  // insert new records
  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array('success' => true));
  } else {
    // Response fail json
    echo json_encode(array('success' => false));
  }

  mysqli_close($conn);
}

function saveRestaurantLayout()
{
  global $conn;

  $findExistingQuery = "SELECT * FROM restaurant_layout WHERE `r_id` = '{$_POST['r_id']}' AND `restaurant_id` = '{$_POST['restaurant_id']}';";
  $rs = mysqli_query($conn, $findExistingQuery);

  echo mysqli_num_rows($rs);

  if (mysqli_num_rows($rs) == 1) {
    echo "found data";
    $sql = "UPDATE restaurant_layout
    SET `position` = '{$_POST['position']}', `timeInterval` = '{$_POST['timeInterval']}'
    WHERE `r_id` = '{$_POST['r_id']}' AND `restaurant_id` = '{$_POST['restaurant_id']}';";
  } else {
    echo "no data";
    $sql = "INSERT INTO `restaurant_layout` (
      `restaurant_id`,
      `r_id`,
      `position`,
      `timeInterval`
    ) VALUES (
      '{$_POST['restaurant_id']}',
      '{$_POST['r_id']}',
      '{$_POST['position']}',
      '{$_POST['timeInterval']}'
    );";
  }

  if (mysqli_query($conn, $sql)) {
    // Response success json
    echo json_encode(array(
      'success' => true
    ));
  } else {
    // Response fail json
    echo json_encode(array(
      'success' => false,
      'reason' => mysqli_error($conn)
    ));
  }
  mysqli_close($conn);
}

function loadTableLayout()
{
  global $conn;

  $findExistingQuery = "SELECT * FROM restaurant_layout WHERE `r_id` = '{$_POST['r_id']}';";

  $result  = mysqli_query($conn, $findExistingQuery);

  if (!$result) {
    echo false;
    exit;
  } else {
    $row = mysqli_fetch_row($result);
    echo $row[0];
  }
  mysqli_close($conn);
}

function loadTimeInterval()
{
  global $conn;

  $findExistingQuery = "SELECT `timeInterval` FROM restaurant_layout WHERE `r_id` = '{$_POST['r_id']}';";

  $result  = mysqli_query($conn, $findExistingQuery);

  if (!$result) {
    echo false;
    exit;
  } else {
    $row = mysqli_fetch_row($result);
    echo $row[0];
  }
  mysqli_close($conn);
}



function loadBookingResult()
{
  global $conn;

  $sql = "select 
     `booking_id`, `restaurant_id`, `account_id`, `booking_date`, `booking_time`, `people`, `booking_subject`, `description`, `contact_name`, `contact_phone`, `contact_email`
   FROM 
    restaurant_booking 
   where 
    restaurant_id = '{$_POST['restaurant_id']}' AND
    booking_date = '{$_POST['booking_date']}' AND
    booking_time between '{$_POST['booking_time_start']}' AND '{$_POST['booking_time_end']}' ;";



  $result  = mysqli_query($conn, $sql);
  if (!$result) {
    // Response fail json
    echo "No result";
  } else {
    // Response success json
    // echo json_encode(array(
    //   'success' => true
    // ));
    $row = mysqli_fetch_row($result);
    while ($row = $result->fetch_row()) {
      printf("%s (%s)\n", $row[0], $row[1]);
    }
  }
  mysqli_close($conn);
}

function getWorkingTime()
{
  global $conn;

  $sql301 = "select 
     `weekday_business_hours`, `weekend_business_hours`
   FROM 
    restaurant
   where 
    restaurant_id = '{$_POST['restaurant_id']}';";

  $result301  = mysqli_query($conn, $sql301);
  $rc301 = mysqli_fetch_assoc($result301);

  if (!$result301) {
    // Response fail json
    echo -1;
  } else {
    echo json_encode(array(
      'weekday' => $rc301['weekday_business_hours'],
      'weekend' => $rc301['weekend_business_hours']
    ));
  }
  mysqli_close($conn);
}

function findBookingByDateAndTime()
{
  global $conn;

  $sql =
    "select 
     `table`
   FROM 
    restaurant_booking
   where 
    restaurant_id = '{$_POST['restaurant_id']}' AND 
    booking_date = '{$_POST['booking_date']}' AND
    booking_time = '{$_POST['booking_time']}';";


  $rs = mysqli_query($conn, $sql);

  if (mysqli_num_rows($rs) == 0) {
    // Response fail json
    echo -1;
  } else {
    $rows = [];
    while ($row = mysqli_fetch_assoc($rs)) {
      $rows[] = $row['table'];
    }
    echo json_encode($rows);
  }
  mysqli_close($conn);
}

function restaurantFinishBooking($id)
{
  global $conn;

  $sql = "UPDATE `restaurant_booking`
          SET `status` = 2
          WHERE `booking_id` = $id";

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

function restaurantCancelBooking($id)
{
  global $conn;

  $sql = "UPDATE `restaurant_booking`
          SET `status` = 3
          WHERE `booking_id` = $id";

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

function loadBookingLayout()
{
  global $conn;

  $sql = "SELECT `table` FROM `restaurant_booking` WHERE 
  `restaurant_id` = '{$_POST['resid']}' AND 
  `booking_date` = '{$_POST['bkdate']}' AND 
  `booking_time` = '{$_POST['bktime']}' AND
  `status` != 3;";

  $rs = mysqli_query($conn, $sql);

  if (mysqli_num_rows($rs) > 0) {

    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
      echo ($row['table']) . ",";
    }
  } else {
    echo -1;
  }
  mysqli_close($conn);
}


function loadTablePlacement()
{
  global $conn;

  $restaurant_id = $_POST['resid'];
  $json = "";

  $findExistingQuery = "SELECT * FROM restaurant_layout WHERE `restaurant_id` = '$restaurant_id';";



  $rs  = mysqli_query($conn, $findExistingQuery);

  if (mysqli_num_rows($rs) == 1) {
    $row = mysqli_fetch_row($rs);
    $json = $row[2];
  } else {
    $json = -1;
  }

  echo $json;
}
