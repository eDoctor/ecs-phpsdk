<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/17 下午5:14
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class ModifyPassword extends PhpecsRequest
{
    private $userAccessToken = '';
    private $oldPassword = '';
    private $newPassword = '';

    public function setUserAccessToken($val)
    {
        $this->userAccessToken = (string) $val;
    }

    public function setOldPassword($val)
    {
        $this->oldPassword = (string) $val;
    }

    public function setNewPassword($val)
    {
        $this->newPassword = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isToken($this->userAccessToken) === false) {
            throw new PhpecsException('用户访问令牌未设置或值无效');
        }
        if (Valid::isPassword($this->oldPassword) === false) {
            throw new PhpecsException('旧密码未设置或值无效');
        }
        if (Valid::isPassword($this->newPassword) === false) {
            throw new PhpecsException('新密码未设置或值无效');
        }

        $api = 'user/v1/modify/password';
        return $this->client->request($api, [
            'user_access_token' => $this->userAccessToken,
            'old_password' => $this->oldPassword,
            'new_password' => $this->newPassword
        ]);
    }
}