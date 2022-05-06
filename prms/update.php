<?php
session_start();
if (!isset($_SESSION['email'])) header("Location:index.php");

require_once('db.php');
require_once('dbget.php');
if (!isset($_POST['table']) && isset($_POST['params'])) {
    $_POST = json_decode($_POST['params'], true);
}

if (!isset($_POST['table'])) header("Location:index.php");

debug($_POST);

try {
    if (isset($_FILES['media_url']) && $_FILES["media_url"]["error"] == 0 ) {

        $fileInfo = pathinfo($_FILES['media_url']["name"]);
        $fileType = strtolower($fileInfo['extension']);
        if (in_array(strtolower($fileType), ['jpg', 'png', 'bmp', 'tif', 'jpeg', 'svg']))
            $_POST['media_type'] = 'image';
        elseif (in_array(strtolower($fileType), ['mp4', 'mov', 'wmv', 'avi', '3gp', 'mkv', 'm4v', 'flv']))
            $_POST['media_type'] = 'video';
        else
            $_POST['media_type'] = 'document';

        $uid = uniqid();
        $_POST['media_url'] = $uid . '.' . $fileInfo['extension'];

        if (
            !move_uploaded_file(
                $_FILES["media_url"]["tmp_name"],
                "uploads/" . $_POST['media_url']
            )
        )
            die("Sorry, there was an error uploading your file.");
    } else {
        // print_r($_POST);
        // die();
    }

    $result = insert_or_update($_POST['table'], $_POST);
    if (!$result[0]) die($result[1]);

    if (isset($_POST['triggers'])) {
        $triggers = json_decode($_POST['triggers'], true);
        
        if (isset($triggers[$action])) {
            $sql = $triggers[$action];
            if ($sql) $conn->query($sql);
        }
    }

    if (isset($_POST['link'])) {
        $last_id = $result[1];
        $data = $_POST;
        $link = json_decode($_POST['link'], true);
        foreach ($link['values'] as $key => $val) {
            $data[$key] = $val;
            if ($val == '?') $data[$key] = $last_id;
        }
        $result = insert_or_update($link['table'], $data);
        if (!$result[0]) die($result[1]);
    }

} catch (\Throwable $th) {
    echo "ERROR";
    print_r($th);
    die();
}

header('Location:' . $_POST['callback']);
