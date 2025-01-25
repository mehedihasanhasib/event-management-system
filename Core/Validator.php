<?php

namespace Core;

class Validator
{
    protected $errors = [];

    public function make($data, $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                if (array_key_exists($field, $data)) {
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
                            if (strlen($data[$field]) > $maxLength) {
                                $this->errors[$field][] = "The $field field must not exceed $maxLength characters.";
                            }
                            break;

                        case str_starts_with($rule, 'min:'):
                            $minLength = (int) substr($rule, 4);
                            if (strlen($data[$field]) < $minLength) {
                                $this->errors[$field][] = "The $field field must be at least $minLength characters.";
                            }
                            break;
                        case str_starts_with($rule, 'confirm:');
                            $targetField = substr($rule, 8); // Extract the field to confirm
                            if ($data[$targetField] !== $data[$field]) {
                                $this->errors[$field][] = "The $field doesn't match the $targetField.";
                            }
                            break;
                        case str_starts_with($rule, 'unique:');
                            list($table, $column) = explode(',', substr($rule, 7));
                            $result = Database::query("SELECT * FROM $table WHERE $column = ?", [$data[$field]]);
                            if (!empty($result)) {
                                $this->errors[$field][] = "The $field already exists.";
                            }
                            break;

                        case 'image':
                            $image = @imagecreatefromstring(file_get_contents($data[$field]['tmp_name']));
                            if ($image === false) {
                                $this->errors[$field][] = "Invalid image file.";
                            }
                            break;
                        case str_starts_with($rule, 'size:'):
                            $maxSize = (int) substr($rule, 5) * 1024; // Convert KB to Bytes
                            if (($data[$field]['size'] ?? 0) > $maxSize) {
                                $this->errors[$field][] = "The $field field must not exceed $maxSize KB.";
                            }
                            break;
                        case str_starts_with($rule, 'mimes:'):
                            $allowedMimes = explode(',', substr($rule, 6));
                            $fileMime = mime_content_type($data[$field]['tmp_name'] ?? '');
                            if (!in_array(substr($fileMime, 6), $allowedMimes)) {
                                $this->errors[$field][] = "The $field field must be one of the following types: " . implode(', ', $allowedMimes) . ".";
                            }
                            break;
                    }
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
