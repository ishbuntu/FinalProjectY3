<?php
session_start();
require_once('db.php');
require_once('dbget.php');
require_once('header.php');
?>

<div>
    <h3 class="mt-4">
        Properties Available for Rent
    </h3>
    <?php rs2cards(property_list("AND property_status = 'AVAILABLE' "), 'cards'); ?>;
</div>

<?php require_once('footer.php') ?>