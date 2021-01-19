<?php
// Created by FO on 23/01/2021
//
// This file should contain all the instantiations of CategoryValidationController, with each instantiated with a ValidationCategory that has a unique name.
// For each instance, all the needed IValidators should be added to it(i.e for $categoryValidationController, call $categoryValidationController->addValidator(),repeatedly),
// then that instance should be added to the array of objects(instances of CategoryValidationController) being returned at the end of this file

$categoryValidation = new \FO\ValidationComponent\Controller\CategoryValidationController(new \FO\ValidationComponent\Type\ValidationCategory\RequestCategory());
$categoryValidation->addValidator(new \FO\ValidationComponent\Validator\StringLengthValidator());

return  [
###############################################################
# Fully established instances of CategoryValidationControllers#
##############################################################
    $categoryValidation
];