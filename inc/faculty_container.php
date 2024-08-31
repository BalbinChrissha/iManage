<link rel="icon" type="image/png" href="images/PSU_logo1.png">
</head>

<body class="">
    <div style="width: 100%; background-color: #89BBEA; position: sticky; top: 0; z-index: 1;" class="sticky-top p-0">

        <nav class="navbar navbar-light bg-light navbar-expand-md">
            <div class="container-fluid"><a class="navbar-brand" href="faculty_dashboard.php"> <img src="images/IMANAGE3.png" width="50" height="50" alt=""></a><button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div id="navcol-1" class="collapse navbar-collapse text-center">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="faculty_dashboard.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_filter_item.php">FILTER INVENTORY</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_report.php">REPORTS</a></li>
                        <li class="nav-item"><a class="nav-link" href="faculty_monthly_item_report.php">MONTHLY REPORTS</a></li>
                        <li class="nav-item"><a class="nav-link dropdown-toggle" href="#" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">SETTINGS</a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <center><button type="button" class="col-8 btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropmema">
                                            PROFILE
                                        </button></center>
                                </li>
                                <li><a class="dropdown-item" href="?logout='1'">
                                        <center>LOGOUT
                                    </a></center>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div style=" background-color: #89BBEA; height: 40px; padding: 8px;" class="col-11 mx-auto">
            <div class="row">
                <div class="col-6">
                    <i class="fa-solid fa-user"></i> Faculty &nbsp; <b>|</b>&nbsp; <b><?php echo $_SESSION['faculty_incharge']['faculty_name']; ?></b>
                </div>
                <div class="col-6" align="right" ;>

                    <?php date_default_timezone_set('Asia/Manila');
                    echo date('D jS F Y'); ?>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="staticBackdropmema" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mx-auto">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><b><?php echo $_SESSION['faculty_incharge']['faculty_name']; ?></b> : Update Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="faculty_dashboard.php?logout='1'" method="post">
                        <div class="col-10 mx-auto">
                            <input type="hidden" class="form-control" value="<?php echo $_SESSION['faculty_incharge']['facultyID']; ?>" name="facultyid">
                            <div class="mb-3">
                                <label>Username: </label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['faculty_incharge']['faculty_username']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Old Password: </label>
                                <input type="password" class="form-control" pattern="^<?php echo $_SESSION['faculty_incharge']['faculty_password']; ?>$" required>
                            </div>
                            <div class="mb-3">
                                <label>New Password: </label>
                                <input type="password" name="password" class="form-control" minlength="6" maxlength="12" required>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <input type="submit" name="faculty_change_mypassword" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_POST['faculty_change_mypassword'])) {
        $db = mysqli_connect('localhost', 'root', '', 'imanage');
        $facultyID = $_POST['facultyid'];
        $password = $_POST['password'];
        $dataset = $db->query("UPDATE faculty_incharge SET faculty_password = '$password' WHERE facultyID =$facultyID") or die("Error query");
    }

    ?>