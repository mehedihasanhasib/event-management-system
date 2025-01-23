<?php

namespace Core;

class Validator
{
    protected $errors = [];

    public function make($data, $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                switch ($rule) {
                    case 'required':
                        if (empty($data[$field])) {
                            $this->errors[$field][] = "The $field field is required.";
                        }
                        break;
                    case "string";
                        if (!is_string($data[$field])) {
                            $this->errors[$field][] = "The $field field must be a string.";
                        }
                        break;
                    case "email";
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$field][] = "The $field field must be a valid email.";
                        }
                        break;
                    case str_starts_with($rule, 'max:'):
                        $maxLength = (int) substr($rule, 4);
                        if (isset($data[$field]) && strlen($data[$field]) > $maxLength) {
                            $this->errors[$field][] = "The $field field must not exceed $maxLength characters.";
                        }
                        break;

                    case str_starts_with($rule, 'min:'):
                        $minLength = (int) substr($rule, 4);
                        if (isset($data[$field]) && strlen($data[$field]) < $minLength) {
                            $this->errors[$field][] = "The $field field must be at least $minLength characters.";
                        }
                        break;
                }
            }
        }
        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
