<?php
require "../functions.php";
include('../inc/header.php');
?>
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


<?php


// Retrieve the button value from the request
$dropdown = $_POST['dropdown'];
$year = $_POST['year'];
$facultyID = $_POST['facultyID'];

$html = '';
$html .= '<table id="table_id5" class="display">';
$html .= '<thead>';
$html .= ' <tr>';
$html .= '<th scope="col">Record #</th>';
$html .= '<th scope="col">Item ID</th>';
$html .= '<th scope="col">Item Name</th>';
$html .= '<th scope="col">Available</th>';
$html .= '<th scope="col">Consumed</th>';
$html .= '<th scope="col">Expired</th>';
$html .= '<th scope="col">Actions</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';


$sql = "SELECT item_transfer.recordno, item_state.checkedID, stateID, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND facultyID = $facultyID AND category.categoryID = 2 AND month='$dropdown' AND year = $year ORDER BY item_state.recordno";
$dataset = $db->query($sql) or die("Error query");

if (mysqli_num_rows($dataset) > 0) {
  while ($data = $dataset->fetch_assoc()) {

    $html .= '<tr>';

    $html .= '<td>' . $data['recordno'] . '</td>';
    $html .= '<td>' . $data['itemid'] . '</td>';
    $html .= '<td>' . $data['item_name'] . '</td>';
    $html .= '<td>' . $data['available_qty'] . '</td>';
    $html .= '<td>' . $data['unavailable1_qty'] . '</td>';
    $html .= '<td>' . $data['unavailable2_qty'] . '</td>';
    $html .= '<td> <a href="faculty_update_itemstate.php?updateid=' . $data['stateID'] . '&& item_state_checkID=' . $data['checkedID'] . '"><i  input type="edit"  class="fa-solid fa-pen-to-square" style="color:blue;"></i></a> &nbsp; <a href="faculty_monthly_item_report.php?item_state_delID=' . $data['stateID'] . ' && item_state_checkID=' . $data['checkedID'] . '" ><i  input type="submit"  class="fas fa-trash-alt" style="color:red;"></i> </a></td>';
    $html .= '</tr>';
  }
} else {
  $html .= 'Empty resultset';
}
$html .= '</tbody></table>';






echo $html;

?>

<script>
  $(document).ready(function() {
    $('#table_id5').DataTable();
    // $('#table_id1').DataTable();
    //$('#table_id2').DataTable();
  });
</script>