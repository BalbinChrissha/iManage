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
<?php if (isset($_GET['updateid'])) : ?>
    <?php global $facultyID, $checkno;

    $facultyID = $_SESSION['faculty_incharge']['facultyID']; ?>


    <?php
    $stateid = $_GET['updateid'];
    $checkno = $_GET['item_state_checkID'];

    $sql = "select * from  item_state WHERE stateID = $stateid";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {

        $sql = "SELECT item_transfer.recordno, item_last_checked.checkedID, item.itemid, item_name, qty_transferred, month, year, available_qty, unavailable1_qty, unavailable2_qty FROM item, item_transfer, item_state, item_last_checked WHERE item.itemid = item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID=item_last_checked.checkedID AND stateID = $stateid";
        $dataset = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($dataset);


        $recordno = $data['recordno'];
        $itemid = $data['itemid'];
        $item_name = $data['item_name'];
        $qty_transferred = $data['qty_transferred'];
        $checkedID = $data['checkedID'];
        $month = $data['month'];
        $year = $data['year'];
        $available_qty = $data['available_qty'];
        $unavailable1_qty = $data['unavailable1_qty'];
        $unavailable2_qty = $data['unavailable2_qty'];


        if (isset($_POST['update_itemstate_monthly'])) {

            global $db, $recorID, $conditionID, $quantity, $month, $year, $stateID, $checkno;
            global $maxcheckID;

            $checkno  =  e($_POST['checkno']);
            $stateID  =  e($_POST['stateID']);
            $recordID    =  e($_POST['recordno']);
            //$conditionID  =  e($_POST['conditionID']);
            // $month       =  e($_POST['month']);
            // $year      =  e($_POST['year']);
            $qty_transferred = e($_POST['qty_transferred']);
            $available_qty = e($_POST['available_qty']);
            $unavailable1_qty = e($_POST['unavailable1_qty']);
            $unavailable2_qty = e($_POST['unavailable2_qty']);


            $total = $available_qty + $unavailable1_qty + $unavailable2_qty;
            if (($total > $qty_transferred) || ($total < $qty_transferred)) {
                array_push($erroradd, "The record for the of $month should not be less than or exceed the transferred quantity");
            } else if ($total == $qty_transferred) {

                $state = $db->query("UPDATE item_state set available_qty = $available_qty , unavailable1_qty = $unavailable1_qty,  unavailable2_qty = $unavailable2_qty  WHERE  stateID=$stateID") or die('Error Query');
                if ($dataset) {
                    echo "<script>swal('Good job!', 'The record has been updated for the $month and year of $year!', 'success')</script>";
                } else {
                    die(mysqli_error($db));
                }
            }
        }

    ?>
        <div class="container" style="margin-top: 5%;">
            <div class="div1">
                <center>
                    <h3><b>UPDATE TRANSFERRED RECORD </b></h3>
                </center><br>
                <?php echo error_add_itemstate(); ?>
                <div class="col-sm-9 mx-auto">
                    <form action="" method="post">

                        <div class="row">
                            <div class="col-lg-6">
                                <input class="form-control mb-3" type="hidden" value="<?php echo  $checkno; ?>" name="checkno" readonly required>
                                <input class="form-control mb-3" type="hidden" value="<?php echo  $stateid; ?>" name="stateID" readonly required>

                                <input class="form-control mb-3" type="hidden" value="<?php echo  $recordno; ?>" name="recordno" readonly required>

                                <label for="">Item Name</label>
                                <input class="form-control mb-3" type="text" value="<?php echo $item_name; ?>" name="item_name" readonly required>
                            </div>
                            <div class="col-lg-6">

                                <label for="">Item ID</label>
                                <input class="form-control mb-3" value="<?php echo  $itemid; ?>" name="itemID" readonly required>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Qty. Transfered</label>
                                <input class="form-control mb-3" value="<?php echo  $qty_transferred; ?>" name="qty_transferred" readonly required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Qty: Available</label>
                                <input type="number" name="available_qty" value="<?php echo  $available_qty; ?>" class="form-control mb-3" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Qty: Unavailable - Decommissioned</label>
                                <input type="number" name="unavailable1_qty" value="<?php echo $unavailable1_qty; ?>" class="form-control mb-3" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Qty: Unavailable - In Repair</label>
                                <input type="number" name="unavailable2_qty" value="<?php echo $unavailable2_qty; ?>" class="form-control mb-3" required>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-6"> <label for="">Month</label>
                                <select name='month' class='form-select mb-3' name="month" disabled>
                                    <option value="January" <?php if ($month == 'January') {
                                                                echo "selected";
                                                            } ?>>January</option>
                                    <option value="February" <?php if ($month == 'February') {
                                                                    echo "selected";
                                                                } ?>>February</option>
                                    <option value="March" <?php if ($month == 'March') {
                                                                echo "selected";
                                                            } ?>>March</option>
                                    <option value="April" <?php if ($month == 'April') {
                                                                echo "selected";
                                                            } ?>>April</option>
                                    <option value="May" <?php if ($month == 'May') {
                                                            echo "selected";
                                                        } ?>>May</option>
                                    <option value="June" <?php if ($month == 'June') {
                                                                echo "selected";
                                                            } ?>>June</option>
                                    <option value="July" <?php if ($month == 'July') {
                                                                echo "selected";
                                                            } ?>>July</option>
                                    <option value="August" <?php if ($month == 'August') {
                                                                echo "selected";
                                                            } ?>>August</option>
                                    <option value="September" <?php if ($month == 'September') {
                                                                    echo "selected";
                                                                } ?>>September</option>
                                    <option value="October" <?php if ($month == 'October') {
                                                                echo "selected";
                                                            } ?>>October</option>
                                    <option value="November" <?php if ($month == 'November') {
                                                                    echo "selected";
                                                                } ?>>November</option>
                                    <option value="December" <?php if ($month == 'December') {
                                                                    echo "selected";
                                                                } ?>>December</option>
                                </select>
                            </div>
                            <div class="col-lg-6"><label for="">Year</label>
                                <input type="number" name="year" id="year" value="<?php echo $year; ?>" class="form-control mb-3" readonly>
                            </div>

                        </div>

                        <br>
                        <input type="submit" class="btn btn-primary" name="update_itemstate_monthly" value="Update">
                        <br><br>
                    </form>

                </div>



            </div>
        </div>

        <br><br>




    <?php
    } else {
        echo "<script>swal('The record is not found!', 'The Record is already deleted (from the database) or could not be found in the database', 'error')</script>";
        header("Refresh: 2; faculty_monthly_item_report.php");
    }

    ?>
<?php endif ?>



<?php include('inc/footer.php'); ?>