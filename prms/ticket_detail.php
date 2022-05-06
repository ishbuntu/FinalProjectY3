<?php
session_start();
if (!isset($_SESSION['email'])) header("Location:index.php");

if (!isset($_GET['id'])) header("Location:index.php");
else $id = $_GET['id'];
?>

<?php require_once('db.php') ?>
<?php require_once('header.php') ?>
<?php require_once('dbget.php') ?>

<?php
$ticket_detail = ticket_detail($id);
$ticket = $ticket_detail['ticket'];
if (!$ticket) header("Location:index.php");
$messageList = $ticket_detail['message'];


$tabs = array('message');

?>

<div class="row justify-content-md-center mt-2">
  <div class="col-md-4">
    <h5 class="d-inline">Ticket Detail</h5>
    <div class='btn-group float-right h5 mb-3'>
      <span>&nbsp;</span>
    </div>

    <table class="table table-striped">
      <?php
      // $slice = 1;
      foreach ($ticket as $key => $value) {
        if (in_array($key, ['property_id', 'tenant_id'])) continue;
        if ($key == 'ticket_id') {
          echo "<input type='hidden' value='$value' id='$key'>";
        } else {
          $class = 'text-bold';
          echo "<tr><td>" . format_label($key) . "</td><th><span class='$class'>$value</span></th></tr>";
        }
      }
      if (!isset($_SESSION['email']))
        echo "<tr><td colspan='2'><button class='btn btn-primary w-100' onclick='contact_owner();'>Contact Owner</button></td></tr>";

      if ($ticket['ticket_status'] == 'OPEN')
        echo "<tr><td colspan='2'>
                <button class='btn btn-success w-100 mt-2' onclick='close_ticket();'><i class='fa fa-lock'></i> Close Ticket</button>
                </td></tr>";
                // <a class='btn btn-success' href='#' onclick='frm_message();'><i class='fa fa-plus'></i> New Message</a>
                
      ?>
    </table>
  </div>

  <div class="col-md-8 border-left">

    <nav class="nav nav-tabs nav-justified" id="myTab">
      <a class='nav-link active' data-toggle='tab' href='#messageList'>Messages</a>
    </nav>

    <div class="tab-content" style="height: 70vh; overflow-y: auto; overflow-x: hidden">

      <div class="tab-pane active" id="messageList">
        <!-- <div class="text-right">
          <a class='btn btn-success' href='#' onclick='frm_message();'><i class="fa fa-plus"></i> New Message</a>
        </div> -->
        <?php

        echo "<table class=''>";
        foreach ($messageList as $message) {
          $align = 'received_msg received_withd_msg';
          if ($message['sender_id'] == $_SESSION['user_id']) $align = 'sent_msg';

          echo "<tr class='border-bottom'>";

          $mid = $message['message_id'];

          echo "  <td class='py-3'><div class='$align'><p>" . $message['message_text'] . "<br/><span class='small'>" . $message['sender_name'] . ' - ' . $message['message_date'] . "</span></div></td>";

          // echo "  <td>";

          // echo "<div class='btn-group float-right h5'>
          // <a href='#' onclick='frm_message(\"edit\", $nid);' title ='Edit' class='text-warning ml-2'><i class='fa fa-pencil'></i></a>
          // <a href='#' onclick='frm_message(\"delete\", $nid);' title ='Delete' class='text-danger ml-2'><i class='fa fa-trash'></i></a>
          // </div>";

          // echo "  </td>";

          echo "</tr>";
        }
        echo "</table>";
        ?>
      </div>
    </div>
    <?php if($ticket['ticket_status'] == 'OPEN') { ?>
    <div class="type_msg">
      <div class="input_msg_write">
        <input type="text" id="message_text" class="write_msg" placeholder="Type a message" />
        <button class="msg_send_btn" type="button" onclick="frm_message();"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
      </div>
    </div>
    <?php } ?>

  </div>

</div>

<?php require_once('footer.php') ?>

<script>
  function frm_message(_action = 'add', _id = '') {
    var msg = message_text.value;
    if(msg.length < 2) {
      alert('Please provide a valid message.');
      return;
    }

    params = {
      table: 'ticket_message',
      action: _action,
      where: '1<>1',
      callback: window.location.href,
      ticket_id: ticket_id.value,
      sender_id: session_user_id.value,
      message_text: msg
    }

    // params['values'] = {
    //   message_id: _id,
    //   ticket_id: ticket_id.value,
    //   sender_id: session_user_id.value,
    //   message_text: msg
    // };

    // params['attributes'] = {
    //   message_text: 'required',
    //   recipient_id: 'required'
    // };

    // params['types'] = {
    //   message_id: 'hidden',
    //   message_date: 'hidden',
    //   ticket_id: 'hidden',
    //   sender_id: 'hidden',
    //   message_text: 'textarea',
    // };

    // post('detail.php', params);
    post('update.php', params);

  }

  function close_ticket() {    
    params = {
      table: 'ticket',
      action: 'edit',
      where: 'ticket_id = ' + ticket_id.value,
      callback: window.location.href,
      ticket_id: ticket_id.value,
      ticket_status: 'CLOSED'
    }

    post('update.php', params);

  }

  $(".tab-content")[0].scrollTop = $(".tab-content")[0].scrollHeight;


</script>

<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>