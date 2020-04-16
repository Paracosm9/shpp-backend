<?php


class PdoProcess
{
    private $dsn = 'mysql:host=localhost;dbname=MyCuteBase';
    private $username = 'root';
    private $pass = 'Lol123';
    private $db;

    /**
     * Initializing PDO class.
     * PdoProcess constructor.
     */
    public function __construct()
    {
        $this->db = new PDO($this->dsn, $this->username, $this->pass);
    }

    /**
     * Get full value of items.
     * @param $login
     * @return array
     */
    function getItems($login)
    {
        $query = $this->db->query('SELECT id, text, checked FROM ToDo WHERE `user` = "' . $login . '"');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Adding item, actually.
     * @param $login
     * @return array
     */
    function addItem($login, $arr)
    {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $prep = $this->db->prepare('INSERT INTO ToDo (text, checked , `user`) VALUES (:text, 0, :user)');
        $prep->execute([":text" => $arr["text"], ":user" => $login]);
        $query = $this->db->query('SELECT * FROM ToDo WHERE id = ( SELECT MAX( id ) FROM ToDo )');
        $arr_id = $query->fetchAll(PDO::FETCH_ASSOC);
        return array(
            "id" => $arr_id[0]["id"]
        );
    }

    /**
     * Exchanging value of existing item - bool or text
     * @param $login
     * @param $arr
     * @return false|string
     */
    function changeItem($login, $arr)
    {
        $check = ($arr["checked"]) ? 1 : 0;
        $this->db->query('UPDATE ToDo SET text = "' . $arr["text"] . '", checked = "' . $check . '" 
        WHERE id = "' . intval($arr["id"]) . '" AND `user` = "' . $login . '"');
        return json_encode(['ok' => true]);
    }

    /**
     * Deleting existing item.
     * @param $login
     * @param $arr
     * @return false|string
     */
    function deleteItem($login, $arr)
    {
        $this->db->query('DELETE FROM ToDo WHERE id="' . intval($arr["id"]) . '" AND `user` = "' . $login . '"');
        return json_encode(['ok' => true]);
    }

    /**
     * Connecting database, checking if there such user exists.
     * @param $data
     * @return array
     */
    function login($data)
    {
        /*Taking data from base.*/
        $query = 'SELECT * FROM users WHERE login = "' . $data["login"] . '" AND password = "' . $data["pass"] . '"';
        $user = $this->db->query($query);
        return $arr = $user->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Making hash, to put in the base for session.
     * @param $hash
     * @param $user
     */
    function setUserHash($hash, $user)
    {
        $this->db->query('UPDATE users SET hash = "' . $hash . '" WHERE login = "' . $user . '"');
    }

    /**
     * Getting all users from base.
     * Checking for same login.
     * @param $name
     * @param $pass
     * @return false|string
     */
    function register($name, $pass)
    {

        $query = $this->db->query('SELECT * FROM users');
        $arr = $query->fetchAll(PDO::FETCH_ASSOC);
        if ($this->checkForExist($name, $arr) || $name === null || $pass === null || $name === "" || $pass === "") {
            header('HTTP1.1 422 Unprocessable Entity');
            return json_encode(["false" => "false"]);
        } else {
            $this->db->query('INSERT INTO users (login, password) VALUES ("' . $name . '", "' . $pass . '")');
            return json_encode(["ok" => "true"]);
        }
    }

    /**
     * Checks if user with such login is already in db.
     * @param $name
     * @param $arr
     * @return bool
     */
    function checkForExist($name, $arr)
    {
        foreach ($arr as $row) {
            if ($name === $row['login']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checking hash of user in database for session control
     * @param $login
     * @param $hash
     * @return false|PDOStatement
     */
    function checkUserHash($login, $hash)
    {
        $query = ('SELECT * FROM users WHERE login = "' . $login . '" AND hash = "' . $hash . '"');
        return $this->db->query($query);
    }
}




