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

<?php include('inc/admincontainer.php'); ?>
<?php if (isset($_SESSION['admin'])) : ?>

    <div class="col-11 mx-auto my-5 bg-light rounded">

        <div class="col-sm-12 mx-auto p-5">
            <center>
                <h3><b>INVENTORY</b></h3>
            </center><br>
            <div class="row">
                <div style="overflow-x:auto;">
                    <table id="table_id2" class="display">
                        <thead>
                            <tr>
                                <th scope="col">Managing Staff</th>
                                <th scope="col">Item #</th>
                                <th scope="col">Category</th>
                                <!-- <th scope="col">Staff ID</th> -->
                                <th scope="col">Item</th>
                                <th scope="col">Serial No.</th>
                                <th scope="col">Description</th>
                                <th scope="col">PPP</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Date Purchased</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Analytics</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // $sql = "select * from item WHERE staffID = $sosID";
                            $sql = "select itemid, item.staffID,  category_name, item_name, serialno, item_desc, cost, date_purchased, quantity, item.categoryID, staff_name from item, supply_office_staff, category WHERE supply_office_staff.staffID =item.staffID AND item.categoryID = category.categoryID";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    $ppp = number_format(($data[6] / $data[8]), 2);
                                    //<td>$data[2]</td>
                                    echo "<tr>
      <td> $data[10]</td> 
      <td> $data[0]</td>
      <td>$data[2]</td>
      <td>$data[3]</td>
      <td>$data[4]</td>
      <td>$data[5]</td>
      <td>$ppp</td>
      <td>$data[6]</td>
      <td>$data[7]</td>
      <td>$data[8]</td>
       <td> <a href=\"admin_view_sos_datachart.php?itemid=" . $data[0] . "&& catID=" . $data[9] . "\" ><i  input type=\"edit\"  class=\"fa-solid fa-eye\" style=\"color:blue;\"></i> Analytics</a></td>
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
                                $sql = "SELECT item.itemid, item_name, quantity, sum(qty_transferred) as totaltransfer, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND category.categoryID = 1 AND month='january' AND year =2023 GROUP BY item.itemid";
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
                                    $sql = "SELECT item.itemid, item_name, quantity, sum(qty_transferred) as totaltransfer, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND category.categoryID = 2 AND month='january' AND year =2023 GROUP BY item.itemid";
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





            <?php endif ?>


            <script src="js/main.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                $(document).ready(function() {
                    $("select#filter").change(function() {
                        var inputValue = $('#year').val();
                        var selectedfilter = $(this).children("option:selected").val();
                        let newmonth = selectedfilter.toUpperCase();

                        // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
                        $('#taon').text(inputValue);
                        $('#buwan').text(newmonth);

                        $.ajax({
                            url: 'filter/admin_filter_itemstate.php', // URL of the server-side script
                            type: 'POST', // Use the POST method
                            data: {
                                dropdown: selectedfilter,
                                year: inputValue,
                            }, // Send any data that you need to the server
                            success: function(html) {
                                $('#filterresult').html(html); // Update the content of the div
                            }
                        });
                    });


                    $("select#filter1").change(function() {
                        var inputValue = $('#year1').val();
                        var selectedfilter = $(this).children("option:selected").val();
                        let newmonth = selectedfilter.toUpperCase();

                        $('#taon1').text(inputValue);
                        $('#buwan1').text(newmonth);

                        $.ajax({
                            url: 'filter/admin_filter_itemstate1.php', // URL of the server-side script
                            type: 'POST', // Use the POST method
                            data: {
                                dropdown: selectedfilter,
                                year: inputValue,
                            }, // Send any data that you need to the server
                            success: function(html) {
                                $('#filterresult1').html(html); // Update the content of the div
                            }
                        });
                    });



                });
            </script>
            <?php include('inc/footer.php'); ?>