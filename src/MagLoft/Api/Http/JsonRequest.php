<?php
namespace MagLoft\Api\Http {

  class JsonRequest {

    public static function get($url, $headers=array()) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, self::transformHeaders($headers));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      return self::performRequest($ch);
    }

    public static function post($url, $params=array(), $headers=array()) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, self::transformHeaders($headers));
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      return self::performRequest($ch);
    }

    public static function put($url, $params=array(), $headers=array()) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, self::transformHeaders($headers));
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      return self::performRequest($ch);
    }

    public static function delete($url, $headers=array()) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, self::transformHeaders($headers));
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      return self::performRequest($ch);
    }

    private static function performRequest($ch) {
      $response = new JsonResponse($ch);
      curl_close($ch);
      return $response;
    }

    private static function transformHeaders($headers=array()) {
      $result = array(
        'Expect: application/json',
        'Content-Type: application/json'
      );
      foreach ($headers as $key => $value) {
        $result[] = "$key: $value";
      }
      return $result;
    }

  }
}