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
        <h3><b><span id="state">
              EQUIPMENT: AVAILABLE
            </span> </b></h3>
        <h3 id="title"><b>REPORT FOR THE MONTH OF <span id="buwan">JANUARY<span></b></h3>
        <h3><b><span id="taon">2023<span></b></h3>
      </center><br>
      <div class="row">
        <div class="col-md">
          <div class="row">
            <div class="col-sm-2"> <label for="">Category</label>
              <select id="category" class='form-select mb-3' name="classification" required>
                <option value="Equipment">Equipment</option>
                <option value="Supply">Supply</option>
              </select>
            </div>
            <div class="col-sm-3" id="changeradio">
              <label for="">State</label><br>
              <select id="statefil" class='form-select mb-3' name="classification" required> -->
                <option value="Available">Available</option>
                <option value="Unavailable - Decomissioned">Unavailable - Decomissioned</option>
                <option value="Unavailable - In repair">Unavailable - In repair</option>
              </select>
            </div>
            <div class="col-sm-3"><label for="">Year</label>
              <input type="number" name="year" id="year" value="2023" class="form-control mb-3" required>
              <input type="hidden" name="year" id="facultyID" value="<?php echo $_SESSION['faculty_incharge']['facultyID']; ?>" class="form-control mb-3" required>
            </div>
            <div class="col-sm-3"> <label for="">Month</label>
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
            <div class="col-1">
              <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
            </div>
          </div>
        </div>
      </div>

      <br> <br>
      <div class="col mx-auto">
        <div style="overflow-x:auto;" id="filterresult">
          <table id="table_id1" class="display">
            <thead>
              <tr>
                <th scope="col">Record #</th>
                <th scope="col">Item ID</th>
                <th scope="col">Item Name</th>
                <th scope="col">No. Available</th>
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
      $('#filterbutton').click(function() {
        var inputValue = $('#year').val();
        var facultyno = $('#facultyID').val();
        var selectedfilter = $("#filter").val();
        var selectedcategory = $("#category").val();

        var stateitem = $("#statefil").val();


        let newmonth = selectedfilter.toUpperCase();
        let newcategory = selectedcategory.toUpperCase();
        var hehe = stateitem.toUpperCase();
        $('#state').text(newcategory + ": " + hehe);
        $('#taon').text(inputValue);
        $('#buwan').text(newmonth);

        $.ajax({
          url: 'filter/fac_filter_item.php', // URL of the server-side script
          type: 'POST', // Use the POST method
          data: {
            dropdown: selectedfilter,
            category : selectedcategory,
            state:  stateitem,
            year: inputValue,
            facultyID: facultyno
          }, // Send any data that you need to the server
          success: function(html) {
            $('#filterresult').html(html); // Update the content of the div
          }
        });
      });


      $("select#category").change(function() {
        var selectedcategory = $(this).children("option:selected").val();
        $.ajax({
          url: 'filter/change_radio.php', // URL of the server-side script
          type: 'POST', // Use the POST method
          data: {
            dropdown: selectedcategory,
          }, // Send any data that you need to the server
          success: function(html) {
            $('#changeradio').html(html); // Update the content of the div
          }
        });
      });



    });
  </script>
  <?php include('inc/footer.php'); ?>