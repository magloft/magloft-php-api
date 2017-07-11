<?php
namespace MagLoft\Api\Resources {

  class Reader extends Base {
    public static $api = 'portal';
    public static $resource = 'readers';
    public static $collectionPath = ':app_id';
    public static $resourcePath = ':app_id/:id';
    public static $attrWriter = array('email', 'name', 'confirmed', 'password', 'confirmation');
    public static $attrReader = array('last_sign_in_at', 'created_at', 'devices');

    public function unlockProductIds($productIds=array(), $orderId=null) {
      if ($this->id === null) { return false; }
      $response = $this->client()->post(static::$api, static::$resource, static::$resourcePath . '/unlock', array(
        'id' => $this->id,
        'product_ids' => $productIds,
        'order_id' => $orderId
      ));
      return $response->json;
    }

  }
}

