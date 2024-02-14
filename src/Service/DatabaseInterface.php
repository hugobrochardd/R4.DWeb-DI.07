<?php

namespace App\Service;
use PDO;
use App\Entity\Lego;

class DatabaseInterface

{
    public function getAllLegoSets(): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", "root", "root") ;
        $statement = $pdo->prepare("SELECT * FROM lego");
        $statement->execute();
        $statement->fetchAll();
        dd($statement);
        $legoObjects = [];
        foreach ($statement as $lego) {
            $legoObject = new Lego($lego['id'], $lego['name'], $lego['collection']);
            $legoObject->setDescription($lego['description']);
            $legoObject->setPrice($lego['price']);
            $legoObject->setPieces($lego['pieces']);
            $legoObject->setBoxImage($lego['imagebox']);
            $legoObject->setLegoImage($lego['imagebg']);
            $legoObjects[] = $legoObject;
        }
        return $legoObjects;
    }
}


/*
        $statement = $pdo->query("SELECT * FROM lego");
        $legos = $statement->fetchAll();
        return $legos;
*/


// a completer getAllLegoSets ainsi que les routes dernieres parties du TP1