<?php
// Created by FO on 22/01/2021

namespace FO\ValidationComponent\Controller;


/**
 * Class CategoryValidationController: controls the validation of a particular ValidationCategory(check types/categories/), by calling validators to validate validation-target
 * @package FO\ValidationComponent
 */
class CategoryValidationController {
    private string $categoryName;       //The ValidationCategory this CategoryValidationController is in control of
    private array $validators;      //the associative array, of Validator-names to Validators, that this CategoryValidationController delegate validation of objects(validation targets) to.
    private static int $count = 0;

    public function __construct(\FO\ValidationComponent\Type\ValidationCategory\ValidationCategory $category)
    {
        //increment the number of CategoryValidationControllers by 1
        self::$count++;

        //try to set the Controller of the passed ValidationCategory
        try {
            $category->setController();
        } catch (\Exception $error) {
            throw new \Exception("In the instantiation number " . self::$count-- . " of CategoryValidation, the passed ValidationCategory " . $error->getMessage());
        }

        //set the name of the Category of this CategoryValidationController
        $this->categoryName = $category->name();
    }

    /**
     * @brief: returns the name of the Validation-category that this CategoryValidationController is in control of
     * @return string
     */
    public function categoryName() : string {
        return $this->categoryName;
    }

    /**
     * @brief: adds a new Validator to array of Validators this CategoryValidationController delegates validation to, by keying that Validator to its name(i.e IValidator::name()),
     * to enable this CategoryValidationController to control a new kind of validation.
     * @param \FO\ValidationComponent\Validator\IValidator $validator: The new Validator to be added
     */
    public function addValidator(\FO\ValidationComponent\Validator\IValidator $validator) : void {
        $this->validators[$validator->name()] = $validator;
    }

    /**
     * @brief: delegates the validation of $target to the  Validators named in the individual ValidatorCommands(stored in $validatorCommands), if they are all in $this->validators.
     * If any of the Validators is not present in this CategoryValidationController, an exception is thrown, reporting the Error
     * @param $target: the target of the validation
     * @param array $validatorCommands: the array of ValidatorCommands that enable this CategoryValidationController to call the appropriate Validator and pass the appropriate arguments
     * @return array: an array of ValidatorErrors, that the Validators generated for $target
     */
    public function startValidation($target, array $validatorCommands) : array {
        //Confirm that all Validators in the ValidatorCommands are supported by this CategoryValidationController
        foreach ($validatorCommands as $validatorCommand) {
            if (!isset($this->validators[$validatorCommand->validatorName()])) {        //This CategoryValidationController does not support the Validator specified by the  ValidatorCommand at this iteration
                //throw an exception, reporting the error
                throw new \Exception("The CategoryValidationController for the " . $this->categoryName . "-category does not support any Validator named " . $validatorCommand->validatorName());
            }
        }

        //initialize the variables used
        $validatorErrors = [];      //array of ValidatorErrors to be returned
        $tempError = null;      //Temporarily stores the return from each validator, after the validation of the target

        //begin the delegation of validation to the appropriate Validators
        foreach ($validatorCommands as $validatorCommand) {
            $tempError = $this->validators[$validatorCommand->validatorName()]->validate($target, $validatorCommand->validatorArguments);
            if ($tempError) {       //The target did not pass the validation test
                $tempError->setCategory($this->categoryName);
                $validatorErrors[] = $tempError;
            }
        }

        return $validatorErrors;
    }
}