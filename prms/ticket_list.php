<?php
session_start();
if (!isset($_SESSION['email'])) header("Location:index.php");
?>

<?php require_once('db.php') ?>
<?php require_once('header.php') ?>
<?php require_once('dbget.php') ?>

<div class="row justify-content-md-center mt-4">
    <div class="col-md-12">
        <h3 class="mb-3">Support Tickets</h3>
        <?php
        $where = ' AND owner_id = ' . $_SESSION['user_id'];
        if($_SESSION['role'] == 'Tenant') $where = ' AND tenant_id = ' . $_SESSION['user_id'];
        rs2table(ticket_list($where), $table_class='', $thead_class='thead-light', $table_id='datagrid');
        ?>
    </div>
</div>

<?php require_once('footer.php') ?>

<!-- DataTables  & Plugins -->
<script src="./js/datatables.min.js"></script>

<!-- Page specific script -->

<script>
 
  $(function() {
    
    dataTable = $('#datagrid').DataTable({
      // scrollX : true,
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: true,
      responsive: true,
      oLanguage: {
        sSearch: ""
      },
      dom: '<"pull-right"B><"top"f>tpi',
      "order": [[ 0, "desc" ]],
      columnDefs : [{ targets : [0, 1, 2], visible: false, searchable: true }],
      buttons: [session_role.value == 'Tenant' ? {
          text: '<i class="fa fa-plus-circle mr-1"></i> Create Ticket',
          className: 'btn-success mr-2',
          action: function(e, dt, node, config) {
            frm_ticket();
          }
        } : '',
      ]

    });
    
    $('#datagrid tbody').on('click', 'tr', function () {
      var data = dataTable.row( this ).data();
      window.location.href = 'ticket_detail.php?id=' + data[0];
      // frm_ticket('view', data[0]);
    } );

    // $('#datagrid tbody').on('click', 'tr', function () {
    //   var data = dataTable.row( this ).data();
    //   frm_ticket('edit', data[0]);
    // } );

    <?php 
      if (isset($_GET['q'])) 
        echo "$('#datagrid').DataTable().search('".$_GET['q']."').draw();";
    ?>

  });
</script>

<script src='js/frm_ticket.js?v=<?php echo date("ymd-Gi", filemtime("js/frm_ticket.js")) ?>'></script>
<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>
