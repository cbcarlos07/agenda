<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prestadores_DAO{
        
       public function lista($nome){
           require_once 'beans/Prestadores.class.php';
           include 'ConnectionFactory.class.php';
           include '/servicos/PrestadorList.class.php';
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

} //fim daclasse