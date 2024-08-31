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



if ((!isset($_GET['addstate'])) && (!isset($_GET['catid']))) {
    header('location: faculty_monthly_item_report.php');
}

global $recordno;
$recordno = $_GET['addstate'];
$catID =  $_GET['catid'];


if ($catID == 2) {
    header("location: faculty_manage2_itemstate.php?addstate=$recordno && catid=$catID");
}


include('inc/header.php');
?>

<title>ADD ITEM CONDITION MONTHLY</title>

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
<?php if ((isset($_GET['addstate'])) && (isset($_GET['catid']))) : ?>

    <?php


    $sql = "select item_name, item_transfer.itemID, qty_transferred from item, item_transfer where item.itemid=item_transfer.itemID AND recordno=$recordno";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {
        $data = mysqli_fetch_assoc($dataset);
        $name = $data['item_name'];
        $itemID = $data['itemID'];
        $qty_transferred = $data['qty_transferred'];







    ?>
        <div class="container" style="margin-top: 2%;">
            <div class="div1">
                <center>
                    <h3><b>UPDATE ITEM STATE </b></h3>
                </center><br>
                <?php echo error_add_itemstate(); ?>
                <div class="col-sm-9 mx-auto">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                            <input class="form-control mb-3" type="hidden" value="<?php echo  $catID; ?>" name="catid" readonly required>
                                <input class="form-control mb-3" type="hidden" value="<?php echo  $recordno; ?>" name="recordno" readonly required>
                                <label for="">Item Name</label>
                                <input class="form-control mb-3" type="text" value="<?php echo  $name; ?>" name="item_name" readonly required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Item ID</label>
                                <input class="form-control mb-3" value="<?php echo  $itemID; ?>" name="itemID" readonly required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Qty. Transfered</label>
                                <input class="form-control mb-3" value="<?php echo  $qty_transferred; ?>" name="qty_transferred" readonly required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Qty: Available</label>
                                <input type="number" name="available_qty" class="form-control mb-3" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Qty: Unavailable - Decommissioned</label>
                                <input type="number" name="unavailable1_qty" class="form-control mb-3" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Qty: Unavailable - In Repair</label>
                                <input type="number" name="unavailable2_qty" class="form-control mb-3" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6"> <label for="">Month</label>
                                <select name='month' class='form-select mb-3' name="month" required>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col-lg-6"><label for="">Year</label>
                                <input type="number" name="year" id="year" class="form-control mb-3" required>
                            </div>

                        </div>

                        <input type="submit" class="btn btn-primary" name="add_itemcondition" value="Update">
                        <br><br>
                    </form>

                </div>



            </div>
        </div>

        <br><br>




    <?php
    } else {
        echo "<script>swal('Record ID Not Found!', 'The Item is already deleted (from the database) or could not be found in the database', 'error')</script>";
        // header("Refresh: 2; URL=faculty_monthly_item_report.php");
    }

    ?>




<?php endif ?>






<?php include('inc/footer.php'); ?>