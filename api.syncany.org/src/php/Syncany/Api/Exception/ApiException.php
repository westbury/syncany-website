<?php

namespace Syncany\Api\Exception;

abstract class ApiException extends \Exception {
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }
}