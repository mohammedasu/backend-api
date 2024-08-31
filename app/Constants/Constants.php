<?php

namespace App\Constants;

class Constants
{
    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const PAGINATION_LENGTH = 10;

    public const RESPONSE_ERROR_MESSAGE = 'Error';
    public const RESPONSE_SUCCESS_MESSAGE = 'Success';

    //api authentication constants
    public const INVALID_REQUEST_DATA = 506;
    public const INTERNAL_SERVER_ERROR = 500;
    public const SUCCESS_RESPONSE_CODE = 200;
    public const UNAUTHORIZED_RESPONSE_CODE = 401;
    public const ACCESS_FORBIDDEN_RESPONSE_CODE = 403;
    public const VALIDATION_RESPONSE_CODE = 422;

    //End Point constants
    public const WHATSAPP_ENDPOINT = 'WHATSAPP_SEND_MESSAGE';
}