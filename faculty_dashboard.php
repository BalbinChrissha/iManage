<?php
include('functions.php');
if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: index.php');
}

if (!isset($_SESSION['faculty_incharge'])) {
  header('location: index.php');
}

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

  a {
    text-decoration: none;
  }
</style>
<script>
  $(document).ready(function() {
    $('#table_id').DataTable();
    $('#table_id1').DataTable();
    $('#table_id2').DataTable();
  });
</script>

<?php include('inc/faculty_container.php'); ?>
<?php if (isset($_SESSION['faculty_incharge'])) : ?>
  <?php
  $facultyID = $_SESSION['faculty_incharge']['facultyID']; ?>


  <div class="col-10 mx-auto my-5 bg-light rounded">

    <div class="col-sm-12 mx-auto p-5">
      <center>
        <h3><b>TRANSFERRED ITEMS</b></h3>
      </center><br>
      <div class="col-sm mb-2" align="right">
        <!-- <button type="button" onclick="location.href='faculty_dashboard.php'" class="btn btn-primary">Print Transfer Report</button> -->

      </div>
      <div class="row">
        <div style="overflow-x:auto;">
          <table id="table_id2" class="display">
            <thead>
              <tr>
                <th scope="col">Record #</th>
                <th scope="col">Item No.</th>
                <th scope="col">Item Category</th>
                <th scope="col">Item Name</th>
                <th scope="col">Description</th>
                <th scope="col">Department</th>
                <th scope="col">Room #</th>
                <th scope="col">Date Transferred</th>
                <th scope="col">Qty. Transferred</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sql = "select recordno, item.itemid, category_name, item_name, item_desc, dep_name,  room_no, date_transferred, qty_transferred, category.categoryID FROM item, category, faculty_incharge, item_transfer, department WHERE item.itemid=item_transfer.itemID AND category.categoryID=item.categoryID AND faculty_incharge.facultyID=item_transfer.facultyID AND department.departmentno=faculty_incharge.departmentno AND faculty_incharge.staffID = item.staffID AND faculty_incharge.facultyID = $facultyID";
              $dataset = $db->query($sql) or die("Error query");

              if (mysqli_num_rows($dataset) > 0) {
                while ($data = $dataset->fetch_array()) {

                  echo "<tr>
                  
      <td> $data[0]</td>
      <td>$data[1]</td>
      <td>$data[2]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>
      <td> $data[5]</td>
      <td>$data[6]</td>
      <td>$data[7]</td>
      <td>$data[8]</td>
      <td> <a href=\"faculty_datachart.php?recordno=" . $data[0] . "&& catID=" . $data[9] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i> Analytics</a></td>
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