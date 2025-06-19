<?php

namespace App\Services;

class TestServices
{
    /**
     * Get a test message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return 'Hello from Service Layer';
    }
}