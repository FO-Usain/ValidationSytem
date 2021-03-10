//
// Created by fo on 10/03/2021.
//
// This file contains the definition of the interface IValidator
// IValidator is the interface that is should be called in order to validate data
#include "../types/VError.h"
#include <any>
#include <vector>
#include <memory>

#ifndef VALIDATIONSYSTEM_IVALIDATOR_H
#define VALIDATIONSYSTEM_IVALIDATOR_H

namespace VSystem {

    namespace Validator {

        template<typename TargetType>
        class IValidator {
        public:
            using Ptr = std::shared_ptr<IValidator<TargetType>>;

            /**
             * @brief: validates target and returns a VError to describe the target, error-wise
             * @param target: the target to be validated
             * @param _arguments: the arguments needed by this IValidator to properly validate the target
             * @return: the VError that describes the error-status of the validation
             */
            virtual Type::VError *validate(const TargetType &target, const std::vector<std::any> &_arguments) = 0;

            /**
             * @brief: returns the name of this IValidator
             * @return: the name of this IValidator
             */
            virtual const char *name() = 0;
        };

    }
}

#endif //VALIDATIONSYSTEM_IVALIDATOR_H
