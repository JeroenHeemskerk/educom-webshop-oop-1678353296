<?php

require_once "db_repository.php";

define("SALUTATIONS", array("mrs" => "Mrs.", "ms" => "Ms.", "mx" => "Mx.", "mr" => "Mr."));
define("COM_PREFS", array("phone" => "phone", "email" => "email"));

define("RESULT_OK", 0);
define("RESULT_WRONG", -1);

class UserModel extends PageModel
{

    public $salutation, $salutationErr, $name, $nameErr, $email, $emailErr, $password, $passwordErr,
        $confirmPassword, $confirmPasswordErr, $phone, $phoneErr, $contactOption, $contactOptionErr, $message, $messageErr,
        $newPassword, $newPasswordErr, $genericErr, $result = "";

    public $userId = 0;
    public $valid = false;

    public function __construct($pagemodel)
    {
        PARENT::__construct($pagemodel);
    }

    // secure the user input
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validateName()
    {

        $this->name = $this->test_input($this->getPostVar("name"));

        if (empty($this->name)) {
            $this->nameErr = "Name is required";
        } else if (!preg_match("/^[a-zA-Z-' ]*$/", $this->name)) {
            $this->nameErr = "Only letters and white space allowed";
        }
    }

    function validateEmail()
    {

        $this->email = $this->test_input($this->getPostVar("email"));

        if (empty($this->email)) {
            $this->emailErr = "Email is required";
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->emailErr = "Invalid email format";
        }
    }

    function validatePassword()
    {
        $this->password = $this->test_input($this->getPostVar("password"));

        if (empty($this->password)) {
            $this->passwordErr = "Password is required";
        }
    }

    function validateLogin()
    {

        if ($this->isPost) {
            $this->validateEmail();
            $this->validatePassword();

            // check if all data are valid       
            if (empty($this->emailErr) && empty($this->passwordErr)) {
                try {
                    $authenticate  = $this->authenticateUser($this->email, $this->password);
                    switch ($authenticate['result']) {
                        case RESULT_OK:
                            $this->valid = true;
                            $this->name = $authenticate['user']['name'];
                            $this->userId = $authenticate['user']['id'];
                            break;
                        case RESULT_WRONG:
                            $this->genericErr = "Email does not exist or
                         password does not match";
                            break;
                    }
                } catch (Exception $e) {
                    $this->genericErr = "There is a technical issue, please try again later.";
                    debug_to_console("Authentication failed: " . $e->getMessage());
                }
            }
        }
    }

    function authenticateUser($email, $password)
    {
        $user = findUserByEmail($email);
        if (empty($user) || $user['password'] != $password) {
            return array("result" => RESULT_WRONG);
        }
        return array("result" => RESULT_OK, "user" => $user);
    }

    public function doLoginUser()
    {
        $this->sessionManager->logUserIn($this->name, $this->userId);
        $this->genericErr = "Login successful";
    }

    public function doLogoutUser()
    {
        $this->sessionManager->logUserOut($this->name, $this->userId);
        $this->genericErr = "Logout successful";
    }

    function validateContact()
    {

        if ($this->isPost) {

            $this->validateName();
            $this->validateEmail();
            $this->salutation = $this->test_input($this->getPostVar("salutation"));
            $this->phone = $this->test_input($this->getPostVar("phone"));
            $this->contactOption = $this->test_input($this->getPostVar("contactOption"));
            $this->message = $this->test_input($this->getPostVar("message"));

            if (!array_key_exists($this->salutation, SALUTATIONS)) {
                $this->genericErr = "invalid option";
            }
            if (empty($this->phone)) {
                $this->phoneErr = "Phone is required";
            }

            if (empty($this->contactOption)) {
                $this->contactOptionErr = "Contact option is required";
            } else if (!array_key_exists($this->contactOption, COM_PREFS)) {
                $this->genericErr = "invalid option";
            }

            if (empty($this->message)) {
                $this->messageErr = "Message is required";
            }

            if (
                empty($this->nameErr) && empty($this->emailErr) &&
                empty($this->phoneErr) && empty($this->contactOptionErr)
                && empty($this->messageErr) && empty($this->genericErr)
            ) {
                $this->valid = true;
            }
        }
    }

    function validateRegistration()
    {

        if ($this->isPost) {

            $this->validateName();
            $this->validateEmail();
            $this->validatePassword();

            $this->confirmPassword = $this->test_input($this->getPostVar("confirmPassword"));
            if (empty($this->confirmPassword)) {
                $this->confirmPasswordErr = "Please repeat your password";
            } else if ($this->confirmPassword !== $this->password) {
                $this->confirmPasswordErr = "Passwords do not match";
            }


            // Check if email is already in use, if not: create new user

            if (
                empty($this->nameErr) && empty($this->emailErr) && empty($this->passwordErr) && empty($this->confirmPasswordErr)
            ) {
                try {
                    if ($this->doesEmailExist()) {
                        $this->emailErr = "An account with this email is already in use";
                    }

                    if (empty($this->emailErr)) {
                        $this->valid = true;
                    }
                } catch (Exception $e) {
                    $this->genericErr = "A technical issue occured.";
                    debug_to_console("does email exist failed: " . $e->getMessage());
                }
            }
        }
    }

    function doesEmailExist()
    {
        if (empty(findUserByEmail($this->email))) {
            return false;
        } else {
            return true;
        };
    }

    function storeUser($email, $name, $password)
    {
        saveUser($email, $name, $password);
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

    function validateChangePassword()
    {

        if ($this->isPost) {

            $this->validatePassword();
            $this->newPassword = $this->test_input($this->getPostVar("newPassword"));


            if (empty($this->newPassword)) {
                $this->newPasswordErr = "New password is required";
            }

            if (
                empty($this->newPasswordErr)
            ) {
                try {
                    $authenticate =
                        $this->authenticateCurrentUser($this->sessionManager->getLoggedInUserId(), $this->password);
                    switch ($authenticate['result']) {
                        case RESULT_OK:
                            $this->valid = true;
                            $this->password = $authenticate['user']['password'];
                            $this->userId = $authenticate['user']['id'];
                            break;
                        case RESULT_WRONG:
                            $this->passwordErr = "Password does not match";
                            break;
                    }
                } catch (Exception $e) {
                    $this->genericErr = "There is a technical issue, please try again later.";
                    debug_to_console("Authentication failed: " . $e->getMessage());
                }
            }
        }
    }

    function updatePassword($id, $password)
    {
        changePassword($id, $password);
    }

    function isAdministrator($id)
    {
        return checkIfAdmin($id);
    }
}
