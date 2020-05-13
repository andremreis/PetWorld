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

        // Comparando Espécie
        if($animal1->getespecie() == $animal2->getespecie()){
            $similaridade += $pesos["especie"];
        }

        // Comparando Raça
        if($animal1->getraca() == $animal2->getraca()){
            $similaridade += $pesos["raca"];
        }

        // Comparando Sexo
        if($animal1->getsexo() == $animal2->getsexo()){
            $similaridade += $pesos["sexo"];
        }

        // Comparando Cores
        $coresAnimal1 = explode(";", $animal1->getcor());
        $coresAnimal2 = explode(";", $animal2->getcor());
        // O peso vai ser sempre a maior quantidade de cores
        $pesoCor = (count($coresAnimal1) > count($coresAnimal2)) ? count($coresAnimal1) : count($coresAnimal2);

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

        // Comparando Porte
        if($animal1->getporte() == $animal2->getporte()){
            $similaridade += $pesos["porte"];
        }

        // Comparando Pelo
        if($animal1->getpelo() == $animal2->getpelo()){
            $similaridade += $pesos["pelo"];
        }

        // Comparando Filhote
        if($animal1->getfilhote() == $animal2->getfilhote()){
            $similaridade += $pesos["filhote"];
        }

        return $similaridade/100;
    }

    public function getSimilares($baseEnum, $objeto){

        $similaridade = array();

        if($baseEnum == BaseEnum::Animal){
            // Similaridade de animal

            $Animais = Animal::listAll($objeto->getidAnimal());
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

            return $similaridade;
        }

    }

}

?>