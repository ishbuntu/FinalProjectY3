<?php

function property_list($where='')
{

    $sql = "SELECT 
          property_id
        , property_type_name `type`
        , property_number `No.`
        , property_description `description`
        , property_sqft `SqFt.`
        , rent_per_month `Rent/Month`
        , city_name city
        , (select media_url from property_media where property_id = property.property_id limit 1) media_url
        , (select count(*) from property_message where property_id = property.property_id limit 1) messages
        , owner_id
        , user_name owner_name
        , property_status `status`
    FROM 
        property NATURAL LEFT JOIN 
        city NATURAL JOIN 
        property_type JOIN
        user ON property.owner_id = user.user_id
        WHERE 1=1 $where";
    
    $result = dbselect($sql);
    return $result;
}


function tenancy_list($where='')
{

    $sql = "SELECT 
                tenancy_id , tenancy.property_id , tenant_id, property_number `No.` , 
                property_description `description` , 
                tenancy_date , 
                tenants.user_name tenant , 
                start_date , end_date , tenancy.rent_per_month , tenancy_status 
            FROM tenancy 
            JOIN property ON tenancy.property_id = property.property_id
            JOIN user ON property.owner_id = user.user_id 
            JOIN user tenants ON tenancy.tenant_id = tenants.user_id 
            WHERE 1=1 $where";
    
    $result = dbselect($sql);
    return $result;
}


function ticket_list($where='')
{

    $sql = "SELECT 
                ticket_id , tenancy.property_id , tenant_id, property_number `No.` , 
                property_description `description` , 
                ticket_date ,
                category_title, 
                tenants.user_name tenant , 
                ticket_text, ticket_status 
            FROM ticket
            JOIN category ON ticket.category_id = category.category_id  
            JOIN tenancy ON ticket.tenancy_id = tenancy.tenancy_id 
            JOIN property ON tenancy.property_id = property.property_id
            JOIN user ON property.owner_id = user.user_id 
            JOIN user tenants ON tenancy.tenant_id = tenants.user_id 
            WHERE 1=1 $where";
    
    $result = dbselect($sql);
    return $result;
}


function property_detail($id)
{
    try {
        $sql = "SELECT 
                    property_id
                    , property_type_name
                    , property_number
                    , property_description
                    , property_sqft
                    , rent_per_month
                    , city_name, country_code
                    , owner_id
                    , user_name owner_name
                    , property_status `status`
                FROM 
                    property JOIN 
                    property_type USING (property_type_id) JOIN
                    user ON property.owner_id = user.user_id JOIN
                    city USING (city_id)
                WHERE property_id = $id";

        $result = dbselect($sql);
        $property['property'] = $result->fetch_assoc();

        $sql = "SELECT * FROM property_media WHERE property_id = $id";
        $result = dbselect($sql);
        $property['media'] = $result;

        if(isset($_SESSION['user_id']))
            $sql = "SELECT m.message_id, property_id, sender_id, recipient_id, DATE_FORMAT(message_date, '%H:%i | %d-%b') message_date, message_text, sender.user_name sender_name, recipient.user_name recipient_name,
            CASE WHEN sender_id = ". $_SESSION['user_id']  ." THEN recipient_id ELSE sender_id END chat_id,
            CASE WHEN sender_id = ". $_SESSION['user_id']  ." THEN recipient.user_name ELSE sender.user_name END chat_name
            FROM property_message m 
            JOIN user sender ON sender.user_id = m.sender_id 
            JOIN user recipient ON recipient.user_id = m.recipient_id 
            WHERE property_id = $id AND (sender_id = ". $_SESSION['user_id']  ." OR recipient_id = ". $_SESSION['user_id']  .") 
            ORDER BY chat_id, m.message_date";
        else
            $sql = "SELECT m.message_id, property_id, sender_id, recipient_id, DATE_FORMAT(message_date, '%H:%i | %d-%b') message_date, message_text, null sender_name, null recipient_name,
            null chat_id, null chat_name
            FROM property_message WHERE 1<>1";

        $result = dbselect($sql);
        $property['message'] = $result;

        $sql = "SELECT * FROM property_note WHERE property_id = $id";
        $result = dbselect($sql);
        $property['note'] = $result;

        return $property;
    } catch (\Throwable $th) {
        die('Error dbget.property_detail: ' . $sql);
    }
}


function ticket_detail($id)
{
    try {
        $sql = "SELECT 
                ticket_id , tenancy.property_id , tenant_id, property_number `No.` , 
                property_description `description` , 
                ticket_date ,
                category_title, 
                tenants.user_name tenant , 
                ticket_text, ticket_status 
            FROM ticket
            JOIN category ON ticket.category_id = category.category_id  
            JOIN tenancy ON ticket.tenancy_id = tenancy.tenancy_id 
            JOIN property ON tenancy.property_id = property.property_id
            JOIN user ON property.owner_id = user.user_id 
            JOIN user tenants ON tenancy.tenant_id = tenants.user_id 
            WHERE ticket_id = $id";

        $result = dbselect($sql);
        $ticket['ticket'] = $result->fetch_assoc();

        $sql = "SELECT m.message_id, sender_id, DATE_FORMAT(message_date, '%H:%i | %d-%b') message_date, 
                message_text, sender.user_name sender_name
            FROM ticket_message m 
            JOIN user sender ON sender.user_id = m.sender_id 
            WHERE ticket_id = $id
            ORDER BY m.message_date";
        
        $result = dbselect($sql);
        $ticket['message'] = $result;

        
        return $ticket;
    } catch (\Throwable $th) {
        die('Error dbget.ticket_detail: ' . $sql);
    }
}


function rs2table($result, $table_class = 'table', $thead_class = 'thead-light', $table_id = '', $displayCols = array())
{
    // if ($result){
    try {
        $table_id == '' ? $id = '' : $id = "id='$table_id'";

        echo "<table $id class='table $table_class table-hover table-responsive w-100 d-block d-md-table' style='width:100%'>";
        echo "<thead class='$thead_class'><tr>";

        $columns = mysqli_fetch_fields($result);

        foreach ($columns as $col) {
            if (!(count($displayCols) == 0 || in_array($col->name, $displayCols))) continue;
            echo "<th class='nowrap'>" . ucwords(str_replace('_', ' ', $col->name)) . "</th>";
        }
        echo "</tr></thead>";
        echo "<tbody class=''>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            $i = 0;
            foreach ($columns as $col) {
                if (!(count($displayCols) == 0 || in_array($col->name, $displayCols))) continue;
                $val = $row[$col->name];
                $dataSort = $val;
                $dataSearch = $val;
                if (in_array($col->name, ['floor_plan', 'document_url'])) $val = gen_link($val);
                if ($i > 0 && strpos($table_class, 'cards')) {
                    echo "<td class='$col->name'
                                data-sort = '$dataSort' data-search = '$dataSearch' title='" . $col->name . "'>"
                        . $val;
                    echo "<label class='card_label'>" . format_label($col->name) . "</label>";
                } else {
                    echo "<td class='$col->name' title='" . $col->name . "'>" . $val;
                }
                echo "</td>";

                $i++;
            }
            echo "</tr>";
        }
        echo "</tbody>";

        // if (strpos($table_class, 'hasfooter')>=0) {
        //     echo "<tfoot>
        //             <tr>";
        //     foreach($columns as $col){
        //         echo "<th class='nowrap'>" . ucwords(str_replace('_', ' ', $col->name)) . "</th>";
        //     }  
        //     echo "  </tr>
        //           </tfoot>";
        // }

        echo "</table>";
    } catch (\Throwable $th) {
        echo $table_id;
        print_r($th);
    }

    // } else { echo "<h2 class='text-info text-center'>No record found</h2>"; }
}

function rs2cards($result, $displayCols = array())
{
    try {
        
        
        $columns = mysqli_fetch_fields($result);
        echo "<div class='row'>";
        while ($row = $result->fetch_assoc()) {
            if($row['status'] != 'AVAILABLE') continue;
            $info = ""; 
            if(isset($row['rent_per_month'])) $info .= '<span class="h5">£' . $row['rent_per_month']."</span> | ";
            if(isset($row['property_sqft'])) $info .= $row['property_sqft']." sqft. | ";
            if($info != "") $info = rtrim($info, "| ");

            echo "<div class='col-md-3 my-4'>";
            echo "<a href='property_detail.php?id=".$row['property_id']."'>";
            echo "<div class='card'>
                        <img class='card-img-top' src='uploads/". $row['media_url'] ."' 
                            alt='".$row['type']."'
                            onerror=\"this.onerror=null;this.src='img/no_image.png';\" 
                            >
                        <div class='card-body'>
                        <h5 class='card-title text-dark nowrap'>".$row['description']."</h5>
                        <p class='card-text mb-1 text-success'>$info</p>
                        <p class='card-text text-info'><i class='fa fa-map-marker'></i> ".$row['city'] ."</p>
                        </div>
                        <div class='card-footer'>
                        <p class='card-text float-left mb-0'>" .$row['owner_name']. "</p>";
                        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['owner_id'] && $row['messages']>0) 
                            echo "<h4><span class='float-right badge badge-success'>" . $row['messages'] ."</span></h4>";
                        echo "
                        </div>
                    </div>";
            echo "</div>";
            echo "</a>";
        }

    } catch (\Throwable $th) {
        print_r($th);
    }

    // } else { echo "<h2 class='text-info text-center'>No record found</h2>"; }
}


function array2table($result, $table_class = 'table', $thead_class = 'thead-light', $table_id = '')
{
    if ($result) {
        $table_id == '' ? $id = '' : $id = "id='$table_id'";

        echo "<table $id class='table $table_class table-hover'>"; // table-responsive
        echo "<thead class='$thead_class'><tr>";

        foreach ($result[0] as $col => $val) {
            echo "<th class='nowrap'>" . format_label($col) . "</th>";
        }
        echo "</tr></thead>";
        foreach ($result as $row) {

            echo "<tr>";
            foreach ($row as $col => $val) {
                // $val = $row[$col->name];
                echo "<td>$val</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2 class='text-info text-center'>No record found</h2>";
    }
}

function generate_dropdown($name, $index = '', $sql = '')
{
    $options = [];

    if ($sql != '') {
        if (substr($sql, 0, 4) == 'enum') {
            $params = explode('.', $sql);
            $options = get_enum_values($params[1], $name);
        } else {
            $result = dbselect($sql);
            $options = $result->fetch_all(MYSQLI_NUM);
        }
    }

    $html = '';

    $isAssoc = isAssoc($options);

    foreach ($options as $key => $val) {
        $k = $key;
        $v = $val;
        if (is_array($v)) {
            if (count($v) > 1) {
                $k = $v[0];
                $v = $v[1];
            } else {
                $k = $v[0];
                $v = $v[0];
            }
        } elseif (!$isAssoc) $k = $v;

        if ($index == $k) $selected = 'selected';
        else $selected = '';
        $html .= "<option $selected value='$k'>" . format_label($v) . "</option>";
    }
    return $html;
}

function format_label($key)
{
    return ucwords(str_replace('_', ' ', str_replace('_id', '', $key)));
}

function get_enum_values($table, $field)
{
    $sql = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'";
    try {
        $result = dbselect($sql);
        $type = $result->fetch_all()[0][1];
        $type = str_replace("'", '', str_replace('enum(', '', str_replace(')', '', $type)));
        $enum = explode(",", $type);
        return $enum;
    } catch (\Throwable $th) {
        echo $th->getMessage();
    }
}

function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function gen_link($value, $class = 'thumbnail')
{

    if (!$value) return false;

    $src = "uploads/$value";
    if (!file_exists($src)) return false;

    if (!is_image("uploads/$value"))
        $src = "img/document.png";

    return "<img src=$src alt='$value' class='$class pointer' onclick='window.open(\"uploads/$value\");'>";
}

function is_image($file)
{
    $mime = mime_content_type($file);
    if ($mime) return explode('/', $mime)[0] == 'image';
    else return false;
}

function debug($message, $print = true, $file = false)
{
    if($print){
        echo "<pre>";
        print_r($message);
        echo "</pre>";
    }

    if($file)
    file_put_contents('debug.log', $message . '\n', FILE_APPEND);
}
