<?php

namespace App\Common;

use Exception;

class ActionResponse
{
    /** @var int status success */
    public const STATUS_SUCCESS = 1;

    /** @var int status error */
    public const STATUS_ERROR = 0;

    /** @var int response status */
    protected $status;

    /** @var int response message */
    protected $message;

    /** @var mixed response data */
    protected $data;

    public function __construct($status, $data = [], $message = '')
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Get response data
     * @param string|int $key - in case response data is array and we need specific key from the erray
     * @return mixed
     * @throws Exception
     */
    public function data($key = null)
    {
        if (!empty($key)) {
            if (!isset($this->data[$key])) {
                throw new Exception("The key [$key] does not exist in action");
            }

            return $this->data[$key];
        }
        return $this->data;
    }


    /**
     * Is error response
     * @return bool
     */
    public function isError()
    {
        return $this->status == static::STATUS_ERROR;
    }

    /**
     * Is success response
     * @return bool
     */
    public function isSuccess()
    {
        return $this->status == true;
    }

    /**
     * Get response message
     * @return bool
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * Create error instance
     * @param string $message
     * @param mixed $data
     * @return static
     */
    public static function error($message, $data = [])
    {
        return new static(static::STATUS_ERROR, $data, $message);
    }

    /**
     * Create success instance
     * @param string $message
     * @param mixed $data
     * @return ActionResponse
     */
    public static function success($data = [], $message = 'Success')
    {        
        return new static(static::STATUS_SUCCESS, $data, $message);
    }
}