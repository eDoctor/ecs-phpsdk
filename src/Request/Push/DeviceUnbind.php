<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午4:28
 */

namespace eDoctor\Phpecs\Request\Push;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class DeviceUnbind extends PhpecsRequest
{
    private $api = 'push/v1/device/unbind';

    private $userId = 0;
    private $roleId = 0;
    private $deviceId = '';

    public function setUserId($val)
    {
        $this->userId = (int) $val;
    }

    public function setRoleId($val)
    {
        $this->roleId = (int) $val;
    }

    public function setDeviceId($val)
    {
        $this->deviceId = (int) $val;
    }

    public function getResponse()
    {
        if (Valid::isId($this->userId) === false) {
            throw new PhpecsException('用户编号未设置或值无效');
        }
        if (Valid::isRole($this->roleId) === false) {
            throw new PhpecsException('角色编号未设置或值无效');
        }
        if ($this->deviceId === '') {
            throw new PhpecsException('设备编号未设置或值无效');
        }

        return $this->client->request($this->api, [
            'user_id' => $this->userId,
            'role_id' => $this->roleId,
            'device_id' => $this->deviceId
        ]);
    }
}