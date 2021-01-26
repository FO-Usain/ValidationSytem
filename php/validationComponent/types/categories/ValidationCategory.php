<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Type\ValidationCategory;

/**
 * Abstract Class ValidationCategory: a validation-category. For example: User, Request, Response
 * It constrains the client from giving ValidationErrors and CategoryValidationControllers arbitrary category-names and names, respectively,
 * because their constructors accept an ICategory. This is to ensure consistency in that client's code-base, in respect to the validation component of her/his system.
 * For any ValidationError to be created, an existing ICategory must be passed into its constructor.
 * This forces the Client to always have the definitions of all the possible categories ValidationErrors can belong to
 * @package FO\ValidationComponent\Type
 */
abstract class ValidationCategory
{
    static private array $hasController = [];        //an array, using the names of all ValidationCategories as key and bool as value, that is used to determine whether or not a ValidationCategory has a Controller

    /**
     * @brief: This member-function is called by an instance of CategoryValidationController, to prevent more than one CategoryValidationController from controlling the validations for the same ValidationCategory.
     * @throws \Exception: if the setController has already been called before by an instance of the same descendant of ValidationCategory
     */
    final public function setController()
    {
        if (isset(self::$hasController[$this->name()])) {       //This ValidationCategory already has a controller
            throw new \Exception("already has a controller");
        }
        self::$hasController[$this->name()] = true;
    }

    /**
     * @brief: Returns the name of the Client-defined Validation Category
     * @return string: the name of this Category
     */
    abstract public function name(): string;

}