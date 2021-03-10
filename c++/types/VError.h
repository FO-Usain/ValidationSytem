//
// Created by fo on 10/03/2021.
//
// This file contains the definition of VError
// Instances of VError are created by Validators when validation-error occur. a VError contains a description of a validation-error, thus its name
#include <memory>
#include <string>

#ifndef VALIDATIONSYSTEM_VERROR_H
#define VALIDATIONSYSTEM_VERROR_H

namespace VSystem::Type {

    class VError {
    public:
        using Ptr = std::shared_ptr<VError>;

        /**
        * @brief: the error-code that maps to the message-type, as defined by the system
        */
        const int _code;

        /**
        * @brief: the error-message
        */
        std::string _message;

        /**
        * @brief: the category the validation that this VError belongs to
        */
        std::string _category{""};

        VError(int code, const std::string &appendedMsg = "") : _code(code) {
            switch (code) {
                case 0:
                    _message = "Ok";
                    break;
                case 1:
                    _message = "Error on validation";
                    break;
                default:        //The Code maps to an unknown error
                    _message = "Unknown validation-error";
            }

            if (!appendedMsg.empty()) {     //message should be appended
                //append the message
                _message += ": ";
                _message += appendedMsg;
            }
        }

        /**
       * @brief: appends the passed message to the default message of this VError
       * @param appendage: the message to be appended
       */
        void appendMessage(const std::string &appendage) {
            if (int pos = _message.find(": ", 0); pos != std::string::npos) {     //an appendage already exists
                //replace the existing appendage with the new one
                _message = _message.replace(pos + 2, _message.size() - (pos + 2), appendage);
            } else {
                //append the appendage
                _message += ": ";
                _message += appendage;
            }
        }

        /**
        * @brief: replaces the default message of this VeError with the passed replacement-message
        * @param replacement: the replacement message
        */
        void replaceMessage(const char *replacement) {
            _message = replacement;
        }
    };

}

#endif //VALIDATIONSYSTEM_VERROR_H
