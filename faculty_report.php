<?php
include('functions.php');
include('sos_function.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}

if (!isset($_SESSION['faculty_incharge'])) {
    header('location: index.php');
}


include('inc/header.php');
?>

<title>Update Item Transferred</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<style>
    body {
        font-family: 'Poppins';
        width: 100%;
        height: auto;
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;

    }

    .div1 {
        width: 80%;
        padding: 20px;
        margin: auto;
        border-radius: 20px;
        background-color: white;
    }
</style>


<?php include('inc/faculty_container.php'); ?>
<?php



$facultyID = $_SESSION['faculty_incharge']['facultyID'];

//////////////////////for total transferred

$sql1 = "select category.categoryID, category_name, sum(qty_transferred) as totaltrans FROM item, category, faculty_incharge, item_transfer WHERE item.itemid=item_transfer.itemID AND category.categoryID=item.categoryID AND faculty_incharge.facultyID=item_transfer.facultyID AND faculty_incharge.staffID = item.staffID AND faculty_incharge.facultyID=$facultyID AND category.categoryID=1 GROUP BY category.categoryID";
$totalfetch1 = mysqli_query($db, $sql1);
if (mysqli_num_rows($totalfetch1) > 0) {
    $data1 = mysqli_fetch_assoc($totalfetch1);
    $totalqty1 = $data1['totaltrans'];
} else {
    $totalqty1 = 0;
}

$sql1 = "select category.categoryID, category_name, sum(qty_transferred) as totaltrans FROM item, category, faculty_incharge, item_transfer WHERE item.itemid=item_transfer.itemID AND category.categoryID=item.categoryID AND faculty_incharge.facultyID=item_transfer.facultyID AND faculty_incharge.staffID = item.staffID AND faculty_incharge.facultyID=$facultyID AND category.categoryID=2 GROUP BY category.categoryID";
$totalfetch2 = mysqli_query($db, $sql1);
if (mysqli_num_rows($totalfetch2) > 0) {
    $data2 = mysqli_fetch_assoc($totalfetch2);
    $totalqty2 = $data2['totaltrans'];
} else {
    $totalqty2 = 0;
}

?>





<div class="col-10 mx-auto my-5 bg-light rounded">
    <div class="col-sm-12 mx-auto p-5">
        <center>
            <h3 id="title"><b>EQUIPMENT : OVERALL REPORT FOR THE YEAR OF 2023</b></h3>
        </center><br>


        <div>
            <center><canvas id="overallChart" style="width:100%;max-width:800px"></canvas></center>
        </div>
    </div>
</div>


<?php

//january
  $sql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='january' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
  $dataset1 = mysqli_query($db, $sql1);
  if (mysqli_num_rows($dataset1) > 0) {
      $data1 = mysqli_fetch_assoc($dataset1);
      $availablecount = $data1['available_qty'];
      $decomcount = $data1['unavailable1_qty'];
      $repaircount = $data1['unavailable2_qty'];
  } else {
      $availablecount = 0;
      $decomcount = 0;
      $repaircount = 0;
  }

//////////////////February///////////////////////////////
$sqlfeb1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='february' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$febdataset1 = mysqli_query($db, $sqlfeb1);
if (mysqli_num_rows($febdataset1) > 0) {
    $febdata= mysqli_fetch_assoc($febdataset1);
    $febavailablecount = $febdata['available_qty'];
    $febdecomcount = $febdata['unavailable1_qty'];
    $febrepaircount = $febdata['unavailable2_qty'];
} else {
    $febavailablecount = 0;
    $febdecomcount = 0;
    $febrepaircount = 0;
}


// MARCHHHHHHHHHHHHHH
$marchsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='march' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$marchdataset1 = mysqli_query($db, $marchsql1);
if (mysqli_num_rows($marchdataset1) > 0) {
    $marchdata = mysqli_fetch_assoc($marchdataset1);
    $marchavailablecount = $marchdata['available_qty'];
    $marchdecomcount = $marchdata['unavailable1_qty'];
    $marchrepaircount = $marchdata['unavailable2_qty'];
} else {
    $marchavailablecount = 0;
    $marchdecomcount = 0;
    $marchrepaircount = 0;
}

/// APRIL
$aprilsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='april' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$aprildataset1 = mysqli_query($db, $aprilsql1);
if (mysqli_num_rows($aprildataset1) > 0) {
    $aprildata = mysqli_fetch_assoc($aprildataset1);
    $aprilavailablecount = $aprildata['available_qty'];
    $aprildecomcount = $aprildata['unavailable1_qty'];
    $aprilrepaircount = $aprildata['unavailable2_qty'];
} else {
    $aprilavailablecount = 0;
    $aprildecomcount = 0;
    $aprilrepaircount = 0;
}


/// MAY
$maysql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='may' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$maydataset1 = mysqli_query($db, $maysql1);
if (mysqli_num_rows($maydataset1) > 0) {
    $maydata = mysqli_fetch_assoc($maydataset1);
    $mayavailablecount = $maydata['available_qty'];
    $maydecomcount = $maydata['unavailable1_qty'];
    $mayrepaircount = $maydata['unavailable2_qty'];
} else {
    $mayavailablecount = 0;
    $maydecomcount = 0;
    $mayrepaircount = 0;
}


/// JUNE
$junesql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='june' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$junedataset1 = mysqli_query($db, $junesql1);
if (mysqli_num_rows($junedataset1) > 0) {
    $junedata = mysqli_fetch_assoc($junedataset1);
    $juneavailablecount = $junedata['available_qty'];
    $junedecomcount = $junedata['unavailable1_qty'];
    $junerepaircount = $junedata['unavailable2_qty'];
} else {
    $juneavailablecount = 0;
    $junedecomcount = 0;
    $junerepaircount = 0;
}



/// JULY
$julysql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='july' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$julydataset1 = mysqli_query($db, $julysql1);
if (mysqli_num_rows($julydataset1) > 0) {
    $julydata = mysqli_fetch_assoc($julydataset1);
    $julyavailablecount = $julydata['available_qty'];
    $julydecomcount = $julydata['unavailable1_qty'];
    $julyrepaircount = $julydata['unavailable2_qty'];
} else {
    $julyavailablecount = 0;
    $julydecomcount = 0;
    $julyrepaircount = 0;
}

/// AUGUST
$augsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='august' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$augdataset1 = mysqli_query($db, $augsql1);
if (mysqli_num_rows($augdataset1) > 0) {
    $augdata = mysqli_fetch_assoc($augdataset1);
    $augavailablecount = $augdata['available_qty'];
    $augdecomcount = $augdata['unavailable1_qty'];
    $augrepaircount = $augdata['unavailable2_qty'];
} else {
    $augavailablecount = 0;
    $augdecomcount = 0;
    $augrepaircount = 0;
}

/// SEPTEMBER
$septsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='september' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$septdataset1 = mysqli_query($db, $septsql1);
if (mysqli_num_rows($septdataset1) > 0) {
    $septdata= mysqli_fetch_assoc($septdataset1);
    $septavailablecount = $septdata['available_qty'];
    $septdecomcount = $septdata['unavailable1_qty'];
    $septrepaircount = $septdata['unavailable2_qty'];
} else {
    $septavailablecount = 0;
    $septdecomcount = 0;
    $septrepaircount = 0;
}

/// OCTOBER
$octsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='october' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$octdataset1 = mysqli_query($db, $octsql1);
if (mysqli_num_rows($octdataset1) > 0) {
    $octdata = mysqli_fetch_assoc($octdataset1);
    $octavailablecount = $octdata['available_qty'];
    $octdecomcount = $octdata['unavailable1_qty'];
    $octrepaircount = $octdata['unavailable2_qty'];
} else {
    $octavailablecount = 0;
    $octdecomcount = 0;
    $octrepaircount = 0;
}


/// NOVEMBER
$novsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='november' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$novdataset1 = mysqli_query($db, $novsql1);
if (mysqli_num_rows($novdataset1) > 0) {
    $novdata = mysqli_fetch_assoc($novdataset1);
    $novavailablecount = $novdata['available_qty'];
    $novdecomcount = $novdata['unavailable1_qty'];
    $novrepaircount = $novdata['unavailable2_qty'];
} else {
    $novavailablecount = 0;
    $novdecomcount = 0;
    $novrepaircount = 0;
}


/// DECEMBER
$decsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='december' AND year =2023 AND category.categoryID= 1 GROUP BY category.categoryID";
$decdataset1 = mysqli_query($db, $decsql1);
if (mysqli_num_rows($decdataset1) > 0) {
    $decdata = mysqli_fetch_assoc($decdataset1);
    $decavailablecount = $decdata['available_qty'];
    $decdecomcount = $decdata['unavailable1_qty'];
    $decrepaircount = $decdata['unavailable2_qty'];
} else {
    $decavailablecount = 0;
    $decdecomcount = 0;
    $decrepaircount = 0;
}
?>


<div class="col-10 mx-auto my-5 bg-light rounded">
    <div class="col-sm-12 mx-auto p-5">
        <center>
            <h3 id="title"><b>SUPPLY: OVERALL REPORT FOR THE YEAR OF 2023</b></h3>
        </center><br>
        <div>
            <center><canvas id="overallChart3" style="width:100%;max-width:800px"></canvas></center>
        </div>
    </div>
</div>

<?php

//january
  $sql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='january' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
  $dataset1 = mysqli_query($db, $sql1);
  if (mysqli_num_rows($dataset1) > 0) {
      $data1 = mysqli_fetch_assoc($dataset1);
      $available3count = $data1['available_qty'];
      $consumedcount = $data1['unavailable1_qty'];
      $expiredcount = $data1['unavailable2_qty'];
  } else {
      $available3count = 0;
      $consumedcount = 0;
      $expiredcount = 0;
  }

//////////////////February///////////////////////////////
$sqlfeb1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='february' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$febdataset1 = mysqli_query($db, $sqlfeb1);
if (mysqli_num_rows($febdataset1) > 0) {
    $febdata= mysqli_fetch_assoc($febdataset1);
    $febavailable3count = $febdata['available_qty'];
    $febconsumedcount = $febdata['unavailable1_qty'];
    $febexpiredcount = $febdata['unavailable2_qty'];
} else {
    $febavailable3count = 0;
    $febconsumedcount = 0;
    $febexpiredcount = 0;
}


// MARCHHHHHHHHHHHHHH
$marchsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='march' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$marchdataset1 = mysqli_query($db, $marchsql1);
if (mysqli_num_rows($marchdataset1) > 0) {
    $marchdata = mysqli_fetch_assoc($marchdataset1);
    $marchavailable3count = $marchdata['available_qty'];
    $marchconsumedcount = $marchdata['unavailable1_qty'];
    $marchexpiredcount = $marchdata['unavailable2_qty'];
} else {
    $marchavailable3count = 0;
    $marchconsumedcount = 0;
    $marchexpiredcount = 0;
}

/// APRIL
$aprilsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='april' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$aprildataset1 = mysqli_query($db, $aprilsql1);
if (mysqli_num_rows($aprildataset1) > 0) {
    $aprildata = mysqli_fetch_assoc($aprildataset1);
    $aprilavailable3count = $aprildata['available_qty'];
    $aprilconsumedcount = $aprildata['unavailable1_qty'];
    $aprilexpiredcount = $aprildata['unavailable2_qty'];
} else {
    $aprilavailable3count = 0;
    $aprilconsumedcount = 0;
    $aprilexpiredcount = 0;
}


/// MAY
$maysql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='may' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$maydataset1 = mysqli_query($db, $maysql1);
if (mysqli_num_rows($maydataset1) > 0) {
    $maydata = mysqli_fetch_assoc($maydataset1);
    $mayavailable3count = $maydata['available_qty'];
    $mayconsumedcount = $maydata['unavailable1_qty'];
    $mayexpiredcount = $maydata['unavailable2_qty'];
} else {
    $mayavailable3count = 0;
    $mayconsumedcount = 0;
    $mayexpiredcount = 0;
}


/// JUNE
$junesql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='june' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$junedataset1 = mysqli_query($db, $junesql1);
if (mysqli_num_rows($junedataset1) > 0) {
    $junedata = mysqli_fetch_assoc($junedataset1);
    $juneavailable3count = $junedata['available_qty'];
    $juneconsumedcount = $junedata['unavailable1_qty'];
    $juneexpiredcount = $junedata['unavailable2_qty'];
} else {
    $juneavailable3count = 0;
    $juneconsumedcount = 0;
    $juneexpiredcount = 0;
}



/// JULY
$julysql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='july' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$julydataset1 = mysqli_query($db, $julysql1);
if (mysqli_num_rows($julydataset1) > 0) {
    $julydata = mysqli_fetch_assoc($julydataset1);
    $julyavailable3count = $julydata['available_qty'];
    $julyconsumedcount = $julydata['unavailable1_qty'];
    $julyexpiredcount = $julydata['unavailable2_qty'];
} else {
    $julyavailable3count = 0;
    $julyconsumedcount = 0;
    $julyexpiredcount = 0;
}

/// AUGUST
$augsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='august' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$augdataset1 = mysqli_query($db, $augsql1);
if (mysqli_num_rows($augdataset1) > 0) {
    $augdata = mysqli_fetch_assoc($augdataset1);
    $augavailable3count = $augdata['available_qty'];
    $augconsumedcount = $augdata['unavailable1_qty'];
    $augexpiredcount = $augdata['unavailable2_qty'];
} else {
    $augavailable3count = 0;
    $augconsumedcount = 0;
    $augexpiredcount = 0;
}

/// SEPTEMBER
$septsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='september' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$septdataset1 = mysqli_query($db, $septsql1);
if (mysqli_num_rows($septdataset1) > 0) {
    $septdata= mysqli_fetch_assoc($septdataset1);
    $septavailable3count = $septdata['available_qty'];
    $septconsumedcount = $septdata['unavailable1_qty'];
    $septexpiredcount = $septdata['unavailable2_qty'];
} else {
    $septavailable3count = 0;
    $septconsumedcount = 0;
    $septexpiredcount = 0;
}

/// OCTOBER
$octsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='october' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$octdataset1 = mysqli_query($db, $octsql1);
if (mysqli_num_rows($octdataset1) > 0) {
    $octdata = mysqli_fetch_assoc($octdataset1);
    $octavailable3count = $octdata['available_qty'];
    $octconsumedcount = $octdata['unavailable1_qty'];
    $octexpiredcount = $octdata['unavailable2_qty'];
} else {
    $octavailable3count = 0;
    $octconsumedcount = 0;
    $octexpiredcount = 0;
}


/// NOVEMBER
$novsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='november' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$novdataset1 = mysqli_query($db, $novsql1);
if (mysqli_num_rows($novdataset1) > 0) {
    $novdata = mysqli_fetch_assoc($novdataset1);
    $novavailable3count = $novdata['available_qty'];
    $novconsumedcount = $novdata['unavailable1_qty'];
    $novexpiredcount = $novdata['unavailable2_qty'];
} else {
    $novavailable3count = 0;
    $novconsumedcount = 0;
    $novexpiredcount = 0;
}


/// DECEMBER
$decsql1 = "SELECT item_name, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty , month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND facultyID =$facultyID AND month='december' AND year =2023 AND category.categoryID= 2 GROUP BY category.categoryID";
$decdataset1 = mysqli_query($db, $decsql1);
if (mysqli_num_rows($decdataset1) > 0) {
    $decdata = mysqli_fetch_assoc($decdataset1);
    $decavailable3count = $decdata['available_qty'];
    $decconsumedcount = $decdata['unavailable1_qty'];
    $decexpiredcount = $decdata['unavailable2_qty'];
} else {
    $decavailable3count = 0;
    $decconsumedcount = 0;
    $decexpiredcount = 0;
}
?>

<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    var availablecon = <?php echo $availablecount ?>;
    var decom = <?php echo $decomcount ?>;
    var repaircon = <?php echo $repaircount ?>;

    // feb
    var febavailablecon = <?php echo $febavailablecount ?>;
    var febdecom = <?php echo $febdecomcount ?>;
    var febrepaircon = <?php echo $febrepaircount ?>;

    // march
    var marchavailablecon = <?php echo $marchavailablecount ?>;
    var marchdecom = <?php echo $marchdecomcount ?>;
    var marchrepaircon = <?php echo $marchrepaircount ?>;

    // april
    var aprilavailablecon = <?php echo $aprilavailablecount ?>;
    var aprildecom = <?php echo $aprildecomcount ?>;
    var aprilrepaircon = <?php echo $aprilrepaircount ?>;

    // may
    var mayavailablecon = <?php echo $mayavailablecount ?>;
    var maydecom = <?php echo $maydecomcount ?>;
    var mayrepaircon = <?php echo $mayrepaircount ?>;

    // june
    var juneavailablecon = <?php echo $juneavailablecount ?>;
    var junedecom = <?php echo $junedecomcount ?>;
    var junerepaircon = <?php echo $junerepaircount ?>;

    // july
    var julyavailablecon = <?php echo $julyavailablecount ?>;
    var julydecom = <?php echo $julydecomcount ?>;
    var julyrepaircon = <?php echo $julyrepaircount ?>;

    // august
    var augavailablecon = <?php echo $augavailablecount ?>;
    var augdecom = <?php echo $augdecomcount ?>;
    var augrepaircon = <?php echo $augrepaircount ?>;

    // september
    var septavailablecon = <?php echo $septavailablecount ?>;
    var septdecom = <?php echo $septdecomcount ?>;
    var septrepaircon = <?php echo $septrepaircount ?>;

    // october
    var octavailablecon = <?php echo $octavailablecount ?>;
    var octdecom = <?php echo $octdecomcount ?>;
    var octrepaircon = <?php echo $octrepaircount ?>;

    // november
    var novavailablecon = <?php echo $novavailablecount ?>;
    var novdecom = <?php echo $novdecomcount ?>;
    var novrepaircon = <?php echo $novrepaircount ?>;

    var decavailablecon = <?php echo $decavailablecount ?>;
    var decdecom = <?php echo $decdecomcount ?>;
    var decrepaircon = <?php echo $decrepaircount ?>;

    var total = <?php echo  $totalqty1;  ?>;
    var xValues = ["Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    new Chart("overallChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "Available",
                // data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                data: [availablecon, febavailablecon, marchavailablecon, aprilavailablecon, mayavailablecon, juneavailablecon, julyavailablecon, augavailablecon, septavailablecon, octavailablecon, novavailablecon, decavailablecon],
                borderColor: "blue",
                fill: true
            }, {
                label: "Unavailable - Decommissioned",
                // data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                data: [decom, febdecom, marchdecom, aprildecom, maydecom, junedecom, julydecom, augdecom, septdecom, octdecom, novdecom, decdecom],
                borderColor: "red",
                fill: true
            }, {
                label: "Unavailable - In Repair",
                // data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                data: [repaircon, febrepaircon, marchrepaircon, aprilrepaircon, mayrepaircon, junerepaircon, julyrepaircon, augrepaircon, septrepaircon, octrepaircon, novrepaircon, decrepaircon],
                borderColor: "green",
                fill: true
            }, {
                label: "Total Equipments",
                data: [total, total, total, total, total, total, total, total, total, total, total, total],
                borderColor: "grey",
                fill: false
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    });
</script>



<script>
    var available3con = <?php echo $available3count ?>;
    var consumed = <?php echo $consumedcount ?>;
    var expiredcon = <?php echo $expiredcount ?>;

    // feb
    var febavailable3con = <?php echo $febavailable3count ?>;
    var febconsumed = <?php echo $febconsumedcount ?>;
    var febexpiredcon = <?php echo $febexpiredcount ?>;

    // march
    var marchavailable3con = <?php echo $marchavailable3count ?>;
    var marchconsumed = <?php echo $marchconsumedcount ?>;
    var marchexpiredcon = <?php echo $marchexpiredcount ?>;

    // april
    var aprilavailable3con = <?php echo $aprilavailable3count ?>;
    var aprilconsumed = <?php echo $aprilconsumedcount ?>;
    var aprilexpiredcon = <?php echo $aprilexpiredcount ?>;

    // may
    var mayavailable3con = <?php echo $mayavailable3count ?>;
    var mayconsumed = <?php echo $mayconsumedcount ?>;
    var mayexpiredcon = <?php echo $mayexpiredcount ?>;

    // june
    var juneavailable3con = <?php echo $juneavailable3count ?>;
    var juneconsumed = <?php echo $juneconsumedcount ?>;
    var juneexpiredcon = <?php echo $juneexpiredcount ?>;

    // july
    var julyavailable3con = <?php echo $julyavailable3count ?>;
    var julyconsumed = <?php echo $julyconsumedcount ?>;
    var julyexpiredcon = <?php echo $julyexpiredcount ?>;

    // august
    var augavailable3con = <?php echo $augavailable3count ?>;
    var augconsumed = <?php echo $augconsumedcount ?>;
    var augexpiredcon = <?php echo $augexpiredcount ?>;

    // september
    var septavailable3con = <?php echo $septavailable3count ?>;
    var septconsumed = <?php echo $septconsumedcount ?>;
    var septexpiredcon = <?php echo $septexpiredcount ?>;

    // october
    var octavailable3con = <?php echo $octavailable3count ?>;
    var octconsumed = <?php echo $octconsumedcount ?>;
    var octexpiredcon = <?php echo $octexpiredcount ?>;

    // november
    var novavailable3con = <?php echo $novavailable3count ?>;
    var novconsumed = <?php echo $novconsumedcount ?>;
    var novexpiredcon = <?php echo $novexpiredcount ?>;

    var decavailable3con = <?php echo $decavailable3count ?>;
    var decconsumed = <?php echo $decconsumedcount ?>;
    var decexpiredcon = <?php echo $decexpiredcount ?>;

    var total = <?php echo  $totalqty2;  ?>;
    var xValues = ["Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    new Chart("overallChart3", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "Available",
                data: [available3con, febavailable3con, marchavailable3con, aprilavailable3con, mayavailable3con, juneavailable3con, julyavailable3con, augavailable3con, septavailable3con, octavailable3con, novavailable3con, decavailable3con],
                //data: [1, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 2],
                borderColor: "blue",
                fill: true
            }, {
                label: "Consumed",
                data: [consumed, febconsumed, marchconsumed, aprilconsumed, mayconsumed, juneconsumed, julyconsumed, augconsumed, septconsumed, octconsumed, novconsumed, decconsumed],
                //data: [0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0],
                borderColor: "green",
                fill: true
            }, {
                label: "Expired",
                data: [expiredcon, febexpiredcon, marchexpiredcon, aprilexpiredcon, mayexpiredcon, juneexpiredcon, julyexpiredcon, augexpiredcon, septexpiredcon, octexpiredcon, novexpiredcon, decexpiredcon],
                //data: [0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0],
                borderColor: "red",
                fill: true
            }, {
                label: "Total Perishable Items",
                data: [total, total, total, total, total, total, total, total, total, total, total, total],
                borderColor: "grey",
                fill: false
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }
    });
</script>






<?php include('inc/footer.php'); ?>