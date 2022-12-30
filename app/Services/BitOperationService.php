<?php

namespace App\Services;

use App\Consts\BitOperation;

class BitOperationService
{
    public const ALL_OFF = 0; // 0b00000000
    public const ALL_ON = 255; // 0b11111111

    public const PATTERN_BIT_ARRAY = '![0-1]{8}!';

    /**
     * ビット列の位置指定して0/1を切り替える
     *
     * @param string $baseBit
     * @param string $pointBit
     * @param integer $operate
     * @return string|null
     */
    public static function pointSwitch(string $baseBit, string $pointBit, int $operate): string|null
    {
        if(0 === preg_match(self::PATTERN_BIT_ARRAY, $baseBit) || 0 === preg_match(self::PATTERN_BIT_ARRAY, $pointBit))
        {
            return null;
        }

        try {
            $bit = bindec($baseBit);
            $pBit = bindec($pointBit);
        } catch(Exception $e) {
            return null;
        }

        return self::_switch($bit, $pBit, $operate);
    }

    /**
     * ビット列の位置を複数指定して0/1を切り替える
     *
     * @param string $baseBit
     * @param array $pointBit
     * @param integer $operate
     * @return string|null
     */
    public static function multiSwitch(string $baseBit, array $pointBit, int $operate): string|null
    {
        if(0 === preg_match(self::PATTERN_BIT_ARRAY, $baseBit) ||  preg_grep(self::PATTERN_BIT_ARRAY, $pointBit, PREG_GREP_INVERT))
        {
            return null;
        }

        if(count($pointBit) < 1)
        {
            return null;
        }

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

    /**
     * ビット配列の0/1を切り替える
     *
     * @param integer $bit
     * @param integer $pBit
     * @param integer $opr
     * @return string|null
     */
    private static function _switch(int $bit, int $pBit, int $opr): string|null
    {
        try {
            switch($opr) {
                case BitOperation::ON:
                    return sprintf("%08d", decbin($bit | $pBit));
                    break;
                case BitOperation::OFF:
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

    /**
     * 全ビット配列を1に切り替える
     *
     * @param string $baseBit
     * @return string|null
     */
    public static function allOff(string $baseBit): string|null
    {
        if(0 === preg_match(self::PATTERN_BIT_ARRAY, $baseBit))
        {
            return null;
        }

        try {
            return sprintf("%08d", decbin(bindec($baseBit) & self::ALL_OFF));
        } catch(Exception $e) {
            return null;
        }
    }

    /**
     * 全ビット配列を0に切り替える
     *
     * @param string|integer $baseBit
     * @return string|null
     */
    public static function allOn(string|int $baseBit): string|null
    {
        if(0 === preg_match(self::PATTERN_BIT_ARRAY, $baseBit))
        {
            return null;
        }

        try {
            return sprintf("%08d", decbin(bindec($baseBit) | self::ALL_ON));
        } catch(Exception $e) {
            return null;
        }
    }
}
