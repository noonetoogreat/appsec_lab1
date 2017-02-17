<?php

class RespImageObj
{
	public $response_status;
    public $response;
    public function __construct($response_status, $response, $image)
    {

        $this->response_status = $response_status;
        $this->response = $response;
        $this->image = $image;

    }
}
