<?php

namespace PetWorld\Model;

use \PetWorld\Model;
use \PetWorld\Model\Animal;
use \PetWorld\DB\Sql;
use PetWorld\Model\BaseEnum;

class Recomendacao extends Model{

    private static function peso()
    {
        $sql = new Sql();

        return $sql->select(
            "SELECT * " . 
            "FROM peso "
        );
    }

    public static function euclidianaAnimal(Animal $animal1, Animal $animal2)
    {

        if($animal1 == null || $animal2 == null){
            throw new \Exception("Animal inválido para euclidiana", 1);
        }

        $similaridade = 0;

        $pesosAux = Recomendacao::peso();
        $pesos = array();

        foreach ($pesosAux as $value) {
            $pesos[$value["descricao"]] = $value["porcentagem"];
        }

        //                                                  Comparando Espécie
        // ____________________________________________________________________________________________________________________
        $especieAnimal1 = explode(";", $animal1->getespecie());
        $especieAnimal2 = explode(";", $animal2->getespecie());
        // O peso vai ser sempre a maior quantidade de especies
        $pesoEspecie = (count($especieAnimal1) > count($especieAnimal2)) ? count($especieAnimal1) : count($especieAnimal2);

        // Tratar caracteres
        foreach ($especieAnimal1 as $key => $value) {
            $especieAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($especieAnimal2 as $key => $value) {
            $especieAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaEspeciesPeso = 0;
        $MPEspecie = 0;

        for($i = 0; $i < count($especieAnimal2); $i++){
            
            //contains
            if(in_array($especieAnimal2[$i], $especieAnimal1)){
                // Somatório das especies que repetem nos dois pets
                $SomaEspeciesPeso += $pesos["especie"];
            }
            // Aplica o peso na somatória
            $MPEspecie = $SomaEspeciesPeso / $pesoEspecie;
        }

        $similaridade += $MPEspecie;

        //                                                  Comparando Raça
        // ____________________________________________________________________________________________________________________
        $racaAnimal1 = explode(";", $animal1->getraca());
        $racaAnimal2 = explode(";", $animal2->getraca());
        // O peso vai ser sempre a maior quantidade de racas
        $pesoRaca = (count($racaAnimal1) > count($racaAnimal2)) ? count($racaAnimal1) : count($racaAnimal2);

        // Tratar caracteres
        foreach ($racaAnimal1 as $key => $value) {
            $racaAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($racaAnimal2 as $key => $value) {
            $racaAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaRacasPeso = 0;
        $MPRaca = 0;

        for($i = 0; $i < count($racaAnimal2); $i++){
            
            //contains
            if(in_array($racaAnimal2[$i], $racaAnimal1)){
                // Somatório das racas que repetem nos dois pets
                $SomaRacasPeso += $pesos["raca"];
            }
            // Aplica o peso na somatória
            $MPRaca = $SomaRacasPeso / $pesoRaca;
        }

        $similaridade += $MPRaca;

        //                                                  Comparando Sexo
        // ____________________________________________________________________________________________________________________
        $sexoAnimal1 = explode(";", $animal1->getsexo());
        $sexoAnimal2 = explode(";", $animal2->getsexo());
        // O peso vai ser sempre a maior quantidade de sexos
        $pesoSexo = (count($sexoAnimal1) > count($sexoAnimal2)) ? count($sexoAnimal1) : count($sexoAnimal2);

        // Tratar caracteres
        foreach ($sexoAnimal1 as $key => $value) {
            $sexoAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($sexoAnimal2 as $key => $value) {
            $sexoAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaSexosPeso = 0;
        $MPSexo = 0;

        for($i = 0; $i < count($sexoAnimal2); $i++){
            
            //contains
            if(in_array($sexoAnimal2[$i], $sexoAnimal1)){
                // Somatório das sexos que repetem nos dois pets
                $SomaSexosPeso += $pesos["sexo"];
            }
            // Aplica o peso na somatória
            $MPSexo = $SomaSexosPeso / $pesoSexo;
        }

        $similaridade += $MPSexo;

        //                                                  Comparando Cores
        // ____________________________________________________________________________________________________________________
        $coresAnimal1 = explode(";", $animal1->getcor());
        $coresAnimal2 = explode(";", $animal2->getcor());
        // O peso vai ser sempre a maior quantidade de cores
        $pesoCor = (count($coresAnimal1) > count($coresAnimal2)) ? count($coresAnimal1) : count($coresAnimal2);

        // Tratar caracteres
        foreach ($coresAnimal1 as $key => $value) {
            $coresAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($coresAnimal2 as $key => $value) {
            $coresAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaCoresPeso = 0;
        $MPCor = 0;

        for($i = 0; $i < count($coresAnimal2); $i++){
            
            //contains
            if(in_array($coresAnimal2[$i], $coresAnimal1)){
                // Somatório das cores que repetem nos dois pets
                $SomaCoresPeso += $pesos["cor"];
            }
            // Aplica o peso na somatória
            $MPCor = $SomaCoresPeso / $pesoCor;
        }

        $similaridade += $MPCor;

        //                                                  Comparando Porte
        // ____________________________________________________________________________________________________________________
        $porteAnimal1 = explode(";", $animal1->getporte());
        $porteAnimal2 = explode(";", $animal2->getporte());
        // O peso vai ser sempre a maior quantidade de portes
        $pesoPorte = (count($porteAnimal1) > count($porteAnimal2)) ? count($porteAnimal1) : count($porteAnimal2);

        // Tratar caracteres
        foreach ($porteAnimal1 as $key => $value) {
            $porteAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($porteAnimal2 as $key => $value) {
            $porteAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaPortesPeso = 0;
        $MPPorte = 0;

        for($i = 0; $i < count($porteAnimal2); $i++){
            
            //contains
            if(in_array($porteAnimal2[$i], $porteAnimal1)){
                // Somatório das portes que repetem nos dois pets
                $SomaPortesPeso += $pesos["porte"];
            }
            // Aplica o peso na somatória
            $MPPorte = $SomaPortesPeso / $pesoPorte;
        }

        $similaridade += $MPPorte;

        //                                                  Comparando Pelo
        // ____________________________________________________________________________________________________________________
        $peloAnimal1 = explode(";", $animal1->getpelo());
        $peloAnimal2 = explode(";", $animal2->getpelo());
        // O peso vai ser sempre a maior quantidade de pelos
        $pesoPelo = (count($peloAnimal1) > count($peloAnimal2)) ? count($peloAnimal1) : count($peloAnimal2);

        // Tratar caracteres
        foreach ($peloAnimal1 as $key => $value) {
            $peloAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($peloAnimal2 as $key => $value) {
            $peloAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaPelosPeso = 0;
        $MPPelo = 0;

        for($i = 0; $i < count($peloAnimal2); $i++){
            
            //contains
            if(in_array($peloAnimal2[$i], $peloAnimal1)){
                // Somatório das pelos que repetem nos dois pets
                $SomaPelosPeso += $pesos["pelo"];
            }
            // Aplica o peso na somatória
            $MPPelo = $SomaPelosPeso / $pesoPelo;
        }

        $similaridade += $MPPelo;

        //                                                  Comparando Filhote
        // ____________________________________________________________________________________________________________________
        $filhoteAnimal1 = explode(";", $animal1->getfilhote());
        $filhoteAnimal2 = explode(";", $animal2->getfilhote());
        // O peso vai ser sempre a maior quantidade de filhotes
        $pesoFilhote = (count($filhoteAnimal1) > count($filhoteAnimal2)) ? count($filhoteAnimal1) : count($filhoteAnimal2);

        // Tratar caracteres
        foreach ($filhoteAnimal1 as $key => $value) {
            $filhoteAnimal1[$key] = strtolower(removerAcentuacao($value));
        }
        foreach ($filhoteAnimal2 as $key => $value) {
            $filhoteAnimal2[$key] = strtolower(removerAcentuacao($value));
        }

        $SomaFilhotesPeso = 0;
        $MPFilhote = 0;

        for($i = 0; $i < count($filhoteAnimal2); $i++){
            
            //contains
            if(in_array($filhoteAnimal2[$i], $filhoteAnimal1)){
                // Somatório das filhotes que repetem nos dois pets
                $SomaFilhotesPeso += $pesos["filhote"];
            }
            // Aplica o peso na somatória
            $MPFilhote = $SomaFilhotesPeso / $pesoFilhote;
        }

        $similaridade += $MPFilhote;

        return $similaridade/100;
    }

    public static function euclidianaUsuario(Usuario $usuario1, Usuario $usuario2){

        if($usuario1 == null || $usuario2 == null){
            throw new \Exception("Usuário inválido para euclidiana", 1);
        }

        $gosto = new Gosto();

        $animal1 = $gosto->obterAnimalDeAcordoComGostos($usuario1->getidUsuario());
        $animal2 = $gosto->obterAnimalDeAcordoComGostos($usuario2->getidUsuario());

        return self::euclidianaAnimal($animal1, $animal2);
    }

    public function getSimilares($baseEnum, $objeto){

        $similaridade = array();

        if($baseEnum == BaseEnum::Animal){
            // Similaridade de animal

            $idAnimal = $objeto->getidAnimal() ?? 0;
            $Animais = Animal::listAll($idAnimal, true, $objeto->getidUsuario());
            foreach($Animais as $Animal){

                $euclidiana = self::euclidianaAnimal($objeto, $Animal);

                if($euclidiana > 0){
                    array_push( 
                        $similaridade, 
                        array(
                            "Animal" => $Animal->getValues(), 
                            "Nota" => $euclidiana)
                        );
                }
            }

            array_multisort(array_column($similaridade, 'Nota'), SORT_DESC  , $similaridade);
            //rsort($similaridade);

            return $similaridade;

        }else{
            // Similaridade de Pessoas

            $Usuarios = Usuario::listAll($objeto->getidUsuario());
            foreach($Usuarios as $Usuario){

                $euclidiana = self::euclidianaUsuario($objeto, $Usuario);

                if($euclidiana > 0){
                    array_push( 
                        $similaridade, 
                        array(
                            "Usuario" => $Usuario->getValues(), 
                            "Nota" => $euclidiana)
                        );
                }
            }

            array_multisort(array_column($similaridade, 'Nota'), SORT_DESC  , $similaridade);
            return $similaridade;
        }

    }

    public function getRecomendacoesUsuario($usuario){

        $especie = [];
        $raca = [];
        $sexo = [];
        $cor = [];
        $porte = [];
        $pelo = [];
        $filhote = [];

        $Usuarios = Usuario::listAll($usuario->getidUsuario());
        foreach($Usuarios as $outro){

            $similaridade = self::euclidianaUsuario($usuario, $outro);
            if($similaridade == 0) continue;

            $gosto = new Gosto();
            $animal1 = $gosto->obterAnimalDeAcordoComGostos($usuario->getidUsuario());
            $animal2 = $gosto->obterAnimalDeAcordoComGostos($outro->getidUsuario());

            //                                                  Comparando Especie
            // ____________________________________________________________________________________________________________________
            $especieAnimal1 = explode(";", $animal1->getespecie());
            $especieAnimal2 = explode(";", $animal2->getespecie());

            $diff = array_diff($especieAnimal2, $especieAnimal1);

            foreach ($diff as $value) {
                if(isset($especie[strtolower(removerAcentuacao($value))])){
                    $especie[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $especie[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Raca
            // ____________________________________________________________________________________________________________________
            $racaAnimal1 = explode(";", $animal1->getraca());
            $racaAnimal2 = explode(";", $animal2->getraca());

            $diff = array_diff($racaAnimal2, $racaAnimal1);

            foreach ($diff as $value) {
                if(isset($raca[strtolower(removerAcentuacao($value))])){
                    $raca[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $raca[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Sexo
            // ____________________________________________________________________________________________________________________
            $sexoAnimal1 = explode(";", $animal1->getsexo());
            $sexoAnimal2 = explode(";", $animal2->getsexo());

            $diff = array_diff($sexoAnimal2, $sexoAnimal1);

            foreach ($diff as $value) {
                if(isset($sexo[strtolower(removerAcentuacao($value))])){
                    $sexo[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $sexo[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Cor
            // ____________________________________________________________________________________________________________________
            $corAnimal1 = explode(";", $animal1->getcor());
            $corAnimal2 = explode(";", $animal2->getcor());

            $diff = array_diff($corAnimal2, $corAnimal1);

            foreach ($diff as $value) {
                if(isset($cor[strtolower(removerAcentuacao($value))])){
                    $cor[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $cor[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Porte
            // ____________________________________________________________________________________________________________________
            $porteAnimal1 = explode(";", $animal1->getporte());
            $porteAnimal2 = explode(";", $animal2->getporte());

            $diff = array_diff($porteAnimal2, $porteAnimal1);

            foreach ($diff as $value) {
                if(isset($porte[strtolower(removerAcentuacao($value))])){
                    $porte[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $porte[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Pelo
            // ____________________________________________________________________________________________________________________
            $peloAnimal1 = explode(";", $animal1->getpelo());
            $peloAnimal2 = explode(";", $animal2->getpelo());

            $diff = array_diff($peloAnimal2, $peloAnimal1);

            foreach ($diff as $value) {
                if(isset($pelo[strtolower(removerAcentuacao($value))])){
                    $pelo[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $pelo[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }

            //                                                  Comparando Filhote
            // ____________________________________________________________________________________________________________________
            $filhoteAnimal1 = explode(";", $animal1->getfilhote());
            $filhoteAnimal2 = explode(";", $animal2->getfilhote());

            $diff = array_diff($filhoteAnimal2, $filhoteAnimal1);

            foreach ($diff as $value) {
                if(isset($filhote[strtolower(removerAcentuacao($value))])){
                    $filhote[strtolower(removerAcentuacao($value))] += $similaridade;
                }else{
                    $filhote[strtolower(removerAcentuacao($value))] = $similaridade;
                }
            }
        }

        arsort($especie);
        arsort($raca);
        arsort($sexo);
        arsort($cor);
        arsort($porte);
        arsort($pelo);
        arsort($filhote);

        $animal = new Animal();
        $data = [
            "idUsuario"=>$usuario->getidUsuario(),
            "especie"=>array_key_first($especie) ?? "",
            "raca"=>array_key_first($raca) ?? "",
            "sexo"=>array_key_first($sexo) ?? "",
            "cor"=>array_key_first($cor) ?? "",
            "porte"=>array_key_first($porte) ?? "",
            "pelo"=>array_key_first($pelo) ?? "",
            "filhote"=>array_key_first($filhote) ?? ""
        ];
        $animal->setData($data);

        return $this->getSimilares(BaseEnum::Animal, $animal);
    }

    public function getRecomendacoesItem($usuario){

        $gosto = new Gosto();
        $animal = $gosto->obterAnimalDeAcordoComGostos($usuario->getidUsuario());
        $animal->setidUsuario($usuario->getidUsuario());
        return $this->getSimilares(BaseEnum::Animal, $animal);

    }

}

?>