<?php

class Form
{
    public static function input($type, $name = '', $label = '', $value = '')
    {
        if (!empty($label)) {
            $label = sprintf('<label class="form-label">%s</label>', $label);
        }
        $xhtml = sprintf('<div class = "mb-3">
                            %s
                            <input type = "%s" value="%s" class = "form-control" name = "%s">
                        </div>', $label, $type, $value, $name);
        return $xhtml;
    }

    public static function select($options, $name = '', $label = '', $selected = null) {
        if (!empty($label)) {
            $label = sprintf('<label class="form-label">%s</label>', $label);
        }

        $xhtmlOptions = '';
        foreach ($options as $optionKey => $optionValue) {
            $selectedX = $selected == $optionKey ? 'selected' : '';
            $xhtmlOptions .= sprintf('<option value="%s" %s>%s</option>', $optionKey, $selectedX, $optionValue);
        }

        $xhtml = sprintf('
        <div class="mb-3">
            %s
            <select class="form-select" name="%s">
               %s
            </select>
        </div>', $label, $name, $xhtmlOptions);
        return $xhtml;
    }
}
