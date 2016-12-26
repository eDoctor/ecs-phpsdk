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

class PushMessage extends PhpecsRequest
{
    private $api = 'push/v1/message';

    private $target = [];
    private $title = '';
    private $content = '';
    private $platform = '';

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
            'platform' => $this->platform
        ]);
    }
}