<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Paciente_DAO{
        
       public function lista($data, $medico){
           require_once 'beans/Paciente.class.php';
           include 'ConnectionFactory.class.php';
           include '/servicos/PacienteList.class.php';
           $con = new ConnectionFactory();
           $conn = $con->getConnection();
           
           $pacienteList = new PacienteList();
          // echo "Data $data";
           try{
               $sql_text = "
                             SELECT A.IND
                                                        ,A.HR_AGENDA
                                                        ,A.DS_OBSERVACAO_GERAL
                                                        ,A.PACIENTE
                                                        ,A.IDADE
                                                        ,A.HR_ATENDIMENTO
                                                        ,CASE
                                                           WHEN TRUNC(D.DT_REALIZACAO) >= A.DT_ATENDIMENTO-10
                                                             THEN 'PÓS OP'
                                                           WHEN SN_RETORNO = 'S'
                                                             THEN 'RETORNO'
                                                           WHEN SN_RETORNO = 'N'
                                                             THEN 'CONSULTA'
                                                         END SIT
                                                        ,PRIORIDADE
                                                        ,DS_SENHA
                                                       -- ,D.DT_REALIZACAO
                                                        ,ESPERA
                                                        ,MEDIA
                                                        ,TO_CHAR((MAIOR_ATD_MEDICO)+(MEDIA2*(B.NUM+1)),'HH24:MI') PREVISAO
                                                  /*      ,CASE
                                                           WHEN ((MAIOR_ATD_MEDICO)+(MEDIA2*(B.NUM+1)))-sysdate >= 0 OR A.ALTA IS NOT NULL
                                                             THEN dbamv.fnc_converte_dia_hr(((MAIOR_ATD_MEDICO)+(MEDIA2*(B.NUM+1)))-sysdate)
                                                           ELSE 'FORA DA PREVISAO'
                                                         END PREVISAO*/

                                                        ,CASE
                                                          WHEN A.ALTA IS NULL AND A.ATD_MEDICO IS NOT NULL
                                                            THEN 'EM ATENDIMENTO'
                                                          WHEN A.ALTA IS NULL AND A.ATD_MEDICO IS NULL
                                                            THEN  TO_CHAR(B.NUM)
                                                          ELSE 'ATENDIDO'
                                                         END ORDEM

                                                    FROM (
                                                            SELECT 3 IND
                                                                ,TO_CHAR(AC.HR_INICIO,'HH24:MI:SS') HR_AGENDA
                                                                ,IAC.NM_PACIENTE PACIENTE
                                                                ,IAC.CD_PACIENTE
                                                                ,to_number((REGEXP_SUBSTR(Fnc_Editor_Retorna_Metadados(A.CD_ATENDIMENTO,'NR_IDADE_PACIENTE'),'[^/ ]+',1,1)),'999999')||' ano(s)' idade
                                                                ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO

                                                                ,CASE
                                                                   WHEN MIN(DC.DH_CRIACAO) IS NULL
                                                                     THEN DBAMV.FNC_CONVERTE_DIA_HR2(SYSDATE - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))

                                                                 ELSE DBAMV.FNC_CONVERTE_DIA_HR2(MIN(DH_CRIACAO) - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))             
                                                                 END ESPERA

                                                                ,SYSDATE                                                            AGOORA
                                                                ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO) ATENDIMENTO
                                                                ,MIN(DC.DH_CRIACAO)                                                 ATD_MEDICO
                                                                ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA)               ALTA
                                                                ,IAC.DS_OBSERVACAO_GERAL
                                                                ,A.SN_RETORNO
                                                                ,A.DT_ATENDIMENTO
                                                                ,CASE
                                                                    WHEN TA.DS_SENHA LIKE '%P%'
                                                                      THEN 'PRIORIDADE'
                                                                    WHEN TA.DS_SENHA IS NULL
                                                                      THEN 'SEM SENHA'
                                                                    ELSE 'NORMAL'
                                                                 END PRIORIDADE
                                                                ,TA.DS_SENHA
                                                            FROM DBAMV.IT_AGENDA_CENTRAL IAC
                                                                ,DBAMV.AGENDA_CENTRAL     AC
                                                                ,ATENDIME                 A
                                                                ,DBAMV.PW_DOCUMENTO_CLINICO DC
                                                                ,TRIAGEM_ATENDIMENTO TA
                                                           WHERE IAC.CD_ATENDIMENTO       = A.CD_ATENDIMENTO
                                                             AND IAC.CD_AGENDA_CENTRAL    = AC.CD_AGENDA_CENTRAL
                                                             AND A.CD_ATENDIMENTO         = DC.CD_ATENDIMENTO(+)
                                                             AND A.CD_ATENDIMENTO         = TA.CD_ATENDIMENTO(+)
                                                             AND AC.TP_AGENDA = 'A'
                                                             AND AC.CD_PRESTADOR = :MEDICO
                                                             AND to_char(AC.DT_AGENDA,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                             AND IAC.CD_PACIENTE IS NOT NULL

                                                        GROUP BY IAC.NM_PACIENTE
                                                                ,A.CD_ATENDIMENTO
                                                                ,A.HR_ATENDIMENTO
                                                                ,A.DT_ATENDIMENTO
                                                                ,A.DT_ALTA
                                                                ,A.HR_ALTA
                                                                ,AC.HR_INICIO
                                                                ,IAC.CD_PACIENTE
                                                                ,IAC.DS_OBSERVACAO_GERAL
                                                                ,A.SN_RETORNO
                                                                ,TA.DS_SENHA


                                                             UNION




                                                           -- NÃO AGENDADO 
                                                          SELECT 4 IND
                                                                ,'NÃO AGENDADO'
                                                                ,P.NM_PACIENTE
                                                                ,P.CD_PACIENTE
                                                                ,to_number((REGEXP_SUBSTR(Fnc_Editor_Retorna_Metadados(A.CD_ATENDIMENTO,'NR_IDADE_PACIENTE'),'[^/ ]+',1,1)),'999999')||' ano(s)' idade
                                                                ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO

                                                                ,CASE
                                                                   WHEN MIN(DC.DH_CRIACAO) IS NULL
                                                                     THEN DBAMV.FNC_CONVERTE_DIA_HR2(SYSDATE - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))

                                                                 ELSE DBAMV.FNC_CONVERTE_DIA_HR2(MIN(DH_CRIACAO) - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))


                                                                 END ESPERA
                                                                 ,MIN(DH_CRIACAO)
                                                                ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO) ATENDIMENTO
                                                                ,MIN(DC.DH_CRIACAO)
                                                                ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA)               ALTA
                                                                ,NULL
                                                                ,A.SN_RETORNO
                                                                ,A.DT_ATENDIMENTO
                                                                ,CASE
                                                                    WHEN TA.DS_SENHA LIKE '%P%'
                                                                      THEN 'PRIORIDADE'
                                                                    WHEN TA.DS_SENHA IS NULL
                                                                      THEN 'SEM SENHA'
                                                                    ELSE 'NORMAL'
                                                                 END PRIORIDADE
                                                                ,TA.DS_SENHA
                                                            FROM ATENDIME A
                                                                ,PACIENTE P
                                                                ,PW_DOCUMENTO_CLINICO DC
                                                                ,TRIAGEM_ATENDIMENTO TA
                                                           WHERE A.CD_ATENDIMENTO = DC.CD_ATENDIMENTO(+)
                                                             AND A.CD_ATENDIMENTO = TA.CD_ATENDIMENTO(+)
                                                             AND A.CD_PACIENTE    = P.CD_PACIENTE
                                                             AND to_char( A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                             AND A.TP_ATENDIMENTO = 'A'
                                                             AND A.CD_PRESTADOR = :MEDICO
                                                             AND A.CD_DES_ATE IS NOT NULL
                                                        GROUP BY P.NM_PACIENTE
                                                                ,P.CD_PACIENTE
                                                                ,A.CD_ATENDIMENTO
                                                                ,A.HR_ATENDIMENTO
                                                                ,A.DT_ATENDIMENTO
                                                                ,A.DT_ALTA
                                                                ,A.HR_ALTA
                                                                ,A.SN_RETORNO
                                                                ,TA.DS_SENHA

                                                        ORDER BY 1,2,5
                                                         ) A -- EXIBE OS PACIENTES COM ATENDIMENTO 




                                                       ,(
                                                          SELECT IND
                                                                ,HR_AGENDA
                                                                ,PACIENTE
                                                                ,HR_ATENDIMENTO
                                                                ,ATD_MEDICO
                                                                ,CD_PACIENTE
                                                                ,ROWNUM-1 NUM
                                                           FROM (
                                                                  SELECT 3 IND
                                                                        ,TO_CHAR(AC.HR_INICIO,'HH24:MI:SS') HR_AGENDA
                                                                        ,IAC.NM_PACIENTE PACIENTE
                                                                        ,IAC.CD_PACIENTE
                                                                        ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO
                                                                        ,MIN(DC.DH_CRIACAO)                     ATD_MEDICO
                                                                    FROM DBAMV.IT_AGENDA_CENTRAL IAC
                                                                        ,DBAMV.AGENDA_CENTRAL     AC
                                                                        ,ATENDIME                 A
                                                                        ,DBAMV.PW_DOCUMENTO_CLINICO DC
                                                                   WHERE IAC.CD_ATENDIMENTO    = A.CD_ATENDIMENTO
                                                                     AND IAC.CD_AGENDA_CENTRAL = AC.CD_AGENDA_CENTRAL
                                                                     AND A.CD_ATENDIMENTO      = DC.CD_ATENDIMENTO(+)
                                                                     AND AC.TP_AGENDA = 'A'
                                                                     AND AC.CD_PRESTADOR = :MEDICO
                                                                     AND to_char(AC.DT_AGENDA,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                                     AND IAC.CD_PACIENTE IS NOT NULL
                                                                     AND DC.DH_CRIACAO IS NULL
                                                                     AND A.DT_ALTA IS NULL
                                                                GROUP BY AC.HR_INICIO
                                                                        ,IAC.NM_PACIENTE
                                                                        ,IAC.CD_PACIENTE
                                                                        ,A.HR_ATENDIMENTO


                                                                  UNION



                                                                -- NÃO AGENDADO 
                                                                SELECT 3 IND
                                                                      ,null
                                                                      ,P.NM_PACIENTE
                                                                      ,P.CD_PACIENTE
                                                                      ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO
                                                                      ,MIN(DH_CRIACAO)

                                                                  FROM ATENDIME A
                                                                      ,PACIENTE P
                                                                      ,PW_DOCUMENTO_CLINICO DC
                                                                 WHERE A.CD_ATENDIMENTO = DC.CD_ATENDIMENTO(+)
                                                                   AND A.CD_PACIENTE    = P.CD_PACIENTE
                                                                   AND to_char( A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                                   AND A.TP_ATENDIMENTO = 'A'
                                                                   AND A.CD_PRESTADOR = :MEDICO
                                                                   AND P.CD_PACIENTE IS NOT NULL
                                                                   AND A.CD_DES_ATE IS NOT NULL
                                                                   AND (DH_CRIACAO) IS NULL
                                                              GROUP BY P.NM_PACIENTE
                                                                      ,P.CD_PACIENTE
                                                                      ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS')
                                                              ORDER BY 1,5
                                                                ) 

                                                     ORDER BY 1,2,4 


                                                        ) B -- EXIBE A ORDEM DE ATEDIMENTO DO PACIENTE

                                                        ,

                                                        (


                                                          SELECT DBAMV.FNC_CONVERTE_DIA_HR((MAX(ALTA)-MIN(ATD_MEDICO))/SUM(ATD)+((1/60)/24)) MEDIA
                                                              ,(MAX(ALTA)-MIN(ATD_MEDICO))/SUM(ATD) MEDIA2
                                                              ,DBAMV.FNC_CONVERTE_DIA_HR(MAX(ALTA)-MIN(ATD_MEDICO))
                                                              ,MAX(ATD_MEDICO) MAIOR_ATD_MEDICO
                                                              ,MIN(ATD_MEDICO)
                                                              ,MAX(ALTA)
                                                              ,SUM(ATD)
                                                          FROM (      

                                                                SELECT 
                                                                       MIN(DC.DH_CRIACAO) ATD_MEDICO
                                                                      ,(DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA))               ALTA
                                                                      ,P.NM_PACIENTE PACIENTE
                                                                      ,CASE 
                                                                          WHEN A.DT_ALTA IS NULL
                                                                             THEN 0
                                                                          ELSE 1
                                                                       END ATD
                                                                  FROM DBAMV.IT_AGENDA_CENTRAL IAC
                                                                      ,DBAMV.AGENDA_CENTRAL     AC
                                                                      ,ATENDIME                 A
                                                                      ,DBAMV.PW_DOCUMENTO_CLINICO DC
                                                                      ,PACIENTE                  P
                                                                 WHERE IAC.CD_ATENDIMENTO    = A.CD_ATENDIMENTO
                                                                   AND IAC.CD_AGENDA_CENTRAL = AC.CD_AGENDA_CENTRAL
                                                                   AND A.CD_PRESTADOR        = DC.CD_PRESTADOR
                                                                   AND A.CD_ATENDIMENTO      = DC.CD_ATENDIMENTO(+)
                                                                   AND A.CD_PACIENTE         = P.CD_PACIENTE
                                                                   AND AC.TP_AGENDA = 'A'
                                                                   AND AC.CD_PRESTADOR = :MEDICO
                                                                   AND to_char(AC.DT_AGENDA,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                                   AND IAC.CD_PACIENTE IS NOT NULL
                                                                --   AND A.DT_ALTA IS NOT NULL
                                                                   GROUP BY (DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA))
                                                                           ,P.NM_PACIENTE,A.DT_ALTA


                                                                UNION


                                                                -- NÃO AGENDADO 
                                                               SELECT  ATD_MEDICO
                                                                      ,ALTA
                                                                      ,PACIENTE
                                                                      ,CASE 
                                                                          WHEN DT_ALTA IS NULL
                                                                             THEN 0
                                                                          ELSE 1
                                                                       END ATD
                                                                 FROM (
                                                                SELECT MIN(DH_CRIACAO) ATD_MEDICO
                                                                      ,(DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA)) ALTA
                                                                      ,P.NM_PACIENTE PACIENTE
                                                                      ,A.DT_ALTA
                                                                  FROM ATENDIME A
                                                                      ,PACIENTE P
                                                                      ,PW_DOCUMENTO_CLINICO DC
                                                                 WHERE A.CD_ATENDIMENTO = DC.CD_ATENDIMENTO(+)
                                                                   AND A.CD_PACIENTE    = P.CD_PACIENTE
                                                                   AND to_char( A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                                                   AND A.TP_ATENDIMENTO = 'A'
                                                                   AND A.CD_PRESTADOR = :MEDICO
                                                                   AND P.CD_PACIENTE IS NOT NULL
                                                                   AND A.CD_DES_ATE IS NOT NULL
                                                                 --  AND A.DT_ALTA IS NOT NULL

                                                              GROUP BY (DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA))
                                                                      ,P.NM_PACIENTE,A.DT_ALTA
                                                                     )


                                                             )   

                                                                ORDER BY 1
                                                        ) C -- EXIBE O TEMPO MÉDIO DE ATENDIMENTO DO MÉDICO.

                                                     ,(
                                                        SELECT MAX(DT_REALIZACAO) DT_REALIZACAO, CD_PACIENTE
                                                          FROM DBAMV.AVISO_CIRURGIA
                                                      GROUP BY CD_PACIENTE
                                                     ) D



                                                   WHERE A.CD_PACIENTE = B.CD_PACIENTE(+)
                                                     AND A.CD_PACIENTE = D.CD_PACIENTE(+)
                                                   ORDER BY 1,2,6
                                                   ";
               //AND to_char(SO.DT_EXECUCAO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
               $statement = oci_parse($conn, $sql_text);
               //print_r($sql_text);
               oci_bind_by_name($statement, ':DATA', $data);
               oci_bind_by_name($statement, ':MEDICO', $medico);
               
               oci_execute($statement);
               while($row = oci_fetch_array($statement, OCI_ASSOC)){
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
                   
                   if(isset($row['MEDIA'])){
                       $media = $row['MEDIA'];
                   }else{
                       $media = 'AGURDANDO ATENDIMENTO';
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
                   
                   $pacienteList->addPaciente($paciente);
               }
              
               $con->closeConnection($conn);
           } catch (PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
           }
           return $pacienteList;
        }

} //fim daclasse