<?php
namespace MagLoft\Api\Exceptions;

use MagLoft\Api\Http\JsonResponse;
use Exception;

class ApiException extends Exception {
  public $response;

  public function __construct(JsonResponse $response) {
    parent::__construct($response->json['error'], $response->code);
    $this->response = $response;
  }
}