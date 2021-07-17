<?php
class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;
    public function __construct(){
        $this->_db = DB::getInstance();
    }
    public function check($source, $items = array()){
        foreach ($items as $item => $rules){
            $field_name = '';
            foreach ($rules as $rule => $rule_value){
                $value = trim($source[$item]);
                $item = escape($item);
                if($rule === 'field'){
                    $field_name = $rule_value;
                }
                if($rule === 'required' && empty($value)){
                    $this->addError("{$field_name} is required");
                } else if(!empty($value)){
                    switch ($rule){
                        case "min":
                            if(strlen($value) < $rule_value){
                                $this->addError("{$field_name} must be a minimum of {$rule_value} characters");
                            }
                            break;
                        case "max":
                            if(strlen($value) > $rule_value){
                                $this->addError("{$field_name} must be a maximum of {$rule_value} characters");
                            }
                            break;
                        case "matches":
                            if($value != $source[$rule_value]){
                                $this->addError("{$field_name} must match");
                            }
                            break;
                        case "unique":
                            $values = explode('/', $rule_value);
                            $check = $this->_db->get($values[0], [$values[1], '=', strtolower($source[$item])]);
                            if($check->count()){
                                $this->addError("{$field_name} already exists.");
                            }
                            break;
                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }
        return $this;
    }
    private function addError($error){
        $this->_errors[] = $error;
    }
    public function errors(){
        return $this->_errors;
    }
    public function passed(){
        return $this->_passed;
    }
}