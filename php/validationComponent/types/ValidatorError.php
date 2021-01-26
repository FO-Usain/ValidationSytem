<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Type;

/**
 * Class ValidatorError: contains the error-report from a validation process, set by the IValidator that performed that validation-operation.
 * It enables the client to retrieve a description of the reason a validation-target failed a validation test, by a particular Validator
 * @package FO\ValidationComponent\Type
 */
class ValidatorError {
    private string $message;
    private string $category;

    public function __construct(string $message) {
        $this->message = $message;
    }


    /**
     * @brief: sets the category of this ValidatorError. This function is to be called by ValidationCategoryController, when is retrieves a ValidationError from an IValidator, afterValidation
     * @param string $categoryName: The name of the ValidationCategory this ValidationError is to belong to
     */
    public function setCategory(string $categoryName) {
        $this->category = $categoryName;
    }

    /**
     * @brief: returns the description of this ValidationError
     * @return string: the description of this ValidationError
     */
    public function message() : string {
        return $this->message;
    }

    /**
     * @brief: returns the name of the category this ValidationError belongs to
     * @return string: the name of the category that this ValidationError belongs to
     */
    public function category() : string {
        return $this->category;
    }
}