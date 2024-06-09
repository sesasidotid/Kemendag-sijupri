<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class BusinessException extends RuntimeException
{
    protected $error_code;
    protected $http_code;
    protected $params;
    protected $options;

    public function __construct($options = array(), $code = 500, Throwable $previous = null)
    {
        if (is_array($options)) {
            if (isset($options['message'])) {
                $message = $options['message'];
                unset($options['message']);
            } else {
                $message = 'Terjadi Masalah';
            }
            $this->options = $options;
            $this->options['code'] = $code;
        } else {
            $message = $options ?? 'Terjadi Masalah';
        }

        parent::__construct($message, $code, $previous);
    }

    public function getErrorResponse()
    {
        if (is_array($this->options)) {
            $this->options['message'] = $this->getMessage();
            return $this->options;
        }
        return [
            'message' => $this->getMessage(),
            'error_code' => $this->getErrorCode(),
            'code' => $this->getCode(),
        ];
    }

    public function getErrorCode()
    {
        return $this->options['error_code'] ?? 'UNC_00000';
    }

    public function getParams()
    {
        return $this->options['params'] ?? null;
    }
}
