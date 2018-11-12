<?php
namespace MagLoft\Api\Resources {

  class User extends Base {
    public static $api = 'portal';
    public static $resource = 'users';
    public static $collectionPath = ':id';
    public static $resourcePath = ':id';
    public static $attrWriter = array('role');
    public static $attrReader = array('firstname', 'email', 'lastname');
  }
}