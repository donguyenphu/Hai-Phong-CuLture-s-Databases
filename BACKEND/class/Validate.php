<?php
class Validate
{

    // Error array
    private $errors    = array();

    // sources array
    private $sources    = array();

    // Rules array
    private $rules    = array();

    // Result array
    private $result    = array();

    // Contrucst
    public function __construct($sources)
    {
        $this->sources = $sources;
    }

    // Add rules
    public function addRules($rules)
    {
        $this->rules = array_merge($rules, $this->rules);
    }

    // Get error
    public function getErrors()
    {
        return $this->errors;
    }

    // Set error
    public function setError($element, $message)
    {
        $this->errors[$element] = '<b>' . ucfirst($element) . ':</b> ' . $message;
    }

    // Get result
    public function getResults()
    {
        return $this->result;
    }

    // Add rule
    public function addRule($element, $type, $options = null, $required = true)
    {
        $this->rules[$element] = $options;
        return $this;
    }
    //Add all rule
    public function addAllRules($rules)
    {
        $this->rules = $rules;
    }

    // Run
    public function run()
    {
        foreach ($this->rules as $element => $value) {
            switch ($value['type']) {
                case 'int':
                    $this->validateInt($element, $value['min'], $value['max']);
                    break;
                case 'string':
                    $this->validateString($element, $value['min'], $value['max']);
                    break;
                case 'url':
                    $this->validateUrl($element);
                    break;
                case 'email':
                    $this->validateEmail($element);
                    break;
                case 'status':
                    $this->validateStatus($element);
                    break;
                case 'group':
                    $this->validateGroupID($element);
                    break;
                case 'image':
                    $this->validateImage($element, $value['max_bytes'], $value['extensions']);
                    break;
                case 'password':
                    $this->validatePassword($element, $value['options']);
                    break;
                case 'date':
                    $this->validateDate($element, $value['options']['start'], $value['options']['end']);
                    break;
                case 'existRecord':
                    $this->validateExistRecord($element, $value['options']);
                    break;
            }
            if (!array_key_exists($element, $this->errors)) {
                $this->result[$element] = $this->sources[$element];
            }
        }
        $eleNotValidate = array_diff_key($this->sources, $this->errors);
        $this->result    = array_merge($this->result, $eleNotValidate);
    }

    // Validate Integer
    public function validateInt($element, $min = 0, $max = 0)
    {
        $condititon = array("options" => array("min_range" => $min, "max_range" => $max));
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_INT, $condititon)) {
            $this->setError($element, 'is an invalid number');
        }
    }

    //Validate Image
    public function validateImage($element, $max_bytes, $extensions)
    {
        $extensions_file = pathinfo($this->sources[$element]["name"], PATHINFO_EXTENSION);
        $bytes = $this->sources[$element]["size"];
        $fullErrors = '';
        if (intval($this->sources[$element]['size']) == 0) {
            $fullErrors .= 'Please upload an image' . '</br>';
        } else {
            if (!in_array($extensions_file, $extensions)) {
                $fullErrors .= 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element]["name"] . '</b>' . ' as Image (extension) </br>';
            }
            if ($bytes > $max_bytes) {
                $fullErrors .= 'Invalid ' . $element . ' ' . '<b>' . $this->sources[$element]["name"] . '</b>' . ' as Image (filesize) </br>';
            }
        }
        if ($fullErrors !== '') {
            $this->errors[$element] = $fullErrors;
        }
    }

    // Validate String
    public function validateString($element, $min = 0, $max = 0)
    {
        $length = strlen($this->sources[$element]);
        if ($length === 0) {
            $this->setError($element, 'has to be filled');
        } else if ($length < $min) {
            $this->setError($element, 'is too short');
        } elseif ($length > $max) {
            $this->setError($element, 'is too long');
        } elseif (!is_string($this->sources[$element])) {
            $this->setError($element, 'is an invalid string');
        }
    }

    // Validate URL
    public function validateURL($element)
    {
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_URL)) {
            $this->setError($element, 'is an invalid url');
        }
    }

    // Validate Email
    public function validateEmail($element)
    {
        if (!filter_var($this->sources[$element], FILTER_VALIDATE_EMAIL)) {
            $this->setError($element, 'is an invalid email');
        }
    }

    public function showErrors()
    {
        $errorFix = '<div class="alert alert-danger" role="alert">';
        foreach ($this->errors as $element => $value) {
            $errorFix .= '<li>' . '<strong>' . ucfirst($element) . '</strong>' . ' : ' . $value . '</li>';
        }
        $errorFix .= '</div>';
        return $errorFix;
    }

    public function isValid()
    {
        if (count($this->errors) > 0) return false;
        return true;
    }

    // Validate Status
    public function validateStatus($element)
    {
        if ($this->sources[$element] < 0 || $this->sources[$element] > 1) {
            $this->setError($element, 'Select status');
        }
    }

    // Validate GroupID
    public function validateGroupID($element)
    {
        if ($this->sources[$element] == 0) {
            $this->setError($element, 'Select group');
        }
    }

    // Validate Password
    public function validatePassword($element, $options)
    {
        if ($options['action'] == 'add' || ($options['action'] == 'edit' && $this->sources[$element])) {
            $pattern = '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,8}$#';    // Php4567!
            if (!preg_match($pattern, $this->sources[$element])) {
                $this->setError($element, 'is an invalid password');
            };
        }
    }

    // Validate Date
    public function validateDate($element, $start, $end)
    {
        // Start
        $arrDateStart     = date_parse_from_format('d/m/Y', $start);
        $tsStart        = mktime(0, 0, 0, $arrDateStart['month'], $arrDateStart['day'], $arrDateStart['year']);

        // End
        $arrDateEnd     = date_parse_from_format('d/m/Y', $end);
        $tsEnd            = mktime(0, 0, 0, $arrDateEnd['month'], $arrDateEnd['day'], $arrDateEnd['year']);

        // Current
        $arrDateCurrent    = date_parse_from_format('d/m/Y', $this->sources[$element]);
        $tsCurrent        = mktime(0, 0, 0, $arrDateCurrent['month'], $arrDateCurrent['day'], $arrDateCurrent['year']);

        if ($tsCurrent < $tsStart || $tsCurrent > $tsEnd) {
            $this->setError($element, 'is an invalid date');
        }
    }

    // Validate Exist record
    public function validateExistRecord($element, $options)
    {
        $database = $options['database'];

        $query      = $options['query'];
        if ($database->isExist($query)) {
            $this->setError($element, 'record is exist');
        }
    }
}
