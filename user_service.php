<?PHP

include_once 'db_repository.php';

define("RESULT_OK", 0);
define("RESULT_WRONG", -1);


function authenticateUser($email, $password)
{
    $user = findUserByEmail($email);
    if (empty($user) || $user['password'] != $password) {
        return array("result" => RESULT_WRONG);
    }
    return array("result" => RESULT_OK, "user" => $user);
}

function authenticateCurrentUser($id, $password)
{
    $user = findUserById($id);
    debug_to_console($password . "test password");
    if (empty($user) || $user['password'] != $password) {
        return array("result" => RESULT_WRONG);
    }

    return array("result" => RESULT_OK, "user" => $user);
}

function doesEmailExist($email)
{
    if (empty(findUserByEmail($email))) {
        return false;
    } else {
        return true;
    };
}

function storeUser($email, $name, $password)
{
    saveUser($email, $name, $password);
}

function updatePassword($id, $password)
{
    changePassword($id, $password);
}

function isAdministrator($id)
{
    return checkIfAdmin($id);
}
