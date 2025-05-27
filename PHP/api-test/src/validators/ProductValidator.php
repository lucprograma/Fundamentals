<?php
namespace Validators;

use Respect\Validation\Validator as v;

class ProductValidator {
    public static function validateId($id) {
        return v::numericVal()->intVal()->positive()->validate($id);
    }

    public static function validateName($name) {
        return v::stringType()->notEmpty()->length(3, 150)->validate($name);
    }

    public static function validateAdditionalInfo($info) {
        return is_null($info) || v::stringType()->length(0, 255)->validate($info);
    }

    public static function validatePrice($price) {
        return v::numericVal()->min(0)->validate($price);
    }

    public static function validateStock($stock) {
        return v::intVal()->min(0)->validate($stock);
    }

    public static function validateState($state) {
        return v::boolType()->validate($state);
    }

    public static function validateCategoryId($id) {
        return v::intVal()->positive()->validate($id);
    }
}
