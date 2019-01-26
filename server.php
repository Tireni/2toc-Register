<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'register');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
 $useraddress = mysqli_real_escape_string($db, $_POST['useraddress']);
  $state = mysqli_real_escape_string($db, $_POST['state']);
   $email = mysqli_real_escape_string($db, $_POST['email']);
    $phoneCode = mysqli_real_escape_string($db, $_POST['phoneCode']);
     $phone = mysqli_real_escape_string($db, $_POST['phone']);
      $gender = mysqli_real_escape_string($db, $_POST['gender']);
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($useraddress)) { array_push($errors, "Email is required"); }
  if (empty($state)) { array_push($errors, "State is required"); }
if (empty($email)) { array_push($errors, "Email is required"); }
if (empty($phoneCode)) { array_push($errors, "Phone Code is required"); }
if (empty($phone)) { array_push($errors, "Phone number is required"); }
if (empty($gender)) { array_push($errors, "Gender is required"); }
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$email = md5($email);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, useraddress, state, email, phoneCode, phone, gender) 
  			  VALUES('$username, $useraddress, $state, $email, $phoneCode, $phone, $gender')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// ... 