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


if ((!isset($_GET['itemid'])) && (!isset($_GET['catID']))) {
    header('location: sos_manage_item.php');
}


global $itemid, $categoryID;
$itemid = $_GET['itemid'];
$catID = $_GET['catID'];



if ($_GET['catID'] == 2) {
    header("location: sos_datachart2.php?itemid= $itemid && catID=$catID");
}


include('inc/header.php');
?>

<title>Update Item Transferred</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<style>
    body {
        font-family: 'Poppins';
        width: 100%;
        height: auto;
        background-image: url('images/banner.jpg');
        background-attachment: fixed;
        background-size: cover;

    }

    .div1 {
        width: 80%;
        padding: 20px;
        margin: auto;
        border-radius: 20px;
        background-color: white;
    }
</style>


<?php include('inc/sos_container.php'); ?>
<?php if ((isset($_GET['itemid']))  && (isset($_GET['catID']))) : ?>
    <?php

    global $sosID;
    $sosID = $_SESSION['supply_office_staff']['staffID'];




    $sql = "select itemid, staffID, CONCAT (item.categoryID, ' ', category_name) as cate, item_name, serialno, item_desc, cost, date_purchased, quantity, item.categoryID from item, category WHERE itemid = $itemid AND item.categoryID = category.categoryID;";
    $dataset = $db->query($sql) or die("Error query");

    if (mysqli_num_rows($dataset) > 0) {
        while ($data = $dataset->fetch_assoc()) {
            $item_name = $data['item_name'];
            $item_qty = $data['quantity'];


            $sql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(qty_transferred) as totaltransfer FROM item, category, item_transfer WHERE item.itemid = item_transfer.itemID AND category.categoryID = item.categoryID AND item.itemid = $itemid GROUP BY item.itemid";
            $dataset1 = mysqli_query($db, $sql1);
            if (mysqli_num_rows($dataset1) > 0) {
                $data1 = mysqli_fetch_assoc($dataset1);
                $transfercount = $data1['totaltransfer'];
            } else {
                $transfercount = 0;
            }


            $remainder = $item_qty - $transfercount;

            ////januray
            $sql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='january' AND year =2023 GROUP BY item.itemid";
            $dataset1 = mysqli_query($db, $sql1);
            if (mysqli_num_rows($dataset1) > 0) {
                $data1 = mysqli_fetch_assoc($dataset1);
                $availablecount = $data1['available_qty'];
                $decomcount = $data1['unavailable1_qty'];
                $repaircount = $data1['unavailable2_qty'];
            } else {
                $availablecount = 0;
                $decomcount = 0;
                $repaircount = 0;
            }

    ?>


            <div class="col-10 mx-auto my-5 bg-light rounded">
                <input type="hidden" name="year" id="itemID" value="<?php echo $itemid; ?>">

                <div class="col-sm-8 mx-auto p-5">
                    <center>
                        <h3 id="title"><b>ITEM <?php echo  strtoupper($item_name); ?> : QUANTITY TRANSFERRED</b></h3>
                    </center><br>

                    <div>
                        <center><canvas id="TransferChart" style="width:100%;max-width:800px"></canvas></center>
                    </div>
                </div>
            </div>

            <div class="col-10 mx-auto my-5 bg-light rounded">
                <input type="hidden" name="year" id="itemID" value="<?php echo $itemid; ?>">

                <div class="col-sm-12 mx-auto p-5">
                    <center>
                        <h3 id="title"><b>ITEM <?php echo  strtoupper($item_name); ?> : REPORT FOR THE YEAR OF 2023</b></h3>
                    </center><br>


                    <div>
                        <center><canvas id="overallChart" style="width:100%;max-width:600px"></canvas></center>
                    </div>
                </div>
            </div>

            <?php

            //////////////////February///////////////////////////////
            $sqlfeb1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='february' AND year =2023 GROUP BY item.itemid";
            $febdataset1 = mysqli_query($db, $sqlfeb1);
            if (mysqli_num_rows($febdataset1) > 0) {
                $febdata = mysqli_fetch_assoc($febdataset1);
                $febavailablecount = $febdata['available_qty'];
                $febdecomcount = $febdata['unavailable1_qty'];
                $febrepaircount = $febdata['unavailable2_qty'];
            } else {
                $febavailablecount = 0;
                $febdecomcount = 0;
                $febrepaircount = 0;
            }




            // MARCHHHHHHHHHHHHHH
            $marchsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='march' AND year =2023 GROUP BY item.itemid";
            $marchdataset1 = mysqli_query($db, $marchsql1);
            if (mysqli_num_rows($marchdataset1) > 0) {
                $marchdata = mysqli_fetch_assoc($marchdataset1);
                $marchavailablecount = $marchdata['available_qty'];
                $marchdecomcount = $marchdata['unavailable1_qty'];
                $marchrepaircount = $marchdata['unavailable2_qty'];
            } else {
                $marchavailablecount = 0;
                $marchdecomcount = 0;
                $marchrepaircount = 0;
            }

            /// APRIL
            $aprilsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='april' AND year =2023 GROUP BY item.itemid";
            $aprildataset1 = mysqli_query($db, $aprilsql1);
            if (mysqli_num_rows($aprildataset1) > 0) {
                $aprildata = mysqli_fetch_assoc($aprildataset1);
                $aprilavailablecount = $aprildata['available_qty'];
                $aprildecomcount = $aprildata['unavailable1_qty'];
                $aprilrepaircount = $aprildata['unavailable2_qty'];
            } else {
                $aprilavailablecount = 0;
                $aprildecomcount = 0;
                $aprilrepaircount = 0;
            }


            /// MAY
            $maysql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='may' AND year =2023 GROUP BY item.itemid";
            $maydataset1 = mysqli_query($db, $maysql1);
            if (mysqli_num_rows($maydataset1) > 0) {
                $maydata = mysqli_fetch_assoc($maydataset1);
                $mayavailablecount = $maydata['available_qty'];
                $maydecomcount = $maydata['unavailable1_qty'];
                $mayrepaircount = $maydata['unavailable2_qty'];
            } else {
                $mayavailablecount = 0;
                $maydecomcount = 0;
                $mayrepaircount = 0;
            }


            /// JUNE
            $junesql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='june' AND year =2023 GROUP BY item.itemid";
            $junedataset1 = mysqli_query($db, $junesql1);
            if (mysqli_num_rows($junedataset1) > 0) {
                $junedata = mysqli_fetch_assoc($junedataset1);
                $juneavailablecount = $junedata['available_qty'];
                $junedecomcount = $junedata['unavailable1_qty'];
                $junerepaircount = $junedata['unavailable2_qty'];
            } else {
                $juneavailablecount = 0;
                $junedecomcount = 0;
                $junerepaircount = 0;
            }



            /// JULY
            $julysql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='july' AND year =2023 GROUP BY item.itemid";
            $julydataset1 = mysqli_query($db, $julysql1);
            if (mysqli_num_rows($julydataset1) > 0) {
                $julydata = mysqli_fetch_assoc($julydataset1);
                $julyavailablecount = $julydata['available_qty'];
                $julydecomcount = $julydata['unavailable1_qty'];
                $julyrepaircount = $julydata['unavailable2_qty'];
            } else {
                $julyavailablecount = 0;
                $julydecomcount = 0;
                $julyrepaircount = 0;
            }

            /// AUGUST
            $augsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='august' AND year =2023 GROUP BY item.itemid";
            $augdataset1 = mysqli_query($db, $augsql1);
            if (mysqli_num_rows($augdataset1) > 0) {
                $augdata = mysqli_fetch_assoc($augdataset1);
                $augavailablecount = $augdata['available_qty'];
                $augdecomcount = $augdata['unavailable1_qty'];
                $augrepaircount = $augdata['unavailable2_qty'];
            } else {
                $augavailablecount = 0;
                $augdecomcount = 0;
                $augrepaircount = 0;
            }

            /// SEPTEMBER
            $septsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='september' AND year =2023 GROUP BY item.itemid";
            $septdataset1 = mysqli_query($db, $septsql1);
            if (mysqli_num_rows($septdataset1) > 0) {
                $septdata = mysqli_fetch_assoc($septdataset1);
                $septavailablecount = $septdata['available_qty'];
                $septdecomcount = $septdata['unavailable1_qty'];
                $septrepaircount = $septdata['unavailable2_qty'];
            } else {
                $septavailablecount = 0;
                $septdecomcount = 0;
                $septrepaircount = 0;
            }

            /// OCTOBER
            $octsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='october' AND year =2023 GROUP BY item.itemid";
            $octdataset1 = mysqli_query($db, $octsql1);
            if (mysqli_num_rows($octdataset1) > 0) {
                $octdata = mysqli_fetch_assoc($octdataset1);
                $octavailablecount = $octdata['available_qty'];
                $octdecomcount = $octdata['unavailable1_qty'];
                $octrepaircount = $octdata['unavailable2_qty'];
            } else {
                $octavailablecount = 0;
                $octdecomcount = 0;
                $octrepaircount = 0;
            }


            /// NOVEMBER
            $novsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='november' AND year =2023 GROUP BY item.itemid";
            $novdataset1 = mysqli_query($db, $novsql1);
            if (mysqli_num_rows($novdataset1) > 0) {
                $novdata = mysqli_fetch_assoc($novdataset1);
                $novavailablecount = $novdata['available_qty'];
                $novdecomcount = $novdata['unavailable1_qty'];
                $novrepaircount = $novdata['unavailable2_qty'];
            } else {
                $novavailablecount = 0;
                $novdecomcount = 0;
                $novrepaircount = 0;
            }


            /// DECEMBER
            $decsql1 = "SELECT item.itemid, item_name, quantity, item.categoryID, category_name, sum(available_qty) as available_qty, sum(unavailable1_qty) as unavailable1_qty, sum(unavailable2_qty) as unavailable2_qty, month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID AND item.itemid =$itemid AND month='december' AND year =2023 GROUP BY item.itemid";
            $decdataset1 = mysqli_query($db, $decsql1);
            if (mysqli_num_rows($decdataset1) > 0) {
                $decdata = mysqli_fetch_assoc($decdataset1);
                $decavailablecount = $decdata['available_qty'];
                $decdecomcount = $decdata['unavailable1_qty'];
                $decrepaircount = $decdata['unavailable2_qty'];
            } else {
                $decavailablecount = 0;
                $decdecomcount = 0;
                $decrepaircount = 0;
            }

            ?>




            <div class="col-10 mx-auto my-5 bg-light rounded">
                <input type="hidden" name="year" id="itemID" value="<?php echo $itemid; ?>">

                <div class="col-sm-12 mx-auto p-5">
                    <center>
                        <h3 id="title"><b>ITEM <?php echo  strtoupper($item_name); ?> : REPORT FOR THE MONTH OF <span id="buwan">JANUARY<span></b></h3>
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


                    <div id="filterresult">
                        <center><canvas id="myChart" style="width:100%;max-width:700px"></canvas></center>
                    </div>


                </div>
            </div>

    <?php

        }
    } ?>


    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>




    <script>
        var rem = <?php echo  $remainder;  ?>;
        var transferred = <?php echo  $transfercount; ?>;

        var xValues = ["Transferred", "Not Transferred"];
        var yValues = [transferred, rem];
        //var yValues = [0, 0, 0];
        var barColors = [
            "#2F5F98",
            "#2D8BBB",

        ];

        new Chart("TransferChart", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },

        });
    </script>

    <script>
        var availablecon = <?php echo $availablecount ?>;
        var decom = <?php echo $decomcount ?>;
        var repaircon = <?php echo $repaircount ?>;

        // feb
        var febavailablecon = <?php echo $febavailablecount ?>;
        var febdecom = <?php echo $febdecomcount ?>;
        var febrepaircon = <?php echo $febrepaircount ?>;

        // march
        var marchavailablecon = <?php echo $marchavailablecount ?>;
        var marchdecom = <?php echo $marchdecomcount ?>;
        var marchrepaircon = <?php echo $marchrepaircount ?>;

        // april
        var aprilavailablecon = <?php echo $aprilavailablecount ?>;
        var aprildecom = <?php echo $aprildecomcount ?>;
        var aprilrepaircon = <?php echo $aprilrepaircount ?>;

        // may
        var mayavailablecon = <?php echo $mayavailablecount ?>;
        var maydecom = <?php echo $maydecomcount ?>;
        var mayrepaircon = <?php echo $mayrepaircount ?>;

        // june
        var juneavailablecon = <?php echo $juneavailablecount ?>;
        var junedecom = <?php echo $junedecomcount ?>;
        var junerepaircon = <?php echo $junerepaircount ?>;

        // july
        var julyavailablecon = <?php echo $julyavailablecount ?>;
        var julydecom = <?php echo $julydecomcount ?>;
        var julyrepaircon = <?php echo $julyrepaircount ?>;

        // august
        var augavailablecon = <?php echo $augavailablecount ?>;
        var augdecom = <?php echo $augdecomcount ?>;
        var augrepaircon = <?php echo $augrepaircount ?>;

        // september
        var septavailablecon = <?php echo $septavailablecount ?>;
        var septdecom = <?php echo $septdecomcount ?>;
        var septrepaircon = <?php echo $septrepaircount ?>;

        // october
        var octavailablecon = <?php echo $octavailablecount ?>;
        var octdecom = <?php echo $octdecomcount ?>;
        var octrepaircon = <?php echo $octrepaircount ?>;

        // november
        var novavailablecon = <?php echo $novavailablecount ?>;
        var novdecom = <?php echo $novdecomcount ?>;
        var novrepaircon = <?php echo $novrepaircount ?>;

        var decavailablecon = <?php echo $decavailablecount ?>;
        var decdecom = <?php echo $decdecomcount ?>;
        var decrepaircon = <?php echo $decrepaircount ?>;

        var total = <?php echo  $transfercount; ?>;
        var xValues = ["Januray", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        new Chart("overallChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Available",
                    data: [availablecon, febavailablecon, marchavailablecon, aprilavailablecon, mayavailablecon, juneavailablecon, julyavailablecon, augavailablecon, septavailablecon, octavailablecon, novavailablecon, decavailablecon],
                    borderColor: "blue",
                    fill: true
                }, {
                    label: "Unavailable - Decommissioned",
                    data: [decom, febdecom, marchdecom, aprildecom, maydecom, junedecom, julydecom, augdecom, septdecom, octdecom, novdecom, decdecom],
                    borderColor: "red",
                    fill: true
                }, {
                    label: "Unavailable - In Repair",
                    data: [repaircon, febrepaircon, marchrepaircon, aprilrepaircon, mayrepaircon, junerepaircon, julyrepaircon, augrepaircon, septrepaircon, octrepaircon, novrepaircon, decrepaircon],
                    borderColor: "green",
                    fill: true
                }, {
                    label: "Qty Transferred",
                    data: [total, total, total, total, total, total, total, total, total, total, total, total],
                    borderColor: "grey",
                    fill: false
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        });
    </script>



    <script>
        var rem = <?php echo  $remainder;  ?>;
        var availablecon = <?php echo $availablecount ?>;
        var decom = <?php echo $decomcount ?>;
        var repaircon = <?php echo $repaircount ?>;

        var xValues = ["Available", "Unavailable - Decommissioned", "Unavailable - In Repair"];
        var yValues = [availablecon, decom, repaircon];
        //var yValues = [0, 0, 0];
        var barColors = [
            "#2F5F98",
            "#2D8BBB",
            "#41B8D5",
            "#99B6E4",
        ];

        new Chart("myChart", {
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




    <script>
        var rem = <?php echo  $remainder;  ?>;
        $(document).ready(function() {
            $("select#filter").change(function() {
                var inputValue = $('#year').val();
                var itemid = $('#itemID').val();
                // var recordno = $('#recorID').val();
                var selectedfilter = $(this).children("option:selected").val();
                let newmonth = selectedfilter.toUpperCase();

                // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
                $('#taon').text(inputValue);
                $('#buwan').text(newmonth);

                $.ajax({
                    url: 'filter/sos_item_monthly_chart.php', // URL of the server-side script
                    type: 'POST', // Use the POST method
                    data: {
                        dropdown: selectedfilter,
                        year: inputValue,
                        itemID: itemid,
                        remainder: rem,
                    }, // Send any data that you need to the server
                    success: function(html) {
                        $('#filterresult').html(html); // Update the content of the div
                    }
                });
            });





        });
    </script>


<?php endif ?>

<?php include('inc/footer.php'); ?>