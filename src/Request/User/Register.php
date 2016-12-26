<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/25 下午3:41
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class Register extends PhpecsRequest
{
    private $api = 'user/v1/register';
    private $userVerifyField = '';
    private $userVerifyToken = '';

    private $email = '';
    private $mobile = '';
    private $password = '';
    private $nickname = '';
    private $avatar = '';
    private $gender = 0;
    private $birthday = '';
    private $address = '';
    private $language = '';

    private $roleId = 0;
    private $platform = '';

    public function setUserVerifyField($val)
    {
        $this->userVerifyField = (string) $val;
    }

    public function setUserVerifyToken($val)
    {
        $this->userVerifyToken = (string) $val;
    }

    public function setRoleId($val)
    {
        $this->roleId = (int) $val;
    }

    public function setPlatform($val)
    {
        $this->platform = (string) $val;
    }

    public function setEmail($val)
    {
        $this->email = (string) $val;
    }

    public function setMobile($val)
    {
        $this->mobile = (string) $val;
    }

    public function setPassword($val)
    {
        $this->password = (string) $val;
    }

    public function setNickname($val)
    {
        $this->nickname = (string) $val;
    }

    public function setAvatar($val)
    {
        $this->avatar = (string) $val;
    }

    public function setGender($val)
    {
        $this->gender = (int) $val;
    }

    public function setBirthday($val)
    {
        $this->birthday = (string) $val;
    }

    public function setAddress($val)
    {
        $this->address = (string) $val;
    }

    public function setLanguage($val)
    {
        $this->language = (string) $val;
    }

    public function getResponse()
    {
        if ($this->userVerifyField === 'mobile') {
            if (Valid::isMobile($this->mobile) === false) {
                throw new PhpecsException('手机号码未设置或值无效');
            }
        } elseif ($this->userVerifyField === 'email') {
            if (Valid::isEmail($this->email) === false) {
                throw new PhpecsException('邮箱地址未设置或值无效');
            }
        } else {
            throw new PhpecsException('注册类型未设置或值无效');
        }

        if ($this->userVerifyToken !== null) {
            if (Valid::isToken($this->userVerifyToken) === false) {
                throw new PhpecsException('校验令牌未设置或值无效');
            }
        }

        if (Valid::isPassword($this->password) === false) {
            throw new PhpecsException('账户密码未设置或值无效');
        }
        if (Valid::isGender($this->gender) === false) {
            throw new PhpecsException('用户性别未设置或值无效');
        }
        if (Valid::isNickname($this->nickname) === false) {
            throw new PhpecsException('用户昵称未设置或值无效');
        }
        if (Valid::isDate($this->birthday) === false) {
            throw new PhpecsException('出生日期未设置或值无效');
        }
        if (Valid::isLanguage($this->language) === false) {
            throw new PhpecsException('语言类型未设置或值无效');
        }
        if (Valid::isRole($this->roleId) === false) {
            throw new PhpecsException('角色编号未设置或值无效');
        }
        if (Valid::isPlatform($this->platform) === false) {
            throw new PhpecsException('终端类型未设置或值无效');
        }

        $this->avatar = (string) $this->avatar;
        $this->address = (string) $this->address;

        return $this->client->request($this->api, [
            'user_verify_token' => $this->userVerifyToken,
            'user_verify_field' => $this->userVerifyField,
            'user_data' => [
                'email' => $this->email,
                'mobile' => $this->mobile,
                'password' => $this->password,
                'gender' => $this->gender,
                'nickname' => $this->nickname,
                'avatar' => $this->avatar,
                'address' => $this->address,
                'birthday' => $this->birthday,
                'language' => $this->language,
            ],
            'platform' => $this->platform,
            'role_id' => $this->roleId
        ]);
    }
}