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
$itemid = $_POST['itemID'];
$rem =  $_POST['remainder'];


$sql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='$dropdown' AND year =$year GROUP BY item.itemid";
$dataset1 = mysqli_query($db, $sql1);
if (mysqli_num_rows($dataset1) > 0) {
    $data1 = mysqli_fetch_assoc($dataset1);
    $availablecount = $data1['available_qty'];
    $consumedcount = $data1['unavailable1_qty'];
    $expiredcount = $data1['unavailable2_qty'];
} else {
    $availablecount = 0;
    $consumedcount = 0;
    $expiredcount = 0;
}


$html = '<center><canvas id="myChart1" style="width:100%;max-width:700px"></canvas></center>';







echo $html;

?>

<script src="js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    var rem = <?php echo $rem; ?>;
    var availablecon = <?php echo $availablecount ?>;
    var consumed = <?php echo $consumedcount ?>;
    var expiredcon = <?php echo $expiredcount ?>;

    var xValues = ["Available", "Consumed", "Expired"];
    var yValues = [availablecon, consumed, expiredcon];

    var barColors = [
        "#2F5F98",
        "#2D8BBB",
        "#41B8D5",
        "#99B6E4"
    ];

    new Chart("myChart1", {
        type: "doughnut",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },

    });
</script>