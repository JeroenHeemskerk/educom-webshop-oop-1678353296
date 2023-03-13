<?php

function connectWithDB()
{

    $servername = "localhost";
    $username = "webshop_Lydia";
    $password = "shoplvg";
    $dbname = "lydia_webshop";

    // Create connection
    $conn = @mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

// =================================================================
// Users
// =================================================================

function findUserByEmail($email)
{
    $user = NULL;
    $conn = connectWithDB();
    try {
        $email = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * from users WHERE email='$email';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Find user by email failed " . mysqli_error($conn));
        }
        $user = mysqli_fetch_assoc($result);
    } finally {
        mysqli_close($conn);
    }

    return $user;
}

function findUserById($id)
{

    $user = NULL;
    $conn = connectWithDB();
    try {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * from users WHERE id='$id';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Find user by id failed" . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $user = $row;
            debug_to_console($user);
        }
    } finally {
        mysqli_close($conn);
    }

    return $user;
}

function saveUser($email, $name, $password)
{
    $conn = connectWithDB();
    try {
        $sql = "INSERT INTO users (email, name, password)
    VALUES ('$email', '$name', '$password')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Save user failed" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}

function changePassword($id, $password)
{
    $conn = connectWithDB();
    try {
        $id = mysqli_real_escape_string($conn, $id);
        $password = mysqli_real_escape_string($conn, $password);
        $sql = "UPDATE users SET password='$password' WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Update password failed" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}

function checkIfAdmin($id)
{

    $isadmin = "false";
    $conn = connectWithDB();
    try {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * from users WHERE id='$id';";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Find user by id failed" . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['isadmin'] == "yes") {
                $isadmin = "true";
                debug_to_console($row['isadmin']);
            };
        }
    } finally {
        mysqli_close($conn);
    }

    return $isadmin;
}

// =================================================================
// Webshop
// =================================================================

function getAllProducts()
{

    $products = array();
    $conn = connectWithDB();
    try {
        $sql = "SELECT * from products;";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Get all products failed " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $product = $row;
            $products[$product['id']] = $product;
        }
    } finally {
        mysqli_close($conn);
    }

    return $products;
}

function findProductById($productId)
{
    $conn = connectWithDB();
    $product = NULL;
    try {
        $productId = mysqli_real_escape_string($conn, $productId);
        $sql = "SELECT * FROM products WHERE id = '$productId'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("findProductById failed, SQL: " . $sql .
                "Error: " . mysqli_error($conn));
        }
        $product = mysqli_fetch_assoc($result);
        return $product;
    } finally {
        mysqli_close($conn);
    }
}

// ----------------------------------------------------------------

function insertOrder($conn, $userId)
{
    $orderNr = date("Y") . "000000";
    $sql = "INSERT INTO orders (userId, date, orderNr) 
      VALUES ('$userId', CURRENT_DATE(), '$orderNr')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("Save order insert userid and currentdate failed" . $sql . mysqli_error($conn));
    }
    $orderId = mysqli_insert_id($conn);
    return $orderId;
}

function getMaxOrderNr($conn)
{
    $sql = "SELECT max(orderNr) as maxOrdernumber from orders";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("find max ordernr failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_array($result);
    $maxOrderNr = $row[0];
    return $maxOrderNr;
}

function updateOrderNr($conn, $orderId, $updatedOrderNr)
{
    $sql = "UPDATE orders SET orderNr = $updatedOrderNr WHERE id = '$orderId'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("Update ordernr failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
    }
}

function insertOrderLines($conn, $orderId, $shoppingcartproducts)
{
    foreach ($shoppingcartproducts as $product) {
        $sql = "INSERT INTO order_products (orderId, productId, quantity)
        VALUES ($orderId, " . $product['productId'] . "," . $product['quantity'] . ")";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Insert into order products failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
        }
    }
}


function saveOrder($userId, $shoppingcartproducts)
{
    $conn = connectWithDB();
    try {
        // start a transaction so the queries only get executed if everything goes well
        mysqli_autocommit($conn, FALSE);

        // 1. insert order
        $orderId = insertOrder($conn, $userId);
        // 2. find max ordernumber 
        $maxOrderNr = getMaxOrderNr($conn);
        // 3. update current record with ordernr + 1
        updateOrderNr($conn, $orderId, $maxOrderNr + 1);
        // 4. insert order products
        insertOrderLines($conn, $orderId, $shoppingcartproducts);

        if (!mysqli_commit($conn)) { // stop the transaction if any query fails, then throw an exception
            throw new Exception("saveOrder commit failed. Error: " . mysqli_error($conn));
        }
    } catch (Exception $e) { // undo transaction and re-throw exception
        mysqli_rollback($conn);
        throw $e;
    } finally {
        mysqli_close($conn);
    }
}

function getTopFive()
{
    $conn = connectWithDB();
    try {
        $sql = "SELECT p.id, p.name, p.price, p.filename_img, SUM(op.quantity) AS quantity
        FROM products p
        LEFT JOIN order_products op ON p.id=op.productId
        LEFT JOIN orders o ON op.orderId=o.id
        AND o.date >= DATE_ADD(CURRENT_DATE(), INTERVAL -7 DAY)
        GROUP BY p.id
        ORDER BY quantity DESC
        LIMIT 5";
        $result =  mysqli_query($conn, $sql);
        $topproducts = array();
        if (!$result) {
            throw new Exception("Get top five failed, SQL: " . $sql . "Error: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $topproduct = $row;
            $topproducts[$topproduct['id']] = $topproduct;
        }
    } finally {
        mysqli_close($conn);
    }
    return $topproducts;
}

function saveProduct($name, $description, $price, $filename_img)
{
    $conn = connectWithDB();
    try {
        $sql = "INSERT INTO products (name, description, price, filename_img)
    VALUES ('$name', '$description', '$price', '$filename_img')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("Save product failed" . mysqli_error($conn));
        }
    } finally {
        mysqli_close($conn);
    }
}
