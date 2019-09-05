<?php

class Address implements Action, JsonSerializable
{
    /**
     * @var Database
     */
    private static $db;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $flat;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        self::$db->query('INSERT INTO Addresses SET city=:city, code=:code, street=:street, flat=:flat');
        self::$db->bind('city', $this->city);
        self::$db->bind('code', $this->code);
        self::$db->bind('street', $this->street);
        self::$db->bind('flat', $this->flat);
        self::$db->execute();
    }

    public function update()
    {
        self::$db->query('UPDATE Addresses SET city=:city, code=:code,
street=:street, flat=:flat WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->bind('city', $this->city);
        self::$db->bind('code', $this->code);
        self::$db->bind('street', $this->street);
        self::$db->bind('flat', $this->flat);
        self::$db->execute();
    }

    public function delete()
    {
        self::$db->query('DELETE FROM Addresses WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->execute();
    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();
        }
        self::$db->query('SELECT * FROM Addresses WHERE id=:id');
        self::$db->bind('id', $id);

        $row = self::$db->single();
        $address = new Address();
        $address->id = $row['id'];
        $address->city = $row['city'];
        $address->code = $row['code'];
        $address->street = $row['street'];
        $address->flat = $row['flat'];

        return $address;
    }

    public static function loadAll()
    {
        self::$db->query('SELECT * FROM Addresses');
        $addresses = self::$db->resultSet();

        $result = [];
        foreach ($addresses as $address) {
            $new = new Address();
            $new->id = $address['id'];
            $new->city = $address['city'];
            $new->code = $address['code'];
            $new->street = $address['street'];
            $new->flat = $address['flat'];
            $result[] = $new;
        }
        return $result;
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'city' => $this->city,
            'code' => $this->code,
            'street' => $this->street,
            'flat' => $this->flat
        ];
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getFlat(): string
    {
        return $this->flat;
    }

    /**
     * @param string $flat
     */
    public function setFlat(string $flat): void
    {
        $this->flat = $flat;
    }

}