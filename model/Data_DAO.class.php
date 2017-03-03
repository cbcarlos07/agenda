<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Data_DAO{
        
       public function getDataDB(){
           require_once "ConnectionFactory.class.php";
           require_once 'beans/Data.class.php';

           $con = new ConnectionFactory();
           $conn = $con->getConnection();
           
           $data =  null;
           
           try{
               $sql_text = "SELECT TO_CHAR(SYSDATE, 'DD/MM/YYYY') DATA_ FROM DUAL";
               $statement = oci_parse($conn, $sql_text);
               oci_execute($statement);
               if($row = oci_fetch_array($statement, OCI_ASSOC)){
                   $data =  new Data();
                   $data->setData($row['DATA_']);
               }
              
               $con->closeConnection($conn);
           } catch (PDOException $ex) {
                echo "Erro: ".$ex->getMessage();
           }
           return $data;
        }

} //fim daclasse