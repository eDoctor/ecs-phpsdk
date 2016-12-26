<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午4:39
 */

namespace eDoctor\Phpecs\Request\Push;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class PushNotice extends PhpecsRequest
{
    private $api = 'push/v1/notice';

    private $target = [];
    private $title = '';
    private $content = '';
    private $platform = '';

    private $iosEnv = 'DEV';
    private $iosSound = '';
    private $iosBadge = '';
    private $iosExtras = [];

    private $androidSound = '';
    private $androidOpenUrl = '';
    private $androidOpenType = 0;
    private $androidOpenActivity = '';
    private $androidExtras = [];

    public function setTarget($roleId, $userIds)
    {
        $roleId = (int)$roleId;
        $this->target[$roleId] = (array) $userIds;
    }

    public function setTitle($val)
    {
        $this->title = (string) $val;
    }

    public function setContent($val)
    {
        $this->content = (string) $val;
    }

    public function setPlatform($val)
    {
        $this->platform = (string) $val;
    }

    public function setIosEnv($val)
    {
        $this->iosEnv = (string) $val;
    }

    public function setIosSound($val)
    {
        $this->iosSound = (string) $val;
    }

    public function setIosBadge($val)
    {
        $this->iosBadge = (string) $val;
    }

    public function setIosExtras($val)
    {
        $this->iosExtras = (array) $val;
    }

    public function getResponse()
    {
        if ($this->title === '' || $this->content === '') {
            throw new PhpecsException('推送标题或推送内容未设置或值无效');
        }

        $platforms = ['ios', 'android'];
        if (in_array($this->platform, $platforms) === false) {
            throw new PhpecsException('推送设备类型未设置或值无效');
        }
        foreach ($this->target as $role => $userIds) {
            if (Valid::isRole($role) === false) {
                throw new PhpecsException('推送目标存在无效的角色编号');
            }
            foreach ($userIds as $userId) {
                if (Valid::isId($userId) === false) {
                    throw new PhpecsException('推送目标存在无效的用户编号');
                }
            }
        }

        return $this->client->request($this->api, [
            'user' => $this->target,
            'title' => $this->title,
            'content' => $this->content,
            'platform' => $this->platform,
            'ios_options' => [
                'env' => $this->iosEnv,
                'sound' => $this->iosSound,
                'badge' => $this->iosBadge,
                'extras' => json_encode($this->iosExtras)
            ],
            'android_options' => [
                'sound' => $this->androidSound,
                'open_url' => $this->androidOpenUrl,
                'open_type' => $this->androidOpenType,
                'open_activity' => $this->androidOpenActivity,
                'extras' => json_encode($this->androidExtras)
            ],
        ]);
    }
}