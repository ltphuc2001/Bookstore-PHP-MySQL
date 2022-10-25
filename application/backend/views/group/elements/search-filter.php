<?php

#FILTER STATUS
$xhtmlFilterStatus = HelperBackend::showFilterStatus($this->arrParam['module'], $this->arrParam['controller'], @$this->countStatusItems, $this->arrParam['status'] ?? 'all', @$this->arrParam['search']);

#FILTER GROUP ACP
$arrFilterGroupACP = ['default' => '- Select Group ACP -', 'yes' => 'Yes', 'no' => 'No'];
$xhtmlFilterForm = HelperBackend::filterForm($this->arrParam['module'], $this->arrParam['controller'], $this->arrParam['action'], 'filter_group_acp' ,$arrFilterGroupACP, $this->arrParam['filter_group_acp'] ?? 'default');


#FILTER BAR
$xhtmlFilterBar = HelperBackend::filterBar($this->arrParam['module'], $this->arrParam['controller'], $this->arrParam['action'], @$this->arrParam['search']);

?>
<div class="card-body">
    <div class="row justify-content-between">
        <div class="mb-1">
            <?php echo $xhtmlFilterStatus; ?>
        </div>
        <div class="mb-1">
            <?php echo $xhtmlFilterForm; ?>
        </div>
        <div class="mb-1">
            <?php echo $xhtmlFilterBar; ?>
        </div>
    </div>
</div>