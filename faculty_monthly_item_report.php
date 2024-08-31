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
</style>
<script>
  $(document).ready(function() {
    $('#table_id').DataTable();
    $('#table_id1').DataTable();
    $('#table_id2').DataTable();

    $('#table_id3').DataTable();
  });
</script>

<?php include('inc/faculty_container.php'); ?>
<?php if (isset($_SESSION['faculty_incharge'])) : ?>
  <?php

  $facultyID = $_SESSION['faculty_incharge']['facultyID']; ?>


  <div class="col-10 mx-auto my-5 bg-light rounded">

    <div class="col-sm-12 mx-auto p-5">
      <center>
        <h3><b>MONTHLY REPORTS - ITEM MANAGEMENT</b></h3>
      </center><br>

      <div class="row">
        <div style="overflow-x:auto;">
          <table id="table_id2" class="display">
            <thead>
              <tr>
                <th scope="col">Record #</th>
                <th scope="col">Item Category</th>
                <th scope="col">Item No.</th>
                <th scope="col">Item Name</th>
                <th scope="col">Description</th>
                <th scope="col">Department</th>
                <th scope="col">Room #</th>
                <th scope="col">Date Transferred</th>
                <th scope="col">Quantity</th>
                <th scope="col">Add Record</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sql = "select recordno, category_name, item.itemid, item_name, item_desc, dep_name,  room_no, date_transferred, qty_transferred, category.categoryID FROM item, category, faculty_incharge, item_transfer, department WHERE item.itemid=item_transfer.itemID AND category.categoryID=item.categoryID AND faculty_incharge.facultyID=item_transfer.facultyID AND department.departmentno=faculty_incharge.departmentno AND faculty_incharge.staffID = item.staffID AND faculty_incharge.facultyID = $facultyID";
              $dataset = $db->query($sql) or die("Error query");

              if (mysqli_num_rows($dataset) > 0) {
                while ($data = $dataset->fetch_array()) {

                  echo "<tr onclick=\"location.href='faculty_manage_itemstate.php?addstate=" . $data[0] . " && catid=" . $data[9] . "';\">
                  
      <td> $data[0]</td>
      <td>$data[1]</td>
      <td>$data[2]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>
      <td> $data[5]</td>
      <td>$data[6]</td>
      <td>$data[7]</td>
      <td>$data[8]</td>
      <td> <i class='fa-solid fa-circle-plus'></i></td>

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



    <div class="col-10 mx-auto my-5 bg-light rounded">

      <div class="col-sm-12 mx-auto p-5">
        <center>
          <h3 id="title"><b>EQUIPMENT REPORT FOR THE MONTH OF <span id="buwan">JANUARY<span></b></h3>
          <h3><b><span id="taon">2023<span></b></h3>
        </center><br>
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-sm-5"> <label for="">Month</label>
                <select name='month' id="filter" class='form-select mb-3' name="month" required>
                  <option value="January">January</option>
                  <option value="February">February</option>
                  <option value="March">March</option>
                  <option value="April">April</option>
                  <option value="May">May</option>
                  <option value="June">June</option>
                  <option value="July">July</option>
                  <option value="August">August</option>
                  <option value="September">September</option>
                  <option value="October">October</option>
                  <option value="November">November</option>
                  <option value="December">December</option>
                </select>
              </div>
              <div class="col-sm-3"><label for="">Year</label>
                <input type="number" name="year" id="year" value="2023" class="form-control mb-3" required>
                <input type="hidden" name="year" id="facultyID" value="<?php echo $_SESSION['faculty_incharge']['facultyID']; ?>" class="form-control mb-3" required>
              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div style="overflow-x:auto;" id="filterresult">
            <table id="table_id1" class="display">
              <thead>
                <tr>
                  <th scope="col">Record #</th>
                  <th scope="col">Item ID</th>
                  <th scope="col">Item Name</th>
                  <th scope="col">Available</th>
                  <th scope="col">Unavailable - Decommissioned </th>
                  <th scope="col">Unavailable - In Repair</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $sql = "SELECT item_transfer.recordno, item_state.checkedID, stateID, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND facultyID = $facultyID AND category.categoryID = 1 AND month='january' AND year =2023 ORDER BY item_state.recordno";
                $dataset = $db->query($sql) or die("Error query");

                if (mysqli_num_rows($dataset) > 0) {
                  while ($data = $dataset->fetch_assoc()) {

                    echo "<tr>
                  
      <td>" . $data['recordno'] . "</td>
      <td>" . $data['itemid'] . "</td>
      <td>" . $data['item_name'] . "</td>
      <td>" . $data['available_qty'] . "</td>
      <td>" . $data['unavailable1_qty'] . "</td>
      <td>" . $data['unavailable2_qty'] . "</td>
      <td> <a href=\"faculty_update_itemstate.php?updateid=" . $data['stateID'] . "&& item_state_checkID=" . $data['checkedID'] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"faculty_monthly_item_report.php?item_state_delID=" . $data['stateID'] . "&& item_state_checkID=" . $data['checkedID'] . "\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
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




      <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-12 mx-auto p-5">
          <center>
            <h3 id="title"><b>SUPPLY REPORT FOR THE MONTH OF <span id="buwan1">JANUARY<span></b></h3>
            <h3><b><span id="taon1">2023<span></b></h3>
          </center><br>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-sm-5"> <label for="">Month</label>
                  <select name='month' id="filter1" class='form-select mb-3' name="month" required>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
                <div class="col-sm-3"><label for="">Year</label>
                  <input type="number" name="year" id="year1" value="2023" class="form-control mb-3" required>
                  <input type="hidden" name="year" id="facultyID1" value="<?php echo $_SESSION['faculty_incharge']['facultyID']; ?>" class="form-control mb-3" required>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div style="overflow-x:auto;" id="filterresult1">
              <table id="table_id3" class="display">
                <thead>
                  <tr>
                    <th scope="col">Record #</th>
                    <th scope="col">Item ID</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Available</th>
                    <th scope="col">Comsumed</th>
                    <th scope="col">Expired</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT item_transfer.recordno, item_state.checkedID, stateID, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND facultyID = $facultyID AND category.categoryID = 2 AND month='january' AND year =2023 ORDER BY item_state.recordno";
                  $dataset = $db->query($sql) or die("Error query");

                  if (mysqli_num_rows($dataset) > 0) {
                    while ($data = $dataset->fetch_assoc()) {

                      echo "<tr>
            
<td>" . $data['recordno'] . "</td>
<td>" . $data['itemid'] . "</td>
<td>" . $data['item_name'] . "</td>
<td>" . $data['available_qty'] . "</td>
<td>" . $data['unavailable1_qty'] . "</td>
<td>" . $data['unavailable2_qty'] . "</td>
<td> <a href=\"faculty_update_itemstate2.php?updateid=" . $data['stateID'] . "&& item_state_checkID=" . $data['checkedID'] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"faculty_monthly_item_report.php?item_state_delID=" . $data['stateID'] . "&& item_state_checkID=" . $data['checkedID'] . "\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
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


      <script src="js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

      <script>
        $(document).ready(function() {
          $("select#filter").change(function() {
            var inputValue = $('#year').val();
            var facultyno = $('#facultyID').val();
            var selectedfilter = $(this).children("option:selected").val();
            let newmonth = selectedfilter.toUpperCase();

            // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
            $('#taon').text(inputValue);
            $('#buwan').text(newmonth);

            $.ajax({
              url: 'filter/fac_filter_itemstate_report.php', // URL of the server-side script
              type: 'POST', // Use the POST method
              data: {
                dropdown: selectedfilter,
                year: inputValue,
                facultyID: facultyno
              }, // Send any data that you need to the server
              success: function(html) {
                $('#filterresult').html(html); // Update the content of the div
              }
            });
          });


          $("select#filter1").change(function() {
            var inputValue = $('#year1').val();
            var facultyno = $('#facultyID1').val();
            var selectedfilter = $(this).children("option:selected").val();
            let newmonth = selectedfilter.toUpperCase();

            // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
            $('#taon1').text(inputValue);
            $('#buwan1').text(newmonth);

            $.ajax({
              url: 'filter/fac_filter_itemstate1_report.php', // URL of the server-side script
              type: 'POST', // Use the POST method
              data: {
                dropdown: selectedfilter,
                year: inputValue,
                facultyID: facultyno
              }, // Send any data that you need to the server
              success: function(html) {
                $('#filterresult1').html(html); // Update the content of the div
              }
            });
          });



        });
      </script>
      <?php include('inc/footer.php'); ?>