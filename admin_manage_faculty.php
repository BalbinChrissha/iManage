<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}

if (!isset($_SESSION['admin'])) {
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

<?php include('inc/admincontainer.php'); ?>
<?php if (isset($_SESSION['admin'])) : ?>


    <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <center>
                <h3><bFACULTY-IN-CHARGE< /b></h3>
            </center><br>
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
                                <th scope="col">Reports</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = " SELECT facultyID, dep_name, faculty_name, faculty_username, faculty_password, room_no, room_name FROM faculty_incharge, department WHERE faculty_incharge.departmentno = department.departmentno";
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
              <td> <a href=\"admin_view_faculty.php?facultyid=$data[0]\" ><i input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i>Analytics</a></td>

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

    <?php endif ?>
    <?php include('inc/footer.php'); ?>