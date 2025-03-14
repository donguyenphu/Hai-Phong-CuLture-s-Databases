<?php

class Form
{
    public static function input($type, $name = '', $label = '', $submittedArray, $listParameters)
    {
        if (!empty($label)) {
            $label = sprintf('<label class = "form - label">%s</label>', $label);
        }
        $submittedValue = '';
        if (isset($submittedArray['submit'])) {
            /// only search use the name attribute of an array
            if (isset($submittedArray['search'])) $submittedValue = $submittedArray['search']; 
            foreach ($listParameters as $key => $value) {
                if (isset($submittedValue[$value]) && !empty($submittedValue[$value])) {
                    $submittedValue = $submittedValue[$value];
                }
                else {
                    $submittedValue = '';
                    break;
                }
            }   
        }
        $xhtml = sprintf('<div class = "mb-3">
                            %s
                            <input type = "%s" value = "'.$submittedValue.'" class = "form-control" name = "%s">
                        </div>', $label, $type, $name);
        return $xhtml;
    }
}
