<?php

class FormDefault
{
    
    public static function label($forname, $text)
    {  
        $xhtml = sprintf('<label for="%s">%s</label>', $forname, $text);
        return $xhtml;
    }


    public static function inputText($name, $value, $readonly=true)
    {
        $xhtmlReadOnly = ($readonly == true) ? 'readonly' : '';
        $xhtml = sprintf(' <input type="text" name="%s" value="%s" class="form-control" %s>', $name, $value, $xhtmlReadOnly);
        return $xhtml;
    }

    public static function inputPassWord($name, $value, $readonly=true)
    {
        $xhtmlReadOnly = ($readonly == true) ? 'readonly' : '';
        $xhtml = sprintf(' <input type="password" name="%s" value="%s" class="form-control" %s>', $name, $value, $xhtmlReadOnly);
        return $xhtml;
    }

    public static function inputHidden($name, $value)
    {
        $xhtml = sprintf(' <input type="hidden" name="%s" value="%s">', $name, $value);
        return $xhtml;

    }

    public static function select($name, $values, $keySelected = 'default')
    {
        $xhtmlOptions = '';
        foreach ($values as $key => $value) {
            $selected = '';
            if ($key === $keySelected) $selected = 'selected';
            $xhtmlOptions .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $value);
        }
        $xhtml = sprintf('
        <select class="custom-select" name="%s">
            %s
        </select>
        ', $name, $xhtmlOptions);
        return $xhtml;
    }

    public static function rowForm($element)
    {
        $xhtml = '';
        switch ($element['type']) {
            case 'input':
            case 'text':
            case 'number':
            case 'password':
            case 'file':
                $xhtml = sprintf('
                <div class="form-group">
                    %s
                    %s
                </div>
                ', $element['label'], $element['input']);
                break;


            case 'input-hidden':
                $xhtml = sprintf('%s', $element['input']);
                break;
        }
        return $xhtml;
    }

    public static function showForm($arrElements)
    {
        $xhtml = '';

        if (!empty($arrElements)) {
            foreach ($arrElements as $element) {
                $xhtml .= self::rowForm($element);
            }
        }

        return $xhtml;
    }

    //USER



    public static function rowText($label, $name, $id)
    {
        $xhtml = sprintf('
                <div class="form-group">
                    <label>%s </label>
                    <input type="text" class="form-control" name="%s" value="%s" readonly="">
                </div>
        ', $label, $name, $id);
        return $xhtml;
    }

    //CATEGORY

    public static function inputOrdering($name, $value)
    {
        $xhtml = sprintf(' <input type="number" id="form[ordering]" name="%s" value="%s" class="form-control form-control-sm">', $name, $value);
        return $xhtml;
    }


    public static function inputImage($name)
    {
        return sprintf('
        <input type="file" name="%s" class="form-control-file" id="admin-file-upload">
       
        ', $name);
    }

    // public static function imagePreview($src)
    // {
    //     return sprintf('
    //         <img src="%s" alt="preview image" id="admin-preview-image" style="display: none;width: 100%; max-width: 500px">
    //     ', $src);
    // }

    //BOOK

    public static function textArea($name, $row, $value)
    {
        $xhtml = sprintf('
       
            <textarea id="" name="%s" class="form-control form-control-sm" rows="%s">%s</textarea>
        
        ', $name, $row, $value);
        return $xhtml;
    }
}
