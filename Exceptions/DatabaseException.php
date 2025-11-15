<?php

class DatabaseException extends Exception
{

    public function __construct(
        string $message = "Database error occurred",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        error_log("DatabaseException: " . $message);
    }
}
