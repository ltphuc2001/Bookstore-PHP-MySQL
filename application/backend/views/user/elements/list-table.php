<?php
$xhtml = '';
$param = $this->arrParam;

if (count($this->items)) {
    foreach ($this->items as $key => $item) {
        $id                 = $item['id'];
        $ckb                = sprintf('<input type="checkbox" name="cid[]" value="%s">', $id);
        $username           = HelperBackend::highlight(@$arrParams['search'], $item['username']);
        $email              = $item['email'];
        $fullname           = $item['fullname'];
        $telephone          = $item['telephone'];
        $address            = $item['address'];
      
        
        //$arrGroupName       = array_combine($this->groupName, $this->groupName);
        $linkChangeGroupID  = URL::createLink($param['module'], $param['controller'], 'changeGroupID', ['group_id' => 'value_new', 'id' => $id]);
        $group_name          = HelperBackend::selectBox('change_group_id', $this->groupName, $item['group_id'], ['data-url' => $linkChangeGroupID, 'class' => 'slb-change-attr custom-select custom-select-sm']);

        $status             = HelperBackend::itemStatus($param['module'], $param['controller'], $item['status'], $id);
        $created            = HelperBackend::itemHistory($item['created_by'], $item['created']);


        //BUTTON 
        $optionsBtnAction   = ['small' => true, 'circle' => true];
        
        $linkChangePass           = URL::createLink($param['module'], $param['controller'], 'changePassword', ['id' => $id]);
        $btnChangePass            = HelperBackend::buttonLink($linkChangePass, '<i class="fas fa-key"></i>', 'btn-secondary', $optionsBtnAction);

        $linkEdit           = URL::createLink($param['module'], $param['controller'], 'form', ['id' => $id]);
        $btnEdit            = HelperBackend::buttonLink($linkEdit, '<i class="fas fa-pen"></i>', 'btn-info', $optionsBtnAction);

        $linkDelete         = URL::createLink($param['module'], $param['controller'], 'delete', ['id' => $id]);
        $btnDelete          = HelperBackend::buttonLink($linkDelete, '<i class="fas fa-trash"></i>', 'btn-danger btn-delete', $optionsBtnAction);

        $xhtml .= '
        <tr class="">
                                            <td>
                                                '.$ckb.'
                                            </td>
                                            <td class="text-center">' . $id . '</td>
                                            <td>
                                                <p class="mb-0">Username: ' . $username . '</p>
                                                <p class="mb-0">Fullname: ' . $fullname . '</p>
                                                <p class="mb-0">Email: ' . $email . '</p>
                                                <p class="mb-0">Email: ' . $telephone . '</p>
                                                <p class="mb-0">Email: ' . $address . '</p>
                                            </td>
                                            <td class="text-center position-relative">' . $group_name . '</td>
                                            <td class="text-center position-relative">
                                               ' . $status . '
                                            </td>
                                            <td class="text-center">
                                                ' . $created . '
                                            </td>

                                            <td class="text-center">
                                               ' . $btnChangePass . $btnEdit . $btnDelete . '
                                            </td>
                                        </tr>

        ';
    }
} else {
    $xhtml = HelperBackend::showTableEmpty(8);
}

?>

<form action="" method="post" id="form-table">
    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
        <thead>
            <tr>
                <th ><input type="checkbox" id="check-all-cid"></th>
                <th class="text-center">ID</th>
                <th class="">Info</th>
                <th class="text-center">Group</th>
                <th class="text-center">Status</th>
                <th class="text-center">Created</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?= $xhtml ?>
        </tbody>
    </table>
</form>