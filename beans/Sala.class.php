<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 27/03/2017
 * Time: 10:38
 */
class Sala
{
private $cdSala;
private $dsMaquina;
private $dsConsultorio;
private $dsMaquinaAux;

    /**
     * @return mixed
     */
    public function getDsMaquinaAux()
    {
        return $this->dsMaquinaAux;
    }

    /**
     * @param mixed $dsMaquinaAux
     * @return Sala
     */
    public function setDsMaquinaAux($dsMaquinaAux)
    {
        $this->dsMaquinaAux = $dsMaquinaAux;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getCdSala()
    {
        return $this->cdSala;
    }

    /**
     * @param mixed $cdSala
     * @return Sala
     */
    public function setCdSala($cdSala)
    {
        $this->cdSala = $cdSala;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsMaquina()
    {
        return $this->dsMaquina;
    }

    /**
     * @param mixed $dsMaquina
     * @return Sala
     */
    public function setDsMaquina($dsMaquina)
    {
        $this->dsMaquina = $dsMaquina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsConsultorio()
    {
        return $this->dsConsultorio;
    }

    /**
     * @param mixed $dsConsultorio
     * @return Sala
     */
    public function setDsConsultorio($dsConsultorio)
    {
        $this->dsConsultorio = $dsConsultorio;
        return $this;
    }


}