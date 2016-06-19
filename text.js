jQuery(document).ready(function () {
    jQuery('#w0').yiiActiveForm(
        {
            "name": {
                "validate": function (attribute, value, messages) {
                    yii.validation.required(value, messages, {"message": "Name cannot be blank."});
                    yii.validation.string(value, messages, {
                        "message": "Name must be a string.",
                        "max": 256,
                        "tooLong": "Name should contain at most 256 characters.",
                        "skipOnEmpty": 1
                    });
                },
                "id": "user-name",
                "name": "name",
                "validateOnChange": true,
                "validateOnType": false,
                "validationDelay": 200,
                "container": ".field-user-name",
                "input": "#user-name",
                "error": ".help-block"
            },
            "password": {
                "validate": function (attribute, value, messages) {
                    yii.validation.required(value, messages, {"message": "Password cannot be blank."});
                    yii.validation.string(value, messages, {
                        "message": "Password must be a string.",
                        "max": 256,
                        "tooLong": "Password should contain at most 256 characters.",
                        "skipOnEmpty": 1
                    });
                },
                "id": "user-password",
                "name": "password",
                "validateOnChange": true,
                "validateOnType": false,
                "validationDelay": 200,
                "container": ".field-user-password",
                "input": "#user-password",
                "error": ".help-block"
            },
            "nickname": {
                "validate": function (attribute, value, messages) {
                    yii.validation.string(value, messages, {
                        "message": "Nickname must be a string.",
                        "max": 256,
                        "tooLong": "Nickname should contain at most 256 characters.",
                        "skipOnEmpty": 1
                    });
                },
                "id": "user-nickname",
                "name": "nickname",
                "validateOnChange": true,
                "validateOnType": false,
                "validationDelay": 200,
                "container": ".field-user-nickname",
                "input": "#user-nickname",
                "error": ".help-block"
            },
            "accessToken": {
                "validate": function (attribute, value, messages) {
                    yii.validation.string(value, messages, {
                        "message": "Access Token must be a string.",
                        "max": 64,
                        "tooLong": "Access Token should contain at most 64 characters.",
                        "skipOnEmpty": 1
                    });
                },
                "id": "user-accesstoken",
                "name": "accessToken",
                "validateOnChange": true,
                "validateOnType": false,
                "validationDelay": 200,
                "container": ".field-user-accesstoken",
                "input": "#user-accesstoken",
                "error": ".help-block"
            },
            "authKey": {
                "validate": function (attribute, value, messages) {
                    yii.validation.string(value, messages, {
                        "message": "Auth Key must be a string.",
                        "max": 64,
                        "tooLong": "Auth Key should contain at most 64 characters.",
                        "skipOnEmpty": 1
                    });
                },
                "id": "user-authkey",
                "name": "authKey",
                "validateOnChange": true,
                "validateOnType": false,
                "validationDelay": 200,
                "container": ".field-user-authkey",
                "input": "#user-authkey",
                "error": ".help-block"
            }
        }, {
            "errorSummary": ".error-summary",
            "validateOnSubmit": true,
            "errorCssClass": "has-error",
            "successCssClass": "has-success",
            "validatingCssClass": "validating",
            "ajaxParam": "ajax",
            "ajaxDataType": "json"
        });
});