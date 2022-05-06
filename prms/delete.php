<?php
session_start();
if (!isset($_SESSION['email'])) header('Location:index.php');

if (!isset($_POST['params'])) header("Location: index.php");
$params = json_decode($_POST['params'], true);
$table = $params['table'];
$where = $params['where'];
require_once('db.php');
require_once('dbget.php');

$is_error = false;
if (isset($_POST['confirm']))
    if ($_POST['confirm'] == 'Yes') {
        $media_url = "";
        if($table=='media') {
            $sql = "SELECT media_url FROM media WHERE $where";
            $media_url = dbselect($sql)->fetch_assoc()["media_url"];
        }
        $res = dbselect("DELETE FROM $table WHERE $where");
        if ($res) {
            if($media_url != "") {
                unlink("uploads/$media_url");
            }
            header('Location: ' . $params['callback']);
        } else {
            $is_error = true;
        }
    }

require_once('header.php');

echo "<div class='container'>";

if($is_error) {
    echo "<div class='text-center w-50 mx-auto mt-5'>";
    echo "<h4 class='text-danger'>Error while processing delete request.</h4>";
    echo "<h6>Please remove all child records, if you want to remove this record.</h6>";
    echo "<a class='btn btn-primary'  href='". $params['callback'] ."'>Go Back</a>";  
    echo "</div>";
    exit;
}
// print_r($_REQUEST);
// die();
$sql = "select * from $table where $where";
$res = dbselect($sql);
$rows = $res->fetch_all(MYSQLI_ASSOC);

if ($res->num_rows == 1) {
    echo "<div class='card mx-auto my-3 w-50'>
            <div class='card-header bg-danger text-light'>
                <h5>Are you SURE you want to DELETE this record?</h5>
            </div>
            <div class='card-body' style='height:300px; overflow-y: scroll;'>
                <table class='table-sm'>
    ";
    foreach ($rows[0] as $key => $val) {
        echo "<tr><td>" . format_label($key) . "</td><th>$val</th>";
    }
    echo "
                </table>
            </div>
            <div class='card-footer'>
                <form method='post'>
                    <input type='hidden' name= 'params' value='" . json_encode($params) . "'/>
                    <button type=submit name='confirm' value='Yes' class='btn btn-danger'>Yes</button>
                    <a onclick='window.location=\"" . $params['callback'] . "\"' value='No' class='btn btn-secondary text-light'>No</a>
            </div>
    </div>";
} else {
    header('Location: ' . $params['callback']);
}

require_once('footer.php');

?>