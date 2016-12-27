<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/27 下午3:53
 */

namespace eDoctor\Phpecs\Request\Cfs;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;

class ZipUpload extends PhpecsRequest
{
    private $api = 'cfs/v1/upload/zip';

    private $path = '';
    private $mime = '';
    private $name = '';
    private $preheat = [];

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
        if (is_array($val)) {
            $this->preheat = array_merge($this->preheat, $val);
        } else {
            $this->preheat[] = (string) $val;
        }
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