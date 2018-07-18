<?php

namespace connect\crm\base\helpers;

class DateHelper
{
    const HOURLY = 'hourly';
    const DAILY = 'daily';

    public static function getMicroTime()
    {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new \DateTime(date('Y-m-d H:i:s.' . $micro, $t));
        return $d->format("Y-m-d H:i:s.u");
    }

    public static function getFloatMicroTime(): float
    {
        list($usec, $sec) = explode(" ", microtime());
        return (float)$usec + (float)$sec;
    }

    public static function getPeriodAsRange($from, $to, $step = self::HOURLY)
    {
        $result = [];
        $spec = static::getSpecs()[$step];
        $to = new \DateTime($to);
        $period = new \DatePeriod(
            new \DateTime($from),
            new \DateInterval($spec),
            $to
        );
        foreach ($period as $key => $value) {
            if ($step == static::HOURLY) {
                $result[] = \Yii::$app->formatter->asDatetime($value->getTimestamp());
            } elseif ($step == static::DAILY) {
                $result[] = \Yii::$app->formatter->asDate($value->getTimestamp());
            }
        }
        if ($step == static::HOURLY) {
            $result[] = \Yii::$app->formatter->asDatetime($to->getTimestamp());
        } elseif ($step == static::DAILY) {
            $result[] = \Yii::$app->formatter->asDate($to->getTimestamp());
        }
        return $result;
    }

    public static function getSpecs()
    {
        return [
            static::HOURLY => 'PT3600S',
            static::DAILY => 'P1D'
        ];
    }
}