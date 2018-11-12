<?php
namespace MagLoft\Api\Resources {

  class Publication extends Base {
    public static $api = 'portal';
    public static $resource = 'publications';
    public static $collectionPath = ':id';
    public static $resourcePath = ':id';
    public static $attrWriter = array('title', 'app_id', 'user_id', 'user_email');
    public static $attrReader = array('slug', 'icon');
  }
}