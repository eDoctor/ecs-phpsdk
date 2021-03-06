<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/17 下午3:57
 */

namespace eDoctor\Phpecs\Request\Cfs;

use eDoctor\Phpecs\PhpecsRequest;
use eDoctor\Phpecs\PhpecsException;

class ImageUpload extends PhpecsRequest
{
    private $api = 'cfs/v1/upload/image';

    private $path = '';
    private $mime = '';
    private $name = '';
    private $thumb = [];
    private $option = '';

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

    public function setThumb($val)
    {
        if (is_array($val)) {
            $this->thumb = array_merge($this->thumb, $val);
        } else {
            $this->thumb[] = (string) $val;
        }
    }

    public function setOption($val)
    {
        $this->option = (string) $val;
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
        return $this->client->request($this->api, [
            'thumb' => $this->thumb,
            'option' => $this->option
        ], [
            'file' => [
                'path' => $this->path,
                'mime' => $this->mime,
                'name' => $this->name
            ]
        ]);
    }
}