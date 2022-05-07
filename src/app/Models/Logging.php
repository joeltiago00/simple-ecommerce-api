<?php

namespace App\Models;

use App\Traits\MongoModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use Throwable;

class Logging extends Model
{
    use HasFactory, MongoModelTrait;

    protected $table = 'logging';

    protected $fillable = [
        'level', 'uuid', 'message', 'error_code', 'trace', 'additional'
    ];

    /**
     * @param Throwable $e
     * @return string
     */
    public static function critical(Throwable $e): string
    {
        $logging = new Logging();
        $logging->level = 'critical';
        $logging->uuid = Str::uuid()->toString();
        $logging->message = $e->getMessage();
        $logging->error_code = $e->getCode();
        $logging->trace = $e->getTraceAsString();
        $logging->additional = '...';
        $logging->save();

        return $logging->uuid;
    }
}
