<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Controller;

/**
 * Class ValidationController: capable of controlling all the validation processes that are to be carried out in the system,
 * by delegating the control of the Validation of a particular category to the CategoryValidationController that is responsible for that category,
 * to provide the client a single object that is capable of controlling validation of any category, as long has the CategoryController of that category is already a component of
 * @package FO\ValidationComponent
 */
class ValidationController
{
    static private ValidationController $validationController;       //The single thing XD
    private array $categoryValidationControllers;       //an array of CategoryValidationControllers that this ValidationController delegates control of validation processes to.

    /**
     * @brief: ensures that the client cannot instantiate her/his own ValidationController
     * ValidationController constructor.
     */
    private function __construct()
    {
        //get all the CategoryControllers
        $categoryValidationControllers = require_once __DIR__ . "/../instantiations/CategoryValidationControllers.php";

        //add all the CategoryControllers
        foreach ($categoryValidationControllers as $categoryValidationController) {
            $this->addCategoryValidationController($categoryValidationController);
        }
    }

    /**
     * @brief: returns the singleton
     * @return ValidationController
     */
    public static function getValidationController(): ValidationController
    {
        if (!isset(self::$validationController)) {
            self::$validationController = new ValidationController();
        }

        return self::$validationController;
    }

    /**
     * @brieg: delegates the control of the validation of $target to its component CategoryValidationController that has the name $categoryName.
     * If not such CategoryValidationController exits in this validationController, an exception is thrown, reporting the error.
     * @param $target : the object to be validated.
     * @param \FO\ValidationComponent\Type\ValidationCategory\ValidationCategory $category : the chosen validation-Category.
     * @param array $validatorCommands :an array of ValidatorCommands to be passed to the appropriate CategoryValidationController.
     * @return array an array of ValidatorErrors, that the Validators generated for $target.
     */
    public function startValidation($target, \FO\ValidationComponent\Type\ValidationCategory\ValidationCategory $category, array $validatorCommands): array
    {
        //confirm that all the element of $validatorCommands are ValidatorCommands
        foreach ($validatorCommands as $validatorCommand) {
            if (!isset($validatorCommand->validatorArguments) || !method_exists($validatorCommand, "validatorName")) {     //This $validatorCommand is not a ValidatorCommand
                throw new \Exception("All the elements of the last argument of ValidationController::startValidation(...) must be instances of ValidatorCommand");
            }
        }

        //Confirm that all CategoryValidationController in the ValidatorCommands are supported by this ValidationController
        if (!isset($this->categoryValidationControllers[$category->name()])) {      //This ValidationController does not support the passed Category
            throw new \Exception("The ValidationController does not support any CategoryValidationController, controlling the $category category");
        }

        //pass control to the appropriate CategoryValidationController
        return $this->categoryValidationControllers[$category->name()]->startValidation($target, $validatorCommands);
    }


    /**
     * @brief: adds a new CategoryValidationController to array of CategoryValidationController this ValidationController delegates validation to, by keying that CategoryValidationController to its name(i.e CategoryValidationController::name())
     * @param CategoryValidationController $categoryValidationController
     */
    private function addCategoryValidationController(CategoryValidationController $categoryValidationController): void
    {
        $this->categoryValidationControllers[$categoryValidationController->categoryName()] = $categoryValidationController;
    }
}