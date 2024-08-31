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
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;

    }
</style>


<?php include('inc/admincontainer.php'); ?>
<?php if (isset($_GET['updateid'])) : ?>

    <?php
    $id = $_GET['updateid'];
    $adminID = $_GET['updateid'];
    $sql = "select * from admin where adminID=$id";
    $dataset = $db->query($sql) or die("Error query");


    if (mysqli_num_rows($dataset) > 0) {

        $sql = "Select * from admin where adminID=$id";
        $dataset = mysqli_query($db, $sql);
        $data = mysqli_fetch_assoc($dataset);


        $adminID = $data['adminID'];
        $name = $data['admin_name'];
        $username = $data['username'];
        $password = $data['password'];

        function update_record($name, $username, $password, $adminID)
        {
            $db = mysqli_connect('localhost', 'root', '', 'imanage');
            $dataset = $db->query("UPDATE admin SET admin_name='$name', username='$username' , password = '$password' WHERE adminID =$adminID") or die("Error query");
            if ($dataset) {
                echo "<script>swal('Good job!', 'The record has been succesfully updated!', 'success')</script>";
            } else {
                die(mysqli_error($db));
            }
        }


        if (isset($_POST['update'])) {
            update_record($_POST['name'], $_POST['username'], $_POST['password'], $id);
        }





    ?>

        <div class="container" style="margin-top: 5%;">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5">
                        <div class="card-body d-flex flex-column ">
                            <br>
                            <div class="col-10 mx-auto">
                                <center><span class="sign">
                                        <h4>Update Admin<h4>
                                    </span></center> <br>
                                <form class="text-center" action=" " method="post">
                                    <div class="mb-3">
                                        <div align="left" ;>Name</div><input class="form-control" name="name" placeholder="Name" value="<?php echo $name; ?>" required />
                                    </div>
                                    <div class="mb-3">
                                        <div align="left" ;>Username</div><input class="form-control" name="username" placeholder="User Name" required value="<?php echo $username; ?>" />
                                    </div>
                                    <div class="mb-3">
                                        <div align="left" ;>Password</div><input class="form-control" type="password" name="password" value="<?php echo $password; ?>" placeholder="Password" minlength="6" maxlength="8" required />
                                    </div><br>
                                    <div class="col-6 mb-3 mx-auto"><input type="submit" name="update" class="btn btn-primary d-block w-100" value="UPDATE"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else {
        echo "<script>swal('Admin ID Not Found!', 'The record of the Admin is already deleted (from the database) or could not be found in the database', 'error')</script>";
        header("Refresh: 2; URL=admin_manageadmin.php");
    }

    ?>
<?php endif ?>



<?php include('inc/footer.php'); ?>