<?php
session_start();
if (!isset($_SESSION['email'])) header("Location:index.php");
?>

<?php require_once('db.php') ?>
<?php require_once('header.php') ?>
<?php require_once('dbget.php') ?>

<div class="row justify-content-md-center mt-4">
    <div class="col-md-12">
        <h3 class="mb-3">Tenancy Contracts</h3>
        <?php
        rs2table(tenancy_list('AND owner_id = '.$_SESSION['user_id']), $table_class='', $thead_class='thead-light', $table_id='datagrid');
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
      buttons: [{
          text: '<i class="fa fa-plus-circle mr-1"></i> Add Contract',
          className: 'btn-success mr-2',
          action: function(e, dt, node, config) {
            frm_tenancy();
          }
        },
      ]

    });
    
    $('#datagrid tbody').on('click', 'tr', function () {
      var data = dataTable.row( this ).data();
        frm_tenancy('edit', data);
    } );

    // $('#datagrid tbody').on('click', 'tr', function () {
    //   var data = dataTable.row( this ).data();
    //   frm_tenancy('edit', data[0]);
    // } );

    <?php 
      if (isset($_GET['q'])) 
        echo "$('#datagrid').DataTable().search('".$_GET['q']."').draw();";
    ?>

  });
</script>

<script src='js/frm_tenancy.js?v=<?php echo date("ymd-Gi", filemtime("js/frm_tenancy.js")) ?>'></script>
<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>
