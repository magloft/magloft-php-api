<?php
namespace MagLoft\Api\Resources {

  class Publication extends Base {
    public static $api = 'portal';
    public static $resource = 'publications';
    public static $collectionPath = '';
    public static $resourcePath = ':id';
    public static $attrWriter = array('title');
    public static $attrReader = array('app_id', 'title');
  }
}

