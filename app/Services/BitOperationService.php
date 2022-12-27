<?php

namespace App\Services;

class BitOperationService
{
    public const OFF = 0;
    public const ON = 1;
    public const ALL_OFF = 0; // 0b00000000
    public const ALL_ON = 255; // 0b11111111

    public static function pointSwitch(string $baseBit, string $pointBit, int $operate): string|null
    {
        try {
            $bit = bindec($baseBit);
            $pBit = bindec($pointBit);
        } catch(Exception $e) {
            return null;
        }

        return self::_switch($bit, $pBit, $operate);
    }

    public static function multiSwitch(string $baseBit, array $pointBit, int $operate): string|null
    {
        $pBit = 0;

        try {
            $bit = bindec($baseBit);

            foreach ($pointBit as $key => $value) {
                $pBit = $pBit | bindec($value);
            }
        } catch(Exception $e) {
            return null;
        }

        return self::_switch($bit, $pBit, $operate);
    }

    private static function _switch(int $bit, int $pBit, int $opr): string|null
    {
        try {
            switch($opr) {
                case self::ON:
                    return sprintf("%08d", decbin($bit | $pBit));
                    break;
                case self::OFF:
                    return sprintf("%08d", decbin($bit & (~$pBit)));
                    break;
                default:
                    break;
            }
        } catch(Exception $e) {
            return null;
        }
        return null;
    }

    public static function allOff(string $baseBit): string|null
    {
        try {
            return sprintf("%08d", decbin(bindec($baseBit) & self::ALL_OFF));
        } catch(Exception $e) {
            return null;
        }
    }

    public static function allOn(string|int $baseBit): string|null
    {
        try {
            return sprintf("%08d", decbin(bindec($baseBit) | self::ALL_ON));
        } catch(Exception $e) {
            return null;
        }
    }
}
