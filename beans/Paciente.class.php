<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paciente {
    private $codigo;
    private $hora;
    private $obs;
    private $paciente;
    private $idade;
    private $horaAtendimento;
    private $num;
    private $codigoAtendimento;
    private $espera;
    private $previsaoHora;
    private $senha;
    private $situacao;
    private $media;
    private $prioridade;
    
    public function getPrioridade() {
        return $this->prioridade;
    }

    public function setPrioridade($prioridade) {
        $this->prioridade = $prioridade;
        return $this;
    }

        
    public function getMedia() {
        return $this->media;
    }

    public function setMedia($media) {
        $this->media = $media;
        return $this;
    }

        public function getSituacao() {
        return $this->situacao;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
        return $this;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    
        public  function getPrevisaoHora() {
        return $this->previsaoHora;
    }

    public function setPrevisaoHora($previsaoHora) {
        $this->previsaoHora = $previsaoHora;
        return $this;
    }

        
    public function getEspera() {
        return $this->espera;
    }

    public function setEspera($espera) {
        $this->espera = $espera;
        return $this;
    }

        
    public function getCodigoAtendimento() {
        return $this->codigoAtendimento;
    }

    public function setCodigoAtendimento($codigoAtendimento) {
        $this->codigoAtendimento = $codigoAtendimento;
        return $this;
    }

        
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getObs() {
        return $this->obs;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function getIdade() {
        return $this->idade;
    }

    public function getHoraAtendimento() {
        return $this->horaAtendimento;
    }

    public function getNum() {
        return $this->num;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    public function setHora($hora) {
        $this->hora = $hora;
        return $this;
    }

    public function setObs($obs) {
        $this->obs = $obs;
        return $this;
    }

    public function setPaciente($paciente) {
        $this->paciente = $paciente;
        return $this;
    }

    public function setIdade($idade) {
        $this->idade = $idade;
        return $this;
    }

    public function setHoraAtendimento($horaAtendimento) {
        $this->horaAtendimento = $horaAtendimento;
        return $this;
    }

    public function setNum($num) {
        $this->num = $num;
        return $this;
    }


}