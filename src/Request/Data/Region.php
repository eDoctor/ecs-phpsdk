<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午6:29
 */

namespace eDoctor\Phpecs\Request\Data;

use eDoctor\Phpecs\PhpecsRequest;

class Region extends PhpecsRequest
{
    private $api = 'data/v1/region/subsets';
    private $regionId = 0;

    public function setRegionId($val)
    {
        $this->regionId = abs((int) $val);
    }

    public function getResponse()
    {
        return $this->client->request($this->api, [
            'region_id' => $this->regionId
        ]);
    }
}