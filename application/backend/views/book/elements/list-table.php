<?php
$xhtml = '';

if (count($this->items)) {
    foreach ($this->items as $key => $item) {

        $id                 = $item['id'];
        $ckb                = sprintf('<input type="checkbox" name="cid[]" value="%s">', $id);
        $name               = HelperBackend::highlight(@$arrParams['search'], $item['name']);
        $picture            = 'public' . DS . 'file' . DS . 'book' . DS . $item['picture'];
        $price              = $item['price'];
        $sale_off           = $item['sale_off'];

        //CATEGORY_NAME
        $linkChangeCategoryID  = URL::createLink($arrParams['module'], $arrParams['controller'], 'changeCategoryID', ['category_id' => 'value_new', 'id' => $id]);
        $categoryName       =   HelperBackend::selectBox('select-category',$this->categoryName, $item['category_id'], ['data-url' => $linkChangeCategoryID, 'class' => 'slb-change-attr custom-select custom-select-sm']);


        $ordering           = HelperBackend::itemOrdering($arrParams['module'], $arrParams['controller'],'number', 'checkOrdering', $item['ordering'], $item['id']);

        $status             = HelperBackend::itemStatus($arrParams['module'], $arrParams['controller'], $item['status'], $id);
        $special             = HelperBackend::itemSpecial($arrParams['module'], $arrParams['controller'], $item['special'], $id);

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
            <td class="text-wrap" style="min-width: 180px">' . $name . '</td> 
            <td style="width: 100px; padding: 5px"><img class="item-image w-100" src="' . $picture . '"></a></td>
            <td class="text-center">' . $price . '</td>
            <td class="text-center">' . $sale_off . '</td>
            <td class="text-center position-relative">' . $categoryName . '</td>
            <td class="text-center position-relative">' . $status . '</td>
            <td class="text-center position-relative">' . $special . '</td>
            <td class="text-center position-relative">' . $ordering . '</td>
            <td>' . $created . '</td>
           
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
                    <th class="">Name</th>
                    <th class="text-center">Picture</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Sale Off</th>
                    <th class="text-center">Category</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Special</th>
                    <th class="text-center">Ordering</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?= $xhtml ?>
            </tbody>
        </table>
    </div>
</form>


<!-- <form action="" method="post" class="table-responsive" id="form-table">
    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
        <thead>
            <tr>
                <th class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="check-all">
                        <label for="check-all" class="custom-control-label"></label>
                    </div>
                </th>
                <th class="text-center">ID</th>
                <th class="">Name</th>
                <th class="text-center">Picture</th>
                <th class="text-center">Price</th>
                <th class="text-center">Sale Off</th>
                <th class="text-center">Category</th>
                <th class="text-center">Status</th>
                <th class="text-center">Special</th>
                <th class="text-center">Ordering</th>
                <th class="text-center">Created</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="checkbox-1" name="checkbox[]" value="1">
                        <label for="checkbox-1" class="custom-control-label"></label>
                    </div>
                </td>
                <td class="text-center">1</td>
                <td class="text-wrap" style="min-width: 180px">Nuôi Con Không Phải Là Cuộc Chiến 2 (Trọn Bộ 3 Tập)</td>
                <td style="width: 100px; padding: 5px"><img class="item-image w-100" src="images/category1.jpg"></td>
                <td class="text-center">319,000 đ</td>
                <td class="text-center">34%</td>
                <td class="text-center position-relative">
                    <select name="select-category" class="custom-select custom-select-sm" style="width: unset" id="1" data-id="1">
                        <option value="1" selected="">Bà mẹ - Em bé</option>
                        <option value="2">Chính Trị - Pháp Lý</option>
                        <option value="3">Công Nghệ Thông Tin</option>
                        <option value="4">Giáo Khoa - Giáo Trình</option>
                        <option value="5">Học Ngoại Ngữ</option>
                    </select>
                </td>
                <td class="text-center position-relative">
                    <a href="i" class="my-btn-state rounded-circle btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                </td>
                <td class="text-center position-relative">
                    <a href="i" class="my-btn-state rounded-circle btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                </td>
                <td class="text-center position-relative"><input type="number" name="chkOrdering[1]" value="1" class="chkOrdering form-control form-control-sm m-auto text-center" style="width: 65px" id="chkOrdering[1]" data-id="1" min="1"></td>
                <td class="text-center">
                    <p class="mb-0 history-by"><i class="far fa-user"></i> admin</p>
                    <p class="mb-0 history-time"><i class="far fa-clock"></i> 15/07/2020 10:36:48</p>
                </td>
                <td class="text-center">
                    <a href="#" class="rounded-circle btn btn-sm btn-info" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <a href="" class="rounded-circle btn btn-sm btn-danger" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="checkbox-5" name="checkbox[]" value="5">
                        <label for="checkbox-5" class="custom-control-label"></label>
                    </div>
                </td>
                <td class="text-center">5</td>
                <td class="text-wrap" style="min-width: 180px">Nuôi Con Không Phải Là Cuộc Chiến (Tái Bản 2020)</td>
                <td style="width: 100px; padding: 5px"><a data-toggle="modal" data-target="#modal-image"><img class="item-image w-100" src="images/category2.jpg"></a></td>
                <td class="text-center">99,000 đ</td>
                <td class="text-center">37%</td>
                <td class="text-center position-relative">
                    <select name="select-category" class="custom-select custom-select-sm" style="width: unset" id="5" data-id="5">
                        <option value="1">Bà mẹ - Em bé</option>
                        <option value="2" selected>Chính Trị - Pháp Lý</option>
                        <option value="3">Công Nghệ Thông Tin</option>
                        <option value="4">Giáo Khoa - Giáo Trình</option>
                        <option value="5">Học Ngoại Ngữ</option>
                    </select>
                </td>
                <td class="text-center position-relative">
                    <a href="#" class="my-btn-state rounded-circle btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                </td>
                <td class="text-center position-relative">
                    <a href="#" class="my-btn-state rounded-circle btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                </td>
                <td class="text-center position-relative"><input type="number" name="chkOrdering[5]" value="1" class="chkOrdering form-control form-control-sm m-auto text-center" style="width: 65px" id="chkOrdering[5]" data-id="5" min="1"></td>
                <td class="text-center">
                    <p class="mb-0 history-by"><i class="far fa-user"></i> admin</p>
                    <p class="mb-0 history-time"><i class="far fa-clock"></i> 15/07/2020 10:39:24</p>
                </td>
                <td class="text-center">
                    <a href="#" class="rounded-circle btn btn-sm btn-info" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>

                    <a href="#" class="rounded-circle btn btn-sm btn-danger" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</form> -->