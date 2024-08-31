<?php

$connect = mysqli_connect('localhost', 'root', '', 'imanage');
$errors   = array();


function display_error_sos()
{
	global $errors;

	if (count($errors) > 0) {
		echo '<div class="alert alert-warning"> <center>';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</center></div>';
	}
}



// array_push($errors, "Wrong username/password combination");


function a($val)
{
	global $connect;
	return mysqli_real_escape_string($connect, trim($val));
}



//////////////////////create faculty in charge and delete /////////////////////////////////
if (isset($_POST['add_faculty_incharge'])) {
	global $connect, $facultyno, $depno, $staffID, $faculty_name, $faculty_username, $faculty_pass, $roomno, $roomname;

	$facultyno = a($_POST['employno']);
	$depno = a($_POST['depno']);
	$staffID = a($_POST['staffID']);
	$faculty_name = a($_POST['name']);
	$faculty_username = a($_POST['username']);
	$faculty_pass= a($_POST['password']);
	$roomno = a($_POST['roomno']);
	$roomname = a($_POST['roomname']);
	

	$dataset = $connect->query("INSERT INTO faculty_incharge (facultyID, departmentno, staffID, faculty_name, faculty_username, faculty_password, room_no, room_name) values ($facultyno, $depno, $staffID, '$faculty_name', '$faculty_username', '$faculty_pass', '$roomno', '$roomname')") or die('Error Query');
	if ($dataset) {
		echo "<script>swal('Good job!', 'The record has been succesfully added!', 'success')</script>";
		header("Location: sos_manage_faculty.php");
		// header("Refresh: 3; URL=admin_manageadmin.php");
	} else {
		die(mysqli_error($connect));
	}
}


if (isset($_GET['faculty_delid'])) {

	$id = $_GET['faculty_delid'];
	$sql = "select * from faculty_incharge where facultyID=$id";
	$dataset = $connect->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {

		$sql = "delete from faculty_incharge where facultyID=$id";
		$dataset = $connect->query($sql) or die("Error query");

		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been deleted!', 'success')</script>";
			header("Location: sos_manage_faculty.php");
		} else {
			die(mysqli_error($connect));
		}
	} else {
		echo "<script>swal('Faculty ID Not Found!', 'The Record of the faculty-in-charge is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=sos_manage_faculty.php");
	}
}


////////////////////////////////////////////////////////////////////////////




if (isset($_GET['item_delid'])) {

	$id = $_GET['item_delid'];

	$sql = "select * from item where itemid=$id";
	$dataset = $connect->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {

		$sql = "delete from item where itemid=$id";
		$dataset = $connect->query($sql) or die("Error query");

		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been deleted!', 'success')</script>";
			header("Location: sos_manage_item.php");
		} else {
			die(mysqli_error($connect));
		}
	} else {
		echo "<script>swal('Item ID Not Found!', 'The Record of the item is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=sos_manage_item.php");
	}
}



if (isset($_POST['create_item'])) {
	global $connect, $catID, $staffID, $item_name, $serialno, $description, $cost, $d8_purchased, $quantity, $billdate;

	$catID = a($_POST['catID']);
	$staffID = a($_POST['staffID']);
	$item_name = a($_POST['item_name']);
	$serialno = a($_POST['serialno']);
	$description = a($_POST['description']);
	$cost = a($_POST['cost']);
	$billdate = date('Y-m-d', strtotime($_POST['d8_purchased']));
	$d8_purchased = a($billdate);
	$quantity = a($_POST['quantity']);

	$dataset = $connect->query("INSERT INTO item (categoryID, staffID, item_name, serialno, item_desc, cost, date_purchased, quantity) values ($catID, $staffID, '$item_name', '$serialno', '$description', $cost, '$d8_purchased', $quantity)") or die('Error Query');
	if ($dataset) {
		echo "<script>swal('Good job!', 'The record has been succesfully added!', 'success')</script>";
		header("Location: sos_manage_item.php");
		// header("Refresh: 3; URL=admin_manageadmin.php");
	} else {
		die(mysqli_error($connect));
	}
}

///////////////transfer item//////////////////

if (isset($_POST['item_transfer'])) {
	global $connect, $itemID, $facultyID, $d8_transfer, $qty_transferred, $transdate;
	global $qty1, $name;

	//echo $_POST['itemID'];
	$qty1 = 0;

	$itemID = a($_POST['itemID']);
	$facultyID = a($_POST['facultyID']);
	$transdate = date('Y-m-d', strtotime($_POST['d8_transfer']));
	$d8_transfer = a($transdate);
	$qty_transferred = a($_POST['qty_transferred']);

	$result = $connect->query("SELECT * FROM item WHERE itemid=$itemID LIMIT 1") or die('Error Query');
	if ($result->num_rows == 1) {
		$itemqty = $result->fetch_assoc();
		$qty1 = $itemqty['quantity'];
		$name =  $itemqty['item_name'];
		
	}
	if($qty_transferred<=0){
	array_push($errors, "The item quantity should be greather than zero .Try again!");
	} else if($qty_transferred <= $qty1) {
		$dataset = $connect->query("INSERT INTO item_transfer (itemID, facultyID, date_transferred, qty_transferred) values ( $itemID, $facultyID, '$d8_transfer', $qty_transferred)") or die('Error Query');
		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been succesfully added!', 'success')</script>";
			header("Location:sos_transfer_item.php");
			// header("Refresh: 3; URL=admin_manageadmin.php");
		} else {
			die(mysqli_error($connect));
		}
	} else {
		array_push($errors, "The item $name only have quantity of $qty1, which inadequate for the quantity ($qty_transferred) of the item being transferred. Try again!");
	}
}


if (isset($_GET['item_trans_recordno'])) {

	$id = $_GET['item_trans_recordno'];

	$sql = "select * from item_transfer where recordno=$id";
	$dataset = $connect->query($sql) or die("Error query");

	if (mysqli_num_rows($dataset) > 0) {

		$sql = "delete from item_transfer where recordno=$id";
		$dataset = $connect->query($sql) or die("Error query");

		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been deleted!', 'success')</script>";
			header("Location: sos_transfer_item.php");
		} else {
			die(mysqli_error($connect));
		}
	} else {
		echo "<script>swal('Record No. Not Found!', 'The Record of the Item Transferred is already deleted (from the database) or could not be found in the database', 'error')</script>";
		header("Refresh: 2; URL=sos_transfer_item.php");
	}
}



if (isset($_POST['update_item_transfer'])) {
	global $connect, $itemID, $facultyID, $d8_transfer, $qty_transferred, $transdate, $recordno;
	global $qty1, $name;

	//echo $_POST['itemID'];
	$qty1 = 0;
	$recordno =  a($_POST['recordno']);
	$itemID = a($_POST['itemID']);
	$facultyID = a($_POST['facultyID']);
	$transdate = date('Y-m-d', strtotime($_POST['d8_transfer']));
	$d8_transfer = a($transdate);
	$qty_transferred = a($_POST['qty_transferred']);

	$result = $connect->query("SELECT * FROM item WHERE itemid=$itemID LIMIT 1") or die('Error Query');
	if ($result->num_rows == 1) {
		$itemqty = $result->fetch_assoc();
		$qty1 = $itemqty['quantity'];
		$name =  $itemqty['item_name'];
		
	}
	if($qty_transferred<=0){
	array_push($errors, "The item quantity should be greather than zero .Try again!");
	} else if($qty_transferred <= $qty1) {
		$dataset = $connect->query("UPDATE item_transfer SET itemID = $itemID, facultyID = $facultyID, date_transferred=  '$d8_transfer', qty_transferred  = $qty_transferred WHERE recordno =$recordno ") or die('Error Query');
		if ($dataset) {
			echo "<script>swal('Good job!', 'The record has been succesfully updated!', 'success')</script>";
			header("Location:sos_transfer_item.php");
		} else {
			die(mysqli_error($connect));
		}
	} else {
		array_push($errors, "The item $name only have quantity of $qty1, which inadequate for the quantity ($qty_transferred) of the item being transferred. Try again!");
	}
}