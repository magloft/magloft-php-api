<?php
namespace MagLoft\Api\Exceptions;

use Requests_Response;
use Exception;

class ApiException extends Exception {
  public $response;

  public function __construct(Requests_Response $response) {
    parent::__construct($response->data['error'], $response->status_code);
    $this->response = $response;
  }
}