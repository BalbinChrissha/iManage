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
    $sql = "select * from  faculty_incharge where facultyID=$id";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {

        $sql = "Select * from faculty_incharge where facultyID=$id";
        $dataset = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($dataset);


        $facultyID = $data['facultyID'];
        $departmentno = $data['departmentno'];
        $staffID = $data['staffID'];
        $faculty_name = $data['faculty_name'];
        $faculty_username = $data['faculty_username'];
        $faculty_password = $data['faculty_password'];
        $room_no = $data['room_no'];
        $room_name = $data['room_name'];

        function update_faculty($facultyno, $depno, $staffID, $faculty_name, $faculty_username, $faculty_pass, $roomno, $roomname, $id)
        {
            $connect = mysqli_connect('localhost', 'root', '', 'imanage');
            $dataset = $connect->query("UPDATE faculty_incharge SET facultyID=$facultyno, departmentno=$depno, staffID=$staffID , faculty_name = '$faculty_name',  faculty_username = '$faculty_username', faculty_password = '$faculty_pass', room_no = '$roomno', room_name = '$roomname' WHERE facultyID =$id") or die("Error query");
            if ($dataset) {
                echo "<script>swal('Good job!', 'The record has been succesfully updated!', 'success')</script>";
            } else {
                die(mysqli_error($connect));
            }
        }


        if (isset($_POST['update_faculty'])) {
            update_faculty(
                $_POST['employno'],
                $_POST['depno'],
                $_POST['staffID'],
                $_POST['name'],
                $_POST['username'],
                $_POST['password'],
                $_POST['roomno'],
                $_POST['roomname'],
                $id
            );
        }







    ?>
        <div class="container" style="margin-top: 2%;">
            <div class="div1">
                <center>
                    <h3><b>UPDATE FACULTY-IN-CHARGE</b></h3>
                </center><br>
                <div class="col-sm-9 mx-auto">
                    <form action="" method="post">
                        <div class="mb-3"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Employee Number</label>
                                <input class="form-control mb-3" type="number" name="employno" value="<?php echo $facultyID; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Department</label>
                                <?php

                                $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                if ($connect) {
                                    $result =  $connect->query("SELECT * FROM department") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='depno' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value='$rows[0]'";
                                                if ($rows[0] == $departmentno) {
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
                            <div class="col-sm-6"> <label for="">Name</label>
                                <input class="form-control" type="text" name="name" value="<?php echo $faculty_name; ?>" required />
                            </div>
                            <div class="col-sm-6"><label for="">Username</label>
                                <input type="text" name="username" class="form-control mb-3" value="<?php echo $faculty_username; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6"> <label for="">Password</label>
                                <input class="form-control" type="password" name="password" value="<?php echo $faculty_password; ?>" minlength="6" maxlength="8" required />
                            </div>
                            <div class="col-sm-6"><label for="">Room No.</label>
                                <input type="text" name="roomno" value="<?php echo $room_no; ?>" class="form-control mb-3" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6"><label for="">Room Name</label>
                                <input type="text" name="roomname" value="<?php echo $room_name; ?>" class="form-control mb-3" required>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" name="update_faculty" value="Update">
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