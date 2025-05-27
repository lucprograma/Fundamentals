<?php
namespace Validators;

use Respect\Validation\Validator as v;

class CategoryValidator {
    public static function validateDescription($description) {
        return v::stringType()->notEmpty()->length(3, 255)->validate($description);
    }
    public static function validateState($state) {
        return v::boolType()->validate($state);
    }
    public static function validateId($id): bool {
        return v::numericVal()->intVal()->positive()->validate($id);
    }
}
?>
