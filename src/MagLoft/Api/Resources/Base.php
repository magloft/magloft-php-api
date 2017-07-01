<?php
namespace MagLoft\Api\Resources;

use stdClass;
use DateTime;
use MagLoft\Api\Client;
use MagLoft\Api\Exceptions\ApiException;

abstract class Base {
  public $id = null;
  protected $data = array();

  public static function all() {
    $response = Client::instance()->get(static::$api, static::$resource, static::$collectionPath);
    $records = array();
    foreach ($response->data as $item) {
      $records[] = new static($item);
    }
    return $records;
  }

  public static function find($id) {
    $response = Client::instance()->get(static::$api, static::$resource, static::$resourcePath, array('id' => $id));
    return new static($response->data);
  }

  public function __construct($data=array()) {
    $this->setAttributes($data);
  }

  public function attributesChanged() {
    if ($this->id === null) { return true; }
    foreach (static::$attrWriter as $key) {
      if ($this->$key !== $this->data[$key]) {
        return true;
      }
    }
    return false;
  }

  public function changedAttributes() {
    $attributes = array();
    foreach (static::$attrWriter as $key) {
      if (isset($this->data[$key]) && ($this->id === null || $this->$key !== $this->data[$key])) {
        $attributes[$key] = $this->$key;
      }
    }
    return $attributes;
  }

  public function setAttributes($data) {
    $this->transformData($data);
    $this->data = $data;
    if (isset($data['id'])) {
      $this->id = $data['id'];
    }
    foreach (static::$attrWriter as $key) {
      $this->$key = isset($data[$key]) ? $data[$key] : null;
    }
    foreach (static::$attrReader as $key) {
      $this->$key = isset($data[$key]) ? $data[$key] : null;
    }
  }

  public function save() {
    $attributes = $this->changedAttributes();
    if (count($attributes) === 0) { return false; }
    if ($this->id === null) {
      $response = $this->client()->post(static::$api, static::$resource, static::$resourcePath, $attributes);
    } else {
      $attributes['id'] = $this->id;
      $response = $this->client()->put(static::$api, static::$resource, static::$resourcePath, $attributes);
    }
    if ($response->success) {
      $this->setAttributes($response->data);
    } else {
      throw new ApiException($response);
    }
  }

  public function transformData(&$data) {

  }

  private function client() {
    return Client::instance();
  }
}