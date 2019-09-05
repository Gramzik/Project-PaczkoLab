<?php
//ten plik odpowiada za obsuge roznego typu zapytan http GET POST itd.
//dla klasy size

//sprawdzamy jak metoda weszlismy na strone
//plik ten powinien tworzyc $response
//która bedzie potem użyty w router do wygenerowania
//json'a który zwrócona bedzie na frontend

//dodajemy połącznie z bazą do klasy Size
//nie mozemy przekazac bezposrednio polaczenia PDO
//poniewaz wymagana jest klasa implementujaca interfejs Database

Size::setDb(new DBmysql());

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //pobieramy wszystkie rozmiary
    $response = Size::loadAll();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $size = new Size();
    $size->setSize($_POST['size']);
    $size->setPrice($_POST['price']);
    $size->save();

} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    //to jest """$_PATCH"""
    parse_str(file_get_contents("php://input"), $patchVars);

    $size = Size::load($patchVars['id']);
    $size->setSize($patchVars['size']);
    $size->setPrice($patchVars['price']);
    $size->update();

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //to jest """$_DELETE"""
    parse_str(file_get_contents("php://input"), $deleteVars);

    //pobieramy obiekt size o podanym id
    $size = Size::load($deleteVars['id']);
    $size->delete();

} else {
    $response = ['error' => 'Wrong request method'];
}
