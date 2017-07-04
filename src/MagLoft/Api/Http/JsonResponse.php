<?php
namespace MagLoft\Api\Http {

  class JsonResponse {
    public $code;
    public $body;
    public $json;
    public $success;

    public function __construct($ch) {
      $this->body = curl_exec($ch);
      $this->code = curl_errno($ch) ? 0 : curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $this->success = ($this->code >= 200 && $this->code < 300);
      $this->json = json_decode($this->body, true);
    }

  }
}
