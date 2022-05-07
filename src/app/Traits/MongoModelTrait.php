<?php


namespace App\Traits;

trait MongoModelTrait
{
    public static function aggregate($conditional)
    {
        $aggregate = self::raw(function ($collection) use ($conditional) {
            return $collection->aggregate($conditional);
        });

        return $aggregate;
    }

    public static function updateRaw($conditional, $updates, $config = ['multi' => true])
    {
        return self::raw(function ($collection) use ($conditional, $updates, $config) {
            return $collection->updateMany($conditional, $updates, $config);
        });
    }

}
