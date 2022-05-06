<?php
session_start();
if (isset($_SESSION['email'])) header('Location:index.php');

$error_message = "";
$message_class = "text-danger";

if (isset($_POST['login'])) {
    require_once('db.php');
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $conn->real_escape_string($_POST['password']);

    $sql = "select * from user 
            where email = '$email' and password = '$pass'";
       
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        foreach ($row as $key => $value)
            $_SESSION[$key] = $value;
        $_SESSION['role'] = $_POST['role'];
        header('Location:index.php');
    } else
        $error_message = "Invalid UserName or Password";
}

if (isset($_POST['register'])) {
    require_once('db.php');
    $name = $conn->real_escape_string($_POST['user_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $pass = $conn->real_escape_string($_POST['password']);
    
    $data = array('user_name' => $name, 'email' => $email, 'password' => $pass, 'mobile' => $mobile);
    $result = dbinsert('user', $data);
       
    if (!$result[0]) $error_message = "Unable to register the user.";
    else {
        $message_class = "text-success";
        $error_message = "User registered successfully.";
    }
}

?>

<?php require_once('header.php') ?>
<div class="row justify-content-md-center mt-5 p-5">
    
    <div class="col-md-3 bg-dark text-light d-flex">
        <h1 class="m-auto"><small>Welcome to</small><br/>PRMS</h1>
    </div>
    <div id="" class="col-md-4 bg-white p-3">
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item"><a class="nav-link active" href="#login" data-toggle="tab"><h6>Login</h6></a></li>
            <li class="nav-item"><a class="nav-link" href="#register" data-toggle="tab"><h6>Sign Up</h6></a></li>
        </ul>

        <div id="myTabContent" class="tab-content p-3">

            <div class="tab-pane active" id="login">
                <!-- <h2 class="text-center mb-4">Login</h2> -->
                <form id="frmLogin" name="frmLogin" action="login.php" method="post">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control">
                    <label>View As</label>
                    <select name='role' class="form-control" required>
                        <option value="Property Owner">Property Owner</option>
                        <option value="Tenant">Tenant</option>
                    </select>
                    <button name="login" class="btn btn-primary mt-3">Login</button>
                    <a class="float-right mt-4" href='forget_password.php'>Forgot Password?</a>
                </form>
            </div>

            <div class="tab-pane fade" id="register">
                <form id="frmRegister" name="frmRegister" action="login.php" method="post">
                    <label>Name</label>
                    <input name="user_name" type="text" class="form-control">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control">
                    <label>Mobile</label>
                    <input name="mobile" type="tel" class="form-control">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control">

                    <button name="register" class="btn btn-primary mt-3">Register</button>

                </form>
            </div>
        </div>

        <p class="<?=$message_class?> text-center font-weight-bold"><?=$error_message;?></p>
    </div>


</div>

<?php require_once('footer.php') ?>