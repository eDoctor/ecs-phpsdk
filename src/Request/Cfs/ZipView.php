<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/27 下午4:01
 */

namespace eDoctor\Phpecs\Request\Cfs;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;

class ZipView extends PhpecsRequest
{
    private $api = 'cfs/v1/view/zip';
    private $hash = '';

    public function setHash($val)
    {
        $this->hash = (string) $val;
    }

    public function getResponse()
    {
        if ($this->hash === '') {
            throw new PhpecsException('文件Hash未设置或值无效');
        }

        return $this->client->request($this->api, [
            'hash' => $this->hash
        ]);
    }
}