<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午4:06
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class BingWechat extends PhpecsRequest
{
    private $api = 'user/v1/bind/wechat';
    private $avatar = '';
    private $openid = '';
    private $unionid = '';
    private $userAccessToken = '';

    public function setAvatar($val)
    {
        $this->avatar = (string) $val;
    }

    public function setOpenid($val)
    {
        $this->openid = (string) $val;
    }

    public function setUnionId($val)
    {
        $this->unionid = (string) $val;
    }

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isWechatId($this->openid) === false) {
            throw new PhpecsException('OPENID未设置或值无效');
        }
        if (Valid::isWechatId($this->unionid) === false) {
            throw new PhpecsException('UNIONID未设置或值无效');
        }
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户访问令牌未设置或值无效');
        }
        return $this->client->request($this->api, [
            'avatar' => $this->avatar,
            'openid' => $this->openid,
            'unionid' => $this->unionid,
            'user_access_token' => $this->userAccessToken
        ]);
    }
}