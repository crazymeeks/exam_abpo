<?php

namespace App\Exceptions;

class CustomerException extends \Exception
{


    public function __construct(string $msg = "Error", int $code = 500)
    {
        parent::__construct($msg, $code);
    }

    /**
     * Throws when customer not found.
     *
     * @return static
     */
    public static function not_found()
    {
        return new static("Customer does not exist!");
    }

    /**
     * Customer deletion error
     *
     * @return static
     */
    public static function delete_error()
    {
        return new static("Unable to delete customer. Either customer does not exist or transaction error.");
    }
}