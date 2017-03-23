<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prestadores {
    private $id;
    private $nome;
    private $consultorio;
    private $valor;
    private $maquina;
    

    /**
     * @return mixed
     */
    public function getConsultorio()
    {
        return $this->consultorio;
    }

    /**
     * @param mixed $consultorio
     * @return Prestadores
     */
    public function setConsultorio($consultorio)
    {
        $this->consultorio = $consultorio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     * @return Prestadores
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaquina()
    {
        return $this->maquina;
    }

    /**
     * @param mixed $maquina
     * @return Prestadores
     */
    public function setMaquina($maquina)
    {
        $this->maquina = $maquina;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }





    
}