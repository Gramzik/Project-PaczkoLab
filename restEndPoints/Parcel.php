<?php


Parcel::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = Parcel::loadAll();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parcel = new Parcel();
    $parcel->setUserId($_POST['user_id']);
    $parcel->setAddressId($_POST['address_id']);
    $parcel->setSizeId($_POST['size_id']);
    $parcel->save();

} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_PATCH"""
    parse_str(file_get_contents("php://input"), $patchVars);

    $parcel = Parcel::load($patchVars['id']);
    $parcel->setUserId($patchVars['user_id']);
    $parcel->setAddressId($patchVars['address_id']);
    $parcel->setSizeId($patchVars['size_id']);
    $parcel->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_DELETE"""
    parse_str(file_get_contents("php://input"), $deleteVars);

    $address = Address::load($deleteVars['id']);
    $address->delete();

} else {
    $response = ['error' => 'Wrong request method'];
}