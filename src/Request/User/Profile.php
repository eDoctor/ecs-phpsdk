<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/25 下午4:16
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class Profile extends PhpecsRequest
{
    private $api = 'user/v1/profile';
    private $userAccessToken = '';

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户访问令牌未设置或值无效');
        }

        return $this->client->request($this->api, [
            'user_access_token' => $this->userAccessToken
        ]);
    }
}