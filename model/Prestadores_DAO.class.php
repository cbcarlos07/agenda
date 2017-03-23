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
               $sql_text = "SELECT DISTINCT 
                            P.CD_PRESTADOR
                            ,P.NM_PRESTADOR
                       FROM DBAMV.AGENDA_CENTRAL AC
                           ,DBAMV.PRESTADOR P
                           ,DBAMV.IT_AGENDA_CENTRAL IAC
                      WHERE AC.CD_PRESTADOR = P.CD_PRESTADOR
                        AND AC.CD_AGENDA_CENTRAL = IAC.CD_AGENDA_CENTRAL
                        AND IAC.CD_ATENDIMENTO IS NOT NULL
                        AND TO_CHAR(DT_AGENDA,'DD/MM/YYYY') = TO_CHAR(SYSDATE,'DD/MM/YYYY')
                        AND TP_AGENDA = 'A'
                        AND P.NM_PRESTADOR LIKE :NOME

                      UNION

                      SELECT DISTINCT 
                             PRESTADOR.CD_PRESTADOR
                            ,PRESTADOR.NM_PRESTADOR
                        FROM ATENDIME
                            ,PRESTADOR
                       WHERE ATENDIME.CD_PRESTADOR = PRESTADOR.CD_PRESTADOR
                         AND ATENDIME.CD_DES_ATE IS NOT NULL
                         AND ATENDIME.TP_ATENDIMENTO = 'A'
						 AND ATENDIME.CD_ORI_ATE = 1
                         AND TO_CHAR(ATENDIME.DT_ATENDIMENTO,'DD/MM/YYYY') = TO_CHAR(SYSDATE,'DD/MM/YYYY')
                         AND PRESTADOR.NM_PRESTADOR LIKE :NOME

                      ORDER BY 2";
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

} //fim daclasse