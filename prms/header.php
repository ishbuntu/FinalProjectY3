<!DOCTYPE html>
<html lang="en">

<head>
    <title>PRMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- <link href="js/select2/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

        <?php
        if (isset($_SESSION['email'])) {
        ?>

            <nav class="navbar navbar-expand-lg sticky-top bg-dark" id="mainmenu">

                <a class="navbar-brand text-warning" href="index.php">
                    <!-- <img src="img/logo.png" width="64px"> -->
                    P R M S
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
                    <span class="navbar-toggler-icon">
                        &#9776;
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <?php
                        if (isset($_SESSION['email'])) {
                            echo "<input type='hidden' id='session_user_id' value='" . $_SESSION['user_id'] . "'>";
                            echo "<input type='hidden' id='session_user_name' value='" . $_SESSION['user_name'] . "'>";
                            echo "<input type='hidden' id='session_email' value='" . $_SESSION['email'] . "'>";
                            echo "<input type='hidden' id='session_role' value='" . $_SESSION['role'] . "'>";
                        }
                        ?>
                    </ul>

                    <ul class="nav navbar-nav">
                        
                        <?php if($_SESSION['role'] == 'Property Owner') { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="property_list.php">
                            <i class="fa fa-home m-2"></i>    
                            My Properties</a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="tenancy_list.php">
                                <i class="fa fa-legal m-2"></i>
                                Tenancy Contracts</a>
                        </li>

                        <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="rental_list.php">
                            <i class="fa fa-dollar m-2"></i>
                                My Rentals</a>
                        </li>
                        <?php } ?>
                        
                        <li class="nav-item ">
                            <a class="nav-link" href="ticket_list.php">
                            <i class="fa fa-support m-2"></i>
                                Support Tickets</a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link" href="logout.php">
                            <i class="fa fa-sign-out m-2"></i>    
                            Logout</a>
                        </li>

                        <li class="nav-item px-md-2 mx-md-3">
                            <a class="nav-link text-warning" href="index.php">
                            <i class="fa fa-user m-2"></i> 
                                <?php echo $_SESSION['user_name']; ?> <span class="sr-only">(current)</span></a>
                        </li>
                        <?php 
                        if(isset($_SESSION['role'])) { ?>
                        <li class="nav-item px-md-2 mx-md-3">
                            <a class="nav-link text-info" href="switch.php">
                            <i class="fa fa-exchange m-2"></i> 
                                <?=$_SESSION['role'];?>
                            </a>
                        </li>
                        <?php  } ?>

                    </ul>
                </div>
            </nav>

            <div class="container-fluid">


        <?php } else { ?>

            <nav class="navbar navbar-expand-lg sticky-top bg-dark" id="mainmenu">

                <a class="navbar-brand text-warning" href="index.php">
                    <!-- <img src="img/logo.png" width="64px"> -->
                    P R M S
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
                    <span class="navbar-toggler-icon">
                        &#9776;
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="login.php">Login / Register</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <?php if(strpos($_SERVER['SCRIPT_NAME'], 'index.php')>0) {?>
            
            <div class="jumbotron  bg-dark text-light" style="background-image: url(https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8cmVhbCUyMGVzdGF0ZXxlbnwwfHwwfHw%3D&w=1000&q=80);
                background-repeat: x-repeat; background-size: cover; background-position: center center">
                <h1 class="display-1 my-4">Welcome to PRMS</h1>
            </div>
            <?php } ?>

            <div class="container-fluid">

        <?php } ?>