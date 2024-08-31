<?php
include('functions.php');
include('sos_function.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}


if (!isset($_SESSION['supply_office_staff'])) {
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


<?php include('inc/sos_container.php'); ?>
<?php if (isset($_GET['updateid'])) : ?>
    <?php global $sosID;

    $sosID = $_SESSION['supply_office_staff']['staffID']; ?>

    <?php
    $id = $_GET['updateid'];
    $sql = "select * from  item_transfer where recordno=$id";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {

        $sql = "Select * from item_transfer where recordno=$id";
        $dataset = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($dataset);


        $recordno = $data['recordno'];
        $itemID = $data['itemID'];
        $facultyID = $data['facultyID'];
        $date_transferred = $data['date_transferred'];
        $qty_transferred = $data['qty_transferred'];


    ?>
        <div class="container" style="margin-top: 5%;">
            <div class="div1">
                <center>
                    <h3><b>UPDATE ITEM / INVENTORY </b></h3>
                </center><br>
                <?php echo display_error_sos(); ?>

                <div class="col-sm-9 mx-auto">
                    <form action="" method="post">
                        <div class="mb-3"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" value="<?php echo $recordno; ?>" name="recordno">
                                <label for="">Item</label>
                                <?php

                                $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                if ($connect) {
                                    $result =  $connect->query("SELECT itemid, CONCAT (item_name, ' : Quantity = ', quantity ) as itemquan FROM item WHERE staffID=$sosID") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='itemID' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'";
                                                if ($rows[0] == $itemID) {
                                                    echo "selected";
                                                }
                                                echo ">$rows[1]</option>";
                                            }
                                        }
                                    }
                                }

                                echo "</select>";
                                ?>

                            </div>
                            <div class="col-lg-6">
                                <label for="">Faculty In Charge</label>
                                <?php
                                if ($connect) {
                                    $result =  $connect->query("SELECT facultyID, faculty_name FROM faculty_incharge WHERE staffID=$sosID") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='facultyID' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'";
                                                if ($rows[0] == $facultyID) {
                                                    echo "selected";
                                                }
                                                echo ">$rows[1]</option>";
                                            }
                                        }
                                    }
                                }

                                echo "</select>";
                                ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6"><label for="">Date Transferred</label>
                                <input type="date" name="d8_transfer" value="<?php echo $date_transferred; ?>" class="form-control mb-3" required>
                            </div>
                            <div class="col-lg-6"><label for="">Quantity Transferred</label>
                                <input type="number" name="qty_transferred" value="<?php echo $qty_transferred; ?>" class="form-control mb-3" required>
                            </div>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" name="update_item_transfer" value="Update">
                        <br><br>
                    </form>

                </div>



            </div>
        </div>

        <br><br>




    <?php
    } else {
        echo "<script>swal('The record of the Item Transferred Not Found!', 'The Record is already deleted (from the database) or could not be found in the database', 'error')</script>";
        header("Refresh: 2; sos_transfer_item.php");
    }

    ?>
<?php endif ?>



<?php include('inc/footer.php'); ?>