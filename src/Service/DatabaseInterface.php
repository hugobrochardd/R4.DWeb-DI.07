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
        $legoso = $statement->fetchAll();
        $legoObjects = [];
        foreach ($legoso as $lego) {
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

    public function getLegoByCollection(string $collection): array
    {
        $pdo = new PDO("mysql:host=tp-symfony-mysql;dbname=lego_store", "root", "root") ;
        $statement = $pdo->prepare("SELECT * FROM lego WHERE collection = :collection");
        $statement->execute(['collection' => $collection]);
        $legoso = $statement->fetchAll();
        $legoObjects = [];
        foreach ($legoso as $lego) {
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


