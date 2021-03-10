//
// Created by fo on 10/03/2021.
//
// This file contains the definition of the interface IValidationController.
// IValidationController is responsible for controlling validation of a target, synchronously
#include "../../../types/VError.h"
#include "../../../types/VComm.h"
#include "../../../validators/IValidator.h"
#include <memory>
#include <vector>
#include <map>

#ifndef VALIDATIONSYSTEM_ISYNCVALIDATIONCONTROLLER_H
#define VALIDATIONSYSTEM_ISYNCVALIDATIONCONTROLLER_H

namespace VSystem {
    namespace Controller::Validation {
        /**
         * @brief: the Enumeration of all ValidationCategories
         */
        enum Cat {
            GENERAL
        };

        namespace Sync {

            template<typename TargetType>
            class ValidationController {
                /**
                 * @brief: maps a Validation-Category to a map that maps a Validator-name to the Validator with that name
                 */
                std::map<Cat, std::map<std::string, typename Validator::IValidator<TargetType>::Ptr>> _validators;
            public:
                using Ptr = std::shared_ptr<ValidationController>;


                /**
                 * @brief: returns the singleton
                 * @return
                 */
                static typename ValidationController<TargetType>::Ptr getController() {
                    return _controller;
                }

                /**
                 * @brief: Validates the passed validation-target, using instructions in passed Validator-Commands and returns a vector of VErrors, to describe the errors encountered
                 * @param target: the validation-target
                 * @param vCat: the ValidationCategory
                 * @param vComms::Ptr: the pointers to Validation-Commands
                 * @param stopOnFirstError: true if validation should stop on the first validation-error encountered
                 * @return
                 */
                virtual std::vector<Type::VError::Ptr>
                validate(const TargetType &target, VSystem::Controller::Validation::Cat vCat,
                         const std::vector<Type::VComm::Ptr> &vComms,
                         bool stopOnFirstError = true) {
                    //confirm that the ValidationCategory is available
                    if (_validators.find(vCat) ==
                        _validators.end()) {      //There are no validators to handle passed ValidationCategory
                        //report the error
                        throw std::logic_error(
                                "In VSystem::Controller::Validation::Sync::ValidationController::validate: there is no Validator to handle validation-targets of the passed category");
                    }

                    std::vector<Type::VError::Ptr> vErrors;     //stores the errors generated

                    for (auto &vComm : vComms) {
                        if (_validators[vCat].find(vComm->_validatorName) ==
                            _validators[vCat].end()) {      //the Validator is not found
                            //construct the Error-message that the exception will entail
                            std::string msg = "In VSystem::Controller::Validation::Sync::ValidationController::validate: there is no Known Validator with the name ";
                            msg += vComm->_validatorName;

                            throw std::logic_error(msg);
                        }

                        //delegate the Validation to the next Validator
                        if (auto vError = _validators[vCat][vComm->_validatorName]->validate(target, vComm->_args); vError != nullptr) {        //Error occurred
                            //enqueue the ValidationError
                            vErrors.emplace_back(vError);

                            if (stopOnFirstError) {     //stop here
                                break;
                            }
                        }
                    }

                    return vErrors;
                }

                /**
                 * @brief: Adds a new Validator to the Collection of Validators that thisValidationController controls
                 * @param validator
                 */
                virtual void addValidator(VSystem::Validator::IValidator<TargetType> *validator, Cat vCat) {
                    _validators[vCat][validator->name()] = typename Validator::IValidator<TargetType>::Ptr(validator);
                }

            private:
                /**
                 * @brief: ensures that ValidationController cannot be initialized
                 */
                ValidationController() = default;

                /**
                 * @brief singleton
                 */
                static typename ValidationController<TargetType>::Ptr _controller;
            };

            template<typename TargetType>
            typename ValidationController<TargetType>::Ptr ValidationController<TargetType>::_controller(new ValidationController<TargetType>);
        }
    }       //VSystem
}

#endif //VALIDATIONSYSTEM_IVALIDATIONCONTROLLER_H
