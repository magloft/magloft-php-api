<?php
namespace MagLoft\Api;

use MagLoft\Api\Resources\Subscription;
use MagLoft\Api\Resources\Reader;
use MagLoft\Api\Http\JsonRequest;

class Client {
  protected $options = array();
  protected $hooks = null;

  public static function instance() {
    static $instance = null;
    if ($instance === null) { $instance = new Client(); }
    return $instance;
  }

  public function setAccessToken($accessToken) {
    $this->options['access_token'] = $accessToken;
  }

  public function setAppId($appId) {
    $this->options['app_id'] = $appId;
  }

  public function subscriptions() {
    return Subscription::all();
  }

  public function subscription($id) {
    return Subscription::find($id);
  }

  public function readers() {
    return Reader::all();
  }

  public function reader($id) {
    return Reader::find($id);
  }

  public function get($api, $resource, $path, $params=array(), $headers=array()) {
    return JsonRequest::get($this->apiUrl($api, $resource, $path, $params), $this->transformHeaders($headers));
  }

  public function put($api, $resource, $path, $params=array(), $headers=array()) {
    return JsonRequest::put($this->apiUrl($api, $resource, $path, $params), $params, $this->transformHeaders($headers));
  }

  public function post($api, $resource, $path, $params=array(), $headers=array()) {
    return JsonRequest::post($this->apiUrl($api, $resource, $path, $params), $params, $this->transformHeaders($headers));
  }

  private function apiUrl($api, $resource, $path='', &$params=array()) {
    $path = preg_replace_callback('/:([a-z0-9_]+)/', function($matches) use ($params) {
      if (isset($params[$matches[1]])) {
        $value = $params[$matches[1]];
        unset($params[$matches[1]]);
        return $value;
      } elseif (isset($this->options[$matches[1]])) {
        return $this->options[$matches[1]];
      } else {
        return '';
      }
    }, $path);
    return "https://www.magloft.com/api/$api/v1/$resource/$path";
  }

  private function transformHeaders($headers=array()) {
    $headers['X-Magloft-Accesstoken'] = $this->options['access_token'];
    return $headers;
  }
}