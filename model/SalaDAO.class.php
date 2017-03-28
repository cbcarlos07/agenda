<?php

/**
 * Created by PhpStorm.
 * User: carlos.bruno
 * Date: 27/03/2017
 * Time: 10:39
 */
class SalaDAO
{
    public function insert(Sala $sala){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $sql_text = "INSERT INTO DBAADV.CONSULTORIO_SALA (CD_SALA, DS_MAQUINA, DS_CONSULTORIO)
		     VALUES (DBAADV.SEQ_CONSULTORIO_SALA.NEXTVAL, :DS_MAQUINA, :DS_CONSULTORIO )";
        try {
            // echo "Nome: ".

            $maquina        = $sala->getDsMaquina(); //o valor pode ser o consultorio
            $consultorio    = $sala->getDsConsultorio();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":DS_MAQUINA", $maquina);
            oci_bind_by_name($statement, ":DS_CONSULTORIO", $consultorio);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $this->procedure($maquina, $consultorio, 'I');
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function update(Sala $sala){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        //echo "Excluir maquina: ".$sala->getDsMaquinaAux();
        $this->procedure($sala->getDsMaquinaAux(), NULL, 'E');
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $sql_text = "UPDATE DBAADV.CONSULTORIO_SALA SET 
                     DS_MAQUINA     = :DS_MAQUINA 
                    ,DS_CONSULTORIO = :DS_CONSULTORIO 
                     WHERE CD_SALA  = :SALA  ";
        try {
            // echo "Nome: ".

            $maquina        = $sala->getDsMaquina(); //o valor pode ser o consultorio
            $consultorio    = $sala->getDsConsultorio();
            $cdsala         = $sala->getCdSala();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":DS_MAQUINA", $maquina);
            oci_bind_by_name($statement, ":DS_CONSULTORIO", $consultorio);
            oci_bind_by_name($statement, ":SALA", $cdsala);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $this->procedure($maquina,  $consultorio, 'I');
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }

        return $teste;
    }

    public function delete($sala, $maquina){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $sql_text = "DELETE FROM DBAADV.CONSULTORIO_SALA 
                     WHERE CD_SALA  = :SALA  ";
        try {

            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":SALA", $sala);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $this->procedure($maquina,NULL, 'E');
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }

    public function getListaSala($maquina){
        include_once 'ConnectionFactory.class.php';
        require_once 'beans/Sala.class.php';
        require_once 'servicos/Salalist.class.php';

        $con = new ConnectionFactory();
        $conn = $con->getConnection();
        $salaList = new SalaList();
        $query = "SELECT * FROM DBAADV.CONSULTORIO_SALA
                  WHERE DS_MAQUINA    LIKE  :maquina
                  OR    DS_CONSULTORIO LIKE :consultorio";
        try{
            $statement = oci_parse($conn, $query);
            $maquina = "%$maquina%";
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_bind_by_name($statement, ':consultorio', $maquina);
            oci_execute($statement);
            while($row = oci_fetch_array($statement, OCI_ASSOC)){
                $sala  = new Sala();
                $sala->setCdSala($row['CD_SALA']);
                $sala->setDsMaquina($row['DS_MAQUINA']);
                $sala->setDsConsultorio($row['DS_CONSULTORIO']);
                $salaList->addSala($sala);
            }
            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $salaList;
    }

    public function getSala($maquina){
        include_once 'ConnectionFactory.class.php';
        require_once 'beans/Sala.class.php';
        require_once 'servicos/Salalist.class.php';

        $con = new ConnectionFactory();
        $conn = $con->getConnection();
        $sala =  null;
        $query = "SELECT * FROM DBAADV.CONSULTORIO_SALA
                  WHERE CD_SALA =  :maquina";
        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_execute($statement);
            while($row = oci_fetch_array($statement, OCI_ASSOC)){
                $sala  = new Sala();
                $sala->setCdSala($row['CD_SALA']);
                $sala->setDsMaquina($row['DS_MAQUINA']);
                $sala->setDsConsultorio($row['DS_CONSULTORIO']);


            }
            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $sala;
    }


    private function procedure ($maquina, $valor,  $acao){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
       // echo "Acao: ".$acao;
        $sql_text = "CALL PRC_CAD_MAC_HAM(:MAQUINA,  :VALOR,  :ACAO)";
        try {
            $statement   = oci_parse($conexao, $sql_text);

            oci_bind_by_name($statement, ":VALOR", $valor);
            oci_bind_by_name($statement, ":MAQUINA", $maquina);
            oci_bind_by_name($statement, ":ACAO",   $acao);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }
}