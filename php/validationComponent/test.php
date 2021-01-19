<?php
require_once __DIR__ . "/AutoLoader.php";

try {
    $controller = \FO\ValidationComponent\Controller\ValidationController::getValidationController();
    $validatorCommand = new \FO\ValidationComponent\Type\ValidatorCommand("StringLengthValidator");
    $validatorCommand->validatorArguments = [1, "Ola"];

    $errors = $controller->startValidation("Olamide", new \FO\ValidationComponent\Type\ValidationCategory\RequestCategory(), [$validatorCommand]);
} catch (Exception $error) {
    echo $error->getMessage() . "\n";
    exit(-1);
}

if ($errors) {
    echo $errors[0]->message() . "\n";
    echo "The error belongs to the category " . $errors[0]->category() . "\n";
    exit(-1);
}