<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/12/26 下午6:31
 */

namespace eDoctor\Phpecs\Request\Data;

use eDoctor\Phpecs\PhpecsRequest;

class Hospital extends PhpecsRequest
{
    private $api = 'data/v1/hospital/region/sets';
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