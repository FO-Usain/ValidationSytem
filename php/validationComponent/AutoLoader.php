<?php
// Created by FO on 22/01/2021

$dependencies = [
    //The  ValidationCategories
    "types/categories/ValidationCategory",
    "types/categories/RequestCategory",

    //ValidationError
    "types/ValidatorError",

    "types/ValidatorCommand",

    //The Validators
    "validators/IValidator",
    "validators/StringLengthValidator",

    //The controllers
    "controllers/CategoryValidationController",
    "controllers/ValidationController"
];

//require all the files of the dependencies, once
foreach ($dependencies as $dependency) {
    require_once __DIR__ . "/$dependency" . ".php";
}