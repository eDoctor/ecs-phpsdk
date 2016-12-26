<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午7:58
 */

namespace eDoctor\Phpecs\Request\Cfs;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;
use eDoctor\Phpecs\PhpecsValidator as Valid;

class RemoteUpload extends PhpecsRequest
{
    private $api = 'cfs/v1/upload/remote';
    private $url = '';

    public function setUrl($val)
    {
        $this->url = (string) $val;
    }

    public function getResponse()
    {
        if (Valid::isUrl($this->url) === false) {
            throw new PhpecsException('远程文件未设置或值无效');
        }

        return $this->client->request($this->api, [
            'url' => $this->url
        ]);
    }
}