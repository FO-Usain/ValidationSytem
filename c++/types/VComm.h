//
// Created by fo on 10/03/2021.
//
// This file contains the definition of VComm(ValidationCommand)
// VComm acts as the instruction for a ValidationController to follow, as it supplies the name of the Validator to call and the argument(s) to pass to that Validator
#include <memory>
#include <vector>
#include <any>

#ifndef VALIDATIONSYSTEM_VCOMM_H
#define VALIDATIONSYSTEM_VCOMM_H

namespace VSystem::Type {

    class VComm {
    public:
        using Ptr = std::shared_ptr<VComm>;

        /**
         * @brief: the name of the Validator to be called
         */
        const std::string _validatorName;

        /**
         * @brief: the arguments to be passed to the Validator
         */
        const std::vector<std::any> _args;

        /**
         * @brief: constructor: sets the name of the Validator that this VComm is concerned with and the arguments to be passed to that Validator
         * @param arguments: the arguments to be passed to the Validator that this VComm is concerned with
         */
        VComm(const std::string &validatorName, const std::vector<std::any> &arguments = {}) : _validatorName(validatorName), _args(arguments) {}
    };

}

#endif //VALIDATIONSYSTEM_VCOMM_H
