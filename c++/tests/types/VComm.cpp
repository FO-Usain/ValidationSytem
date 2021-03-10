//
// Created by fo on 10/03/2021.
//
// This file contains a use-case of VComm
#include "../../types/VComm.h"
#include <iostream>

int main() {
    //initialize the VComm
    VSystem::Type::VComm::Ptr vComm(
            new VSystem::Type::VComm("StringValidator", {1, (std::string) "Olamide", (float) 2.2, false}));

    try {
        //output the content of the VComm
        std::cout << "Validator: " << vComm->_validatorName
                  << "First arg: " << std::any_cast<int>(vComm->_args[0]) << "\n"
                  << "Second arg: " << std::any_cast<std::string>(vComm->_args[1]) << "\n"
                  << "Third arg: " << std::any_cast<float>(vComm->_args[2]) << "\n"
                  << "Fourth arg: " << std::any_cast<bool>(vComm->_args[3]) << std::endl;
    } catch (std::bad_any_cast &error) {
        std::cout << "\aError: " << error.what() << std::endl;
        exit(-1);
    }
}
