<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/25 下午3:11
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class Login extends PhpecsRequest
{
    private $api = 'user/v1/order/tokens';
    private $email = '';
    private $roleId = 0;
    private $mobile = '';
    private $gender = 0;
    private $avatar = '';
    private $openId = '';
    private $unionId = '';
    private $nickname = '';
    private $language = '';
    private $password = '';
    private $platform = '';
    private $authMethod = '';

    public function setEmail($val)
    {
        $this->email = (string) $val;
    }

    public function setRoleId($val)
    {
        $this->roleId = (int) $val;
    }

    public function setMobile($val)
    {
        $this->mobile = (string) $val;
    }
    public function setAvatar($val)
    {
        $this->avatar = (string) $val;
    }

    public function setGender($val)
    {
        $this->gender = (int) $val;
    }

    public function setOpenId($val)
    {
        $this->openId = (string) $val;
    }

    public function setUnionId($val)
    {
        $this->unionId = (string) $val;
    }

    public function setPlatform($val)
    {
        $this->platform = (string) $val;
    }

    public function setNickname($val)
    {
        $this->nickname = (string) $val;
    }

    public function setLanguage($val)
    {
        $this->language = (string) $val;
    }

    public function setPassword($val)
    {
        $this->password = (string) $val;
    }

    public function setAuthMethod($val)
    {
        $this->authMethod = (string) $val;
    }

    public function getResponse()
    {
        $methodArr = ['email', 'mobile', 'wechat'];
        if (in_array($this->authMethod, $methodArr)) {
            throw new PhpecsException('认证方法未设置或值无效');
        }
        if ($this->authMethod === 'wechat') {
            if (Valid::isGender($this->gender) === false) {
                throw new PhpecsException('用户性别未设置或值无效');
            }
            if (Valid::isWechatId($this->openId) === false) {
                throw new PhpecsException('OPENID未设置或值无效');
            }
            if (Valid::isWechatId($this->unionId) === false) {
                throw new PhpecsException('UNIONID未设置或值无效');
            }
            if (Valid::isNickname($this->nickname)) {
                throw new PhpecsException('用户昵称未设置或值无效');
            }
            if (Valid::isLanguage($this->language)) {
                throw new PhpecsException('语言类型未设置或值无效');
            }
        } else {
            if (Valid::isPassword($this->password) === false) {
                throw new PhpecsException('账户密码未设置或值无效');
            }
            if ($this->authMethod === 'email') {
                if (Valid::isEmail($this->email) === false) {
                    throw new PhpecsException('邮箱地址未设置或值无效');
                }
            } else {
                if (Valid::isMobile($this->mobile) === false) {
                    throw new PhpecsException('手机号码未设置或值无效');
                }
            }
        }
        if (Valid::isRole($this->roleId) === false) {
            throw new PhpecsException('角色编号未设置或值无效');
        }
        if (Valid::isPlatform($this->platform) === false) {
            throw new PhpecsException('终端类型未设置或值无效');
        }

        return $this->client->request($this->api, [
            'auth_method' => $this->authMethod,
            'auth_params' => [
                'email' => $this->email,
                'mobile' => $this->mobile,
                'password' => $this->password,
                'avatar' => $this->avatar,
                'gender' => $this->gender,
                'openid' => $this->openId,
                'unionid' => $this->unionId,
                'nickname' => $this->nickname,
                'language' => $this->language
            ],
            'platform' => $this->platform,
            'role_id' => $this->roleId
        ]);
    }
}