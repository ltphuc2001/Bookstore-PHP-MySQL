<?php
//$arrParams = $this->arrParams;
?>

<?= HelperBackend::showMessage() ?>
<!-- Search & Filter -->
<?php require_once 'elements/search-filter.php' ?>

<!-- List -->
<div class="card card-outline card-info">
    <?php require_once 'elements/card-header.php' ?>
    <div class="card-body">
        <!--Content -->
        <?php require_once 'elements/list-table.php' ?>
    </div>
    <?php require_once 'elements/pagination.php' ?>
</div>


