<?php

session_start();

$userloginid = $_SESSION["userid"] = $_GET['userlogid'];
// echo $_SESSION["userid"];


?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- <link rel="stylesheet" href="otheruser_dashboard.css"> -->
    <link rel="stylesheet" href="admin_service_dashboard.css">
</head>

<body>

    <?php
    include("data_class.php");
    ?>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class="fas fa-book"></i>
                <div class="logo_name">Library M</div>
            </div>
        </div>
        <ul class="nav-list">
            <li>
                <Button><i class="fas fa-home"></i> Welcome</Button>
            </li>
            <li>
                <Button onclick="openpart('myaccount')"><i class="fas fa-plus-square"></i> My Account</Button>
            </li>
            <li>
                <Button onclick="openpart('requestbook')"><i class="fas fa-book"></i> Request Book</Button>
            </li>
            <li>
                <Button onclick="openpart('issuereport')"><i class="fas fa-heart"></i>Issued Book Report</Button>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <!-- <img src="images\sanjay.png" alt=""> -->
                    <div class="name_job">
                        <div class="name">User</div>
                        <div class="job">Logout</div>
                    </div>
                </div>

                <Button><a href="index.php"><i class="fas fa-sign-out-alt" id="Log_out"></i></a></Button>
            </div>
        </div>
    </div>
    <!-- *********************************************************************************************************
    ********************************************************************************************************* -->
    <div class="container">
        <div class="innerdiv">

            <div class="rightinnerdiv">
                <div id="myaccount" class="innerright portion" style="<?php if (!empty($_REQUEST['returnid'])) {
                                                                            echo "display:none";
                                                                        } else {
                                                                            echo "";
                                                                        } ?>">
                    <Button class="greenbtn">My Account</Button>

                    <?php

                    $u = new data;
                    $u->setconnection();
                    $u->userdetail($userloginid);
                    $recordset = $u->userdetail($userloginid);
                    foreach ($recordset as $row) {

                        $id = $row[0];
                        $name = $row[1];
                        $email = $row[2];
                        $pass = $row[3];
                        $type = $row[4];
                    }
                    ?>
                    <div class="person_d">
                        <p><u>Person Name:</u> &nbsp&nbsp<?php echo $name ?></p>
                        <p><u>Person Email:</u> &nbsp&nbsp<?php echo $email ?></p>
                        <p><u>Account Type:</u> &nbsp&nbsp<?php echo $type ?></p>
                    </div>
                </div>
            </div>






            <div class="rightinnerdiv">
                <div id="issuereport" class="innerright portion" style="<?php if (!empty($_REQUEST['returnid'])) {
                                                                            echo "display:none";
                                                                        } else {
                                                                            echo "display:none";
                                                                        } ?>">
                    <Button class="greenbtn">ISSUED BOOKS RECORD</Button>

                    
                        <?php

                        $userloginid = $_SESSION["userid"] = $_GET['userlogid'];
                        $u = new data;
                        $u->setconnection();
                        $u->getissuebook($userloginid);
                        $recordset = $u->getissuebook($userloginid);

                        $table = "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse:
                                  collapse;width: 100%;'><tr><th style='  border: 0px solid #ddd;
                                  padding: 10px;'>Name</th><th>Book Name</th><th>Issue Date</th>
                                  <th>Return Date</th><th>Fine</th></th><th>Return</th></tr>";

                        foreach ($recordset as $row) {
                            $table .= "<tr>";
                            "<td>$row[0]</td>";
                            $table .= "<td>$row[2]</td>";
                            $table .= "<td>$row[3]</td>";
                            $table .= "<td>$row[6]</td>";
                            $table .= "<td>$row[7]</td>";
                            $table .= "<td>$row[8]</td>";
                            $table .= "<td>
                            <a href='otheruser_dashboard.php?returnid=$row[0]&userlogid=$userloginid'>
                            <button type='button' class='b'>Return</button>
                            </a></td>";
                            $table .= "</tr>";
                            // $table.=$row[0];
                        }
                        $table .= "</table>";
                        echo $table;
                        ?>
                    

                </div>
            </div>


            <div class="rightinnerdiv">
                <div id="return" class="innerright portion" style="<?php if (!empty($_REQUEST['returnid'])) {
                                                                        $returnid = $_REQUEST['returnid'];
                                                                    } else {
                                                                        echo "display:none";
                                                                    } ?>">
                    <Button class="greenbtn">Return Book</Button>

                    <?php

                    $u = new data;
                    $u->setconnection();
                    $u->returnbook($returnid);
                    $recordset = $u->returnbook($returnid);
                    ?>

                </div>
            </div>


            <div class="rightinnerdiv">
                <div id="requestbook" class="innerright portion" style="<?php if (!empty($_REQUEST['returnid'])) {
                                                                            $returnid = $_REQUEST['returnid'];
                                                                            echo "display:none";
                                                                        } else {
                                                                            echo "display:none";
                                                                        } ?>">
                    <Button class="greenbtn">Request Book</Button>

                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->getbookissue();
                    $recordset = $u->getbookissue();

                    $table = "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: 
                    collapse;width: 100%;'><tr ><th style=' padding: 10px;'>Image</th><th>Book Name</th>
                    <th>Book Authour</th><th>Branch</th><th>Price</th></th><th>Request Books</th></tr>";

                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        "<td>$row[0]</td>";
                        $table .= "<td><img src='uploads/$row[1]' width='100px' height='130px' 
                        style='margin:10px;border-radius:12px;border:4px solid rgba(255, 127, 0,0.5);'></td>";
                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[4]</td>";
                        $table .= "<td>$row[6]</td>";
                        $table .= "<td>$row[7]</td>";
                        $table .= "<td><a href='requestbook.php?bookid=$row[0]&userid=$userloginid'>
                        <button type='button' class='b'>Request</button></a></td>";

                        $table .= "</tr>";
                        // $table.=$row[0];
                    }
                    $table .= "</table>";

                    echo $table;


                    ?>

                </div>
            </div>

        </div>
    </div>


    <script>
        function openpart(portion) {
            var i;
            var x = document.getElementsByClassName("portion");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(portion).style.display = "block";
        }
    </script>
    <script src="https://kit.fontawesome.com/d35fbd3f4e.js" crossorigin="anonymous"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>