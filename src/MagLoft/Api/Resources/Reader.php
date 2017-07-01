<?php
namespace MagLoft\Api\Resources;

class Reader extends Base {
  public static $api = 'portal';
  public static $resource = 'readers';
  public static $collectionPath = ':app_id';
  public static $resourcePath = ':app_id/:id';
  public static $attrWriter = array('email', 'name', 'confirmed', 'password');
  public static $attrReader = array('last_sign_in_at', 'created_at', 'devices');
}