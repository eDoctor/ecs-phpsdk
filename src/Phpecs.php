<?php
/**
 * Author: Wenpeng
 * Email: imwwp@outlook.com
 * Time: 16/11/4 上午10:51
 */

namespace eDoctor\Phpecs;

use Wenpeng\Curl\Curl;

class Phpecs
{
    private $key;
    private $secret;
    private $server;
    private $timeout;

    private $redis;
    private $hashes = [
        'access' => 'phpecs:app_access_token',
        'refresh' => 'phpecs:app_refresh_token'
    ];

    /**
     * Phpecs constructor.
     * @param array $config
     * @param object $redis
     */
    public function __construct($config, $redis)
    {
        $this->key = (string) $config['api_key'];
        $this->secret = (string) $config['api_secret'];
        $this->server = trim($config['api_server'], '/');
        $this->timeout = abs((int) $config['max_timeout']);

        $this->redis = $redis;
    }

    public function abort($message, $code = 400)
    {
        throw new PhpecsException($message, $code);
    }

    public function request($uri, $post, $files = null)
    {
        $redis = $this->redis;
        $access = $this->hashes['access'];
        $refresh = $this->hashes['refresh'];
        if ($redis->ttl($access) < 10) {
            if ($redis->ttl($refresh)) {
                $this->refresh();
            } else {
                $this->order();
            }
        }
        $array = array_merge((array) $post, [
            'app_access_token' => $redis->get($access)
        ]);
        $response = $this->curl($uri, $array, $files);
        $code = (int) $response->code;
        if ($code === 40001) {
            return $this->refresh()->request($uri, $post, $files);
        }
        return $response;
    }

    private function api($uri)
    {
        $uri = trim((string) $uri, '/');
        return $this->server .'/'. $uri;
    }

    private function order()
    {
        $resp = $this->curl('app/v1/order/tokens', [
            'api_key' => $this->key,
            'api_secret' => $this->secret
        ]);
        if ($resp->code) {
            throw new PhpecsException($resp->message, $resp->code);
        }
        return $this->cache($resp->data);
    }

    private function refresh()
    {
        $hash = $this->hashes['refresh'];
        $resp = $this->curl('app/v1/refresh/tokens', [
            'app_refresh_token' => $this->redis->get($hash)
        ]);
        if ($resp->code) {
            if ($resp->code === 40002) {
                return $this->order();
            } else {
                throw new PhpecsException($resp->message, $resp->code);
            }
        } else {
            return $this->cache($resp->data);
        }
    }

    private function cache($data)
    {
        $this->redis->set($this->hashes['access'], $data->app_access_token);
        $this->redis->set($this->hashes['refresh'], $data->app_refresh_token);
        $this->redis->expire($this->hashes['access'], $data->app_access_token_expire);
        $this->redis->expire($this->hashes['refresh'], $data->app_refresh_token_expire);
        return $this;
    }

    private function curl($uri, $post, $files = null)
    {
        $curl = new Curl();
        $curl->set('CURLOPT_TIMEOUT', $this->timeout);
        if ($files !== null) {
            foreach ($files as $field => $file) {
                $curl->file($field, $file['path'], $file['mime'], $file['name']);
            }
        }
        $curl->post($post)->url($this->api($uri));
        if ($curl->error()) {
            throw new PhpecsException($curl->message(), 500);
        }
        $data = json_decode($curl->data());
        if ($data === false) {
            throw new PhpecsException('Remote server response error', 502);
        }
        return $data;
    }
}