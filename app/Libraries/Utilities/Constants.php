<?php
/**
 * Created by PhpStorm.
 * User: stpl
 * Date: 12/10/22
 * Time: 4:12 PM
 */

namespace App\Libraries\Utilities;


/**
 * Class Constants
 *
 * @package App\Libraries\Utilities
 */
class Constants
{
    const REQUIRED = 'required';
    const NULLABLE = 'nullable';
    const PRESENT = 'present|min:0';
    const REQU_NUM = 'required|numeric';
    const STATUS = 'status';
    const ERROR = 'error';
    const TOKEN = 'token';
    const SUCCESS = 'success';
    const ACTION = 'action';
    const CODE = 'code';
    const Code = 'Code';
    const Status = 'Status';
    const MOBILE_NO = 'mobileNo';
    const FULL_NAME = 'fullName';
    const ACCOUNT_NO = 'accountNo';
    const ACCOUNT_TYPE = 'accountType';
    const EMAIL = 'email';
    const RESPONSE_CODE = 'respCode';
    const RESPONSE_DESCRIPTION = 'respDescription';
    const TXN_ID = 'txnId';
    const RESPONSE = "response";
    const MESSAGE_LEVEL = 'message.level';
    const MESSAGE_CONTENT = 'message.content';
    const ERROR_MESSAGE = 'error_message';
    const MESSAGE = 'message';
    const MESSAGES = 'Message';
    const RESPONSES = 'Response';

    const ACTION_REGISTER = 'register';
    const ACTION_FETCH = 'fetch';
    const ALGO_HMAC_SHA_256 = 'HMAC_SHA256';
    const HMAC_SHA_256 = 'SHA256';
    const TXN_TIMEOUT = 'TXN_TIMEOUT';
    const TXN_CONNECT_TIMEOUT = 'TXN_CONNECT_TIMEOUT';
    const HTTP_OK_1 = '0';
    const HTTP_OK_2 = '200';
    public static $validSuccessCodes = [
        self::HTTP_OK_1,
        self::HTTP_OK_2,
    ];

    const IKYC_AES_ENCRYPTION = 'IKYC_AES_ENCRYPTION';
    const IKYC_AES_IV = 'IKYC_AES_IV';

    const YOUTUBE = 1;
    const INSTAGRAM = 2;
    const FACEBOOK = 3;
    const GOOGLE_DRIVE = 4;

    const HOURLY = 1;
    const DAILY = 2;
    const WEEKLY = 3;
    const MONTHLY = 4;
    const YEARLY = 5;

    const POST = 1;
    const REEL_OR_SHORTS = 2;
    const CAROUSAL = 3;

}
