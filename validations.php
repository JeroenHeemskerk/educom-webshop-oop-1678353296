<?php

include_once 'user_service.php';
define("SALUTATIONS", array("mrs" => "Mrs.", "ms" => "Ms.", "mx" => "Mx.", "mr" => "Mr."));
define("COM_PREFS", array("phone" => "phone", "email" => "email"));

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

    $name = test_input((getPostVar("name")));
    $nameErr = '';

    if (empty($name)) {
        $nameErr = "Name is required";
    } else if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    }

    return array('name' => $name, 'nameErr' => $nameErr);
}

function validateEmail()
{

    $email = test_input(getPostVar("email"));
    $emailErr = '';

    if (empty($email)) {
        $emailErr = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    return array('email' => $email, 'emailErr' => $emailErr);
}

function validatePassword()
{

    $password = test_input(getPostVar("password"));
    $passwordErr = '';

    if (empty($password)) {
        $passwordErr = "Password is required";
    }
    return array('password' => $password, 'passwordErr' => $passwordErr);
}

function validateContact()
{
    // initate the variables   

    $data = array(
        "salutation" => test_input(getPostVar("salutation")), "name" => "",
        "email" => "", "phone" => test_input(getPostVar("phone")),
        "contactOption" => test_input(getPostVar("contactOption")),
        "message" => test_input(getPostVar("message")),
        "nameErr" => "", "emailErr" => "", "phoneErr" => "",
        "contactOptionErr" => "", "messageErr" => "", "genericErr" => "",
        "valid" => false
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data = array_merge($data, validateName());

        $data = array_merge($data, validateEmail());

        if (empty($data['phone'])) {
            $data['phoneErr'] = "Phone is required";
        }

        if (!array_key_exists($data['salutation'], SALUTATIONS)) {
            $data['genericErr'] = "invalid option";
        }

        if (empty($data['contactOption'])) {
            $data['contactOptionErr'] = "Contact option is required";
        } else if (!array_key_exists($data['contactOption'], COM_PREFS)) {
            $data['genericErr'] = "invalid option";
        }

        if (empty($data['message'])) {
            $data['messageErr'] = "Message is required";
        }

        if (
            $data['nameErr'] === "" && $data['emailErr'] === ""
            && $data['phoneErr'] === "" && $data['contactOptionErr'] === ""
            && $data['messageErr'] === "" && $data['genericErr'] === ""
        ) {
            $data['valid'] = true;
        };
    }

    return $data;
}

function validateRegistration()
{
    // initate the variables     

    $data = array(
        "name" => "", "email" => "", "password" => "",
        "confirmPassword" => test_input(getPostVar("confirmPassword")),
        "nameErr" => "", "emailErr" => "", "passwordErr" => "",
        "confirmPasswordErr" => "", "genericErr" => "", "valid" => false
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data = array_merge($data, validateName());
        $data = array_merge($data, validateEmail());
        $data = array_merge($data, validatePassword());

        if (empty($data['confirmPassword'])) {
            $data['confirmPasswordErr'] = "Please repeat your password";
        } else if (strcmp($data['confirmPassword'], $data['password']) != 0) {
            $data['confirmPasswordErr'] = "Passwords do not match";
        }


        // Check if email is already in use, if not: create new user

        if (
            $data['name'] !== "" && $data['email'] !== "" && $data['password'] !== "" &&
            $data['confirmPassword'] !== "" && $data['nameErr'] === ""
            && $data['emailErr'] === "" &&
            $data['passwordErr'] === "" && $data['confirmPasswordErr'] === "" &&
            $data['genericErr'] === ""
        ) {
            //try catch 
            if (doesEmailExist($data['email'])) {
                $data['emailErr'] = "An account with this email is already in use";
            }

            if ($data['emailErr'] === "") {
                $data['valid'] = true;
            }
        }
    }

    return $data;
}

function validateLogin()
{

    // initiate the variables     

    $data = array(
        "userid" => test_input(getPostVar("userid")),
        "name" => test_input(getPostVar("name")), "email" => "",
        "password" => "", "emailErr" => "",
        "passwordErr" => "", "genericErr" => "", "valid" => false
    );


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = array_merge($data, validateEmail());
        $data = array_merge($data, validatePassword());

        // check if all data are valid       
        if (
            $data['email'] !== "" && $data['password'] !== "" &&
            $data['emailErr'] === "" && $data['passwordErr'] === ""
        ) {
            try {
                $authenticate = authenticateUser($data['email'], $data['password']);
                switch ($authenticate['result']) {
                    case RESULT_OK:
                        $data['valid'] = true;
                        $data['name'] = $authenticate['user']['name'];
                        $data['userid'] = $authenticate['user']['id'];
                        break;
                    case RESULT_WRONG:
                        $data['emailErr'] = "Email does not exist or
                         password does not match";
                        break;
                }
            } catch (Exception $e) {
                $data['genericErr'] = "There is a technical issue, please try again later.";
                debug_to_console("Authentication failed: " . $e->getMessage());
            }
        }
    }

    return $data;
}

function validateChangePassword()
{
    $data = array(
        "id" => getLoggedInUserId(), "password" => "",
        "newPassword" => test_input(getPostVar("newPassword")), "passwordErr" => "",
        "newPasswordErr" => "", "genericErr" => "", "valid" => false
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $data = array_merge($data, validatePassword());

        if (empty($data['newPassword'])) {
            $data['newPasswordErr'] = "New password is required";
        }

        if (
            $data['password'] !== "" && $data['newPassword'] !== "" &&
            $data['passwordErr'] === "" &&
            $data['newPasswordErr'] === "" &&
            $data['genericErr'] === ""
        )
            try {
                $authenticate =
                    authenticateCurrentUser(getLoggedInUserId(), $data['password']);
                switch ($authenticate['result']) {
                    case RESULT_OK:
                        $data['valid'] = true;
                        break;
                    case RESULT_WRONG:
                        $data['passwordErr'] = "Password does not match";
                        break;
                }
            } catch (Exception $e) {
                $data['genericErr'] = "There is a technical issue, please try again later.";
                debug_to_console("Authentication failed: " . $e->getMessage());
            }
    }

    return $data;
}

function validateAddProduct()
{
    $data = array(
        "name" => test_input(getPostVar("name")),
        "description" => test_input(getPostVar("description")),
        "price" => test_input(getPostVar("price")),
        "filename_img" => test_input(getPostVar("filename_img")),
        "nameErr" => "",
        "descriptionErr" => "", "priceErr" => "",
        "fileNameErr" => "", "genericErr" => "", "valid" => false
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (empty($data['name'])) {
            $data['nameErr'] = "Name of product is required";
        }

        if (empty($data['description'])) {
            $data['descriptionErr'] = "Description of product is required";
        }

        if (empty($data['price'])) {
            $data['priceErr'] = "Price of product is required";
        } else if (preg_match("/^[a-zA-Z-' ]*$/", $data['price'])) {
            $data['priceErr'] = "Only numbers allowed";
        }

        if (empty($data['filename_img'])) {
            $data['fileNameErr'] = "Filename of image of product is required";
        }

        if (
            $data['name'] !== "" && $data['description'] !== "" &&
            $data['price'] !== "" && $data['filename_img'] !== "" &&
            $data['nameErr'] === "" &&
            $data['descriptionErr'] === "" &&
            $data['priceErr'] === "" &&
            $data['fileNameErr'] === "" &&
            $data['genericErr'] === ""
        ) {
            $data['valid'] = true;
        }
    }

    return $data;
}
