<?php

namespace App;

class Payload
{
    
    /**
     * The response code.
     *
     * @var int
     */
    public $code = 200;

    /**
     * The overall message.
     *
     * @var string
     */
    public $message = 'success';

    /**
     * The stored data.
     *
     * @var array
     */
    public $data = [];

    public function __construct($_code = 200) {
        $this->code = $_code;
    }

}
