<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Kolkata');

session_start();


function getPDOObject()
{
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
    $pdo = new PDO("mysql:host=$servername;dbname=techvilla", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}

function check_session()
{
  if (!isset($_SESSION['userId']) or empty($_SESSION['userId'])) {
    header('location:login.php');
    die();
  }
}

function userlogin()
{
  extract($_POST);
  $umessage = '';
  $pdo = getPDOObject();
  // echo $email;
  // echo '<br>';
  // echo $password;
  // die();
  if (empty($email) or empty($password)) {
    $umessage = '<div class="alert alert-danger">Login id or Password required</div>';
  } else {

    $sql = $pdo->prepare("SELECT id,names,email,password,astatus FROM admin WHERE email=? AND deleted='0' LIMIT 1");
    $sql->execute([$email]);

    $rowCnt = $sql->rowCount();
    // echo $rowCnt; die("till here");

    if ($rowCnt > 0) {
      $rowData = $sql->fetch(PDO::FETCH_ASSOC);
      // print_r($rowData);
      // echo '<br>';
      // die();


    // $a = 12345;
    // $b=password_hash($a,PASSWORD_BCRYPT);
    // echo $b;
      // $newpass = $password;
      // echo "$password";
      // die();
      


      // verifypassword
      // $password = $_POST['password'];
      
     
   

    
    // $newpassword=password_hash($password,PASSWORD_BCRYPT);
    // echo "$newpassword";
    // echo '<br>';
 

      // $hashPass = $rowData['password'];
      // echo "$hashPass";
      // die();
      // die();
    //  echo '<br>';
    //  echo "$password";
    //  die();

    function getCountry(){

      "SELECT name from countries INNER JOIN state ON countries.contry_id = state.countries_id";
    }


      


      if (password_verify($password, $rowData['password'])) {
        if ($rowData['astatus'] == '1') {

          $_SESSION['userId'] = $rowData['id'];
          $_SESSION['userName'] = $rowData['names'];
          $_SESSION['userPhone'] = $rowData['phone'];
          $_SESSION['userEmail'] = $rowData['email'];

          if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            $update = $pdo->prepare("UPDATE admin SET login_time=? WHERE id=?");
            $update->execute([date('Y-m-d H:m:s'), $_SESSION['userId']]);
            header('location:index.php');
            die();
          } else {
            $umessage = '<div class="alert alert-danger">Sorry ! Something went wrong !</div>';
          }
        } else {
          $umessage = '<div class="alert alert-danger">Sorry ! Your account is suspended !</div>';
        }
      } else {
        $umessage = '<div class="alert alert-danger">Invalid Userid Or Password</div>';
      }
    } else {
      $umessage = '<div class="alert alert-danger">Invalid Userid Or Password</div>';
    }
  }

  return $umessage;
}
