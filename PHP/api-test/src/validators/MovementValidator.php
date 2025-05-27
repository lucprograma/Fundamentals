<?php
namespace Validators;

use Respect\Validation\Validator as v;

class MovementValidator {
    public static function validateId($id) {
        return v::numericVal()->intVal()->positive()->validate($id);
    }

    public static function validateIdProduct($id_product) {
        return v::numericVal()->intVal()->positive()->validate($id_product);
    }

    public static function validateQuantity($quantity) {
        return v::numericVal()->intVal()->positive()->validate($quantity);
    }

    public static function validateType($type) {
        return in_array($type, ['in', 'out']);
    }

    public static function validateComments($comments) {
        return v::optional(v::stringType()->length(0, 500))->validate($comments);
    }
}
?>
