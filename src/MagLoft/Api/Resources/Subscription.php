<?php
namespace MagLoft\Api\Resources;

class Subscription extends Base {
  public static $api = 'portal';
  public static $resource = 'custom_subscriptions';
  public static $collectionPath = ':app_id';
  public static $resourcePath = ':app_id/:id';
  public static $attrWriter = array('order_id', 'active', 'start_date', 'end_date', 'status', 'password', 'email', 'firstname', 'lastname', 'confirmation');
  public static $attrReader = array('source', 'user_id', 'created_at', 'reader_id');

  public function transformData(&$data) {
    if (isset($data['reader'])) {
      $data['reader_id'] = $data['reader']['id'];
      $data['email'] = $data['reader']['email'];
      $data['confirmation'] = $data['reader']['confirmed'];
      unset($data['reader']);
    }
  }
}