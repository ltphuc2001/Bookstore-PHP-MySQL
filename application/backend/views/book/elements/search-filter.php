<?php


#FILTER STATUS
$xhtmlFilterStatus = HelperBackend::showFilterStatus($this->arrParam['module'], $this->arrParam['controller'], @$this->countStatusItems, $this->arrParam['status'] ?? 'all', @$this->arrParam['search']);

#FILTER SPECIAL && FILTER CATEGORY
$arrFilterSpecial = ['default' => '- Select Special -', 'yes' => 'Yes', 'no' => 'No'];
$arrFilterCategory = array_merge(['0' => '- Select Category -'], $this->categoryName);
$xhtmlFilterForm = HelperBackend::filterFormBook($this->arrParam['module'], $this->arrParam['controller'], $this->arrParam['action'],'filter_special', 'filter_category',$arrFilterSpecial, $arrFilterCategory,  $this->arrParam['filter_special'] ?? 'default' ,$this->arrParam['filter_category'] ?? '0',);

#FILTER BAR
$xhtmlFilterBar = HelperBackend::filterBar($this->arrParam['module'], $this->arrParam['controller'], $this->arrParam['action'], @$this->arrParam['search']);

?>
<div class="card-body">
    <div class="row justify-content-between">
        <div class="mb-1">
            <?php echo $xhtmlFilterStatus ?>
        </div>
        <div class="mb-1">
            <?php echo $xhtmlFilterForm ?>
        </div>
        <div class="mb-1">
            <?php echo $xhtmlFilterBar ?>
        </div>
    </div>
</div>