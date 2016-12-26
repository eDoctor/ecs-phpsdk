<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/4 上午11:10
 */

namespace eDoctor\Phpecs;

class PhpecsRequest
{
    protected $client;

    /**
     * PhpecsRequest constructor.
     * @param Phpecs $client
     */
    public function __construct(Phpecs $client)
    {
        $this->client = $client;
    }
}