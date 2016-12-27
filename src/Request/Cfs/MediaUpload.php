<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/27 下午3:48
 */

namespace eDoctor\Phpecs\Request\Cfs;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;

class MediaUpload extends PhpecsRequest
{
    private $api = 'cfs/v1/upload/media';

    private $path = '';
    private $mime = '';
    private $name = '';
    private $preheat = 0;

    public function setPath($val)
    {
        $this->path = (string) $val;
    }

    public function setMime($val)
    {
        $this->mime = (string) $val;
    }

    public function setName($val)
    {
        $this->name = (string) $val;
    }

    public function setPreheat($val)
    {
        $this->preheat = (int) $val ? 1 : 0;
    }

    public function getResponse()
    {
        if ($this->path === '') {
            throw new PhpecsException('文件路径未设置或值无效');
        }
        if ($this->mime === '') {
            throw new PhpecsException('文件类型未设置或值无效');
        }
        if ($this->name === '') {
            throw new PhpecsException('文件名称未设置或值无效');
        }

        return $this->client->request($this->api, [], [
            'file' => [
                'path' => $this->path,
                'mime' => $this->mime,
                'name' => $this->name
            ],
            'preheat' => $this->preheat
        ]);
    }
}