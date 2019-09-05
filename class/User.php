<?php

class User implements Action, JsonSerializable
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
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var float
     */
    private $credits;

    /**
     * @var int
     */
    private $address_id;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        self::$db->query('INSERT INTO Users SET name=:name, surname=:surname, credits=:credits, address_id=:address_id');
        self::$db->bind('name', $this->name);
        self::$db->bind('surname', $this->surname);
        self::$db->bind('credits', $this->credits);
        self::$db->bind('address_id', $this->address_id);
        self::$db->execute();
    }

    public function update()
    {
        self::$db->query('UPDATE Users SET name=:name, surname=:surname, credits=:credits WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->bind('name', $this->name);
        self::$db->bind('surname', $this->surname);
        self::$db->bind('credits', $this->credits);
        self::$db->execute();
    }

    public function delete()
    {
        self::$db->query('DELETE FROM Users WHERE id=:id');
        self::$db->bind('id', $this->id);
        self::$db->execute();
    }

    public static function load($id = null)
    {
        if ($id == null) {
            return self::loadAll();

        }
        self::$db->query('SELECT * FROM Users WHERE id=:id');
        self::$db->bind('id', $id);
        $row = self::$db->single();


        $user = new User();
        $user->id = $row['id'];
        $user->name = $row['name'];
        $user->surname = $row['surname'];
        $user->credits = $row['credits'];
        $user->address_id = $row['address_id'];
        return $user;
    }

    public static function loadAll()
    {
        self::$db->query('SELECT * FROM Users');
        $users = self::$db->resultSet();

        $result = [];
        foreach ($users as $user) {
            $new = new User();
            $new->id = $user['id'];
            $new->name = $user['name'];
            $new->surname = $user['surname'];
            $new->credits = $user['credits'];
            $new->address_id = $user['address_id'];
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
            'name' => $this->name,
            'surname' => $this->surname,
            'credits' => $this->credits,
            'address_id' => $this->address_id
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return float
     */
    public function getCredits(): float
    {
        return $this->credits;
    }

    /**
     * @param float $credits
     */
    public function setCredits(float $credits): void
    {
        $this->credits = $credits;
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
}