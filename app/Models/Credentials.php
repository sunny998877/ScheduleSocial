<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credentials extends Model
{
    const TABLE = "credentials";
    const ID = "id";
    const TYPE = 'social_type';
    const EMAIL = 'email';
    const USERNAME = 'username';
    const CLIENT_ID = 'client_id';
    const CLIENT_SECRET = "client_secret";
    const BASE_URL = "base_url";
    const REDIRECT_URL = 'redirect_url';
    const OAUTH_URL = 'oauth_url';
    const OAUTH_KEY = 'oauth2_key';
    const STATUS = 'status';
    const PRIORITY = 'priority';
    const CREATED_AT = "created_at";
    const UPDATED_AT = 'updated_at';

    /** @var string */
    protected $table = self::TABLE;

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $guarded = [];

    /** @var string */
    protected $primaryKey = self::ID;

    public static function insertAndUpdate(array $requestData, $id = null)
    {
        if (isset($id)) {
            $result = self::where(self::ID, $id)->update($requestData);
        } else {
            $result = self::create($requestData);
        }
        return $result;
    }
}
