<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午3:58
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class BindMobile extends PhpecsRequest
{
    private $api = 'user/v1/bind/mobile';

    private $mobile = '';
    private $password = '';
    private $userAccessToken = '';
    private $userVerifyToken = '';

    public function setMobile($val)
    {
        $this->mobile = (string) $val;
    }

    public function setPassword($val)
    {
        $this->password = (string) $val;
    }

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function setUserVerifyToken($val)
    {
        $this->userVerifyToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isMobile($this->mobile) === false) {
            throw new PhpecsException('手机号码未设置或值无效');
        }
        if (Valid::isPassword($this->password) === false) {
            throw new PhpecsException('账户密码未设置或值无效');
        }
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户访问令牌设置或值无效');
        }
        if (Valid::isToken($this->userVerifyToken) === false) {
            throw new PhpecsException('用户校验令牌未设置或值无效');
        }

        return $this->client->request($this->api, [
            'mobile' => $this->mobile,
            'password' => $this->password,
            'user_access_token' => $this->userAccessToken,
            'user_verify_token' => $this->userVerifyToken
        ]);
    }
}