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

<title>Manage Admin</title>

<style>
    body {
        font-family: 'Poppins';
        width: 100%;
        height: auto;
        background-color: pink;
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;

    }
</style>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>

<?php include('inc/admincontainer.php'); ?>
<?php if (isset($_SESSION['admin'])) : ?>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Add Admin</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body"><br>
                        <div class="col-sm-8 mb-3 mx-auto">
                            <div class="mb-3"><input class="form-control" name="name" placeholder="Full Name" required /></div>
                            <div class="mb-3"><input class="form-control" name="username" placeholder="User Name" required /></div>
                            <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" minlength="6" maxlength="8" required />
                            </div>
                        </div><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="create" value="Insert Record">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-10 mx-auto p-5">
            <center>
                <h3><b>MANAGE ADMIN</b></h3>
            </center><br>
            <div class="row">
                <div class="col-sm-2 mb-2">
                </div>

                <div class="col-sm-10 mb-2" align="right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Add Admin</button>

                </div>

            </div>
            <div class="row">
                <div style="overflow-x:auto;">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "select * from admin";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {

                                    echo "<tr>
  						
              <td> $data[0]</td>
              <td>$data[1]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
               <td> <a href=\"admin_update.php?updateid=$data[0]\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"admin_manageadmin.php?deleteid=$data[0]\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
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

        <?php endif ?>
        </div>


        <?php include('inc/footer.php'); ?>