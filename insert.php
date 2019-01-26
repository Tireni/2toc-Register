<?php
$username = $_POST['username'];
$useraddress = $_POST['useraddress'];
$state = $_POST['state'];
$email = $_POST['email'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];

if (!empty($username) || !empty($useraddress) || !empty($state) || !empty($email) || !empty($phoneCode) || !empty($phone) || !empty($username) || !empty($gender)){
$host ="localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "register";


$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if (mysqli_connect_error()) {
die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
}else{
$SELECT = "SELECT email From register Where email = ? Limit 1";
$INSERT = "INSERT Into register (username, useraddress, state, email, phoneCode, phone, gender) value(?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($SELECT);


$stmt->bind_param("s", $email);


$stmt->execute();


$stmt->bind_result($email);



$stmt->store_result();


$rnum = $stmt->num_rows;


if ($rnum==0) {
$stmt->close();

$stmt = $conn->prepare($INSERT);
$stmt->bind_param("ssssii", $username, $useraddress, $state, $email, $phoneCode, $phone);
$stmt->execute();
echo "New record inserted sucessully"
}else{
echo "Sorry This Person Already Registered";
}
$stmt->close();
$conn->close();
}else {

echo "All fields are required";
die();
}
?>