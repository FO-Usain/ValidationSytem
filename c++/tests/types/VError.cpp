//
// Created by fo on 10/03/2021.
//
// This file contains a use-case of VError
#include "../../types/VError.h"
#include <iostream>

int main() {
    //initialize the VError
    VSystem::Type::VError::Ptr vError(new VSystem::Type::VError(1, "This is the message"));

    //output the content of the VError
    std::cout << "After init\n" << "Code: " << vError->_code << "\n"
              << "Category: " << vError->_category << "\n"
              << "Message: " << vError->_message << std::endl;

    //append a new message to the VError
    vError->appendMessage("This is a test");

    //output the content of the VError
    std::cout << "\nAfter appendage to message\n" << "Code: " << vError->_code << "\n"
              << "Category: " << vError->_category << "\n"
              << "Message: " << vError->_message << std::endl;

    //append a new message to the VError
    vError->appendMessage("This is my second appendage");

    //output the content of the VError
    std::cout << "\nAfter appendage to message\n" << "Code: " << vError->_code << "\n"
              << "Category: " << vError->_category << "\n"
              << "Message: " << vError->_message << std::endl;


    //replace the Error-message
    vError->replaceMessage("This is the replacement");

    //output the content of the VError
    std::cout << "\nAfter replacement of message\n" << "Code: " << vError->_code << "\n"
              << "Category: " << vError->_category << "\n"
              << "Message: " << vError->_message << std::endl;


    return 0;
}
