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

<title>Supply Office Staff</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
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
    });
</script>
<script>
    function downloadPDF() {
        var pdf = new jsPDF();
        var div = document.getElementById("table_id");
        pdf.fromHTML(div, 15, 15, {
            'width': 170
        });
        pdf.save("Record of Transferred Items.pdf");
    }
</script>

<?php include('inc/sos_container.php'); ?>
<?php if (isset($_SESSION['supply_office_staff'])) : ?>
    <?php global $sosID, $quan_trans;

    $sosID = $_SESSION['supply_office_staff']['staffID']; ?>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Transfer Item to Faculty In Charge</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body"><br>
                        <div class="col-sm-11 mb-2 mx-auto">
                            <?php //echo display_error_sos(); 
                            ?>
                            <div class="mb-2"><input value="<?php echo $_SESSION['supply_office_staff']['staffID']; ?>" type="hidden" name="staffID" required /></div>
                            <div class="col">
                                <label for="">Item</label>
                                <?php
                                $quan_trans = 0;
                                $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                if ($connect) {
                                    $result =  $connect->query("SELECT itemid, CONCAT (item_name, ' : Quantity = ', quantity ) as itemquan FROM item WHERE staffID=$sosID") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='itemID' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value=$rows[0]>$rows[1]</option>";
                                            }
                                        }
                                    }
                                }

                                echo "</select>";
                                ?>

                            </div>
                            <div class="col">
                                <label for="">Faculty In Charge</label>
                                <?php

                                $connect = new mysqli("localhost", "root", "", "imanage") or die("Error Connection");

                                if ($connect) {
                                    $result =  $connect->query("SELECT facultyID, faculty_name FROM faculty_incharge WHERE staffID=$sosID") or die("Error Query");
                                    if ($result) {
                                        if ($result->num_rows >= 1) {
                                            echo "<select name='facultyID' class='form-select mb-3' >";
                                            while ($rows = $result->fetch_array()) {
                                                echo "<option value=$rows[0]>$rows[1]</option>";
                                            }
                                        }
                                    }
                                }
                                echo "</select>";
                                ?>
                            </div>
                            <div class="col"><label for="">Date Transfer</label>
                                <input type="date" name="d8_transfer" class="form-control mb-3" required>
                            </div>
                            <div class="col"><label for="">Quantity</label>
                                <input type="number" name="qty_transferred" class="form-control mb-3" required>
                            </div>


                        </div><br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="item_transfer" value="Insert Record">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <div class="col-10 mx-auto my-5 bg-light rounded">

        <div class="col-sm-11 mx-auto p-5">
            <center>
                <h3><b>RECORDS FOR TRANSFERING</b></h3>
            </center><br>
            <?php echo display_error_sos(); ?>

            <div class="row">
                <div class="col-sm-2 mb-2">
                </div>

                <div class="col-sm-10 mb-2" align="right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Transfer Item</button>

                </div>

            </div>

            <div class="row">
                <div style="overflow-x:auto;" class="col-md-6">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th scope="col">Employee No.</th>
                                <th scope="col">Departmeent</th>
                                <th scope="col">Name</th>
                                <th scope="col">Room No.</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "select facultyID, dep_name, faculty_name, room_no from faculty_incharge, department WHERE department.departmentno = faculty_incharge.departmentno AND staffID = $sosID";
                            $dataset = $db->query($sql) or die("Error query");

                            if (mysqli_num_rows($dataset) > 0) {
                                while ($data = $dataset->fetch_array()) {
                                    echo "<tr>
  						
              <td> $data[0]</td>
              <td>$data[1]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
  					</tr>";
                                }
                            } else {
                                echo "Empty resultset";
                            }
                            echo "</tbody>
  	</table>
  <br><br>
    </div>"; ?>




                            <div style="overflow-x:auto;" class="col-md-6">
                                <table id="table_id1" class="display">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item ID</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date Purchased</th>
                                            <th scope="col">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        $sql = "select  itemid, category_name, item_name, date_purchased, quantity FROM item, category WHERE item.categoryID = category.categoryID AND staffID = $sosID";
                                        $dataset = $db->query($sql) or die("Error query");

                                        if (mysqli_num_rows($dataset) > 0) {
                                            while ($data = $dataset->fetch_array()) {


                                                echo "<tr>
  						
              <td> $data[0]</td>
              <td>$data[1]</td>
              <td>$data[2]</td>
              <td>$data[3]</td>
              <td>$data[4]</td>
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


            <div class="col-10 mx-auto my-5 bg-light rounded">

                <div class="col-sm-12 mx-auto p-5">
                    <center>
                        <h3><b>TRANSFERRED ITEMS</b></h3>
                    </center><br>
                    <div class="row">
                        <div class="col-sm-2 mb-2">
                        </div>

                        <div class="col-sm-10 mb-2" align="right">
                            <!-- Button trigger modal -->
                            <!-- <button type="button" onclick="downloadPDF()" class="btn btn-primary">Print Transfer Report</button> -->
                        </div>
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
                                        <th scope="col">Employee #</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Faculty In Charge</th>
                                        <th scope="col">Room #</th>
                                        <th scope="col">Date Transferred</th>
                                        <th scope="col">Qty. Transferred</th>
                                        <th scope="col">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sql = "select recordno, item.itemid, category_name, item_name, faculty_incharge.facultyID, dep_name, faculty_name, room_no, date_transferred, qty_transferred FROM item, category, faculty_incharge, item_transfer, department WHERE item.itemid=item_transfer.itemID AND category.categoryID=item.categoryID AND faculty_incharge.facultyID=item_transfer.facultyID AND department.departmentno=faculty_incharge.departmentno AND faculty_incharge.staffID = item.staffID AND item.staffID = $sosID";
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
      <td>$data[9]</td>
       <td> <a href=\"sos_update_transfer.php?updateid=$data[0]\" ><i  input type=\"edit\"  class=\"fa-solid fa-pen-to-square\" style=\"color:blue;\"></i></a> &nbsp; <a href=\"sos_manage_item.php?item_trans_recordno=$data[0]\" ><i  input type=\"submit\"  class=\"fas fa-trash-alt\" style=\"color:red;\"></i> </a></td>
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