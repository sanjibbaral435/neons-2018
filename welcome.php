<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['pnr']) || empty($_SESSION['pnr'])){
  header("location: login.php");
  exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo $_SESSION['pnr']; ?></b>. Welcome to our site.</h1>
    </div>
    <p><a href="logout.php" class="btn btn-danger">Go Back to Request Page</a></p>
</body>
</html>

<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'user_db');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
//Swap seats
//1. request aayi,uski choice available hai ya nahi
$curr_pnr = $_SESSION['pnr'];
echo $curr_pnr;
$choiceseatsql = "SELECT choice_seat FROM user_req WHERE pnr = $curr_pnr";
$currentseatsql = "SELECT current_seat FROM user_req WHERE pnr = $curr_pnr";

$choiceseat = mysqli_query($link, $choiceseatsql);
$choiceseat_type;
if(mysqli_num_rows($choiceseat) > 0){
	$row = mysqli_fetch_assoc($choiceseat);
	$choiceseat_type = $row["choice_seat"];
	//echo $row["choice_seat"];
}

$currentseat = mysqli_query($link, $currentseatsql);
$currentseat_type;
if(mysqli_num_rows($currentseat) > 0){
	$row = mysqli_fetch_assoc($currentseat);
	$currentseat_type = $row["current_seat"];
	//echo $row["current_seat"];
}

echo "Choice seat type: " . $choiceseat_type . "Current seat type: " . $currentseat_type . "";

$pnrnosql = "SELECT pnr FROM user_req WHERE choice_seat = '$currentseat_type' AND current_seat = '$choiceseat_type'";
echo "\n";
echo $pnrnosql;
$pnrno_query = mysqli_query($link, $pnrnosql);
$pnr_no = "";
if(mysqli_num_rows($pnrno_query) > 0){
	$row = mysqli_fetch_assoc($pnrno_query);
	$pnr_no = $row["pnr"];
	echo $row["pnr"];
}else{
	echo " Nothing ";
}
echo "PNR NO: " . $pnr_no . "";
//if($seatno > 0){
	//echo "Match found. Your new seat no is :";
	//echo $seatno;
//}

//DELETE FROM user_req WHERE seatnumber=$seatno;
//DELETE FROM user_req WHERE pnr=$pnr;
// Close connection
mysqli_close($link);
?>