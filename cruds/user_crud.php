<?PHP

class UserCrud
{

    private $crud;

    public function __construct($crud)
    {
        $this->crud = $crud;
    }

    public function createUser($email, $name, $password)
    {
        $params = get_defined_vars();
        $sql = "INSERT INTO users (email, name, password) VALUES (:email, :name, :password)";
        $this->crud->createRow($sql, $params);
    }

    public function readUserById($id)
    {
        $params = get_defined_vars();
        $sql = "SELECT * FROM users WHERE id=:id";
        return $this->crud->readOneRow($sql, $params);
    }

    public function readUserByEmail($email)
    {
        $params = get_defined_vars();
        $sql = "SELECT * FROM users WHERE email=:email";
        return $this->crud->readOneRow($sql, $params);
    }

    public function readAllUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->crud->readMultipleRows($sql, $params = NULL);
    }

    public function updateUser($id, $name = NULL, $email = NULL, $password = NULL)
    {
        $possibleParams = get_defined_vars();
        $params = array('id' => $id);
        $toUpdate = "";
        foreach ($possibleParams as $key => $value) {
            if ($key !== "id" && $value !== NULL) {
                if (!empty($toUpdate)) {
                    $toUpdate .= ', ';
                }
                $toUpdate .= $key . "=:" . $key;
                $params[$key] = $possibleParams[$key];
            }
        }
        $sql = "UPDATE users SET " . $toUpdate  . " WHERE id = :id";
        $this->crud->updateRow($sql, $params);
    }

    public function deleteUser($id)
    {

        $params = get_defined_vars();
        $sql = "DELETE FROM users WHERE id=:id";
        $this->crud->deleteRow($sql, $params);
    }
}
