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
$sosID = $_POST['staffID'];



$html = '';
$html .= '<table id="table_id10" class="display">';
$html .= '<thead>';
$html .= ' <tr>';
$html .= '<th scope="col">Item ID</th>';
$html .= '<th scope="col">Item Name</th>';
$html .= '<th scope="col">Quantity</th>';
$html .= '<th scope="col">Quantity Transferred</th>';
$html .= '<th scope="col">Available</th>';
$html .= '<th scope="col">Unavailable - Decommissioned</th>';
$html .= '<th scope="col">Unavailable - In Repair</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$sql = "SELECT item.itemid, item_name, quantity, sum(qty_transferred) as totaltransfer, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.staffID =$sosID AND category.categoryID = 1 AND month='$dropdown' AND year =$year  GROUP BY item.itemid";
$dataset = $db->query($sql) or die("Error query");

if (mysqli_num_rows($dataset) > 0) {
  while ($data = $dataset->fetch_assoc()) {

    $html .= '<tr>';
    $html .= '<td>' . $data['itemid'] . '</td>';
    $html .= '<td>' . $data['item_name'] . '</td>';
    $html .= '<td>' . $data['quantity'] . '</td>';
    $html .= '<td>' . $data['totaltransfer'] . '</td>';
    $html .= '<td>' . $data['available_qty'] . '</td>';
    $html .= '<td>' . $data['unavailable1_qty'] . '</td>';
    $html .= '<td>' . $data['unavailable2_qty'] . '</td>';
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
    $('#table_id10').DataTable();
    // $('#table_id1').DataTable();
    //$('#table_id2').DataTable();
  });
</script>