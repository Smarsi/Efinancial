<?php
include("config.php");
session_start();
if(!isset($_SESSION["email"])){
header("Location: login.php");
exit();
}

$sess_email = $_SESSION["email"];
$sql = "SELECT id_user, user_firstname, user_lastname, user_email, user_profile_path FROM users WHERE user_email = '$sess_email'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $userid=$row["id_user"];
    $firstname = $row["user_firstname"];
    $lastname = $row["user_lastname"];
    $username =$row["user_firstname"]." ".$row["user_lastname"];
    $useremail=$row["user_email"];
    $userprofile="uploads/".$row["user_profile_path"];
  }
} else {
    $userid="GHX1Y2";
    $username ="Jhon Doe";
    $useremail="mailid@domain.com";
    $userprofile="Uploads/default_profile.png";
}
?>