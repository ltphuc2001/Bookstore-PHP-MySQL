<?php
class HelperBackend
{
    public static function itemGroupACP($module, $controller, $action, $group_acp, $id)
    {
        $class = 'btn-danger';
        $icon = 'fa-minus';
        if ($group_acp == 'yes') {
            $class = 'btn-success';
            $icon = 'fa-check';
        }
        $link = URL::createLink($module, $controller, 'ajaxACP', ['group_acp' => $group_acp, 'id' => $id]);
        $xhtml = '';
        $xhtml .= sprintf('
             <button type = "button" data-url = "%s" class = "btn-group-acp my-btn-state rounded-circle btn btn-sm %s">
                 <i class= "fas %s"></i>
             </button>
        ', $link, $class, $icon);
        return $xhtml;
    }




    public static function itemOrdering($module, $controller, $type, $name, $ordering, $id)
    {
        $link = URL::createLink($module, $controller, 'changeOrdering', ['ordering' => 'value_new', 'id' => $id]);
        $xhtml = '<input type="' . $type . '" data-url = "' . $link . '" name="' . $name . '[' . $id . ']" value="' . $ordering . '" class="chkOrdering form-control form-control-sm m-auto text-center" style="width: 65px" id="' . $name . '[' . $id . ']"">';
        return $xhtml;
    }

    public static function itemStatus($module, $controller, $status, $id)
    {
        $class = 'btn-danger';
        $icon = 'fa-minus';
        if ($status == 'active') {
            $class = 'btn-success';
            $icon = 'fa-check';
        }
        $link = URL::createLink($module, $controller, 'ajaxChangeStatus', ['status' => $status, 'id' => $id]);
        $xhtml = '';
        $xhtml .= sprintf('
            <button type = "button" data-url = "%s" class = "btn-status my-btn-state rounded-circle btn btn-sm %s">
                <i class= "fas %s"></i>
            </button>
       ', $link, $class, $icon);
        return $xhtml;
    }

    public static function itemShowHome($module, $controller, $showHome, $id)
    {
        $class = 'btn-danger';
        $icon = 'fa-minus';
        if ($showHome == 'active') {
            $class = 'btn-success';
            $icon = 'fa-check';
        }
        $link = URL::createLink($module, $controller, 'ajaxChangeShowHome', ['showHome' => $showHome, 'id' => $id]);
        $xhtml = '';
        $xhtml .= sprintf('
            <button type = "button" data-url = "%s" class = "btn-showHome my-btn-state rounded-circle btn btn-sm %s">
                <i class= "fas %s"></i>
            </button>
       ', $link, $class, $icon);
        return $xhtml;
    }

    public static function itemSpecial($module, $controller, $special, $id)
    {
        $class = 'btn-danger';
        $icon = 'fa-minus';
        if ($special == 'yes') {
            $class = 'btn-success';
            $icon = 'fa-check';
        }
        $link = URL::createLink($module, $controller, 'ajaxChangeSpecial', ['special' => $special, 'id' => $id]);
        $xhtml = '';
        $xhtml .= sprintf('
            <button type = "button" data-url = "%s" class = "btn-status my-btn-state rounded-circle btn btn-sm %s">
                <i class= "fas %s"></i>
            </button>
       ', $link, $class, $icon);
        return $xhtml;
    }

    public static function itemHistory($by, $time)
    {

        $xhtml = '';
        if ($by != '' || $time != '') {
            $xhtml .= sprintf('
                <p class="mb-0 history-by"><i class="far fa-user"></i> ' . $by . '</p>
                <p class="mb-0 history-time"><i class="far fa-clock"></i> ' . date('d/m/Y H:i:s', strtotime($time)) . '</p>
                ');
        }


        return $xhtml;
    }

    public static function button($type, $name, $class = 'btn-info', $options = ['small' => false, 'circle' => false])
    {
        $optionsClass = '';
        if ($options['small']) $optionsClass .= ' btn-sm';
        if ($options['circle']) $optionsClass .= ' rounded-circle';
        return sprintf('<button type="%s" class="btn %s %s">%s</button> ', $type, $class, $optionsClass, $name);
    }
    public static function highlight($search, $value)
    {
        if (!empty(trim($search))) {
            return preg_replace('/' . preg_quote($search, '/') . '/ui', '<mark>$0</mark>', $value);
        }

        return $value;
    }

    public static function showMessage()
    {
        $xhtml = '';
        if (Session::get('message')) {
            $xhtml = sprintf('
                <div class="alert alert-success alert-dismissible system-message">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p class="mb-0">%s</p>
                </div>
                ', Session::get('message'));
            Session::unset('message');
        }
        return $xhtml;
    }
    // public static function buttonLink($id, $type){

    //     $xhtml = '';
    //     $link  = '';
    //     $link = URL::createLink('backend', 'group', $type);


    //     if($type == 'edit'){
    //         $xhtml .= sprintf('
    //                     <a href="%s&id=%s" class="rounded-circle btn btn-sm btn-info" title="%s">
    //                          <i class="fas fa-pencil-alt"></i>
    //                     </a>', $link, $id, ucfirst($type));
    //     }
    //     if($type == 'delete'){
    //         $xhtml .= sprintf('
    //                     <a href="%s&id=%s" class="rounded-circle btn btn-sm btn-danger btn-delete" title="%s" >
    //                         <i class="fas fa-trash-alt"></i>
    //                     </a>', $link, $id, ucfirst($type));
    //     }

    //     return $xhtml;
    // }

    public static function buttonLink($link, $name, $class = 'btn-info', $options = ['small' => false, 'circle' => false])
    {
        $optionsClass = '';
        if ($options['small']) $optionsClass .= ' btn-sm';
        if ($options['circle']) $optionsClass .= ' rounded-circle';
        return sprintf('<a href="%s" class="btn %s %s">%s</a> ', $link, $class, $optionsClass, $name);
    }


    public static function showFilterStatus($module, $controller, $itemStatusCount, $currentStatus, $searchValue)
    {
        $xhtml = '';
        if (!empty($itemStatusCount)) {
            foreach ($itemStatusCount as $key => $value) {
                $active = $key == $currentStatus ? 'btn-info' : 'btn-secondary';
                $name = ucfirst($key);
                $params = ['status' => $key];
                if (!empty($searchValue)) $params['search'] = $searchValue;
                $link = URL::createLink($module, $controller, 'index', $params);
                $xhtml .= sprintf(
                    '
                    <a href="%s" class="mr-1 btn btn-sm %s">%s <span class="badge badge-pill badge-light">%s</span></a>',
                    $link,
                    $active,
                    $name,
                    $value
                );
            }
            return $xhtml;
        }
    }

    // public static function highlightSearch($keyword, $string){
    //     $xhtml = !empty($keyword) ? preg_replace("#$keyword#ui", "<mark>$0</mark>", $string) : $string;
    //     return $xhtml;
    // }

    public static function showTableEmpty($columns = 0)
    {
        return sprintf('<tr><td colspan="%s" class="text-center">Dữ liệu đang được cập nhật!</td></tr>', $columns);
    }

    public static function filterForm($module, $controller, $action, $id, $arrValue, $keySelect = 'default')
    {
        $xhtml = '';
        $xhtml .= ' <form action="" id="form-filter">
            <input type="hidden" name="module" value="' . $module . '">
            <input type="hidden" name="controller" value="' . $controller . '">
            <input type="hidden" name="action" value="' . $action . '">
            <select id="' . $id . '" name="' . $id . '" class="custom-select custom-select-sm mr-1" style="width: unset">';

        if (!empty($arrValue)) {

            foreach ($arrValue as $key => $value) {
                if ($key == $keySelect) {
                    $xhtml .= ' <option value="' . $key . '" selected = "selected">' . $value . '</option>';
                } else {
                    $xhtml .= ' <option value="' . $key . '">' . $value . '</option>';
                }
            }
            $xhtml .= '</select>' . '</form>';
        }
        return $xhtml;
    }

    public static function filterBar($module, $controller, $action, $search)
    {
        $xhtml = '';
        $link = URL::createLink($module, $controller, $action);
        $xhtml .= sprintf('
            <form action="">
                <div class="input-group" id="filter_bar">
                    <input type="hidden" name="module" value="%s">
                    <input type="hidden" name="controller" value="%s">
                    <input type="hidden" name="action" value="%s">

                    <input type="text" id="filter_search" class="form-control form-control-sm" name="search" value="%s" style="min-width: 300px">
                    <div class="input-group-append">
                        <a href="%s" type="reset" class="btn btn-sm btn-danger" id="btn-clear-search">Clear</a>
                        <button type="submit" class="btn btn-sm btn-info" id="btn-search">Search</button>
                    </div>
                </div>
            </form>', $module, $controller, $action, $search, $link);

        return $xhtml;
    }

    public static function selectBox($name, $arrOptions, $keySelected, $paramsOptions = [])
    {
        $strParams = '';
        if (!empty($paramsOptions)) {
            foreach ($paramsOptions as $key => $value) {
                $strParams .= "$key='$value'";
            }
        }
        $xhtml = sprintf('<select %s name="%s" style="width: unset">', $strParams, $name);
        if (!empty($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                $classSelected = ($keySelected == $key) ? 'selected' : '';
                $xhtml .= sprintf('<option value="%s" %s>%s</option>', $key, $classSelected, ucfirst($value));
            }
        }
        $xhtml .= '</select>';
        return $xhtml;
    }

    //BOOK

    public static function filterCategory($module, $controller, $action, $id, $arrValue, $keySelect = 'default')
    {
        $xhtml = '';
        $xhtml .= ' <form action="" id="form-filter">
                        <input type="hidden" name="module" value="' . $module . '">
                        <input type="hidden" name="controller" value="' . $controller . '">
                        <input type="hidden" name="action" value="' . $action . '">
                        <select id="' . $id . '" name="' . $id . '" class="custom-select custom-select-sm mr-1" style="width: unset">';

        if (!empty($arrValue)) {

            foreach ($arrValue as $key => $value) {
                if ($key == $keySelect) {
                    $xhtml .= ' <option value="' . $key . '" selected = "selected">' . $value . '</option>';
                } else {
                    $xhtml .= ' <option value="' . $key . '">' . $value . '</option>';
                }
            }
            $xhtml .= '</select>' . '</form>';
        }
        return $xhtml;
    }


    public static function filterFormBook($module, $controller, $action, $idSpecial, $idCategory, $arrValueSpecial, $arrValueCategory, $keySelectSpecial = 'default', $keySelectCategory = '0')
    {
        $xhtml = '';
        $xhtml .= ' <form action="" id="form-filter">
                        <input type="hidden" name="module" value="' . $module . '">
                        <input type="hidden" name="controller" value="' . $controller . '">
                        <input type="hidden" name="action" value="' . $action . '">';


        $xhtml .= '<select id="' . $idSpecial . '" name="' . $idSpecial . '" class="custom-select custom-select-sm mr-1" style="width: unset">';
        if (!empty($arrValueSpecial)) {

            foreach ($arrValueSpecial as $key => $value) {
                if ($key == $keySelectSpecial) {
                    $xhtml .= ' <option value="' . $key . '" selected = "selected">' . $value . '</option>';
                } else {
                    $xhtml .= ' <option value="' . $key . '">' . $value . '</option>';
                }
            }
            $xhtml .= '</select>';
        }



        $xhtml .= '<select id="' . $idCategory . '" name="' . $idCategory . '" class="custom-select custom-select-sm mr-1" style="width: unset">';
        if (!empty($arrValueCategory)) {

            foreach ($arrValueCategory as $key => $value) {
                if ($key == $keySelectCategory) {
                    $xhtml .= ' <option value="' . $key . '" selected = "selected">' . $value . '</option>';
                } else {
                    $xhtml .= ' <option value="' . $key . '">' . $value . '</option>';
                }
            }
            $xhtml .= '</select>' . '</form>';
        }
        return $xhtml;
    }
}
