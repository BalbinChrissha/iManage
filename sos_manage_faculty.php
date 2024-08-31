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

<?php include('inc/sos_container.php'); ?>
<?php if (isset($_SESSION['supply_office_staff'])) : ?>
    <?php global $sosID;

    $sosID = $_SESSION['supply_office_staff']['staffID']; ?>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Add Faculty In Charge </b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body"><br>
                        <div class="col-sm-11 mb-3 mx-auto">
                            <div class="mb-3"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Employee Number</label>
                                    <input class="form-control mb-3" type="number" name="employno" required>
                                </div>
                                <div class="col-sm-6">

                                    <label for="">Department</label>
                                    <?php

                                    $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                    if ($connect) {
                                        $result =  $connect->query("SELECT * FROM Department") or die("Error Query");
                                        if ($result) {
                                            if ($result->num_rows >= 1) {
                                                echo "<select name='depno' class='form-select mb-3' >";
                                                while ($rows = $result->fetch_array()) {
                                                    echo "<option value=$rows[0]>$rows[1]</option>";
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
                                    <input class="form-control" type="text" name="name" required />
                                </div>
                                <div class="col-sm-6"><label for="">Username</label>
                                    <input type="text" name="username" class="form-control mb-3" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6"> <label for="">Password</label>
                                    <input class="form-control" type="password" name="password" minlength="6" maxlength="8" required />
                                </div>
                                <div class="col-sm-6"><label for="">Room No.</label>
                                    <input type="text" name="roomno" class="form-control mb-3" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6"><label for="">Room Name</label>
                                    <input type="text" name="roomname" class="form-control mb-3" required>
                                </div>
                            </div>


                        </div><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="add_faculty_incharge" value="Insert Record">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <center>
                <h3><b>MANAGE FACULTY-IN-CHARGE</b></h3>
            </center><br>
            <div class="row">
                <div class="col-sm-2 mb-2">
                </div>

                <div class="col-sm-10 mb-2" align="right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Add faculty-in-charge</button>

                </div>

            </div>

            <div class="row">
                <div style="overflow-x:auto;">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th scope="col">Employee Number</th>
                                <th scope="col">Department</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Room No.</th>
                                <th scope="col">Room Name</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Reports</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = " SELECT facultyID, dep_name, faculty_name, faculty_username, faculty_password, room_no, room_name FROM faculty_incharge, department WHERE faculty_incharge.departmentno = department.departmentno  AND staffID = $sosID ";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    echo "<tr>
  						
              <td> $data[0]</td>
              <td>$data[1]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
              <td>$data[4]</td>
              <td>$data[5]</td>
              <td>$data[6]</td>
              <td> <a href=\"sos_update_faculty.php?updateid=$data[0] && staffID=$sosID\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"sos_manage_item.php?faculty_delid=$data[0]\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
              <td> <a href=\"sos_view_faculty.php?facultyid=$data[0]\" ><i input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i>Analytics</a></td>

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

        <!-- end of first div ---------------------------------------------------------->

    <?php endif ?>

    <?php include('inc/footer.php'); ?>