//
// Created by fo on 10/03/2021.
//
// This file contains a use-case of ValidationController
#include "../../../../controllers/validation/sync/ValidationController.h"
#include "../../../../validators/StringLengthValidator.h"
#include <iostream>

int main() {
    //get the ValidationController
    auto vController = VSystem::Controller::Validation::Sync::ValidationController<std::string>::getController();

    //add a new Validator to the ValidationController
    vController->addValidator(new VSystem::Validator::StringLengthValidator(),
                              VSystem::Controller::Validation::Cat::GENERAL);

    //initialize a new VComm with no argument
    std::vector<VSystem::Type::VComm::Ptr> vComms;
    vComms.emplace_back(new VSystem::Type::VComm("StringLengthValidator"));

    try {
        //validate the "Olamide"
        vController->validate("Olamide", VSystem::Controller::Validation::GENERAL, vComms);
    } catch (std::logic_error &error) {
        std::cout << "\aError: " << error.what() << std::endl;

        //empty vComms
        {
            std::vector<VSystem::Type::VComm::Ptr> tmpComms;
            vComms.swap(tmpComms);
        }

        vComms.emplace_back(new VSystem::Type::VComm("StringLengthValidator", {100}));

        try {
            auto vErrors = vController->validate("Olamide", VSystem::Controller::Validation::GENERAL, vComms);

            if (!vErrors.empty()) {      //Error occurred
                for (auto vError : vErrors) {
                    std::cout << "VError: \n"
                              << "Code: " << vError->_code
                              << "Message: " << vError->_message << std::endl;
                }
            }
        } catch (std::logic_error &error) {
            std::cout << "\aError: " << error.what() << std::endl;
        }
    }

    return 0;
}
