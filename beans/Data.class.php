<?php

/**
 * Created by PhpStorm.
 * User: carlos.brito
 * Date: 03/03/2017
 * Time: 08:53
 */
class Data
{
    private $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }


}