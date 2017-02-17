<?php
class RespImageGalleryObj
{
    public $response_status;
    public $response;
    public function __construct($response_status, $count, $response)
    {

        $this->response_status = $response_status;
        $this->count = $count;
        $this->response = $response;

    }
}

