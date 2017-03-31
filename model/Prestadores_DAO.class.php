<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prestadores_DAO{
        
       public function lista($nome){
           require_once 'beans/Prestadores.class.php';
           include_once 'ConnectionFactory.class.php';
           include_once '/servicos/PrestadorList.class.php';
           $con = new ConnectionFactory();
           $conn = $con->getConnection();
           
           $prestadorList = new PrestadoresList();
           
           try{
               $sql_text = "SELECT * FROM V_HAM_LISTA_PRESTADOR WHERE NM_PRESTADOR LIKE :NOME";
               $statement = oci_parse($conn, $sql_text);
               oci_bind_by_name($statement, ':NOME', $nome);
               oci_execute($statement);
               while($row = oci_fetch_array($statement, OCI_ASSOC)){
                   $prestadores = new Prestadores();
                   $prestadores->setId($row['CD_PRESTADOR']);
                   $prestadores->setNome($row['NM_PRESTADOR']);
                   
                   $prestadorList->addPrestadores($prestadores);
               }
              
               $con->closeConnection($conn);
           } catch (PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
           }
           return $prestadorList;
        }


        public function getLocalPrestador($cdprestador){
                include_once 'ConnectionFactory.class.php';
                require_once 'beans/Prestadores.class.php';
                $maquina = new Prestadores();
                $maquina->setMaquina("");
                $maquina->setValor("");
                $con = new ConnectionFactory();
                $conn = $con->getConnection();

                $query = "SELECT * FROM DBAADV.CONSULTORIO_MEDICO C WHERE C.CD_PRESTADOR = :prestador";
                try{
                    $statement = oci_parse($conn, $query);
                    oci_bind_by_name($statement, ':prestador', $cdprestador);
                    oci_execute($statement);
                    if($row = oci_fetch_array($statement, OCI_ASSOC)){

                       $maquina->setMaquina($row['MAQUINA']);
                       $maquina->setValor($row['VALOR']);

                    }
                    $con->closeConnection($conn);
                }catch(PDOException $exception){
                    echo "Erro: ".$exception->getMessage();
                }
            return $maquina;
        }

      public function insertConsultorio(Prestadores $prestador){
          include_once 'ConnectionFactory.class.php';
          $teste = false;
          $conn = new ConnectionFactory();
          $conexao = $conn->getConnection();
          $sql_text = "INSERT INTO DBAADV.CONSULTORIO_MEDICO (CD_CONSULTORIO, CD_PRESTADOR, VALOR, MAQUINA)
		     VALUES (DBAADV.SEQ_CONSULTORIO_MEDICO.NEXTVAL, :prestador, :valor, :maquina )";
          try {
              // echo "Nome: ".
              $cdprestador      = $prestador->getId();
              $valor          = $prestador->getValor(); //o valor pode ser o consultorio
              $maquina        = $prestador->getMaquina();
              $statement   = oci_parse($conexao, $sql_text);
              oci_bind_by_name($statement, ":prestador", $cdprestador);
              oci_bind_by_name($statement, ":valor", $valor);
              oci_bind_by_name($statement, ":maquina", $maquina);
              oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
              $teste = true;
              $conn->closeConnection($conexao);
          } catch (PDOException $ex) {
              echo " Erro: ".$ex->getMessage();
          }
          return $teste;
      }

    public function updateConsultorio(Prestadores $prestador){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $sql_text = "UPDATE DBAADV.CONSULTORIO_MEDICO SET 
                             VALOR = :valor, MAQUINA = :maquina
		             WHERE CD_PRESTADOR = :prestador";
        try {
            // echo "Nome: ".
            $cdprestador      = $prestador->getId();
            $valor          = $prestador->getValor(); //o valor pode ser o consultorio
            $maquina        = $prestador->getMaquina();
            $statement   = oci_parse($conexao, $sql_text);
            oci_bind_by_name($statement, ":prestador", $cdprestador);
            oci_bind_by_name($statement, ":valor", $valor);
            oci_bind_by_name($statement, ":maquina", $maquina);
            oci_execute($statement,  OCI_COMMIT_ON_SUCCESS);
            $teste = true;
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }
        return $teste;
    }


    public function getPossuiMaquina($prestador){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DBAADV.CONSULTORIO_MEDICO C 
                       WHERE C.CD_PRESTADOR = :prestador";
        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $teste = true;
            }
            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }



    public function getLocalValor($maquina){
        include_once 'ConnectionFactory.class.php';
        require_once 'beans/Prestadores.class.php';
        $maquina1 = "";
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM reg_maquina
                  WHERE maquina = :maquina
                  AND   sequencia LIKE 'NM_ESTACAO'";
        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $maquina1 = $row['VALOR'];
            }
            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $maquina1;
    }

    public function getEstaAtendendo($prestador){
        include_once 'ConnectionFactory.class.php';
        $teste = 0;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DBAADV.CONSULTORIO_CACHE A 
                    WHERE A.CD_PRESTADOR = :prestador";
        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $teste = 1;
            }
            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function insertVaiAtender($prestador, $maquina){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "INSERT INTO DBAADV.CONSULTORIO_CACHE VALUES (:prestador, :maquina)";

        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_execute($statement);

                $teste = true;

            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function updateVaiAtender($prestador, $maquina){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "UPDATE DBAADV.CONSULTORIO_CACHE SET MAQUINA = :maquina WHERE CD_PRESTADOR = :prestador";

        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_execute($statement);

            $teste = true;

            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }

    public function deleteVaiAtender($prestador, $maquina){
        include_once 'ConnectionFactory.class.php';
        $teste = false;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "DELETE FROM  DBAADV.CONSULTORIO_CACHE WHERE MAQUINA = :maquina AND CD_PRESTADOR = :prestador";

        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_bind_by_name($statement, ':maquina', $maquina);
            oci_execute($statement);

            $teste = true;

            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }


    public function consultorioLivre($prestador){
        include_once 'ConnectionFactory.class.php';
        $teste = 0;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "SELECT * FROM DBAADV.V_CONSULTORIO_OCUPADO WHERE MAQUINA = :prestador";

        try{
            $statement = oci_parse($conn, $query);
            oci_bind_by_name($statement, ':prestador', $prestador);
            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $teste = $row['IND'];
            }


            $con->closeConnection($conn);
        }catch(PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $teste;
    }


} //fim daclasse