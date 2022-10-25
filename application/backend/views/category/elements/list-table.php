<?php
$xhtml = '';
if (count($this->items)) {
    foreach ($this->items as $key => $item) {
      
        $id                 = $item['id'];
        $ckb                = sprintf('<input type="checkbox" name="cid[]" value="%s">', $id);
        $name               = HelperBackend::highlight(@$arrParams['search'], $item['name']);
        $ordering           = HelperBackend::itemOrdering($arrParams['module'], $arrParams['controller'],'number', 'checkOrdering', $item['ordering'], $item['id']);
        
      
        $picture           = 'public' . DS . 'file' . DS . 'category' . DS . $item['picture'];
        

        $status             = HelperBackend::itemStatus($arrParams['module'], $arrParams['controller'], $item['status'], $id);
        //$showHome           = HelperBackend::itemShowHome($arrParams['module'], $arrParams['controller'], $item['showHome'], $id);

        $created            = HelperBackend::itemHistory($item['created_by'], $item['created']);
        $modified           = HelperBackend::itemHistory($item['modified_by'], $item['modified']);

        $optionsBtnAction   = ['small' => true, 'circle' => true];
        $linkEdit           = URL::createLink($arrParams['module'], $arrParams['controller'], 'form', ['id' => $id]);
        $btnEdit            = HelperBackend::buttonLink($linkEdit, '<i class="fas fa-pen"></i>', 'btn-info', $optionsBtnAction);
        $linkDelete         = URL::createLink($arrParams['module'], $arrParams['controller'], 'delete', ['id' => $id]);
        $btnDelete          = HelperBackend::buttonLink($linkDelete, '<i class="fas fa-trash"></i>', 'btn-danger btn-delete', $optionsBtnAction);

        $xhtml .= '
        <tr>
            <td>' . $ckb . '</td>
            <td>' . $id . '</td>
            <td class="text-center">' . $name . '</td> 
            <td style="width: 150px; padding: 5px"><img class="item-image w-100" src="'.$picture.'"></a></td>
            <td class="text-center position-relative">' . $status . '</td>
            <td class="text-center position-relative">' . $ordering . '</td>
            <td>' . $created . '</td>
            <td>' . $modified . '</td>
            <td>
                ' . $btnEdit . '
                ' . $btnDelete . '
            </td>
        </tr>
        ';
    }
} else {
    $xhtml = HelperBackend::showTableEmpty(8);
}

?>

<form action="" method="post" id="form-table">
    <div class="table-responsive">
        <table class="table align-middle text-center table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all-cid"></th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Picture</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ordering</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Modified</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?= $xhtml ?>
            </tbody>
        </table>
    </div>
</form>


