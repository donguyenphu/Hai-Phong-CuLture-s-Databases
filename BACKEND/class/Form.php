<?php

class Form
{
    public static function input($type, $name = '', $label = '')
    {
        if (!empty($label)) {
            $label = sprintf('<label class = "form - label">%s</label>', $label);
        }
        $xhtml = sprintf('<div class = "mb-3">
                            %s
                            <input type = "%s" class = "form-control" name = "%s">
                        </div>', $label, $type, $name);
        return $xhtml;
    }
}
