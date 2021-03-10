//
// Created by fo on 10/03/2021.
//
// This file contains the definition of StringLengthValidator, which is responsible for Validating String-length of its target
#include "IValidator.h"
#include <string>

#ifndef VALIDATIONSYSTEM_STRINGLENGTHVALIDATOR_H
#define VALIDATIONSYSTEM_STRINGLENGTHVALIDATOR_H

namespace VSystem::Validator {

    class StringLengthValidator : public IValidator<std::string> {
    public:
        Type::VError *validate(const std::string &target, const std::vector<std::any> &_arguments) override {
            //validate the arguments
            validateArgs(_arguments);
            Type::VError *vError = new Type::VError(1);

            if (target.length() < std::any_cast<int>(_arguments[0])) {
                vError->appendMessage("target to short");
            }

            return vError;
        }

        const char *name() override {
            return "StringLengthValidator";
        }

    private:
        inline void validateArgs(const std::vector<std::any> &_args) {
            //construct the base error-message for when _args is not valid
            std::string msg = "In VSystem::Validator::StringLengthValidator::validate: ";

            if (_args.empty()) {
                msg.append("the arguments cannot be empty");

                throw std::logic_error(msg);
            } else if (_args[0].type() != typeid(int)) {        //The argument is not an integer
                msg.append("the first member of its arguments must be an integer, to specify the minimum acceptable target-length");
            }
        }
    };

}

#endif //VALIDATIONSYSTEM_STRINGLENGTHVALIDATOR_H
