<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}

if (!isset($_SESSION['admin'])) {
    header('location: index.php');
}

if (!isset($_GET['sosid'])) {
    header('location: admin_manage_sos');
}

include('inc/header.php');
?>

<title>Manage Supply Office Staff</title>

<style>
    body {
        font-family: 'Poppins';
        width: 100%;
        height: auto;
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;

    }

    a {
        text-decoration: none;
    }
</style>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>

<?php include('inc/admincontainer.php'); ?>
<?php if (isset($_SESSION['admin'])) : ?>

    <?php global $sosID;
    $sosID = $_GET['sosid'];

    $sql1 = "SELECT item.categoryID, category_name, sum(quantity) as totalqty FROM item, category, supply_office_staff WHERE category.categoryID = item.categoryID AND supply_office_staff.staffID=item.staffID AND category.categoryID= 1 AND supply_office_staff.staffID = $sosID GROUP BY category.categoryID";
    $totalfetch = mysqli_query($db, $sql1);
    if (mysqli_num_rows($totalfetch) > 0) {
        $data1 = mysqli_fetch_assoc($totalfetch);
        $totalqty = $data1['totalqty'];
    } else {
        $totalqty = 0;
    }




    $sql1fetch = "SELECT item.categoryID, category_name, sum(qty_transferred) as totaltransfer FROM item, category, supply_office_staff, item_transfer WHERE item.itemid = item_transfer.itemID AND category.categoryID = item.categoryID AND supply_office_staff.staffID=item.staffID AND category.categoryID= 1 AND supply_office_staff.staffID = $sosID GROUP BY category.categoryID";
    $totalfetch1 = mysqli_query($db,  $sql1fetch);
    if (mysqli_num_rows($totalfetch1) > 0) {
        $data1 = mysqli_fetch_assoc($totalfetch1);
        $totaltransfer = $data1['totaltransfer'];
    } else {
        $totaltransfer = 0;
    }

    $remainder = $totalqty - $totaltransfer;





    ////januray
    $sql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='january' AND year =2023 GROUP BY category.categoryID";
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
    $sqlfeb1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='february' AND year =2023 GROUP BY category.categoryID";
    $febdataset1 = mysqli_query($db, $sqlfeb1);
    if (mysqli_num_rows($febdataset1) > 0) {
        $febdata = mysqli_fetch_assoc($febdataset1);
        $febavailablecount = $febdata['available_qty'];
        $febdecomcount = $febdata['unavailable1_qty'];
        $febrepaircount = $febdata['unavailable2_qty'];
    } else {
        $febavailablecount = 0;
        $febdecomcount = 0;
        $febrepaircount = 0;
    }




    // MARCHHHHHHHHHHHHHH
    $marchsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='march' AND year =2023 GROUP BY category.categoryID";
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
    $aprilsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='april' AND year =2023 GROUP BY category.categoryID";
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
    $maysql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='may' AND year =2023 GROUP BY category.categoryID";
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
    $junesql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='june' AND year =2023 GROUP BY category.categoryID";
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
    $julysql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='july' AND year =2023 GROUP BY category.categoryID";
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
    $augsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='august' AND year =2023 GROUP BY category.categoryID";
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
    $septsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='september' AND year =2023 GROUP BY category.categoryID";
    $septdataset1 = mysqli_query($db, $septsql1);
    if (mysqli_num_rows($septdataset1) > 0) {
        $septdata = mysqli_fetch_assoc($septdataset1);
        $septavailablecount = $septdata['available_qty'];
        $septdecomcount = $septdata['unavailable1_qty'];
        $septrepaircount = $septdata['unavailable2_qty'];
    } else {
        $septavailablecount = 0;
        $septdecomcount = 0;
        $septrepaircount = 0;
    }

    /// OCTOBER
    $octsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='october' AND year =2023 GROUP BY category.categoryID";
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
    $novsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='november' AND year =2023 GROUP BY category.categoryID";
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
    $decsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 1 AND supply_office_staff.staffID =$sosID AND month='december' AND year =2023 GROUP BY category.categoryID";
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



    <div class="col-11 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <?php
            $dataset = $db->query("SELECT * from  supply_office_staff WHERE staffID = $sosID") or die("Error Query");
            if (mysqli_num_rows($dataset) > 0) {
                while ($data = $dataset->fetch_array()) {

                    $name = $data[1];
                }
            }
            ?>
            <center>
                <h3><b>ITEM MAGANEMENT: <?php echo  strtoupper($name); ?></b></h3>
            </center><br>
            <div class="col-sm mb-2" align="right">
                <!-- <button type="button" onclick="location.href='admin_view_sos.php?sosid=<?php echo $sosID; ?>'" class="btn btn-primary">Print Item Management Record</button> -->
            </div>
            <div class="row">
                <div style="overflow-x:auto;">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Category</th>
                                <!-- <th scope="col">Staff ID</th> -->
                                <th scope="col">Name</th>
                                <th scope="col">Serial No.</th>
                                <th scope="col">Description</th>
                                <th scope="col">PPP</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Analytics</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // $sql = "select * from item WHERE staffID = $sosID";
                            $sql = "select itemid, staffID,  category_name, item_name, serialno, item_desc, cost, date_purchased, quantity, item.categoryID from item, category WHERE staffID = $sosID AND item.categoryID = category.categoryID";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    $ppp = number_format(($data[6] / $data[8]), 2);
                                    //<td>$data[2]</td>
                                    echo "<tr>
                  
      <td> $data[0]</td>
      <td>$data[2]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>
      <td>$data[5]</td>
      <td>$ppp</td>
      <td>$data[6]</td>
      <td>$data[7]</td>
      <td>$data[8]</td>
       <td> <a href=\"sos_update_item.php?updateid=$data[0] && staffID=$data[1]\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"sos_manage_item.php?item_delid=$data[0]\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
       <td> <a href=\"admin_view_sos_datachart.php?itemid=" . $data[0] . "&& catID=" . $data[9] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i> Analytics</a></td>
       </tr>";
                                }
                            } else {
                                echo "Empty resultset";
                            }
                            echo "</tbody>
</table>
</div>"; ?>


                </div>
            </div>

        </div>


        <div class="col-10 mx-auto my-5 bg-light rounded">
            <input type="hidden" name="year" id="itemID" value="<?php echo $itemid; ?>">

            <div class="col-sm-8 mx-auto p-5">
                <center>
                    <h3 id="title"><b>EQUIPMENT : QUANTITY TRANSFERRED</b></h3>
                </center><br>

                <div>
                    <center><canvas id="TransferChart" style="width:100%;max-width:800px"></canvas></center>
                </div>
                <br>

                <h5 style="text-align: justify;"><?php
                                                    if (($totaltransfer == 0) && ($remainder == 0) && ($totalqty == 0)) {
                                                        echo "<b>No equipment handling yet</b>";
                                                    } else if (($totaltransfer == 0) && ($remainder == $totalqty)) {
                                                        echo "100% of the supply inventory, or " . $totalqty . " items, have not been transferred to a Faculty In Charge.";
                                                    } else if ($totaltransfer  == $totalqty) {
                                                        $transfpercent = round((($totaltransfer / $totalqty) * 100), 2);
                                                        $nottransfpercent = round((($remainder / $totalqty) * 100), 2);
                                                        echo $transfpercent . "% of the equipment inventory, or " . $totaltransfer . " out of " . $totalqty . " items, have been transferred to the Faculty In Charge.";
                                                    } else {
                                                        $transfpercent = round((($totaltransfer / $totalqty) * 100), 2);
                                                        $nottransfpercent = round((($remainder / $totalqty) * 100), 2);
                                                        echo $transfpercent . "% of the equipment inventory, or " . $totaltransfer . " out of " . $totalqty . " items, have been transferred to the Faculty In Charge, while the remaining " . $nottransfpercent . "% or " . $remainder . " items have not been transferred.";
                                                    }
                                                    ?></h5>

            </div>
        </div>

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

        $sql1 = "SELECT item.categoryID, category_name, sum(quantity) as totalqty FROM item, category, supply_office_staff WHERE category.categoryID = item.categoryID AND supply_office_staff.staffID=item.staffID AND category.categoryID= 2 AND supply_office_staff.staffID = $sosID GROUP BY category.categoryID";
        $totalfetch = mysqli_query($db, $sql1);
        if (mysqli_num_rows($totalfetch) > 0) {
            $data1 = mysqli_fetch_assoc($totalfetch);
            $totalqty2 = $data1['totalqty'];
        } else {
            $totalqty2 = 0;
        }

        $sql1fetch = "SELECT item.categoryID, category_name, sum(qty_transferred) as totaltransfer FROM item, category, supply_office_staff, item_transfer WHERE item.itemid = item_transfer.itemID AND category.categoryID = item.categoryID AND supply_office_staff.staffID=item.staffID AND category.categoryID= 2 AND supply_office_staff.staffID = $sosID GROUP BY category.categoryID";
        $totalfetch1 = mysqli_query($db,  $sql1fetch);
        if (mysqli_num_rows($totalfetch1) > 0) {
            $data1 = mysqli_fetch_assoc($totalfetch1);
            $totaltransfer2 = $data1['totaltransfer'];
        } else {
            $totaltransfer2 = 0;
        }
        $remainder2 = $totalqty2 - $totaltransfer2;

        ?>

        <div class="col-10 mx-auto my-5 bg-light rounded">
            <input type="hidden" name="year" id="itemID" value="<?php echo $itemid; ?>">

            <div class="col-sm-8 mx-auto p-5">
                <center>
                    <h3 id="title"><b>SUPPLY: QUANTITY TRANSFERRED</b></h3>
                </center><br>

                <div>
                    <center><canvas id="TransferChart2" style="width:100%;max-width:800px"></canvas></center>
                </div>
                <br>
                <h5 style="text-align: justify;"><?php
                                                    if (($totaltransfer2 == 0) && ($remainder2 == 0) && ($totalqty2 == 0)) {
                                                        echo "<b>No supply handling yet</b>";
                                                    } else if (($totaltransfer2 == 0) && ($remainder2 == $totalqty2)) {
                                                        echo "100% of the supply inventory, or " . $totalqty2 . " items, have not been transferred to a Faculty In Charge.";
                                                    } else if ($totaltransfer2  == $totalqty2) {
                                                        $transfpercent2 = round((($totaltransfer2 / $totalqty2) * 100), 2);
                                                        $nottransfpercent2 = round((($remainder2 / $totalqty2) * 100), 2);
                                                        echo $transfpercent2 . "% of the supply inventory, or " . $totaltransfer2 . " out of " . $totalqty2 . " items, have been transferred to the Faculty In Charge.";
                                                    } else {
                                                        $transfpercent2 = round((($totaltransfer2 / $totalqty2) * 100), 2);
                                                        $nottransfpercent2 = round((($remainder2 / $totalqty2) * 100), 2);
                                                        echo $transfpercent2 . "% of the supply inventory, or " . $totaltransfer2 . " out of " . $totalqty2 . " items, have been transferred to the Faculty In Charge, while the remaining " . $nottransfpercent2 . "% or " . $remainder2 . " items have not been transferred.";
                                                    }
                                                    ?></h5>

            </div>
        </div>



        <div class="col-10 mx-auto my-5 bg-light rounded">
            <div class="col-sm-12 mx-auto p-5">
                <center>
                    <h3 id="title"><b>SUPPLY: OVERALL REPORT FOR THE YEAR OF 2023</b></h3>
                </center><br>


                <div>
                    <center><canvas id="overallChart2" style="width:100%;max-width:800px"></canvas></center>
                </div>
            </div>
        </div>

        <?php


        ////januray
        $sql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='january' AND year =2023 GROUP BY category.categoryID";
        $dataset1 = mysqli_query($db, $sql1);
        if (mysqli_num_rows($dataset1) > 0) {
            $data1 = mysqli_fetch_assoc($dataset1);
            $available2count = $data1['available_qty'];
            $consumedcount = $data1['unavailable1_qty'];
            $expiredcount = $data1['unavailable2_qty'];
        } else {
            $available2count = 0;
            $consumedcount = 0;
            $expiredcount = 0;
        }



        //////////////////February///////////////////////////////
        $sqlfeb1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='february' AND year =2023 GROUP BY category.categoryID";
        $febdataset1 = mysqli_query($db, $sqlfeb1);
        if (mysqli_num_rows($febdataset1) > 0) {
            $febdata = mysqli_fetch_assoc($febdataset1);
            $febavailable2count = $febdata['available_qty'];
            $febconsumedcount = $febdata['unavailable1_qty'];
            $febexpiredcount = $febdata['unavailable2_qty'];
        } else {
            $febavailable2count = 0;
            $febconsumedcount = 0;
            $febexpiredcount = 0;
        }




        // MARCHHHHHHHHHHHHHH
        $marchsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='march' AND year =2023 GROUP BY category.categoryID";
        $marchdataset1 = mysqli_query($db, $marchsql1);
        if (mysqli_num_rows($marchdataset1) > 0) {
            $marchdata = mysqli_fetch_assoc($marchdataset1);
            $marchavailable2count = $marchdata['available_qty'];
            $marchconsumedcount = $marchdata['unavailable1_qty'];
            $marchexpiredcount = $marchdata['unavailable2_qty'];
        } else {
            $marchavailable2count = 0;
            $marchconsumedcount = 0;
            $marchexpiredcount = 0;
        }

        /// APRIL
        $aprilsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='april' AND year =2023 GROUP BY category.categoryID";
        $aprildataset1 = mysqli_query($db, $aprilsql1);
        if (mysqli_num_rows($aprildataset1) > 0) {
            $aprildata = mysqli_fetch_assoc($aprildataset1);
            $aprilavailable2count = $aprildata['available_qty'];
            $aprilconsumedcount = $aprildata['unavailable1_qty'];
            $aprilexpiredcount = $aprildata['unavailable2_qty'];
        } else {
            $aprilavailable2count = 0;
            $aprilconsumedcount = 0;
            $aprilexpiredcount = 0;
        }


        /// MAY
        $maysql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='may' AND year =2023 GROUP BY category.categoryID";
        $maydataset1 = mysqli_query($db, $maysql1);
        if (mysqli_num_rows($maydataset1) > 0) {
            $maydata = mysqli_fetch_assoc($maydataset1);
            $mayavailable2count = $maydata['available_qty'];
            $mayconsumedcount = $maydata['unavailable1_qty'];
            $mayexpiredcount = $maydata['unavailable2_qty'];
        } else {
            $mayavailable2count = 0;
            $mayconsumedcount = 0;
            $mayexpiredcount = 0;
        }


        /// JUNE
        $junesql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='june' AND year =2023 GROUP BY category.categoryID";
        $junedataset1 = mysqli_query($db, $junesql1);
        if (mysqli_num_rows($junedataset1) > 0) {
            $junedata = mysqli_fetch_assoc($junedataset1);
            $juneavailable2count = $junedata['available_qty'];
            $juneconsumedcount = $junedata['unavailable1_qty'];
            $juneexpiredcount = $junedata['unavailable2_qty'];
        } else {
            $juneavailable2count = 0;
            $juneconsumedcount = 0;
            $juneexpiredcount = 0;
        }



        /// JULY
        $julysql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='july' AND year =2023 GROUP BY category.categoryID";
        $julydataset1 = mysqli_query($db, $julysql1);
        if (mysqli_num_rows($julydataset1) > 0) {
            $julydata = mysqli_fetch_assoc($julydataset1);
            $julyavailable2count = $julydata['available_qty'];
            $julyconsumedcount = $julydata['unavailable1_qty'];
            $julyexpiredcount = $julydata['unavailable2_qty'];
        } else {
            $julyavailable2count = 0;
            $julyconsumedcount = 0;
            $julyexpiredcount = 0;
        }

        /// AUGUST
        $augsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='august' AND year =2023 GROUP BY category.categoryID";
        $augdataset1 = mysqli_query($db, $augsql1);
        if (mysqli_num_rows($augdataset1) > 0) {
            $augdata = mysqli_fetch_assoc($augdataset1);
            $augavailable2count = $augdata['available_qty'];
            $augconsumedcount = $augdata['unavailable1_qty'];
            $augexpiredcount = $augdata['unavailable2_qty'];
        } else {
            $augavailable2count = 0;
            $augconsumedcount = 0;
            $augexpiredcount = 0;
        }

        /// SEPTEMBER
        $septsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='september' AND year =2023 GROUP BY category.categoryID";
        $septdataset1 = mysqli_query($db, $septsql1);
        if (mysqli_num_rows($septdataset1) > 0) {
            $septdata = mysqli_fetch_assoc($septdataset1);
            $septavailable2count = $septdata['available_qty'];
            $septconsumedcount = $septdata['unavailable1_qty'];
            $septexpiredcount = $septdata['unavailable2_qty'];
        } else {
            $septavailable2count = 0;
            $septconsumedcount = 0;
            $septexpiredcount = 0;
        }

        /// OCTOBER
        $octsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='october' AND year =2023 GROUP BY category.categoryID";
        $octdataset1 = mysqli_query($db, $octsql1);
        if (mysqli_num_rows($octdataset1) > 0) {
            $octdata = mysqli_fetch_assoc($octdataset1);
            $octavailable2count = $octdata['available_qty'];
            $octconsumedcount = $octdata['unavailable1_qty'];
            $octexpiredcount = $octdata['unavailable2_qty'];
        } else {
            $octavailable2count = 0;
            $octconsumedcount = 0;
            $octexpiredcount = 0;
        }


        /// NOVEMBER
        $novsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='november' AND year =2023 GROUP BY category.categoryID";
        $novdataset1 = mysqli_query($db, $novsql1);
        if (mysqli_num_rows($novdataset1) > 0) {
            $novdata = mysqli_fetch_assoc($novdataset1);
            $novavailable2count = $novdata['available_qty'];
            $novconsumedcount = $novdata['unavailable1_qty'];
            $novexpiredcount = $novdata['unavailable2_qty'];
        } else {
            $novavailable2count = 0;
            $novconsumedcount = 0;
            $novexpiredcount = 0;
        }


        /// DECEMBER
        $decsql1 = "SELECT category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, supply_office_staff, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND supply_office_staff.staffID=item.staffID AND category.categoryID = 2 AND supply_office_staff.staffID =$sosID AND month='december' AND year =2023 GROUP BY category.categoryID";
        $decdataset1 = mysqli_query($db, $decsql1);
        if (mysqli_num_rows($decdataset1) > 0) {
            $decdata = mysqli_fetch_assoc($decdataset1);
            $decavailable2count = $decdata['available_qty'];
            $decconsumedcount = $decdata['unavailable1_qty'];
            $decexpiredcount = $decdata['unavailable2_qty'];
        } else {
            $decavailable2count = 0;
            $decconsumedcount = 0;
            $decexpiredcount = 0;
        }



        ?>





        <script>
            var rem = <?php echo  $remainder2;  ?>;
            var transferred = <?php echo  $totaltransfer2; ?>;

            var xValues = ["Transferred", "Not Transferred"];
            var yValues = [transferred, rem];
            //var yValues = [0, 0, 0];
            var barColors = [
                "#2F5F98",
                "#2D8BBB",

            ];

            new Chart("TransferChart2", {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },

            });
        </script>


        <script>
            var rem = <?php echo  $remainder;  ?>;
            var transferred = <?php echo  $totaltransfer; ?>;

            var xValues = ["Transferred", "Not Transferred"];
            var yValues = [transferred, rem];
            //var yValues = [0, 0, 0];
            var barColors = [
                "#2F5F98",
                "#2D8BBB",

            ];

            new Chart("TransferChart", {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },

            });
        </script>


        <script>
            var availablecon = <?php echo $availablecount; ?>;
            var decom = <?php echo $decomcount; ?>;
            var repaircon = <?php echo $repaircount;  ?>;

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


            var rem = <?php echo  $remainder;  ?>;
            var total = <?php echo  $totaltransfer; ?>;

            var xValues = ["Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            new Chart("overallChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: "Available",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [availablecon, febavailablecon, marchavailablecon, aprilavailablecon, mayavailablecon, juneavailablecon, julyavailablecon, augavailablecon, septavailablecon, octavailablecon, novavailablecon, decavailablecon],
                        borderColor: "blue",
                        fill: true
                    }, {
                        label: "Unavailable - Decommissioned",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [decom, febdecom, marchdecom, aprildecom, maydecom, junedecom, julydecom, augdecom, septdecom, octdecom, novdecom, decdecom],
                        borderColor: "red",
                        fill: true
                    }, {
                        label: "Unavailable - In Repair",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [repaircon, febrepaircon, marchrepaircon, aprilrepaircon, mayrepaircon, junerepaircon, julyrepaircon, augrepaircon, septrepaircon, octrepaircon, novrepaircon, decrepaircon],
                        borderColor: "green",
                        fill: true
                    }, {
                        label: "Total Equipment Transferred",
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
            var available2con = <?php echo $available2count; ?>;
            var consumed = <?php echo $consumedcount; ?>;
            var expiredcon = <?php echo $expiredcount;  ?>;

            // feb
            var febavailable2con = <?php echo $febavailable2count ?>;
            var febconsumed = <?php echo $febconsumedcount ?>;
            var febexpiredcon = <?php echo $febexpiredcount ?>;

            // march
            var marchavailable2con = <?php echo $marchavailable2count ?>;
            var marchconsumed = <?php echo $marchconsumedcount ?>;
            var marchexpiredcon = <?php echo $marchexpiredcount ?>;

            // april
            var aprilavailable2con = <?php echo $aprilavailable2count ?>;
            var aprilconsumed = <?php echo $aprilconsumedcount ?>;
            var aprilexpiredcon = <?php echo $aprilexpiredcount ?>;

            // may
            var mayavailable2con = <?php echo $mayavailable2count ?>;
            var mayconsumed = <?php echo $mayconsumedcount ?>;
            var mayexpiredcon = <?php echo $mayexpiredcount ?>;

            // june
            var juneavailable2con = <?php echo $juneavailable2count ?>;
            var juneconsumed = <?php echo $juneconsumedcount ?>;
            var juneexpiredcon = <?php echo $juneexpiredcount ?>;

            // july
            var julyavailable2con = <?php echo $julyavailable2count ?>;
            var julyconsumed = <?php echo $julyconsumedcount ?>;
            var julyexpiredcon = <?php echo $julyexpiredcount ?>;

            // august
            var augavailable2con = <?php echo $augavailable2count ?>;
            var augconsumed = <?php echo $augconsumedcount ?>;
            var augexpiredcon = <?php echo $augexpiredcount ?>;

            // september
            var septavailable2con = <?php echo $septavailable2count ?>;
            var septconsumed = <?php echo $septconsumedcount ?>;
            var septexpiredcon = <?php echo $septexpiredcount ?>;

            // october
            var octavailable2con = <?php echo $octavailable2count ?>;
            var octconsumed = <?php echo $octconsumedcount ?>;
            var octexpiredcon = <?php echo $octexpiredcount ?>;

            // november
            var novavailable2con = <?php echo $novavailable2count ?>;
            var novconsumed = <?php echo $novconsumedcount ?>;
            var novexpiredcon = <?php echo $novexpiredcount ?>;

            var decavailable2con = <?php echo $decavailable2count ?>;
            var decconsumed = <?php echo $decconsumedcount ?>;
            var decexpiredcon = <?php echo $decexpiredcount ?>;


            var rem = <?php echo  $remainder;  ?>;
            var total = <?php echo  $totaltransfer2; ?>;

            var xValues = ["Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            new Chart("overallChart2", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: "Available",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [available2con, febavailable2con, marchavailable2con, aprilavailable2con, mayavailable2con, juneavailable2con, julyavailable2con, augavailable2con, septavailable2con, octavailable2con, novavailable2con, decavailable2con],
                        borderColor: "blue",
                        fill: true
                    }, {
                        label: "Consumed",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [consumed, febconsumed, marchconsumed, aprilconsumed, mayconsumed, juneconsumed, julyconsumed, augconsumed, septconsumed, octconsumed, novconsumed, decconsumed],
                        borderColor: "red",
                        fill: true
                    }, {
                        label: "Expired",
                        //data: [1, 12, 3, 4, 5, 6, 7, 8, 9, 79, 66, 78],
                        data: [expiredcon, febexpiredcon, marchexpiredcon, aprilexpiredcon, mayexpiredcon, juneexpiredcon, julyexpiredcon, augexpiredcon, septexpiredcon, octexpiredcon, novexpiredcon, decexpiredcon],
                        borderColor: "green",
                        fill: true
                    }, {
                        label: "Total Supply Transferred",
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

    <?php endif ?>
    <?php include('inc/footer.php'); ?>