<?php
class HelperDefault
{
    public static function button($link, $class, $name)
    {
        return sprintf('<button type="button" data-url="%s" class="btn btn-solid %s">%s</button>', $link, $class, $name);
    }

    public static function inputHidden( $name, $value, $id)
    {
       
        $xhtml = sprintf(' <input type="hidden" name="%s" value="%s" id="%s">', $name, $value, $id);
        return $xhtml;
    }

    
    //SORT FORM
    public static function sortForm($arrValue, $keySelect = 'default')
    {
        $xhtml = '';
        $xhtml .= '  <form action="" id="sort-form" method="POST">
                        <select id="sort" name="sort">';

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
    
    public static function itemNavBar($type, $link, $title, $controllerActive, $arrElement = null)
    {
        $xhtml = '';
        $controller = HelperDefault::getURLQuery('controller');
        $classActive = ($controller == $controllerActive) ? 'active' : '';
        if ($type == 'single') {
            $xhtml = '<li><a href="' . $link . '" class="my-menu-link ' . $classActive . '">' . $title . '</a></li>';
        } elseif ($type == 'dropdown') {
            $xhtml .= '<li><a href="' . $link . '" class="my-menu-link ' . $classActive . '">' . $title . '</a><ul>';
            foreach ($arrElement as $value) {
                $xhtml .= '<li><a href="' . $value['link'] . '">' . $value['title'] . '</a></li>';
            }
            $xhtml .= '</ul></li>';
        }

        return $xhtml;
    }

    public static function getURLQuery($type = 'controller')
    {
        $result = '';
        if ($type == 'controller') {
            @$string = (explode('&', $_SERVER['QUERY_STRING'])[1]);
            $result = (!is_null($string)) ? (explode('=', $string))[1] : 'home';
        }
        return $result;
    }

    public static function highlight($search, $value)
    {
        if (!empty(trim($search))) {
            return preg_replace('/' . preg_quote($search, '/') . '/ui', '<mark>$0</mark>', $value);
        }

        return $value;
    }

}
