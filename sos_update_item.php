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

<title>Manage Admin</title>

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

    <?php
    $id = $_GET['updateid'];
    $sql = "select * from  item where itemid=$id";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {

        $sql = "Select * from item where itemid=$id";
        $dataset = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($dataset);


        $itemid = $data['itemid'];
        $categoryID = $data['categoryID'];
        // echo   $categoryID ;
        $item_name = $data['item_name'];
        $serialno = $data['serialno'];
        $item_desc = $data['item_desc'];
        $cost = $data['cost'];
        $date_purchased = $data['date_purchased'];
        $quantity = $data['quantity'];

        function update_item($catID, $staffID, $name, $serialno, $desc, $cost, $date_purch, $quantity, $id)
        {
            $connect = mysqli_connect('localhost', 'root', '', 'imanage');
            $dataset = $connect->query("UPDATE item SET categoryID=$catID, staffID=$staffID ,item_name = '$name', serialno='$serialno', item_desc = '$desc', cost = $cost, date_purchased='$date_purch', quantity='$quantity' WHERE itemID =$id") or die("Error query");
            if ($dataset) {
                echo "<script>swal('Good job!', 'The record has been succesfully updated!', 'success')</script>";
            } else {
                die(mysqli_error($connect));
            }
        }


        if (isset($_POST['update_item'])) {
            update_item($_POST['catID'], $_POST['staffID'], $_POST['item_name'], $_POST['serialno'],  $_POST['description'], $_POST['cost'], $_POST['d8_purchased'], $_POST['quantity'], $id);
        }







    ?>
        <div class="container" style="margin-top: 2%;">
            <div class="div1">
                <center>
                    <h3><b>UPDATE ITEM / INVENTORY </b></h3>
                </center><br>
                <div class="col-sm-9 mx-auto">
                    <form action="" method="post">
                        <div class="mb-3"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Item Category</label>
                                <?php

                                $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                if ($connect) {
                                    $result =  $connect->query("SELECT * FROM category") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='catID' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'";
                                                if ($rows[0] == $categoryID) {
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
                                <label for="">Item Name</label>
                                <input class="form-control mb-3" value="<?php echo  $item_name; ?>" name="item_name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6"> <label for="">Serial No.</label>
                                <input type="text" name="serialno" value="<?php echo $serialno; ?>" class="form-control mb-3" required>
                            </div>
                            <div class="col-lg-6"> <label for="">Description</label>
                                <textarea class="form-control" name="description" rows="3" required><?php echo $item_desc; ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6"> <label for="">Overall Cost</label>
                                <input type="number" name="cost" value="<?php echo $cost; ?>" class="form-control mb-3" required>
                            </div>
                            <div class="col-lg-6"><label for="">Quantity</label>
                                <input type="number" name="quantity" value="<?php echo $quantity; ?>" class="form-control mb-3" required>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6"><label for="">Date Purchased</label>
                                <input type="date" name="d8_purchased" value="<?php echo $date_purchased; ?>" class="form-control mb-3" required>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="update_item" value="Update">
                        <br><br>
                    </form>

                </div>



            </div>
        </div>

        <br><br>




    <?php
    } else {
        echo "<script>swal('Item ID Not Found!', 'The Item is already deleted (from the database) or could not be found in the database', 'error')</script>";
        header("Refresh: 2; URL=sos_manage_item.php");
    }

    ?>
<?php endif ?>



<?php include('inc/footer.php'); ?>