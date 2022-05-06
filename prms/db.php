<?php

    $db_host = 'localhost';
    $db_port = '3306';
    $db_username = 'root';
    $db_password = '';
    $db_primaryDatabase = 'prms';

    
    $conn = new mysqli($db_host, $db_username, $db_password, $db_primaryDatabase);
    
    if (mysqli_connect_errno()) {
        die("Could not connect to MySQL databse: " . mysqli_connect_error());
    }

    function get_summary_info($table, $where = '1=1', $function='count(*)'){
        $sql = "select $function from $table where $where";
        try {
            $result = $GLOBALS['conn']->query($sql);
            $row = $result->fetch_array();
            return $row[0];
        } catch (\Throwable $th) {
            return $sql;
        }
    }

    function insert_or_update($table, $data) {
        $result = dbselect("select * from $table where 1<>1");
        $cols = mysqli_fetch_fields($result);
        $clist = ''; $ilist = ''; $ulist=''; $mask = '';
        
        foreach ($cols as $col) {
            if (isset($data[$col->name])){
                $clist .= "$col->name, ";
                $ilist .= "'". $GLOBALS['conn']->real_escape_string($data[$col->name]) . "', ";
                $ulist .= "$col->name = '" . $GLOBALS['conn']->real_escape_string($data[$col->name]) . "', ";
            }
        }
        
        $clist = rtrim($clist, ", ");
        $ilist = rtrim($ilist, ", ");
        $ulist = rtrim($ulist, ", ");

        $sql = "INSERT INTO $table ($clist) VALUES ($ilist) 
        ON DUPLICATE KEY UPDATE 
        $ulist";

        $sql = str_replace("''", 'null', $sql);
        $sql = str_replace("'current_timestamp'", 'current_timestamp', $sql);
        
        try {
            $result = $GLOBALS['conn']->query($sql);
            if ($result) return [true, $GLOBALS['conn']->insert_id];
            else return [false, "Error: " . $GLOBALS['conn']->error];
        } catch(Exception $e) {
            debug($sql);
            // return [false, "Error: " . $e->getMessage()];
        }
    }

    function dbinsert($table, $data) {
        $result = dbselect("select * from $table where 1<>1");
        $cols = mysqli_fetch_fields($result);
        $clist = ''; $ilist = ''; $ulist=''; $mask = '';
        
        foreach ($cols as $col) {
            if (isset($data[$col->name])){
                $clist .= "$col->name, ";
                $ilist .= "'". $GLOBALS['conn']->real_escape_string($data[$col->name]) . "', ";
                $ulist .= "$col->name = '" . $GLOBALS['conn']->real_escape_string($data[$col->name]) . "', ";
            }
        }
        
        $clist = rtrim($clist, ", ");
        $ilist = rtrim($ilist, ", ");
        $ulist = rtrim($ulist, ", ");

        $sql = "INSERT INTO $table ($clist) VALUES ($ilist)";

        $sql = str_replace("''", 'null', $sql);
        $sql = str_replace("'current_timestamp'", 'current_timestamp', $sql);
        
        try {
            $result = $GLOBALS['conn']->query($sql);
            if ($result) return [true, $GLOBALS['conn']->insert_id];
            else return [false, "Error: " . $GLOBALS['conn']->error];
        } catch(Exception $e) {
            return [false, "Error: " . $e->getMessage()];
        }
    }

    function dbselect ($sql) {
        try {
            $result = $GLOBALS['conn']->query($sql);            
            return $result;
        } catch (\Throwable $th) {
            die('Error: ' . $sql);
        }
    }

    if (isset($_GET['sql'])) {
        $sql = $_GET['sql'];
        $result = dbselect($sql);
        if(stripos($sql, 'select') !== false) $result = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($result, true);
        return;
    }
 
?>
