<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/25 下午1:59
 */

namespace eDoctor\Phpecs;


class PhpecsValidator
{
    public static function isId($val)
    {
        return is_int($val) && $val >= 0;
    }

    public static function isToken($val)
    {
        return preg_match('/^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}$/', $val) === 1;
    }

    public static function isRole($val)
    {
        $roles = [1, 2, 3];
        return in_array($val, $roles);
    }

    public static function isPlatform($val)
    {
        $platforms = [
            'android', 'windows', 'ios',
            'web', 'wechat', 'wp', 'osx',
            'android_tv', 'tvos'
        ];
        return in_array($val, $platforms);
    }

    public static function isWechatId($val)
    {
        return preg_match('/^[_0-9a-zA-Z\-]{28,32}$/', $val) === 1;
    }

    public static function isLanguage($val)
    {
        return in_array($val, ['zh_CN', 'en_US', 'zh_TW']);
    }

    public static function isNickname($val)
    {
        return preg_match('/^[\S]{1,20}$/', $val) === 1;
    }

    public static function isEmail($val)
    {
        return filter_var($val, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isMobile($val)
    {
        return preg_match("/^1[3-9]{1}[0-9]{9}$/", $val) === 1;
    }

    public static function isPassword($input)
    {
        return preg_match('/^[\S]{6,20}$/', $input) === 1;
    }

    public static function isGender($input)
    {
        if (is_numeric($input) && in_array($input, [0, 1, 2])) {
            return true;
        }
        return false;
    }

    public static function isDate($input)
    {
        $time = strtotime($input);
        if ($time !== false) {
            if (date('Y/m/d', $time) === $input) {
                return true;
            }
        }
        return false;
    }

    public static function isDeviceType($val)
    {
        return in_array((int) $val, [0, 1]);
    }
}