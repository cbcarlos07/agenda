<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuario_DAO{
    
    public function recuperarEmpresa ($user){
         require_once  'ConnectionFactory.class.php';
         $conn = new ConnectionFactory();   
         $conexao = $conn->getConnection();
         $i = "";
         $sql_text = "SELECT  
                        E.DS_MULTI_EMPRESA EMPRESA  
                      FROM   
                      DBASGU.USUARIOS                  U  
                      ,DBAMV.USUARIO_MULTI_EMPRESA     M  
                      ,DBAMV.MULTI_EMPRESAS            E  
                      WHERE  
                           U.CD_USUARIO = :NAME  
                      AND  U.CD_USUARIO = M.CD_ID_USUARIO ";
         try {
           $stmt = oci_parse($conexao, $sql_text);    
           //echo "Variavel use $user";
           oci_bind_by_name($stmt, ":NAME", $user);
           oci_execute($stmt);
           if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                $i = $row['EMPRESA']; 
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
           echo " Erro: ".$ex->getMessage();
        }
        return $i;
    }
    
    
    public function recuperarSenha ($user)
    {
        require_once 'ConnectionFactory.class.php';
        $conn = new ConnectionFactory();
        $conexao = $conn->getConnection();
        $i = "NAO";
        $sql_text = "select dbaadv.senhausuariomv(:USERNAME)  SENHA FROM DUAL";
        try {
            $stmt = oci_parse($conexao, $sql_text);
            oci_bind_by_name($stmt, ":USERNAME", $user);
            oci_execute($stmt);
            if ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                $i = $row['SENHA'];
            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: " . $ex->getMessage();
        }
        return $i;
    }

        public function verificarPapel ($login){
            //    System.out.println("DAO");
            $teste = false;
            $conn = new ConnectionFactory();
            $conexao = $conn->getConnection();
        try {
            $sql_text = "SELECT * FROM V_TI_PAPEL V WHERE V.USUARIO  = :LOGIN";


            $stmt =  oci_parse($conexao, $sql_text);
            oci_bind_by_name($stmt, ":LOGIN", $login);
            oci_execute($stmt);
            if($row = oci_fetch_array($stmt, OCI_ASSOC)){

                $teste = true;

            }
            $conn->closeConnection($conexao);
        } catch (PDOException $ex) {
            echo " Erro: ".$ex->getMessage();
        }

        return $teste;
    }
}