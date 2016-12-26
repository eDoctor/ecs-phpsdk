<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/25 下午3:39
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class Logout extends PhpecsRequest
{
    private $api = 'user/v1/destroy/tokens';
    private $userRefreshToken = '';

    public function setUserRefreshToken($val)
    {
        $this->userRefreshToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->userRefreshToken) === false) {
            throw new PhpecsException('用户刷新令牌未设置或格式错误');
        }

        return $this->client->request($this->api, [
            'user_refresh_token' => $this->userRefreshToken
        ]);
    }
}