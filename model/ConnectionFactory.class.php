<?php   
class ConnectionFactory{
    private $ora_user = "dbamv";
    private $ora_senha = "dbamvsml";
    private $ora_bd = "(DESCRIPTION=
                        (ADDRESS_LIST=
                        (ADDRESS=(PROTOCOL=TCP)(HOST=10.51.26.63)(PORT=1521))
                        )
                        (CONNECT_DATA=
                        (SERVICE_NAME=smlmv)
                        )
                        )"; 
    public  function  getConnection(){
            putenv("NLS_LANG=PORTUGUESE_BRAZIL.AL32UTF8") or die("Falha ao inserir a variavel de ambiente");
            $ora_conexao = oci_connect($this->ora_user, $this->ora_senha, $this->ora_bd);
        return $ora_conexao;
                    
    }
    
    public function closeConnection($connection){
        $ora_conexao = oci_close($connection);
        
    }
    

}

?>