<?php

class FormBackend
{
    //GROUP
    public static function label($forname, $text, $required = true)
    {
        $xhtmlRequired = ($required == true) ? 'required' : '';
        $xhtml = sprintf('<label for="%s" class="col-sm-2 col-form-label text-sm-right %s">%s</label>', $forname, $xhtmlRequired, $text);
        return $xhtml;
    }


    public static function inputText($name, $value)
    {
        $xhtml = sprintf(' <input type="text" id="%s" name="%s" value="%s" class="form-control form-control-sm">', $name, $name, $value);
        return $xhtml;
    }

    public static function inputHidden($name, $value)
    {
        $xhtml = sprintf(' <input type="hidden" name="%s" value="%s" class="form-control form-control-sm">', $name, $value);
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
            case 'number':
            case 'file':
            case 'password':
                $xhtml = sprintf('
                <div class="form-group row">
                    %s
                    <div class="col-xs-12 col-sm-8">
                         %s
                    </div>
                </div>
                ', $element['label'], $element['input']);
                break;


            case 'input-hidden':
                $xhtml = sprintf('
                <div class="form-group row">
                    <div class="col-xs-12 col-sm-8">
                         %s
                    </div>
                </div>
                ', $element['input']);
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
