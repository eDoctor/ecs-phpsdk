<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/23 下午3:41
 */

namespace eDoctor\Phpecs\Request\Oauth;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class QrcodeStatus extends PhpecsRequest
{
    private $api = 'oauth/v1/qrcode/status';

    private $userAccessToken;
    private $oauthQrcodeToken;

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function setOauthQrcodeToken($val)
    {
        $this->oauthQrcodeToken = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户令牌未设置或者格式错误');
        }
        if (Valid::isToken($this->oauthQrcodeToken) === false) {
            throw new PhpecsException('扫码令牌未设置或者格式错误');
        }

        return $this->client->request($this->api, [
            'user_access_token' => $this->userAccessToken,
            'oauth_qrcode_token' => $this->oauthQrcodeToken
        ]);
    }
}