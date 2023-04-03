<?PHP

class ShopCrud
{

    private $crud;

    public function __construct($crud)
    {
        $this->crud = $crud;
    }

    public function readAllProducts()
    {
        $sql = "SELECT * FROM products";
        $params = array();
        return $this->crud->readMultipleRows($sql, $params);
    }

    public function readProductById($productId)
    {
        $params = get_defined_vars();
        $sql = "SELECT * FROM products  WHERE id = :productId";
        return $this->crud->readOneRow($sql, $params);
    }

    function readTopFive()
    {

        $sql = "SELECT p.id, p.name, p.price, p.filename_img, SUM(op.quantity) AS quantity
        FROM products p
        LEFT JOIN order_products op ON p.id=op.productId
        LEFT JOIN orders o ON op.orderId=o.id
        AND o.date >= DATE_ADD(CURRENT_DATE(), INTERVAL -7 DAY)
        GROUP BY p.id
        ORDER BY quantity DESC
        LIMIT 5";
        $topproducts = array();
        return $this->crud->readMultipleRows($sql, $topproducts);
    }

    function insertOrder($userId)
    {
        $orderNr = date("Y") . "000000";
        $sql = "INSERT INTO orders (userId, date, orderNr) 
      VALUES (:userId, CURRENT_DATE(), :orderNr)";
        $params = array(':userId' => $userId, ':orderNr' => $orderNr);
        $orderId = $this->crud->createRow($sql, $params);
        debugToConsole("insert order" . $orderId);
        return $orderId;
    }

    function getMaxOrderNr()
    {
        $sql = "SELECT max(orderNr) as maxOrdernumber from orders";
        $params = array();
        $row = $this->crud->readOneRow($sql, $params);
        $maxOrderNr = $row->maxOrdernumber;
        debugToConsole("get max order number" . $maxOrderNr);
        return $maxOrderNr;
    }

    function updateOrderNr($orderId, $updatedOrderNr)
    {
        $sql = "UPDATE orders SET orderNr = :updatedOrderNr WHERE id = :orderId";
        $params = array(':orderId' => $orderId, ':updatedOrderNr' => $updatedOrderNr);
        $this->crud->updateRow($sql, $params);
        debugToConsole("updateOrderNr");
    }

    function insertOrderLines($orderId, $shoppingcartproducts)
    {
        foreach ($shoppingcartproducts as $product) {
            $sql = "INSERT INTO order_products (orderId, productId, quantity)
        VALUES (:orderId, :productId, :quantity)";
            $params = array(':orderId' => $orderId, ':productId' => $product['productId'], ':quantity' => $product['quantity']);
            $this->crud->createRow($sql, $params);
            debugToConsole("insert order lines");
        }
    }

    public function createOrder($userId, $shoppingcartproducts)
    {
        try {
            //start a transaction so the queries only get executed if everything goes well
            $this->crud->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->crud->pdo->beginTransaction();
            // 1. insert order
            $orderId = $this->insertOrder($userId);
            // 2. find max ordernumber 
            $maxOrderNr = $this->getMaxOrderNr();
            // 3. update current record with ordernr + 1
            $this->updateOrderNr($orderId, $maxOrderNr + 1);
            // 4. insert order products           
            $this->insertOrderLines($orderId, $shoppingcartproducts);
            $this->crud->pdo->commit();
        } catch (PDOException $e) { // undo transaction and re-throw exception
            $this->crud->pdo->rollBack();
            throw $e;
        }
    }

    public function createProduct($name, $description, $price, $filename_img)
    {
        $sql = "INSERT INTO products (name, description, price, filename_img) 
        VALUES (:name, :description, :price, :filename_img)";
        $params = array(':name' => $name, ':description' => $description, ':price' => $price, ':filename_img' => "temp filename");
        $id = $this->crud->createRow($sql, $params);
        $this->updateProduct($id, $name, $description, $price, $filename_img, "temp filename");
        return $id;
    }

    public function updateProduct($productId, $name, $description, $price, $filename_img, $oldfilename_img)
    {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price" . (!empty($filename_img) ? ", filename_img = :filename_img" : "") . " WHERE id = :productId AND filename_img = :oldfilename_img";
        $params = array(':productId' => $productId, ':name' => $name, ':description' => $description, ':price' => $price, ':oldfilename_img' => $oldfilename_img);
        if (!empty($filename_img)) {
            $params[':filename_img'] = $productId . "_" . $filename_img;
        }
        $rowcount = $this->crud->updateRow($sql, $params);
        if ($rowcount != 1) {
            throw new Exception('Update failed');
        }
    }
}
