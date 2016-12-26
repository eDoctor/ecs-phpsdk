<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/23 下午3:45
 */

namespace eDoctor\Phpecs\Request\Oauth;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class QrcodeGrant extends PhpecsRequest
{
    private $api = 'oauth/v1/qrcode/grant';
    private $role;
    private $type;
    private $userAccessToken;
    private $oauthQrcodeToken;

    public function setRole($val)
    {
        $this->role = (int) $val;
    }

    public function setType($val)
    {
        $this->type = (string) $val;
    }

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
        if (Valid::isId($this->role) === false) {
            throw new PhpecsException('授权角色未设置或值无效');
        }
        $typeArr = ['granted', 'refused'];
        if (in_array($this->type, $typeArr) === false) {
            throw new PhpecsException('授权类型未设置或值无效');
        }
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户令牌未设置或者格式错误');
        }
        if (Valid::isToken($this->oauthQrcodeToken) === false) {
            throw new PhpecsException('扫码令牌未设置或者格式错误');
        }

        return $this->client->request($this->api, [
            'role' => $this->role,
            'type' => $this->type,
            'user_access_token' => $this->userAccessToken,
            'oauth_qrcode_token' => $this->oauthQrcodeToken
        ]);
    }
}