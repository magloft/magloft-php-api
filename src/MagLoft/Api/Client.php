<?php
namespace MagLoft\Api;

use Requests;
use Requests_Hooks as Hooks;
use MagLoft\Api\Resources\Subscription;
use MagLoft\Api\Resources\Reader;

class Client {
  public static $timeout = 30;
  protected $options = array();
  protected $hooks = null;

  public static function instance() {
    static $instance = null;
    if ($instance === null) {
      $instance = new Client();
    }
    return $instance;
  }

  public function __construct() {
    $this->registerHooks();
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
    return Requests::get($this->apiUrl($api, $resource, $path, $params), $headers, array(
      'hooks' => $this->hooks,
      'verify' => false,
      'timeout' => self::$timeout
    ));
  }

  public function put($api, $resource, $path, $params=array(), $headers=array()) {
    return Requests::put($this->apiUrl($api, $resource, $path, $params), $headers, $params, array(
      'hooks' => $this->hooks,
      'verify' => false,
      'timeout' => self::$timeout
    ));
  }

  public function post($api, $resource, $path, $params=array(), $headers=array()) {
    return Requests::post($this->apiUrl($api, $resource, $path, $params), $headers, $params, array(
      'hooks' => $this->hooks,
      'verify' => false,
      'timeout' => self::$timeout
    ));
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

  private function registerHooks() {
    $this->hooks = new Hooks();
    $this->hooks->register('requests.before_request', function(&$url, &$headers, &$params, &$type, &$options) {
      $headers['X-Magloft-Accesstoken'] = $this->options['access_token'];
      $headers['Content-Type'] = 'application/json';
      $headers['Accept'] = 'application/json';
      if ($params) { $params = json_encode($params); }
    });
    $this->hooks->register('requests.after_request', function(&$return) {
      $return->data = json_decode($return->body, true);
    });
  }
}