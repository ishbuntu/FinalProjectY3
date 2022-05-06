<?php
session_start();
// if (!isset($_SESSION['email'])) header("Location:index.php");

if (!isset($_GET['id'])) header("Location:index.php");
else $id = $_GET['id'];
?>

<?php require_once('db.php') ?>
<?php require_once('header.php') ?>
<?php require_once('dbget.php') ?>

<?php
$property_detail = property_detail($id);
$property = $property_detail['property'];
if (!$property) header("Location:index.php");
$mediaList = $property_detail['media'];
$noteList = $property_detail['note'];
$messageList = $property_detail['message'];
$owner_id = $property['owner_id'];

$is_owner = false;
if (isset($_SESSION['user_id'])) $is_owner = $owner_id == $_SESSION['user_id'];


$tabs = array('media');
if (isset($_SESSION['email'])) array_push($tabs, 'message');
if ($is_owner) array_push($tabs, 'note');

?>

<div class="row justify-content-md-center mt-2">
  <div class="col-md-4">
    <h5 class="d-inline">Property Detail</h5>
    <div class='btn-group float-right h5 mb-3'>
      <?php
      if ($is_owner)
        echo "<a href='#' onclick='frm_property(\"edit\", $id);' title ='Edit' class='text-warning ml-2'><i class='fa fa-pencil'></i></a>";
      else
        echo "<span>&nbsp;</span>";
      ?>
    </div>

    <table class="table table-striped">
      <?php
      // $slice = 1;
      foreach ($property as $key => $value) {
        if ($key == 'property_id' || $key == 'owner_id') {
          echo "<input type='hidden' value='$value' id='$key'>";
        } else {
          $class = 'text-bold';
          echo "<tr><td>" . format_label($key) . "</td><th><span class='$class'>$value</span></th></tr>";
        }
      }
      if (!isset($_SESSION['email']))
        echo "<tr><td colspan='2'><button class='btn btn-primary w-100' onclick='contact_owner();'>Contact Owner</button></td></tr>";
      
      // if ($is_owner && $property['status']=='AVAILABLE')
      //   echo "<tr><td colspan='2'><button class='btn btn-primary w-100' onclick='frm_tenancy();'>Create Tenancy Agereement</button></td></tr>";
      
      ?>
    </table>
  </div>

  <div class="col-md-8 border-left">

    <nav class="nav nav-tabs nav-justified" id="myTab">
      <a class="nav-link active" data-toggle='tab' href="#mediaList">Media</a>
      <?php
      if (isset($_SESSION['email']))
        echo "<a class='nav-link' data-toggle='tab' href='#messageList'>Messages</a>";
      if ($is_owner)
        echo "<a class='nav-link' data-toggle='tab' href='#noteList'>Notes</a>";
      ?>
    </nav>

    <div class="tab-content" style="height: 80vh; overflow-y: auto; overflow-x: hidden">

      <div class="tab-pane active" id="mediaList">
        <div class="text-right">
          <?php if ($is_owner) { ?>
            <a class='btn btn-success' href='#' onclick="frm_media();"><i class="fa fa-plus"></i> Add New</a>
          <?php } ?>
        </div>
        <div class="row mt-3">
          <?php
          foreach ($mediaList as $media) {
            $did = $media['media_id'];
            $url = 'uploads/' . $media['media_url'];
            $icon = 'img/' . $media['media_type'] . '.png';
            if ($media['media_type'] == 'IMAGE') $icon = 'uploads/' . $media['media_url'];
            echo "<div class='col-md-4'>";
            echo "<div class='card my-3'>
                    <a href='$url'  title ='Download' class='text-primary' target='_blank'>
                      <!-- div style='background: url($icon) no-repeat center center; background-size:contain; height: 100px' class='w-100'></div -->
                      <img class='card-img-top' src='$icon' 
                            onerror=\"this.onerror=null;this.src='img/no_image.png';\" 
                            alt = '".$media['media_title']."'>
                    </a>
                  <div class='text-center'>";
            if ($is_owner)
              echo "<div class='btn-group h5 my-3'>
                    <a href='uploads/" . $media['media_url'] . "'  title ='Download' class='text-primary'><i class='fa fa-download'></i></a>
                    <a href='#' onclick='frm_media(\"edit\", $did);'  title ='Edit' class='text-warning ml-2'><i class='fa fa-pencil'></i></a>
                    <a href='#' onclick='frm_media(\"delete\", $did);' title ='Delete' class='text-danger ml-2'><i class='fa fa-trash'></i></a>
                  </div>";
            echo "<p class='h6 mt-1'>" . $media['media_title'] . "</p>";
            echo " </div>
                </div>
              </div>";
          }
          ?>
        </div>
      </div>

      <div class="tab-pane " id="messageList">
        <?php if($messageList) { ?>
        <div class="messaging">
          <div class="inbox_msg">

            <div class="inbox_people">

              <div class="inbox_chat scroll">

                <?php
                $messages = $messageList->fetch_all(MYSQLI_ASSOC);
                $chat_name = "";
                $active = "active_chat";

                foreach ($messages as $message) {
                  if ($chat_name != $message['chat_name']) {
                ?>
                    <div class="chat_list <?= $active ?>" data-chatid='<?= $message['chat_id'] ?>'>
                      <div class="chat_people">
                        <div class="chat_img"> <img src="img/chat_avatar.png" alt="prms"> </div>
                        <div class="chat_ib">
                          <h5><?= $message['chat_name'] ?> <span class="chat_date"></span></h5>
                          <p></p>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                  $active = "";
                  $chat_name = $message['chat_name'];
                } ?>

              </div>
            </div>

            <div class="mesgs">
              <div class="msg_history">
                <?php
                foreach ($messages as $message) {
                  if ($message['sender_id'] != $_SESSION['user_id']) {
                ?>
                    <div class="msg incoming_msg" data-chatid="<?= $message['chat_id'] ?>">
                      <div class="incoming_msg_img"> <img src="img/chat_avatar.png" alt="prms"> </div>
                      <div class="received_msg received_withd_msg">
                        <!-- <div class="received_withd_msg"> -->
                        <p><?= $message['message_text'] ?></p>
                        <span class="time_date"><?= $message['message_date'] ?></span>
                        <!-- </div> -->
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="msg outgoing_msg " data-chatid="<?= $message['chat_id'] ?>">
                      <div class="sent_msg">
                        <p><?= $message['message_text'] ?></p>
                        <span class="time_date"><?= $message['message_date'] ?></span>
                      </div>
                    </div>
                <?php
                  }
                }
                ?>
              </div>

              <div class="type_msg">
                <div class="input_msg_write">
                  <input type="text" id="message_text" class="write_msg" placeholder="Type a message" />
                  <button class="msg_send_btn" type="button" onclick="frm_chat();"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                </div>
              </div>

            </div>

          </div>
        </div>
        <?php } ?>
      </div>

      <div class="tab-pane " id="noteList">
        <div class="text-right">
          <a class='btn btn-success' href='#' onclick='frm_note();'><i class="fa fa-plus"></i> Add New</a>
        </div>
        <?php

        echo "<table class='cards'>";
        foreach ($noteList as $note) {
          echo "<tr class='border-bottom'>";

          $nid = $note['note_id'];
          echo "  <td class='py-3'>" . $note['note_text'] . "<p class='mt-3 text-italic'>" . $note['note_date'] . "<p></td>";

          echo "  <td>";

          echo "<div class='btn-group float-right h5'>
          <a href='#' onclick='frm_note(\"edit\", $nid);' title ='Edit' class='text-warning ml-2'><i class='fa fa-pencil'></i></a>                  
          <a href='#' onclick='frm_note(\"delete\", $nid);' title ='Delete' class='text-danger ml-2'><i class='fa fa-trash'></i></a>
          </div>";

          echo "  </td>";



          echo "</tr>";
        }
        echo "</table>";
        ?>
      </div>

    </div>

  </div>

</div>

<?php require_once('footer.php') ?>

<script>
  var is_owner = <?php if ($is_owner) echo 1; else echo 0; ?>;

  function frm_media(_action = 'add', _id = '') {
    var _where = _action == 'add' ? '1<>1' : 'media_id=' + _id;

    params = {
      table: 'property_media',
      action: _action,
      where: _where,
      callback: window.location.href,
    }

    if (_action == 'delete') {
      post('delete.php', params);
      return;
    }

    params['values'] = {
      media_id: _id,
      property_id: property_id.value,
      owner_id: session_user_id.value
    };

    if (_action = 'add') params['values']['is_private'] = 'NO';

    params['attributes'] = {
      media_title: 'required',
      media_url: 'required',
      is_private: 'required',
      media_date: 'hidden',
      media_type: 'hidden',
    };

    params['types'] = {
      property_id: 'hidden',
      owner_id: 'hidden',
      media_id: 'hidden',
      media_url: 'file',
    }

    params['dropdowns'] = {
      is_private: 'enum.property_media'
    }

    post('detail.php', params);

  }

  function frm_chat() {

    var _recipient_id = is_owner ? $('.active_chat').data('chatid') : owner_id.value;
    if(typeof(_recipient_id) == 'undefined') {
      Swal.fire(title='Restricted', text='No recipient selected', icon='warning');
      return;
    }

    var _message_text = message_text.value;
    if(_message_text.length < 2) {
      Swal.fire(title='Restricted', text='Please enter a valid message', icon='warning');
      return; 
    }

    params = {
      table: 'property_message',
      action: 'add',
      where: '1<>1',
      callback: window.location.href,

      property_id: property_id.value,
      sender_id: <?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "''" ?>,
      recipient_id: _recipient_id,
      message_text: _message_text
    }

    post('update.php', params);

  }

  function frm_message(_action = 'add', _id = '') {

    var _where = _action == 'add' ? '1<>1' : 'message_id=' + _id;
    params = {
      table: 'property_message',
      action: _action,
      where: _where,
      callback: window.location.href
    }

    if (_action == 'delete') {
      post('delete.php', params);
      return;
    }

    params['values'] = {
      message_id: _id,
      property_id: property_id.value,
      sender_id: session_user_id.value,
      recipient_id: owner_id.value
    };

    params['attributes'] = {
      message_text: 'required',
      recipient_id: 'required'
    };

    params['types'] = {
      message_id: 'hidden',
      message_date: 'hidden',
      property_id: 'hidden',
      sender_id: 'hidden',
      message_text: 'textarea',
    };

    params['dropdowns'] = {
      recipient_id: 'select user_id, user_name from user where user_id = ' + owner_id.value
    }

    if (_action == 'reply') {
      params['action'] = 'add';
      params['where'] = '1<>1';
      params['values'] = {
        message_id: '',
        property_id: property_id.value,
        sender_id: session_user_id.value,
        recipient_id: _id
      };
      params['dropdowns'] = {
        recipient_id: 'select user_id, user_name from user where user_id = ' + _id
      }
    }

    post('detail.php', params);

  }

  function frm_note(_action = 'add', _id = '') {

    var _where = _action == 'add' ? '1<>1' : 'note_id=' + _id;

    params = {
      table: 'property_note',
      action: _action,
      where: _where,
      callback: window.location.href
    }

    if (_action == 'delete') {
      post('delete.php', params);
      return;
    }

    params['values'] = {
      note_id: _id,
      property_id: property_id.value,
      user_id: session_user_id.value
    };

    params['attributes'] = {
      note_text: 'required'
    };

    params['types'] = {
      note_id: 'hidden',
      note_date: 'hidden',
      property_id: 'hidden',
      user_id: 'hidden',
      note_text: 'textarea',
    };

    post('detail.php', params);

  }

  function contact_owner() {
    Swal.fire(title = "Restricted", text = 'Please register and login to contact property owner.', icon = "warning");
  }

  // chat
  $(".chat_list").on('click', function(e) {
    $(".chat_list").removeClass('active_chat');
    $(this).addClass('active_chat');
    localStorage.setItem('activeChat', $(this).data('chatid'));
    filterMessages($(this).data('chatid'));
  });

  function filterMessages(chatid) {
    $('.msg').addClass('d-none');
    $('.msg').filter(function() {
      return $(this).data("chatid") == chatid
    }).removeClass('d-none');
    
    $(".msg_history")[0].scrollTop = $(".msg_history")[0].scrollHeight;

  }

  $(document).ready ( 
    
      function() {

      var activeChat = localStorage.getItem('activeChat');
      if (activeChat) {
        $('.chat_list[data-chatid='+activeChat+']').click()
      } else {
        filterMessages($(".active_chat").data('chatid'));
      }      
    }
  );

</script>

<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>