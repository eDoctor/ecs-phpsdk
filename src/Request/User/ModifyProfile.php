<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午3:45
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class ModifyProfile extends PhpecsRequest
{
    private $api = 'user/v1/modify/profile';

    private $avatar = '';
    private $gender = 0;
    private $address = '';
    private $language = '';
    private $nickname = '';
    private $birthday = '';
    private $userAccessToken = '';

    public function setAvatar($val)
    {
        $this->avatar = (string) $val;
    }

    public function setGender($val)
    {
        $this->gender = (int) $val;
    }

    public function setAddress($val)
    {
        $this->address = (string) $val;
    }

    public function setLanguage($val)
    {
        $this->language = (string) $val;
    }

    public function setNickname($val)
    {
        $this->nickname = (string) $val;
    }

    public function setBirthday($val)
    {
        $this->birthday = (string) $val;
    }

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户访问令牌未设置或值无效');
        }
        if (Valid::isNickname($this->nickname) === false) {
            throw new PhpecsException('未设置或值无效');
        }
        if (Valid::isGender($this->gender) === false) {
            throw new PhpecsException('用户性别未设置或值无效');
        }
        if (Valid::isDate($this->birthday) === false) {
            throw new PhpecsException('出生日期未设置或值无效');
        }
        if (Valid::isLanguage($this->language) === false) {
            throw new PhpecsException('语言类型未设置或值无效');
        }

        return $this->client->request($this->api, [
            'user_data' => [
                'nickname' => $this->nickname,
                'avatar' => $this->avatar,
                'gender' => $this->gender,
                'birthday' => $this->birthday,
                'address' => $this->address,
                'language' => $this->language
            ],
            'user_access_token' => $this->userAccessToken
        ]);
    }
}