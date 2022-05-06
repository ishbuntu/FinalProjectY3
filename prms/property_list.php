<?php
session_start();
if (!isset($_SESSION['email'])) header("Location:index.php");
?>

<?php require_once('db.php') ?>
<?php require_once('header.php') ?>
<?php require_once('dbget.php') ?>

<div class="row justify-content-md-center mt-4">
    <div class="col-md-12">
        <h3 class="mb-3">Properties</h3>
        <?php
        rs2table(property_list('AND owner_id = '.$_SESSION['user_id']), $table_class='', $thead_class='thead-light', $table_id='datagrid', array('property_id', 'type', 'No.', 'description', 'SqFt.', 'Rent/Month', 'city', 'messages', 'status'));
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
      columnDefs : [{ targets : [0], visible: false, searchable: true }],
      buttons: [{
          text: '<i class="fa fa-plus-circle mr-1"></i> Add Property',
          className: 'btn-success mr-2',
          action: function(e, dt, node, config) {
            frm_property();
          }
        }
      ]

    });
    
    $('#datagrid tbody').on('click', 'tr', function () {
      var data = dataTable.row( this ).data();
      window.location = 'property_detail.php?id=' + data[0];
    } );

    // $('#datagrid tbody').on('click', 'tr', function () {
    //   var data = dataTable.row( this ).data();
    //   frm_property('edit', data[0]);
    // } );

    <?php 
      if (isset($_GET['q'])) 
        echo "$('#datagrid').DataTable().search('".$_GET['q']."').draw();";
    ?>

  });
</script>

<script src='js/frm_property.js?v=<?php echo date("ymd-Gi", filemtime("js/frm_property.js")) ?>'></script>
<script src='js/utils.js?v=<?php echo date("ymd-Gi", filemtime("js/utils.js")) ?>'></script>
