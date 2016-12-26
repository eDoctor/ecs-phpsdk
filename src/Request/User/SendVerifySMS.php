<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/17 下午6:08
 */

namespace eDoctor\Phpecs\Request\User;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class SendVerifySMS extends PhpecsRequest
{
    private $api = 'user/v1/send/verify/sms';

    private $type = '';
    private $debug = 0;
    private $roleId = 0;
    private $mobile = '';
    private $content = '';
    private $template = 0;

    public function setType($val)
    {
        $this->type = (string) $val;
    }

    public function setDebug($val)
    {
        $this->debug = (int) $val;
    }

    public function setRoleId($val)
    {
        $this->roleId = (int) $val;
    }

    public function setMobile($val)
    {
        $this->mobile = (string) $val;
    }

    public function setContent($val)
    {
        $this->content = (string) $val;
    }

    public function setTemplate($val)
    {
        $this->template = (int) $val;
    }

    public function getResponse()
    {
        $this->debug = $this->debug ? 1 : 0;
        $typeArr = [
            'register', 'bind_mobile',
            'unbind_mobile', 'forget_password'
        ];
        if (in_array($this->type, $typeArr) === false) {
            throw new PhpecsException('业务类型未设置或值无效');
        }

        if (Valid::isRole($this->roleId) === false) {
            throw new PhpecsException('角色编号未设置或值无效');
        }
        if (Valid::isMobile($this->mobile) === false) {
            throw new PhpecsException('手机号码未设置或值无效');
        }
        if (Valid::isId($this->template) === false) {
            throw new PhpecsException('模板编号未设置或值无效');
        }
        if ($this->content === '') {
            throw new PhpecsException('短信内容不能为空');
        }

        return $this->client->request($this->api, [
            'type' => $this->type,
            'debug' => $this->debug,
            'role_id' => $this->roleId,
            'mobile' => $this->mobile,
            'content' => $this->content,
            'template' => $this->template
        ]);
    }
}