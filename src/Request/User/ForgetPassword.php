<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/17 下午4:45
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class ForgetPassword extends PhpecsRequest
{
    private $api = 'user/v1/forget/password';
    private $email = '';
    private $mobile = '';
    private $method = '';
    private $password = '';
    private $userVerifyToken = '';

    public function setEmail($val)
    {
        $this->email = (string) $val;
    }

    public function setMobile($val)
    {
        $this->mobile = (string) $val;
    }

    public function setMethod($val)
    {
        $this->method = (string) $val;
    }

    public function setPassword($val)
    {
        $this->password = (string) $val;
    }

    public function setUserVerifyToken($val)
    {
        $this->userVerifyToken = (string) $val;
    }

    public function getResponse()
    {
        if ($this->method === 'mobile') {
            if (Valid::isMobile($this->mobile) === false) {
                throw new PhpecsException('手机号码未设置或值无效');
            }
        } elseif ($this->method === 'email') {
            if (Valid::isEmail($this->email) === false) {
                throw new PhpecsException('邮箱地址未设置或值无效');
            }
        } else {
            throw new PhpecsException('校验方法未设置或值无效');
        }
        if (Valid::isToken($this->userVerifyToken) === false) {
            throw new PhpecsException('用户校验令牌未设置或值无效');
        }
        if (Valid::isPassword($this->password) === false) {
            throw new PhpecsException('新密码未设置或值无效');
        }

        return $this->client->request($this->api, [
            'email' => $this->email,
            'mobile' => $this->mobile,
            'method' => $this->method,
            'password' => $this->password,
            'user_verify_token' => $this->userVerifyToken,
        ]);
    }
}