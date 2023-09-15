<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    const TABLE = "scheduler";
    const ID = "id";
    const TYPE = 'social_type';
    const EXECUTION_PERIOD = 'execution_period';
    const CONTENT_TYPE = 'content_type';
    const TIME_PERIOD = 'time_period';
    const STATUS = 'status';
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
