<?php
class Validate
{
    private $sources = array();
    private $rules = array();
    private $errors = array();
    private $result = array();
    public function __construct($inputData)
    {
        $this->sources = $inputData;
    }
    public function addAllRules($rules)
    {
        $this->rules = $rules;
    }
    public function addOneRule($name, $typeData, $min, $max)
    {
        $this->rules[$name]['type'] = $typeData;
        $this->rules[$name]['min'] = $min;
        $this->rules[$name]['max'] = $max;
    }
    public function printRules()
    {
        echo '<pre style="color: red;font-weight:bold">';
        print_r($this->rules);
        echo '</pre>';
    }
    public function printErrors()
    {
        echo '<pre style="color: red;font-weight:bold">';
        print_r($this->errors);
        echo '</pre>';
    }
    public function printResults()
    {
        echo '<pre style="color: red;font-weight:bold">';
        print_r($this->result);
        echo '</pre>';
    }
    public function returnResults()
    {
        return $this->result;
    }
    public function returnErrors()
    {
        return $this->errors;
    }
    public function printSources()
    {
        echo '<pre style="color: red;font-weight:bold">';
        print_r($this->sources);
        echo '</pre>';
    }
    public function run()
    {
        foreach ($this->rules as $element => $value) {
            // if ($value['type'] == 'int') {
            //     $this -> validateInt($element, $value['min'], $value['max']);
            // }
            // else if ($value['type'] == 'string') {
            //     $this -> validateString($element, $value['min'], $value['max']);
            // }
            // else if ($value['type'] == 'email') {
            //     $this -> validateEmail($element);
            // }
            // else if ($value['type'] == 'url') {
            //     $this -> validateURL($element);
            // }
            if ($value['type'] == 'string') {
                $this->validateString($element, $value['min'], $value['max']);
            } else if ($value['type'] == 'file') {
                $this->validateFile($element);
            } else if ($value['type'] == 'url') {
                $this->validateURL($element);
            } else if ($value['type'] == 'url-custom') {
                $this->validateURLCustom($element);
            } else if ($value['type'] == 'int') {
                $this->validateInt($element, $value['min'], $value['max']);
            }
            else if ($value['type'] == 'image') {
                $this->validateImage($element, $value['max_bytes'], $value['extensions']);
            }
            if (!array_key_exists($element, $this->errors)) $this->result[$element] = $this->sources[$element];
        }
    }
    // VALIDATE INPUT
    public function validateInt($element, $minRange, $maxRange)
    {
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_INT, array("options" => array(
            "min_range" => $minRange,
            "max_range" => $maxRange
        )))) {
            $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as int';
        }
    }
    public function validateString($element, $minRange, $maxRange)
    {
        $errorAll = '';
        if (!is_string($this->sources[$element])) {
            $errorAll = 'The ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' is not a string';
        } else if (strlen(trim($this->sources[$element])) < $minRange || strlen(trim($this->sources[$element])) > $maxRange) {
            if (strlen(trim($this->sources[$element])) < $minRange) $errorAll = 'The ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' is too short';
            else $errorAll = 'The ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' is too long';
        }
        if ($errorAll !== '') {
            $this->errors[$element] = $errorAll;
        }
    }
    public function validateEmail($element)
    {
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as email';
        }
    }
    public function validateURL($element)
    {
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_URL)) {
            $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as URL';
        }
    }

    // goole.com, zendvn.com -> validateURL
    // goole.com, index.php -> validateURLCustom

    public function validateURLCustom($element) {
        $extensions = pathinfo($this->sources[$element], PATHINFO_EXTENSION);
        if (filter_var($this->sources[$element], FILTER_VALIDATE_URL)) {
            return;
        } else if ($extensions == 'php') {
            return;
        } else if ($extensions == 'html') {
            return;
        } else if ($extensions == 'com') {
            return;
        }
        $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as URL';
        // if (!filter_var($this->sources[$element], FILTER_VALIDATE_URL)) {
        //     $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as URL';
        // }
    }

    public function validateFile($element)
    {
        if (!file_exists($this->sources[$element])) {
            $this->errors[$element] = 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element] . '</b>' . ' as File';
        }
    }

    public function validateImage($element, $max_bytes, $extensions) {
        $extensions_file = pathinfo($this->sources[$element]["name"], PATHINFO_EXTENSION);
        $bytes = $this->sources[$element]["size"];
        $fullErrors = '';
        if (!in_array($extensions_file, $extensions)) {
            $fullErrors .= 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element]["name"] . '</b>' . ' as Image (extension) </br>';
        }
        if ($bytes > $max_bytes) {
            $fullErrors .= 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element]["name"] . '</b>' . ' as Image (filesize) </br>';
        }
        if ($fullErrors !== '') {
            $this->sources[$element] = $fullErrors;
        }
    }
}
