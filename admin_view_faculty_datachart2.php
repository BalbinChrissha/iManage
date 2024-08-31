<?php
include('functions.php');
include('sos_function.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}


if (!isset($_SESSION['admin'])) {
    header('location: index.php');
}

if ((!isset($_GET['recordno'])) && (!isset($_GET['catID']))  && (!isset($_GET['facultyid']))) {
    header('location: admin_view_faculty.php');
}


include('inc/header.php');
?>

<title>Data Analytics</title>
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


<?php include('inc/admincontainer.php'); ?>
<?php if ((isset($_GET['recordno']))  && (isset($_GET['catID'])) && (isset($_GET['facultyid']))) : ?>
    <?php global $recordno, $categoryID, $facultyID;
    $recordno = $_GET['recordno'];
    $catID = $_GET['catID'];
    $facultyID = $_GET['facultyid'];



    $sql = "SELECT item_transfer.recordno, qty_transferred, item.itemid, item_name, category_name FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_transfer.recordno =$recordno AND facultyID = $facultyID GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
    $dataset = $db->query($sql) or die("Error query");

    if (mysqli_num_rows($dataset) > 0) {
        while ($data = $dataset->fetch_assoc()) {
            $item_name = $data['item_name'];
            $qty_transferred = $data['qty_transferred'];





            //////////////////January///////////////////////////////
            $sql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='january' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
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

    ?>




            <div class="col-10 mx-auto my-5 bg-light rounded">
                <input type="hidden" name="year" id="facultyID" value="<?php echo $facultyID; ?>">
                <input type="hidden" name="year" id="recorID" value="<?php echo $recordno; ?>">

                <div class="col-sm-12 mx-auto p-5">
                    <center>
                        <h3 id="title"><b>ITEM <?php echo  strtoupper($item_name); ?> : REPORT FOR THE YEAR OF 2023</b></h3>
                    </center><br>


                    <div>
                        <center><canvas id="overallChart" style="width:100%;max-width:800px"></canvas></center>
                    </div>
                </div>
            </div>

            <!-- overall sql -->
            <?php

            //////////////////February///////////////////////////////
            $sqlfeb1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='february' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $febdataset1 = mysqli_query($db, $sqlfeb1);
            if (mysqli_num_rows($febdataset1) > 0) {
                $febdata = mysqli_fetch_assoc($febdataset1);
                $febavailablecount = $febdata['available_qty'];
                $febconsumedcount = $febdata['unavailable1_qty'];
                $febexpiredcount = $febdata['unavailable2_qty'];
            } else {
                $febavailablecount = 0;
                $febconsumedcount = 0;
                $febexpiredcount = 0;
            }


            // MARCHHHHHHHHHHHHHH
            $marchsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='march' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $marchdataset1 = mysqli_query($db, $marchsql1);
            if (mysqli_num_rows($marchdataset1) > 0) {
                $marchdata = mysqli_fetch_assoc($marchdataset1);
                $marchavailablecount = $marchdata['available_qty'];
                $marchconsumedcount = $marchdata['unavailable1_qty'];
                $marchexpiredcount = $marchdata['unavailable2_qty'];
            } else {
                $marchavailablecount = 0;
                $marchconsumedcount = 0;
                $marchexpiredcount = 0;
            }

            /// APRIL
            $aprilsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='april' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $aprildataset1 = mysqli_query($db, $aprilsql1);
            if (mysqli_num_rows($aprildataset1) > 0) {
                $aprildata = mysqli_fetch_assoc($aprildataset1);
                $aprilavailablecount = $aprildata['available_qty'];
                $aprilconsumedcount = $aprildata['unavailable1_qty'];
                $aprilexpiredcount = $aprildata['unavailable2_qty'];
            } else {
                $aprilavailablecount = 0;
                $aprilconsumedcount = 0;
                $aprilexpiredcount = 0;
            }


            /// MAY
            $maysql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='may' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $maydataset1 = mysqli_query($db, $maysql1);
            if (mysqli_num_rows($maydataset1) > 0) {
                $maydata = mysqli_fetch_assoc($maydataset1);
                $mayavailablecount = $maydata['available_qty'];
                $mayconsumedcount = $maydata['unavailable1_qty'];
                $mayexpiredcount = $maydata['unavailable2_qty'];
            } else {
                $mayavailablecount = 0;
                $mayconsumedcount = 0;
                $mayexpiredcount = 0;
            }


            /// JUNE
            $junesql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='june' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $junedataset1 = mysqli_query($db, $junesql1);
            if (mysqli_num_rows($junedataset1) > 0) {
                $junedata = mysqli_fetch_assoc($junedataset1);
                $juneavailablecount = $junedata['available_qty'];
                $juneconsumedcount = $junedata['unavailable1_qty'];
                $juneexpiredcount = $junedata['unavailable2_qty'];
            } else {
                $juneavailablecount = 0;
                $juneconsumedcount = 0;
                $juneexpiredcount = 0;
            }



            /// JULY
            $julysql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='july' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $julydataset1 = mysqli_query($db, $julysql1);
            if (mysqli_num_rows($julydataset1) > 0) {
                $julydata = mysqli_fetch_assoc($julydataset1);
                $julyavailablecount = $julydata['available_qty'];
                $julyconsumedcount = $julydata['unavailable1_qty'];
                $julyexpiredcount = $julydata['unavailable2_qty'];
            } else {
                $julyavailablecount = 0;
                $julyconsumedcount = 0;
                $julyexpiredcount = 0;
            }

            /// AUGUST
            $augsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='august' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $augdataset1 = mysqli_query($db, $augsql1);
            if (mysqli_num_rows($augdataset1) > 0) {
                $augdata = mysqli_fetch_assoc($augdataset1);
                $augavailablecount = $augdata['available_qty'];
                $augconsumedcount = $augdata['unavailable1_qty'];
                $augexpiredcount = $augdata['unavailable2_qty'];
            } else {
                $augavailablecount = 0;
                $augconsumedcount = 0;
                $augexpiredcount = 0;
            }

            /// SEPTEMBER
            $septsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='september' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $septdataset1 = mysqli_query($db, $septsql1);
            if (mysqli_num_rows($septdataset1) > 0) {
                $septdata = mysqli_fetch_assoc($septdataset1);
                $septavailablecount = $septdata['available_qty'];
                $septconsumedcount = $septdata['unavailable1_qty'];
                $septexpiredcount = $septdata['unavailable2_qty'];
            } else {
                $septavailablecount = 0;
                $septconsumedcount = 0;
                $septexpiredcount = 0;
            }

            /// OCTOBER
            $octsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='october' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $octdataset1 = mysqli_query($db, $octsql1);
            if (mysqli_num_rows($octdataset1) > 0) {
                $octdata = mysqli_fetch_assoc($octdataset1);
                $octavailablecount = $octdata['available_qty'];
                $octconsumedcount = $octdata['unavailable1_qty'];
                $octexpiredcount = $octdata['unavailable2_qty'];
            } else {
                $octavailablecount = 0;
                $octconsumedcount = 0;
                $octexpiredcount = 0;
            }


            /// NOVEMBER
            $novsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='november' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $novdataset1 = mysqli_query($db, $novsql1);
            if (mysqli_num_rows($novdataset1) > 0) {
                $novdata = mysqli_fetch_assoc($novdataset1);
                $novavailablecount = $novdata['available_qty'];
                $novconsumedcount = $novdata['unavailable1_qty'];
                $novexpiredcount = $novdata['unavailable2_qty'];
            } else {
                $novavailablecount = 0;
                $novconsumedcount = 0;
                $novexpiredcount = 0;
            }


            /// DECEMBER
            $decsql1 = "SELECT item_transfer.recordno, item.itemid, item_name, category_name, available_qty, unavailable1_qty, unavailable2_qty,month, year FROM item, category, item_transfer, item_last_checked , item_state WHERE category.categoryID=item.categoryID AND item.itemid=item_transfer.itemID AND item_transfer.recordno=item_state.recordno AND item_state.checkedID = item_last_checked.checkedID  AND item_transfer.recordno =$recordno AND facultyID = $facultyID AND month='december' AND year =2023 GROUP BY item_transfer.recordno ORDER BY item_state.recordno";
            $decdataset1 = mysqli_query($db, $decsql1);
            if (mysqli_num_rows($decdataset1) > 0) {
                $decdata = mysqli_fetch_assoc($decdataset1);
                $decavailablecount = $decdata['available_qty'];
                $decconsumedcount = $decdata['unavailable1_qty'];
                $decexpiredcount = $decdata['unavailable2_qty'];
            } else {
                $decavailablecount = 0;
                $decconsumedcount = 0;
                $decexpiredcount = 0;
            }

            ?>



            <div class="col-10 mx-auto my-5 bg-light rounded">
                <input type="hidden" name="year" id="facultyID" value="<?php echo $facultyID; ?>">
                <input type="hidden" name="year" id="recorID" value="<?php echo $recordno; ?>">

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
                                    <input type="hidden" name="year" id="facultyID" value="<?php echo $facultyID; ?>" class="form-control mb-3" required>
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
    } else {

        ?>


        <div class="container" style="margin-top: 10%;">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-xl-8">
                    <div class="card mb-8">
                        <div class="card-body d-flex flex-column align-items-center">

                            <center><h2><b>THERE IS NO RECORD YET FOR THIS TRANSFERRED ITEM</b></h2></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    <?php
    } ?>


    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        var availablecon = <?php echo $availablecount ?>;
        var consumed = <?php echo $consumedcount ?>;
        var expiredcon = <?php echo $expiredcount ?>;

        // feb
        var febavailablecon = <?php echo $febavailablecount ?>;
        var febconsumed = <?php echo $febconsumedcount ?>;
        var febexpiredcon = <?php echo $febexpiredcount ?>;

        // march
        var marchavailablecon = <?php echo $marchavailablecount ?>;
        var marchconsumed = <?php echo $marchconsumedcount ?>;
        var marchexpiredcon = <?php echo $marchexpiredcount ?>;

        // april
        var aprilavailablecon = <?php echo $aprilavailablecount ?>;
        var aprilconsumed = <?php echo $aprilconsumedcount ?>;
        var aprilexpiredcon = <?php echo $aprilexpiredcount ?>;

        // may
        var mayavailablecon = <?php echo $mayavailablecount ?>;
        var mayconsumed = <?php echo $mayconsumedcount ?>;
        var mayexpiredcon = <?php echo $mayexpiredcount ?>;

        // june
        var juneavailablecon = <?php echo $juneavailablecount ?>;
        var juneconsumed = <?php echo $juneconsumedcount ?>;
        var juneexpiredcon = <?php echo $juneexpiredcount ?>;

        // july
        var julyavailablecon = <?php echo $julyavailablecount ?>;
        var julyconsumed = <?php echo $julyconsumedcount ?>;
        var julyexpiredcon = <?php echo $julyexpiredcount ?>;

        // august
        var augavailablecon = <?php echo $augavailablecount ?>;
        var augconsumed = <?php echo $augconsumedcount ?>;
        var augexpiredcon = <?php echo $augexpiredcount ?>;

        // september
        var septavailablecon = <?php echo $septavailablecount ?>;
        var septconsumed = <?php echo $septconsumedcount ?>;
        var septexpiredcon = <?php echo $septexpiredcount ?>;

        // october
        var octavailablecon = <?php echo $octavailablecount ?>;
        var octconsumed = <?php echo $octconsumedcount ?>;
        var octexpiredcon = <?php echo $octexpiredcount ?>;

        // november
        var novavailablecon = <?php echo $novavailablecount ?>;
        var novconsumed = <?php echo $novconsumedcount ?>;
        var novexpiredcon = <?php echo $novexpiredcount ?>;

        var decavailablecon = <?php echo $decavailablecount ?>;
        var decconsumed = <?php echo $decconsumedcount ?>;
        var decexpiredcon = <?php echo $decexpiredcount ?>;

        var total = <?php echo  $qty_transferred;  ?>;

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
                    label: "Consumed",
                    data: [consumed, febconsumed, marchconsumed, aprilconsumed, mayconsumed, juneconsumed, julyconsumed, augconsumed, septconsumed, octconsumed, novconsumed, decconsumed],
                    borderColor: "red",
                    fill: true
                }, {
                    label: "Expired",
                    data: [expiredcon, febexpiredcon, marchexpiredcon, aprilexpiredcon, mayexpiredcon, juneexpiredcon, julyexpiredcon, augexpiredcon, septexpiredcon, octexpiredcon, novexpiredcon, decexpiredcon],
                    borderColor: "green",
                    fill: true
                }, {
                    label: "Total Quantity",
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
        var availablecon = <?php echo $availablecount ?>;
        var consumed = <?php echo $consumedcount ?>;
        var expiredcon = <?php echo $expiredcount ?>;

        var xValues = ["Available", "Consumed", "Expired"];
        var yValues = [availablecon, consumed, expiredcon];
        //var yValues = [0, 0, 0];
        var barColors = [
            "#2F5F98",
            "#2D8BBB",
            "#41B8D5"
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
        $(document).ready(function() {
            $("select#filter").change(function() {
                var inputValue = $('#year').val();
                var facultyno = $('#facultyID').val();
                var recordno = $('#recorID').val();
                var selectedfilter = $(this).children("option:selected").val();
                let newmonth = selectedfilter.toUpperCase();

                // $('#buwan').replaceWith('<span id="buwan">' + newmonth + '</span>');
                $('#taon').text(inputValue);
                $('#buwan').text(newmonth);

                $.ajax({
                    url: 'filter/item_monthly_chart2.php', // URL of the server-side script
                    type: 'POST', // Use the POST method
                    data: {
                        dropdown: selectedfilter,
                        year: inputValue,
                        facultyID: facultyno,
                        recordID: recordno
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