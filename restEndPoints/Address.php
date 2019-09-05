<?php


Address::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = Address::loadAll();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = new Address();
    $address->setCity($_POST['city']);
    $address->setCode($_POST['code']);
    $address->setStreet($_POST['street']);
    $address->setFlat($_POST['flat']);
    $address->save();

} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_PATCH"""
    parse_str(file_get_contents("php://input"), $patchVars);

    $address = Address::load($patchVars['id']);
    $address->setCity($patchVars['city']);
    $address->setCode($patchVars['code']);
    $address->setStreet($patchVars['street']);
    $address->setFlat($patchVars['flat']);
    $address->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_DELETE"""
    parse_str(file_get_contents("php://input"), $deleteVars);

    $address = Address::load($deleteVars['id']);
    $address->delete();

} else {
    $response = ['error' => 'Wrong request method'];
}