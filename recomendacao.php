<?php

use \PetWorld\Model\Gosto;
use \PetWorld\Model\Animal;
use \PetWorld\Model\Recomendacao;
use \PetWorld\Model\BaseEnum;

$app->get('/recomendacao/animal/:idAnimal', function($idAnimal){

    $recomendacao = new Recomendacao();

    $animal1 = new Animal();
    $animal2 = new Animal();

    $animal1->getById(1);
    $animal2->getById(44);

    //$euclidiana = $recomendacao->euclidianaAnimal($animal1, $animal2);
    //echo $euclidiana;

    $teste = $recomendacao->getSimilares(BaseEnum::Animal, $animal1);
    echo json_encode($teste);

});

?>