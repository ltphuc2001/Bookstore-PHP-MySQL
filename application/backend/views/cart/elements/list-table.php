<?php
$xhtml = '';
$param = $this->arrParam;

if (count($this->items)) {
    foreach ($this->items as $key => $item) {
        
        $date           = date("d/m/Y H:i:s", strtotime($item['date']));
        $fullName       = $item['fullname'];
        $email          = $item['email'];
        $telephone      = $item['telephone'];
        $address        = $item['address'];
        $id             = HelperBackend::highlight(@$param['search'], $item['id']);
        $arrBookID      = json_decode($item['books']);
        $arrPrice       = json_decode($item['prices']);
        $arrName        = json_decode($item['names'], JSON_UNESCAPED_UNICODE);
        $arrQuantity    = json_decode($item['quantities']);
        $arrPicture     = json_decode($item['pictures']);
        $totalPrice     = 0;
        $tableContent  = '';
        $nameDetail    = '';
        $status         = HelperBackend::itemStatus($param['module'], $param['controller'], $item['status'], $id);

        //DELETE
        $optionsBtnAction   = ['small' => true, 'circle' => true];
        $linkDelete         = URL::createLink('backend', 'cart' ,'delete', ['id' => $id]);
        $btnDelete          = HelperBackend::buttonLink($linkDelete, '<i class="fas fa-trash"></i>', 'btn-danger btn-delete', $optionsBtnAction);


       
        foreach ($arrBookID as $keyB => $itemB) {
            $prices = filter_var($arrPrice[$keyB], FILTER_SANITIZE_NUMBER_INT);
            $picturePath = IMG_DEFAULT_BOOK_PATH . $arrPicture[$keyB];
            $totalPrice  += $arrQuantity[$keyB] * $prices;
            $nameDetail .= '<p>'.$arrName[$keyB].' x '.$arrQuantity[$keyB].' = ' .number_format($arrQuantity[$keyB] * $prices). ' đ</p>';
  
        }
 
        
       
        $tableContent .= '
                                        <tr class="">
                                            <td class="text-center">' . $id . '</td>
                                            <td>
                                                <p class="mb-0">Họ Tên: ' . $fullName . '</p>
                                                <p class="mb-0">Email: ' . $email . '</p>
                                                <p class="mb-0">SĐT: ' . $telephone . '</p>
                                                <p class="mb-0">Địa Chỉ: ' . $address . '</p>
                                            </td>
                                            
                                            <td class="text-center position-relative">
                                               ' . $status . '
                                            </td>

                                            <td class="text-center">
                                                '.$nameDetail.'
                                                
                                            </td>

                                            <td class="text-center">
                                                ' . number_format($totalPrice) . ' đ 
                                            </td>

                                            <td class="text-center">
                                               ' . $date . '
                                            </td>
                                            <td class="text-center">
                                               ' . $btnDelete . '
                                            </td>
                                        </tr>

        ';

        $xhtml .= $tableContent;
      

        
    }
} else {
    $tableContent = HelperBackend::showTableEmpty(8);
}

?>

<form action="" method="post" id="form-table">
    <table class="table table-bordered table-hover text-nowrap btn-table mb-0">
            <thead>
            <tr>
                <th class="text-center">Mã đơn hàng</th>
                <th class="text-center">Thông tin</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thông tin sản phẩm</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center">Ngày đặt</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php echo $xhtml ?>
            </tbody>
    </table>
</form>