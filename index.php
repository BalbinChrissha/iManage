<?php
include('inc/header.php');
?>
<title>Login Page</title>
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
<?php include('inc/container.php'); ?>
<?php include('functions.php') ?>
<div class="container" style="margin-top: 8%;">
  <div class="row d-flex justify-content-center">
    <div class="col-md-6 col-xl-4">
      <div class="card mb-5">
        <div class="card-body d-flex flex-column align-items-center">
          <br>
          <div class="iconn">  <img src="images/IMANAGE3.png" width="40" height="40" alt=""></div>
          <span class="sign">Log in to your account</span> <br><br>
          <form class="text-center" action="index.php" method="post">
            <?php echo display_error(); ?>
            <div class="mb-3"><input class="form-control"  name="username" placeholder="User Name" required /></div>
            <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password" minlength="6" maxlength="12" required />
            </div><br>
            <div class="col-6 mb-3 mx-auto"><input type="submit"  name="submit" class="btn btn-primary d-block w-100" value="LOGIN"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include('inc/footer.php'); ?>