<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Validator;

/**
 * Interface IValidator: responsible for performing a validation operation on a validation-target,
 * by testing the target with an algorithm(implementation of the 'validate' method), to confirm the validation of that target,
 * in respect to some desired condition.
 * Ideally, an IValidator should only test for a single condition(e.g string-length), following the Single Responsibility Principle.
 * @package FO\ValidationComponent\Validator
 */
interface IValidator {
    /**
     * @brief: returns the name of this IValidator.
     * The name should semantically match the operation the 'validate' method performs(e.g. stringLengthValidator) and should also be the name of the file its defined in, for easy navigation
     * @return string: the name of this Validator
     */
    public function name() : string;

    /**
     * @brief: validates the passed target. The validation checks if $target meets the necessary criteria to be counted as valid and returns  ValidatorError if not, but returns null if the target  passes the test
     * @param $target: The object to be validated
     * @param array $arguments: an array of objects that this validator may depend on to successfully perform the validation operation.
     * For example, if this IValidator is to validate a string's length, $arguments may contain the max-length(maybe 10) and/or the min-length for the target to counted as valid
     * @return \FO\ValidationComponent\Type\ValidatorError|null: contains the error-report from a validation process, set by this IValidator.
     */
    public function validate($target, array $arguments) : ?\FO\ValidationComponent\Type\ValidatorError;
}