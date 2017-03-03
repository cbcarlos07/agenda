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
               $sql_text = "
SELECT IND
      ,A.HR_AGENDA
      ,A.PACIENTE
      ,A.DS_OBSERVACAO_GERAL
      ,A.IDADE
      ,A.HR_ATENDIMENTO
      ,A.SIT
      ,A.PRIORIDADE
      ,A.DS_SENHA
      ,A.ESPERA
      ,DBAMV.FNC_CONVERTE_DIA_HR(A.MEDIA2+((1/24)/60)) MEDIA2
      ,TO_CHAR((A.MAIOR_ATD_MEDICO)+(A.MEDIA2*(B.ORD)),'HH24:MI') PREVISAO
      ,CASE
        WHEN A.ALTA IS NULL AND A.ATD_MEDICO IS NOT NULL
          THEN 'EM ATENDIMENTO'
        WHEN A.ALTA IS NULL AND A.ATD_MEDICO IS NULL
          THEN  TO_CHAR(B.ORD-1)
        ELSE 'ATENDIDO'
       END ORDEM
  FROM (
  
          SELECT IND
                ,A.HR_AGENDA
                ,A.PACIENTE
                ,A.CD_PACIENTE
                ,A.DS_OBSERVACAO_GERAL
                ,A.IDADE
                ,A.HR_ATENDIMENTO
                ,CASE
                   WHEN TRUNC(DT_REALIZACAO) >= A.DT_ATENDIMENTO-10
                     THEN 'PÓS OP'
                   WHEN SN_RETORNO = 'S'
                     THEN 'RETORNO'
                   WHEN SN_RETORNO = 'N'
                     THEN 'CONSULTA'
                  END SIT
                 ,PRIORIDADE
                 ,DS_SENHA
                 ,ESPERA
                 ,MEDIA2
                 ,ATD_MEDICO
                 ,COD_ATD
                 ,ALTA
                 ,MAIOR_ATD_MEDICO
            FROM (
                  SELECT ROWNUM-1 IND
                        ,A.HR_AGENDA
                        ,A.PACIENTE
                        ,A.CD_PACIENTE
                        ,A.DS_OBSERVACAO_GERAL
                        ,A.IDADE
                        ,A.HR_ATENDIMENTO
                        ,PRIORIDADE
                        ,DS_SENHA
                        ,ESPERA
                        ,ALTA
                        ,A.COD_ATD
                        ,SN_RETORNO
                        ,DT_ATENDIMENTO
                        ,ATD_MEDICO
                        ,DT_REALIZACAO
                        
                    FROM (
                          SELECT TO_CHAR(AC.HR_INICIO,'HH24:MI:SS') HR_AGENDA
                                ,P.NM_PACIENTE PACIENTE
                                ,P.CD_PACIENTE
                                ,to_number((REGEXP_SUBSTR(Fnc_Editor_Retorna_Metadados(A.CD_ATENDIMENTO,'NR_IDADE_PACIENTE'),'[^/ ]+',1,1)),'999999')||' ano(s)' idade
                                ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO
                                ,CASE
                                   WHEN MIN(DC.DH_CRIACAO) IS NULL
                                     THEN DBAMV.FNC_CONVERTE_DIA_HR2(SYSDATE - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))
                                 ELSE DBAMV.FNC_CONVERTE_DIA_HR2(MIN(DH_CRIACAO) - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))             
                                 END ESPERA
                                ,MIN(DC.DH_CRIACAO)                                                 ATD_MEDICO
                                ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA)               ALTA
                                ,IAC.DS_OBSERVACAO_GERAL
                                ,A.SN_RETORNO
                                ,A.DT_ATENDIMENTO
                                ,'PRIORIDADE' PRIORIDADE
                                ,TA.DS_SENHA
                                ,A.CD_ATENDIMENTO COD_ATD
                                ,MAX(DT_REALIZACAO) DT_REALIZACAO
                                ,a.cd_prestador
                            FROM DBAMV.IT_AGENDA_CENTRAL IAC
                                ,DBAMV.AGENDA_CENTRAL     AC
                                ,ATENDIME                 A
                                ,DBAMV.PW_DOCUMENTO_CLINICO DC
                                ,TRIAGEM_ATENDIMENTO TA
                                ,PACIENTE            P
                                ,DBAMV.AVISO_CIRURGIA AV
                           WHERE IAC.CD_ATENDIMENTO(+)    = A.CD_ATENDIMENTO
                             AND IAC.CD_AGENDA_CENTRAL    = AC.CD_AGENDA_CENTRAL(+)
                             AND A.CD_ATENDIMENTO         = DC.CD_ATENDIMENTO(+)
                             AND A.CD_ATENDIMENTO         = TA.CD_ATENDIMENTO(+)
                             AND A.CD_PACIENTE            = P.CD_PACIENTE
                             AND AV.CD_PACIENTE(+)        = P.CD_PACIENTE
                             AND A.TP_ATENDIMENTO = 'A'
                             AND A.CD_PRESTADOR = :MEDICO
                             AND TA.SN_PRIORIDADE_ESPECIAL = 'S'
                             AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))

                        GROUP BY P.NM_PACIENTE
                                ,A.CD_ATENDIMENTO
                                ,A.HR_ATENDIMENTO
                                ,A.DT_ATENDIMENTO
                                ,A.DT_ALTA
                                ,A.HR_ALTA
                                ,AC.HR_INICIO
                                ,P.CD_PACIENTE
                                ,IAC.DS_OBSERVACAO_GERAL
                                ,A.SN_RETORNO
                                ,TA.DS_SENHA
                                ,A.CD_ATENDIMENTO
                                ,a.cd_prestador
                        ORDER BY 5
                           ) A 


            UNION





                SELECT   ROWNUM IND
                        ,A.HR_AGENDA
                        ,A.PACIENTE
                        ,A.CD_PACIENTE
                        ,A.DS_OBSERVACAO_GERAL
                        ,A.IDADE
                        ,A.HR_ATENDIMENTO
                        ,PRIORIDADE
                        ,DS_SENHA
                        ,ESPERA
                        ,ALTA
                        ,A.COD_ATD
                        ,SN_RETORNO
                        ,DT_ATENDIMENTO
                        ,ATD_MEDICO
                        ,DT_REALIZACAO

                 FROM (
                        SELECT TO_CHAR(AC.HR_INICIO,'HH24:MI:SS') HR_AGENDA
                            ,P.NM_PACIENTE PACIENTE
                            ,P.CD_PACIENTE
                            ,to_number((REGEXP_SUBSTR(Fnc_Editor_Retorna_Metadados(A.CD_ATENDIMENTO,'NR_IDADE_PACIENTE'),'[^/ ]+',1,1)),'999999')||' ano(s)' idade
                            ,TO_CHAR(A.HR_ATENDIMENTO,'HH24:MI:SS') HR_ATENDIMENTO

                            ,CASE
                               WHEN MIN(DC.DH_CRIACAO) IS NULL
                                 THEN DBAMV.FNC_CONVERTE_DIA_HR2(SYSDATE - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))

                             ELSE DBAMV.FNC_CONVERTE_DIA_HR2(MIN(DH_CRIACAO) - DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ATENDIMENTO,A.HR_ATENDIMENTO))             
                             END ESPERA
                            ,MIN(DC.DH_CRIACAO)                                                 ATD_MEDICO
                            ,DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA)               ALTA
                            ,IAC.DS_OBSERVACAO_GERAL
                            ,A.SN_RETORNO
                            ,A.DT_ATENDIMENTO
                            ,'NORMAL' PRIORIDADE
                            ,TA.DS_SENHA
                            ,A.CD_ATENDIMENTO COD_ATD
                            ,MAX(DT_REALIZACAO) DT_REALIZACAO
                        FROM DBAMV.IT_AGENDA_CENTRAL IAC
                            ,DBAMV.AGENDA_CENTRAL     AC
                            ,ATENDIME                 A
                            ,DBAMV.PW_DOCUMENTO_CLINICO DC
                            ,TRIAGEM_ATENDIMENTO TA
                            ,PACIENTE P
                            ,DBAMV.AVISO_CIRURGIA AV
                       WHERE IAC.CD_ATENDIMENTO(+)    = A.CD_ATENDIMENTO
                         AND IAC.CD_AGENDA_CENTRAL    = AC.CD_AGENDA_CENTRAL(+)
                         AND A.CD_ATENDIMENTO         = DC.CD_ATENDIMENTO(+)
                         AND A.CD_ATENDIMENTO         = TA.CD_ATENDIMENTO(+)
                         AND A.CD_PACIENTE            = P.CD_PACIENTE
                         AND AV.CD_PACIENTE(+)        = P.CD_PACIENTE
                         AND A.TP_ATENDIMENTO = 'A'
                         AND A.CD_PRESTADOR = :MEDICO
                         AND (TA.SN_PRIORIDADE_ESPECIAL = 'N' OR TA.DS_SENHA IS NULL)
                         AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))

                    GROUP BY P.NM_PACIENTE
                            ,A.CD_ATENDIMENTO
                            ,A.HR_ATENDIMENTO
                            ,A.DT_ATENDIMENTO
                            ,A.DT_ALTA
                            ,A.HR_ALTA
                            ,AC.HR_INICIO
                            ,P.CD_PACIENTE
                            ,IAC.DS_OBSERVACAO_GERAL
                            ,A.SN_RETORNO
                            ,TA.DS_SENHA
                            ,A.CD_ATENDIMENTO
					ORDER BY 5
                       ) A -- ATENDIMENTOS NÃO AGENDADOS
                     ORDER BY 1,7
              ) A -- ATENDIMENTOS NO AMBULATÓRIO
             
           ,

             (
                SELECT (MAX(ALTA)-MIN(ATD_MEDICO))/SUM(ATD) MEDIA2
                    ,DBAMV.FNC_CONVERTE_DIA_HR(MAX(ALTA)-MIN(ATD_MEDICO))
                    ,MAX(ATD_MEDICO) MAIOR_ATD_MEDICO
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
                        FROM ATENDIME                 A
                            ,DBAMV.PW_DOCUMENTO_CLINICO DC
                            ,PACIENTE                  P
                       WHERE A.CD_PRESTADOR        = DC.CD_PRESTADOR
                         AND A.CD_ATENDIMENTO      = DC.CD_ATENDIMENTO(+)
                         AND A.CD_PACIENTE         = P.CD_PACIENTE
                         AND A.TP_ATENDIMENTO = 'A'
                         AND A.CD_PRESTADOR = :MEDICO
                         AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                         GROUP BY (DBAMV.FNC_MV_RECUPERA_DATA_HORA(A.DT_ALTA,A.HR_ALTA))
                                 ,P.NM_PACIENTE,A.DT_ALTA
                      )   

               ) C -- MÉDIA DE ATENDIMENTO DO MÉDICO

            

                  
                
     ) A  -- ATENDIMENTOS
 
,

    (
      SELECT ind ind1
            ,PRIORIDADE
            ,DS_SENHA
            ,COD_ATD
            ,hr_atendimento
            ,ROWNUM 
            ,ROWNUM ORD
            
        FROM (
               SELECT 
                     ROWNUM-1 ind
                    ,'PRIORIDADE' PRIORIDADE
                    ,TA.DS_SENHA
                    ,A.CD_ATENDIMENTO COD_ATD
                    ,hr_atendimento
                FROM ATENDIME                 A
                             LEFT JOIN  DBAMV.PW_DOCUMENTO_CLINICO DC ON DC.CD_ATENDIMENTO = A.CD_ATENDIMENTO
                             LEFT JOIN  TRIAGEM_ATENDIMENTO TA ON TA.CD_ATENDIMENTO = A.CD_ATENDIMENTO
               WHERE A.TP_ATENDIMENTO = 'A'
                 AND A.CD_PRESTADOR = :MEDICO
                 AND TA.SN_PRIORIDADE_ESPECIAL = 'S'
                 AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                 AND DC.DH_CRIACAO IS NULL
                 AND A.DT_ALTA IS NULL
                 
UNION

              SELECT ROWNUM IND
                    ,PRIORIDADE
                    ,DS_SENHA
                    ,COD_ATD
                    ,hr_atendimento
                 FROM (
                        SELECT 'NORMAL' PRIORIDADE
                            ,TA.DS_SENHA
                            ,A.CD_ATENDIMENTO COD_ATD
                            ,a.hr_atendimento
                        FROM ATENDIME                 A
                             LEFT JOIN  DBAMV.PW_DOCUMENTO_CLINICO DC ON DC.CD_ATENDIMENTO = A.CD_ATENDIMENTO
                             LEFT JOIN  TRIAGEM_ATENDIMENTO TA ON TA.CD_ATENDIMENTO = A.CD_ATENDIMENTO
                       WHERE A.TP_ATENDIMENTO = 'A'
                         AND A.CD_PRESTADOR = :MEDICO
                         AND (TA.SN_PRIORIDADE_ESPECIAL = 'N' OR TA.DS_SENHA IS NULL)
                         AND to_char(A.DT_ATENDIMENTO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                         AND DC.DH_CRIACAO IS NULL
                         AND A.DT_ALTA IS NULL
                       order by 4
                       ) A -- EXIBE OS PACIENTES COM ATENDIMENTO 

                   ORDER BY 1,2 desc
                 ) A                   
      ) B -- ORDEM DE CHAMADA


  WHERE A.COD_ATD = B.COD_ATD(+) ";
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
				   $paciente->setMedia($media);
                   
                   $pacienteList->addPaciente($paciente);
               }
              
               $con->closeConnection($conn);
           } catch (PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
           }
           return $pacienteList;
        }

} //fim daclasse