<?php
namespace FO\ValidationComponent\Validator;

use FO\ValidationComponent\Type\ValidatorError;

class StringLengthValidator implements IValidator {
    public function name() : string {
        return "StringLengthValidator";
    }

    public function validate($target, array $arguments): ?\FO\ValidationComponent\Type\ValidatorError
    {
        //test if $target is an integer
       if (!is_int($target)) {
            return new ValidatorError("The passed validation target is not not an integer");
       }

        return null;
    }
}