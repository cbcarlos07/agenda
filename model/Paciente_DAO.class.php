<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paciente_DAO{
        
       public function lista($data, $medico){
           require_once 'beans/Paciente.class.php';
           require_once 'ConnectionFactory.class.php';
           include '/servicos/PacienteList.class.php';
           $con = new ConnectionFactory();
           $conn = $con->getConnection();
           
           $pacienteList = new PacienteList();
          // echo "Data $data";
           try{
               $sql_text = "SELECT IND
                                  ,HR_AGENDA
                                  ,PACIENTE
                                  ,DS_OBSERVACAO_GERAL
                                  ,IDADE,HR_ATENDIMENTO
                                  ,SIT,PRIORIDADE
                                  ,DS_SENHA
                                  ,ESPERA
                                  ,MEDIA2
                                  ,MEDIA
                                  ,TO_CHAR(PREVISAO,'DD/MM/YYYY HH24:MI:SS') PREVISAO
                                  ,ORDEM
                                  ,COD_ATD 
                            FROM TABLE(FN_PACIENTE(:MEDICO))";
               //AND to_char(SO.DT_EXECUCAO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
               $statement = oci_parse($conn, $sql_text);
               //print_r($sql_text);
               //oci_bind_by_name($statement, ':DATA', $data);
               oci_bind_by_name($statement, ':MEDICO', $medico);
               
               oci_execute($statement);
               while($row = oci_fetch_array($statement, OCI_ASSOC)){

                   if(isset($row['MEDIA'])){
                       $mediaFloat = $row['MEDIA'];
                   }else{
                       $mediaFloat = "";
                   }
                   if(isset($row['ORDEM'])){
                       $num = $row['ORDEM'];
                   }else{
                       $num = '';
                   }
                   
                   if(isset($row['DS_OBSERVACAO_GERAL'])){
                       $obs = $row['DS_OBSERVACAO_GERAL'];
                   }else{
                       $obs = '';
                   }
                   
                    if(isset($row['HR_AGENDA'])){
                       $horaagenda = $row['HR_AGENDA'];
                   }else{
                       $horaagenda = '';
                   }
                   if(isset($row['PREVISAO'])){
                       $previsaoHora = $row['PREVISAO'];
                   }else{
                       $previsaoHora = '';
                   }
                   
                   if(isset($row['MEDIA2'])){
                       $media = $row['MEDIA2'];
                   }else{
                       $media = 'AGUARDANDO ATENDIMENTO';
                   }
                   
                   if(isset($row['DS_SENHA'])){
                       $senha = $row['DS_SENHA'];
                   }else{
                       $senha = '';
                   }
                   //PREVISAO_HORA
                   
                   $paciente = new Paciente();
                   $paciente->setCodigo($row['IND']);                   
                   $paciente->setHora($horaagenda);
                   $paciente->setPaciente($row['PACIENTE']);
                   $paciente->setIdade($row['IDADE']);
                   $paciente->setHoraAtendimento($row['HR_ATENDIMENTO']);
                   $paciente->setNum($num);
                   $paciente->setObs($obs);
                   $paciente->setEspera($row['ESPERA']);
                   $paciente->setPrevisaoHora($previsaoHora);
                   $paciente->setSituacao($row['SIT']);
                   $paciente->setMedia($media);
                   $paciente->setPrioridade($row['PRIORIDADE']);
                   $paciente->setSenha($senha);
                   $paciente->setCodigoAtendimento($row['COD_ATD']);
                   $paciente->setMediaFloat($mediaFloat);
                   $pacienteList->addPaciente($paciente);

               }
              
               $con->closeConnection($conn);
           } catch (PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
           }
           return $pacienteList;
        }


      public function getCdTriagemAtendimento($atendimento){

          require_once 'ConnectionFactory.class.php';
          $codigo = 0;
          $con = new ConnectionFactory();
          $conn = $con->getConnection();

          $query = "SELECT * FROM TRIAGEM_ATENDIMENTO A 
                   WHERE A.CD_ATENDIMENTO = :atendimento";

          try{
              $statement = oci_parse($conn, $query);
              //print_r($sql_text);
              oci_bind_by_name($statement, ':atendimento', $atendimento);

              oci_execute($statement);
              if($row = oci_fetch_array($statement, OCI_ASSOC)){
                  $codigo = $row['CD_TRIAGEM_ATENDIMENTO'];
              }
          }catch (PDOException $exception){
              echo "Erro: ".$exception->getMessage();
          }
            return $codigo;
     }

     public function chamarPaciente($maquina,$atendimento, $triagem){
         require_once 'ConnectionFactory.class.php';
         $status = false;
         $con = new ConnectionFactory();
         $conn = $con->getConnection();
         //echo "Maquina: $maquina";
         $parametro = "<cdmultiempresa>1</cdmultiempresa><cdatendimento>$atendimento</cdatendimento><nmmaquina>$maquina</nmmaquina><tptempoprocesso>30</tptempoprocesso><nmusuario>DBAMV</nmusuario><cdtriagematendimento>$triagem</cdtriagematendimento>";

         $query = "DECLARE

                    parametro VARCHAR2(4000) ;
                    
                    
                     BEGIN
                        parametro := '$parametro';
                        prc_realiza_chamada_painel(parametro) ;
                    
                    END;";
         try{
             $statement = oci_parse($conn, $query);



             oci_execute($statement);
             $status = true;
         }catch (PDOException $exception){
             echo "Erro: ".$exception->getMessage();
         }

         return $status;

     }

    public function getNrChamada($atendimento){

        require_once 'ConnectionFactoryAdv.class.php';
        $codigo = 0;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "SELECT C.NR_CHAMADA FROM DBAADV.CONSULTORIO_CHAMADA C
                    WHERE C.CD_ATENDIMENTO = :atendimento";

        try{
            $statement = oci_parse($conn, $query);
            //print_r($sql_text);
            oci_bind_by_name($statement, ':atendimento', $atendimento);

            oci_execute($statement);
            if($row = oci_fetch_array($statement, OCI_ASSOC)){
                $codigo = $row['NR_CHAMADA'];
            }
        }catch (PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $codigo;
    }

    public function insertNrChamada($atendimento){

        require_once 'ConnectionFactoryAdv.class.php';
        $codigo = 0;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "INSERT INTO DBAADV.CONSULTORIO_CHAMADA  (CD_ATENDIMENTO, NR_CHAMADA)
                  VALUES
                    (:atendimento, 1)";

        try{
            $statement = oci_parse($conn, $query);
            //print_r($sql_text);
            oci_bind_by_name($statement, ':atendimento', $atendimento);

            oci_execute($statement);
         //   if($row = oci_fetch_array($statement, OCI_ASSOC)){
            //    $codigo = $row['NR_CHAMADA'];
          //  }
        }catch (PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $codigo;
    }

    public function updateNrChamada($atendimento, $chamada){

        require_once 'ConnectionFactoryAdv.class.php';
        $codigo = 0;
        $con = new ConnectionFactory();
        $conn = $con->getConnection();

        $query = "UPDATE DBAADV.CONSULTORIO_CHAMADA  SET NR_CHAMADA = :chamada 
                    WHERE  CD_ATENDIMENTO = :atendimento";

        try{
            $statement = oci_parse($conn, $query);
            //print_r($sql_text);
            oci_bind_by_name($statement, ':atendimento', $atendimento);
            oci_bind_by_name($statement, ':chamada', $chamada);
            oci_execute($statement);
            //if($row = oci_fetch_array($statement, OCI_ASSOC)){
                //$codigo = $row['NR_CHAMADA'];
            //}
        }catch (PDOException $exception){
            echo "Erro: ".$exception->getMessage();
        }
        return $codigo;
    }




} //fim daclasse