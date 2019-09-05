<?php

class Parcel implements Action, JsonSerializable
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
     * @var int
     */
    private $user_id;

    /**
     * @var int
     */
    private $address_id;

    /**
     * @var int
     */
    private $size_id;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        self::$db->query('INSERT INTO Parcel SET user_id=:user_id, address_id=:addres_id, size_id=:size_id');
        self::$db->bind('user_id', $this->user_id);
        self::$db->bind('address_id', $this->address_id);
        self::$db->bind('size_id', $this->size_id);
        self::$db->execute();
    }

    public function update()
    {
        self::$db->query('UPDATE Parcel SET user_id=:user_id, address_id=:addres_id, size_id=:size_id WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->bind('user_id', $this->user_id);
        self::$db->bind('address_id', $this->address_id);
        self::$db->bind('size_id', $this->size_id);
        self::$db->execute();
    }

    public function delete()
    {
        self::$db->query('DELETE FROM Parcel WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->execute();
    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();

        }
        self::$db->query('SELECT * FROM Parcel WHERE id=:id');
        self::$db->bind('id', $id);

        $row = self::$db->single();
        $parcel = new Parcel();
        $parcel->id = $row['id'];
        $parcel->user_id = $row['user_id'];
        $parcel->address_id = $row['address_id'];
        $parcel->size_id = $row['size_id'];

        return $parcel;
    }

    public static function loadAll()
    {
        self::$db->query('SELECT * FROM Parcel');
        $parcels = self::$db->resultSet();

        $result = [];
        foreach ($parcels as $parcel) {
            $new = new Parcel();
            $new->id = $parcel['id'];
            $new->user_id = $parcel['user_id'];
            $new->address_id = $parcel['address_id'];
            $new->size_id = $parcel['size_id'];
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
            'user_id' => $this->size_id,
            'address_id' => $this->address_id,
            'size_id' => $this->size_id
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getAddressId(): int
    {
        return $this->address_id;
    }

    /**
     * @param int $address_id
     */
    public function setAddressId(int $address_id): void
    {
        $this->address_id = $address_id;
    }

    /**
     * @return int
     */
    public function getSizeId(): int
    {
        return $this->size_id;
    }

    /**
     * @param int $size_id
     */
    public function setSizeId(int $size_id): void
    {
        $this->size_id = $size_id;
    }

}