<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\DB\Sql;

class Usuario extends Model{

    public static function login($login, $password)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM usuario a WHERE a.login = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if(count($results) === 0){
            throw new \Exception("Usuário inexistente ou senha inválida", 1);
        }

        $data = $results[0];

        // if(password_verify($password, $data["senha"]) === true)
        if($password == $data["senha"])
        {
            $user = new Usuario();
            
            //$data['nome'] = utf8_encode($data['nome']);

            $user->setData($data);

            return $user;

        }else{
            throw new \Exception("Usuário inexistente ou senha inválida.", 1);
        }
    }

    public static function listAll($exceto = 0)
    {
        
        $Usuarios = array();

        $sql = new Sql();

        $result = $sql->select(
            "SELECT * 
            FROM usuario a  
            WHERE (:Exceto = 0 || a.idUsuario <> :Exceto)   
            ORDER BY a.nome",
            [
                "Exceto"=>$exceto
            ]
        );

        foreach($result as $usuairo){
            $obj = new Usuario();
            $obj->setData($usuairo);
            array_push($Usuarios, $obj);
        }

        return $Usuarios; 
        
    }

    public function getById($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM usuario u WHERE idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        $this->setData($results[0]);

    }

    public static function getPets($idUsuario)
    {
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM animal a WHERE a.idUsuario = :idUsuario", [
            ":idUsuario"=>$idUsuario
        ]);

        return $results;

    }

    public function save()
	{

		$sql = new Sql();
		
		$results = $sql->select("CALL sp_users_save(:login, :senha, :nome, :sobrenome, :sexo, :nascimento, :cep, :rua, :numero, :bairro, :cidade, :estado, :telefone)", array(
            ":login"=>$this->getlogin(),
            ":senha"=>$this->getsenha(),
            ":nome"=>$this->getnome(),
            ":sobrenome"=>$this->getsobrenome(),
            ":sexo"=>$this->getsexo(),
            ":nascimento"=>$this->getnascimento(),
            ":cep"=>$this->getcep(),
            ":rua"=>$this->getrua(),
            ":numero"=>$this->getnumero(),
            ":bairro"=>$this->getbairro(),
            ":cidade"=>$this->getcidade(),
            ":estado"=>$this->getestado(),
            ":telefone"=>$this->gettelefone()
		));

		$this->setData($results[0]);

	}

}

?>