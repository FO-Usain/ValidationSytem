<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Type;

/**
 * Class ValidatorCommand: enables a CategoryValidationController to identify the appropriate Validator(using the $validatorName attribute) to pass a particular validation-target to along with its arguments,
 * by providing the name of the concerned Validator and its arguments
 * @package FO\ValidationComponent\Type
 */
class ValidatorCommand {
    private string $validatorName;      //The name of the concerned Validator
    public array $validatorArguments;       //an array of the arguments to be passed to the concerned Validator

    public function __construct(string $validatorName)
    {
        $this->validatorArguments = [];
        $this->validatorName = $validatorName;
    }

    /**
     * @: returns the name of the Validator the arguments belong to
     * @return string
     */
    public function validatorName() : string {
        return $this->validatorName;
    }
}