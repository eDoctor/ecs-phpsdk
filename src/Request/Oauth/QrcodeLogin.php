<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/23 下午3:44
 */

namespace eDoctor\Phpecs\Request\Oauth;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class QrcodeLogin extends PhpecsRequest
{
    private $api = 'oauth/v1/qrcode/login';

    private $oauthGrantToken;

    public function setOauthGrantToken($val)
    {
        $this->oauthGrantToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->oauthGrantToken) === false) {
            throw new PhpecsException('授权令牌未设置或者格式错误');
        }

        return $this->client->request($this->api, [
            'oauth_grant_token' => $this->oauthGrantToken
        ]);
    }
}