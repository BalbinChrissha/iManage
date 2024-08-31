<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'imanage');
$errors   = array();
$erroradd = array();

function e($val)
{
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}


function error_add_itemstate()
{
	global $erroradd;

	if (count($erroradd) > 0) {
		echo '<div class="alert alert-warning"> <center>';
		foreach ($erroradd as $error) {
			echo $error . '<br>';
		}
		echo '</center></div>';
	}
}



function display_error()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="alert alert-warning">';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['admin'])) {
		return true;
	} else if (isset($_SESSION['supply_office_staff'])) {
		return true;
	} else if (isset($_SESSION['faculty_incharge'])) {
		return true;
	} else {
		return false;
	}
}



if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['admin']);
	unset($_SESSION['supply_office_staff']);
	unset($_SESSION['faculty_incharge']);
	header("location: index.php");
}


if (isset($_POST['submit'])) {
	login();
}

function login()
{
	global $db, $username, $errors;

	$username = e($_POST['username']);
	$password = e($_POST['password']);


	if (count($errors) == 0) {
		$password = ($password);

		$query = "SELECT * FROM admin WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		$query1 = "SELECT * FROM supply_office_staff WHERE staff_username='$username' AND staff_password='$password' LIMIT 1";
		$results1 = mysqli_query($db, $query1);

		$query2 = "SELECT * FROM faculty_incharge WHERE faculty_username='$username' AND faculty_password='$password' LIMIT 1";
		$results2 = mysqli_query($db, $query2);


		if (mysqli_num_rows($results) == 1) {
			$logged_in_user = mysqli_fetch_assoc($results);
			$_SESSION['admin'] = $logged_in_user;
			header('location: admin_dashboard.php');
		} else if (mysqli_num_rows($results1) == 1) {
			$logged_in_sos = mysqli_fetch_assoc($results1);
			$_SESSION['supply_office_staff'] = $logged_in_sos;
			header('location: sos_dashboard.php');
		} else if (mysqli_num_rows($results2) == 1) {
			$logged_in_sos = mysqli_fetch_assoc($results2);
			$_SESSION['faculty_incharge'] = $logged_in_sos;
			header('location: faculty_dashboard.php');
		} else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}


if (isset($_GET['deleteid'])) {

	$id = $_GET['deleteid'];

	$sql = "select * from admin where adminID=$id";
	$dataset = $db->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {

		$sql = "delete from admin where adminID=$id";
		$dataset = $db->query($sql) or die("Error query");

		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been deleted!', 'success')</script>";
			header("Location: admin_manageadmin.php");
		} else {
			die(mysqli_error($db));
		}
	} else {
		echo "<script>swal('Admin ID Not Found!', 'The Record of the admin is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=admin_manageadmin.php");
	}
}



if (isset($_POST['create'])) {
	global $db, $name, $username, $password;

	$name    =  e($_POST['name']);
	$username    =  e($_POST['username']);
	$password       =  e($_POST['password']);


	$dataset = $db->query("INSERT INTO admin (admin_name, username, password) values ('$name', '$username', '$password')") or die('Error Query');
	if ($dataset) {
		echo "<script>swal('Good job!', 'The record has been succesfully added!', 'success')</script>";
		header("Location: admin_manageadmin.php");
		// header("Refresh: 3; URL=admin_manageadmin.php");
	} else {
		die(mysqli_error($db));
	}
}





//////////////////////MANAGE SUPPLY OFFICE STAFF/////////////////

if (isset($_POST['create_sos'])) {
	global $db, $employeenum, $name, $username, $password, $adminID;

	$employeenum   =  e($_POST['employeenum']);
	$name    =  e($_POST['name']);
	$username    =  e($_POST['username']);
	$password       =  e($_POST['password']);
	$adminID      =  e($_POST['adminID']);


	$dataset = $db->query("INSERT INTO supply_office_staff (staffID, staff_name, staff_username, staff_password, adminID) values ( $employeenum,'$name', '$username', '$password', $adminID)") or die('Error Query');
	if ($dataset) {
		echo "<script>swal('Good job!', 'The record has been succesfully added!', 'success')</script>";
	} else {
		die(mysqli_error($db));
	}
}

if (isset($_GET['sos_deleteid'])) {

	$id = $_GET['sos_deleteid'];

	$sql = "select * from supply_office_staff where staffID=$id";
	$dataset = $db->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {
		$sql = "delete from supply_office_staff where staffID=$id";
		$dataset = $db->query($sql) or die("Error query");

		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been deleted!', 'success')</script>";
			header("Location: admin_manage_sos.php");
		} else {
			die(mysqli_error($db));
		}
	} else {
		echo "<script>swal('Office Staff ID Not Found!', 'The Record of the admin is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=admin_manage_sos.php");
	}
}



/////////////////faculty function////////////////

if (isset($_POST['add_itemcondition'])) {
	global $db, $recorID, $conditionID, $quantity, $month, $year, $available_qty, $unavailable1_qty, $unavailable2_qty, $qty_transferred, $catid;
	global $maxcheckID;

	$catid = e($_POST['catid']);
	$recordID    =  e($_POST['recordno']);
	// $conditionID  =  e($_POST['conditionID']);
	// $quantity       =  e($_POST['quantity']);
	$qty_transferred = e($_POST['qty_transferred']);
	$available_qty = e($_POST['available_qty']);
	$unavailable1_qty = e($_POST['unavailable1_qty']);
	$unavailable2_qty = e($_POST['unavailable2_qty']);
	$month       =  e($_POST['month']);
	$year      =  e($_POST['year']);

	$verification = 0;
	$query = "SELECT recordno, item_last_checked.checkedID, month, year FROM item_state, item_last_checked WHERE recordno =$recordID AND item_last_checked.checkedID = item_state.checkedID AND month ='$month' AND year=$year";
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) == 0) {

		$total = $available_qty + $unavailable1_qty + $unavailable2_qty;
		if (($total > $qty_transferred) || ($total < $qty_transferred)) {
			array_push($erroradd, "The record for the of $month should not be less than or exceed the transferred quantity");
		} else if ($total == $qty_transferred) {


			$dataset = $db->query("INSERT INTO item_last_checked (month, year) values ('$month', '$year')") or die('Error Query');
			if (!$dataset) {
				die(mysqli_error($db));
			}
			$getnum = $db->query("SELECT max(checkedID) as maxid FROM item_last_checked") or die("Error Query");
			if ($getnum) {
				$res = $getnum->fetch_assoc();
				$maxcheckID = $res['maxid'];
			}
			$state = $db->query("INSERT INTO item_state (recordno, checkedID, available_qty, unavailable1_qty, unavailable2_qty) values ($recordID, $maxcheckID, $available_qty, $unavailable1_qty, $unavailable2_qty)") or die('Error Query');
			if ($dataset) {
				echo "<script>swal('Good job!', 'The record of the item transferred for the month of $month and year of $year has been succesfully added!', 'success')</script>";
				header("Location: faculty_monthly_item_report.php");
			} else {
				die(mysqli_error($db));
			}
		}
	}else{
		array_push($erroradd, "There is already a record of the Item for the month of $month year of $year");

	}
}


///////////////////////////////////delete item state records//////////////////////////////////////

if (isset($_GET['item_state_delID']) && ($_GET['item_state_checkID'])) {

	$stateid = $_GET['item_state_delID'];
	$checkID = $_GET['item_state_checkID'];

	$sql = "select * from item_state where stateID=$stateid";
	$dataset = $db->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {
		$sql = "delete from supply_office_staff where staffID=$stateid";
		$dataset = $db->query($sql) or die("Error query");

		if ($dataset) {

			$sql1 = "delete from item_last_checked where checkedID=$checkID ";
			$dataset1 = $db->query($sql1) or die("Error query");
			if ($dataset1) {
				header("Location: faculty_monthly_item_report.php");
			} else {
				die(mysqli_error($db));
			}
		} else {
			die(mysqli_error($db));
		}
	} else {
		echo "<script>swal('Office Staff ID Not Found!', 'The Record of the admin is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=faculty_monthly_item_report.php");
	}
}

