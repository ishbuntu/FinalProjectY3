<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}
?>

<?php
ini_set('file_uploads', 'On');

if (!isset($_POST['params'])) header("Location:index.php");
$params = json_decode($_POST['params'], true);

if (!isset($params['table'])) header("Location:index.php");
$table = $params['table'];

$title = $table;
if (isset($params['title'])) $title = $params['title'];

$currency = '£';
if (isset($params['currency'])) $currency = $params['currency'];

$action = 'add';
if (isset($params['action'])) $action = $params['action'];

$where = '1<>1';
if (isset($params['where'])) $where = $params['where'];

$callback = 'index.php';
if (isset($params['callback'])) $callback = $params['callback'];

$delcallback = $callback;
if (isset($params['delcallback'])) $delcallback = $params['delcallback'];

$btn_delete = true;
if (isset($params['btn_delete'])) $btn_delete = $params['btn_delete'];

$values = [];
if (isset($params['values'])) $values = $params['values'];

$attributes = [];
if (isset($params['attributes'])) $attributes = $params['attributes'];

$types = [];
if (isset($params['types'])) $types = $params['types'];

$checks = [];
if (isset($params['checks'])) $checks = $params['checks'];

$labels = [];
if (isset($params['labels'])) $labels = $params['labels'];

$dropdowns = [];
if (isset($params['dropdowns'])) $dropdowns = $params['dropdowns'];

$divsizes = [];
if (isset($params['divsizes'])) $divsizes = $params['divsizes'];

$link = [];
if (isset($params['link'])) $link = $params['link'];

$triggers = [];
if (isset($params['triggers'])) $triggers = $params['triggers'];

$scripts = [];
if (isset($params['scripts'])) $scripts = $params['scripts'];

$buttons = [];
if (isset($params['buttons'])) $buttons = $params['buttons'];

$sql = "select * from $table where $where";
if (isset($params['sql'])) $sql = $params['sql'];


require_once('db.php');
require_once('dbget.php');

// debug($sql);
?>

<?php require_once('header.php') ?>

<div class="container px-md-5">


    <?php

    // $sql = "select * from $table where $where";
    $result = dbselect($sql);
    
    echo "<h2 class='my-3'>" . format_label($title) . "</h2>";

    echo "<form id='detail' action='update.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='hidden' name='table' value='$table' />";
    echo "<input type='hidden' name='action' value='$action' />";
    echo "<input type='hidden' name='callback' value='$callback' />";
    echo "<input type='hidden' name='delcallback' value='$delcallback' />";
    echo "<input type='hidden' name='where' value='$where' />";
    
    if (!empty($link))
        echo "<input type='hidden' name='link' value='" . json_encode($link) . "' />";

    if (!empty($triggers))
        echo "<input type='hidden' name='triggers' value='" . json_encode($triggers) . "' />";


    $columns = mysqli_fetch_fields($result);

    if (isset($link['columns'])) {
        $array_of_cols = [];
        foreach ($link['columns'] as $key => $val) {
            $col = new stdClass();
            $col->name = $key;
            array_push($array_of_cols, $col);
        }
        $columns = array_merge($columns, $array_of_cols);
    }

    $colindex = 0;
    $row = $result->fetch_assoc();
    echo "<div class='row'>";
    echo "<div class='col-md-8 bg-form'>";
    echo "<div class='row'>";
    foreach ($columns as $col) {
        if (isset($attributes[$col->name])) if ($attributes[$col->name] == 'hidden') continue;

        $type = 'text';
        if (isset($types[$col->name])) $type = $types[$col->name];

        $state = '';
        if ($action == 'view') $state = 'disabled'; 
        elseif (isset($attributes[$col->name])) $state = $attributes[$col->name];

        $star = '';
        if($state == 'required') $star = "<span class='text-danger required'> *</span>";

        if ($type != 'hidden') {
            $divClass = "col-sm-6";
            if (isset($divsizes[$col->name])) $divClass = "col-sm-" . $divsizes[$col->name];
            echo "<div class='$divClass'>";
            
            $label = $col->name;
            if (isset($labels[$col->name])) $label = $labels[$col->name];
            echo "<label for='$col->name'>" . format_label($label) . $star . "</label>";
        }

        $pattern = '';
        if($type=='tel') $pattern= 'pattern="[2-9]{1}[0-9]{2}-[2-9]{1}[0-9]{2}-[0-9]{4}" placeholder="555-555-1234" ';

        $val =  $row[$col->name];
        if (isset($values[$col->name])) $val = $values[$col->name];

        $check = '';
        if (array_key_exists($col->name, $checks)) {
            foreach ($checks[$col->name] as $ckey => $cval) {
                $check .= " $ckey = '$cval' ";
            }
        }

        if (array_key_exists($col->name, $dropdowns)) {
            echo "<select name='" . $col->name  . "' class='form-control' $state data-value='$val'>";
            if ($state != 'required') echo "<option value=''></option>";
            echo generate_dropdown($col->name, $val, $dropdowns[$col->name]);
            echo "</select>";
            
        } elseif ($type == 'textarea')
            echo "<textarea name='" . $col->name  . "'  class='form-control' $state>$val</textarea>";
        elseif ($type == 'file') {
            echo "<div id='divMedia' class='p-3'>";
            if($val!='') {
                echo "<div id='divPreview'>";
                // echo "<img class='w-100' src='uploads/$val' onclick='window.open(\"uploads/$val\")' onerror='this.src=\"img/document.png\"' alt='$val' />";
                echo gen_link($val, 'w-100');
                echo "<a class='float-right' href='#' onclick='divPreview.classList.add(\"d-none\"); document.forms[0][\"$col->name\"][0].value=\"\";'><i class='ml-2 fa fa-trash text-danger'></i></a>"; 
                echo "</div>";
            }
            echo "<input type='hidden' name='" . $col->name  . "' value='" . $val . "' class='form-control' $pattern $state>";
            echo "<input type='$type' name='" . $col->name  . "' value='" . $val . "' class='form-control' $pattern $state>";
            echo "</div>"; //divMedia
        } elseif ($type=='number') {
            echo "<input type='$type' name='" . $col->name  . "' value='" . $val . "' step='any' class='form-control' $check $pattern $state>";
        } elseif ($type=='currency') {
            $type = 'number';
            echo "<div class='input-group'>";
            echo "<span class='input-group-text'><i class='currency'>$currency</i></span>";
            echo "<input type='$type' name='" . $col->name  . "' value='" . $val . "'  step='any' class='form-control'  $check $pattern $state>";
            echo "</div>";
        } else {
            echo "<input type='$type' name='" . $col->name  . "' value='" . $val . "' class='form-control'  $check $pattern $state>";
        }

        if ($type != 'hidden') 
            echo "</div>";
        $colindex++;
    }
    echo "</div>";

    echo "<div class='row'><div class='col my-3'>";

    if(in_array($action, ['add', 'edit']))
        echo "<button type=submit class='btn btn-success mw-90 mr-2'>Save</button>";
    
    if($action == 'edit' && $btn_delete)
        echo "<a onclick='del();' class='btn btn-danger text-light mr-2 mw-90'>Delete</a>";
    
    foreach ($buttons as $button) {
        echo "<a href='#' class='".$button['class']."' onclick='".$button['onclick']."'>".$button['text']."</a>";
    }
    echo "<a onclick=window.location='$callback' class='btn btn-secondary text-light mw-90'>Back</a>";
    echo "</div></div>";
    
    echo "</div>"; //col-8
    
    echo "<div class='col-md-4' id='rightSidebar'>";

    echo "</div>"; // col-4

    echo "</div>"; //outer-row

    echo "</form>";
    ?>

</div>
<?php require_once('footer.php') ?>

<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>

<!-- PAGE SCRIPTS -->
<?php 
    foreach ($scripts as $script) {
        echo "<script src='js/$script.js?v=" . date('ymd-Gi', filemtime("js/$script.js")) . "'></script>";
    }
?>

<script>
    $(function() {
        $("#divMedia").parent().removeClass('<?php echo $divClass ?>');
        $("#divMedia").parent().appendTo("#rightSidebar");
        // $("select").select2();
    });
    
    function del(){
        var params = [];
        params = {table: detail.table.value, where: detail.where.value, callback: detail.callback.value};
        console.log(params);
        // return;
        post('delete.php', params);
    }
</script>
