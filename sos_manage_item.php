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
        $('#table_id1').DataTable();
        $('#table_id2').DataTable();

        $('#table_id3').DataTable();
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
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Add Inventory</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body"><br>
                        <div class="col-sm-11 mb-3 mx-auto">
                            <div class="mb-3"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Item Category</label>
                                    <?php

                                    $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                    if ($connect) {
                                        $result =  $connect->query("SELECT * FROM category") or die("Error Query");
                                        if ($result) {
                                            if ($result->num_rows >= 1) {
                                                echo "<select name='catID' class='form-select mb-3' >";
                                                while ($rows = $result->fetch_array()) {
                                                    echo "<option value=$rows[0]>$rows[1]</option>";
                                                }
                                            }
                                        }
                                    }

                                    echo "</select>";
                                    ?>

                                </div>
                                <div class="col-sm-6">
                                    <label for="">Item Name</label>
                                    <input class="form-control mb-3" name="item_name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6"> <label for="">Serial No.</label>
                                    <input type="text" name="serialno" class="form-control mb-3" required>
                                </div>
                                <div class="col-lg-6"> <label for="">Description</label>
                                    <textarea class="form-control" name="description" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6"> <label for="">Overall Cost</label>
                                    <input type="number" name="cost" class="form-control mb-3" required>
                                </div>
                                <div class="col-sm-6"><label for="">Quantity</label>
                                    <input type="number" name="quantity" class="form-control mb-3" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6"><label for="">Date Purchased</label>
                                    <input type="date" name="d8_purchased" class="form-control mb-3" required>
                                </div>
                            </div>

                        </div><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="create_item" value="Insert Record">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="col-11 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <center>
                <h3><b>MANAGE INVENTORY</b></h3>
            </center><br>
            <div class="row">
                <div class="col-sm-2 mb-2">
                </div>

                <div class="col-sm-10 mb-2" align="right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Add Item</button>

                </div>

            </div>
            <div class="row">
                <div style="overflow-x:auto;">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Category</th>
                                <!-- <th scope="col">Staff ID</th> -->
                                <th scope="col">Name</th>
                                <th scope="col">Serial No.</th>
                                <th scope="col">Description</th>
                                <th scope="col">PPP</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Analytics</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // $sql = "select * from item WHERE staffID = $sosID";
                            $sql = "select itemid, staffID,  category_name, item_name, serialno, item_desc, cost, date_purchased, quantity, item.categoryID from item, category WHERE staffID = $sosID AND item.categoryID = category.categoryID";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    $ppp = number_format(($data[6] / $data[8]), 2);
                                    //<td>$data[2]</td>
                                    echo "<tr>
  						
              <td> $data[0]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
              <td>$data[4]</td>
              <td>$data[5]</td>
              <td>$ppp</td>
              <td>$data[6]</td>
              <td>$data[7]</td>
              <td>$data[8]</td>
               <td> <a href=\"sos_update_item.php?updateid=$data[0] && staffID=$data[1]\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"sos_manage_item.php?item_delid=$data[0]\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
               <td> <a href=\"sos_datachart.php?itemid=" . $data[0] . "&& catID=" . $data[9] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i> Analytics</a></td>
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

            <div class="col-sm-11 mx-auto p-5">
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
                                <input type="hidden" name="year" id="staffID" value="<?php echo $sosID; ?>" class="form-control mb-3" required>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div style="overflow-x:auto;" id="filterresult">
                        <table id="table_id1" class="display">
                            <thead>
                                <tr>

                                    <th scope="col">Item ID</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Quantity Transferred</th>
                                    <th scope="col">Available</th>
                                    <th scope="col">Unavailable - Decommissioned </th>
                                    <th scope="col">Unavailable - In Repair</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql = "SELECT item.itemid, item_name, quantity, sum(qty_transferred) as totaltransfer, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.staffID =$sosID AND category.categoryID = 1 AND month='january' AND year =2023 GROUP BY item.itemid";
                                $dataset = $db->query($sql) or die("Error query");

                                if (mysqli_num_rows($dataset) > 0) {
                                    while ($data = $dataset->fetch_assoc()) {

                                        echo "<tr>
            
<td>" . $data['itemid'] . "</td>
<td>" . $data['item_name'] . "</td>
<td>" . $data['quantity'] . "</td>
<td>" . $data['totaltransfer'] . "</td>
<td>" . $data['available_qty'] . "</td>
<td>" . $data['unavailable1_qty'] . "</td>
<td>" . $data['unavailable2_qty'] . "</td>
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

                <div class="col-sm-11 mx-auto p-5">
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
                                    <input type="hidden" name="year" id="staffID1" value="<?php echo $sosID; ?>" class="form-control mb-3" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div style="overflow-x:auto;" id="filterresult1">
                            <table id="table_id3" class="display">
                                <thead>
                                    <tr>
                                        <th scope="col">Item ID</th>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Quantity Transferred</th>
                                        <th scope="col">Available</th>
                                        <th scope="col">Consumed</th>
                                        <th scope="col">Expired</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "SELECT item.itemid, item_name, quantity, sum(qty_transferred) as totaltransfer, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.staffID =$sosID AND category.categoryID = 2 AND month='january' AND year =2023 GROUP BY item.itemid";
                                    $dataset = $db->query($sql) or die("Error query");

                                    if (mysqli_num_rows($dataset) > 0) {
                                        while ($data = $dataset->fetch_assoc()) {

                                            echo "<tr>
            
<td>" . $data['itemid'] . "</td>
<td>" . $data['item_name'] . "</td>
<td>" . $data['quantity'] . "</td>
<td>" . $data['totaltransfer'] . "</td>
<td>" . $data['available_qty'] . "</td>
<td>" . $data['unavailable1_qty'] . "</td>
<td>" . $data['unavailable2_qty'] . "</td>
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

        <script src="js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

      <script>
        $(document).ready(function() {
          $("select#filter").change(function() {
            var inputValue = $('#year').val();
            var staffno = $('#staffID').val();
            var selectedfilter = $(this).children("option:selected").val();
            let newmonth = selectedfilter.toUpperCase();

            $('#taon').text(inputValue);
            $('#buwan').text(newmonth);

            $.ajax({
              url: 'filter/staff_filter_itemstate.php', // URL of the server-side script
              type: 'POST', // Use the POST method
              data: {
                dropdown: selectedfilter,
                year: inputValue,
                staffID: staffno
              }, // Send any data that you need to the server
              success: function(html) {
                $('#filterresult').html(html); // Update the content of the div
              }
            });
          });


          $("select#filter1").change(function() {
            var inputValue = $('#year1').val();
            var staffno = $('#staffID1').val();
            var selectedfilter = $(this).children("option:selected").val();
            let newmonth = selectedfilter.toUpperCase();

            $('#taon1').text(inputValue);
            $('#buwan1').text(newmonth);

            $.ajax({
              url: 'filter/staff_filter_itemstate1.php', // URL of the server-side script
              type: 'POST', // Use the POST method
              data: {
                dropdown: selectedfilter,
                year: inputValue,
                staffID: staffno
              }, // Send any data that you need to the server
              success: function(html) {
                $('#filterresult1').html(html); // Update the content of the div
              }
            });
          });



        });
      </script>

        <?php include('inc/footer.php'); ?>