<?PHP

require_once "products_doc.php";


class ShoppingCartDoc extends ProductsDoc
{

    protected function showContent($data)
    {
        echo '<class="products">';
        if (($data['shoppingcartproducts'])) {
            foreach ($data['shoppingcartproducts'] as $product) {
                echo '<class="product"><a href="index.php?page=productdetail&id=' .
                    $product['productId'] . '">';
                echo '<h2>' . $product['name'] . '</h2>';
                echo '<img src="Images/' . $product['filename_img'] .
                    '" alt="' . $product['name'] . '" width="60" 
                height="80"></a>' . PHP_EOL;
                echo '<div class="text">';
                echo '<div class="amount">';
                echo '<p> Quantity:&nbsp;</p>';
                echo $product['quantity'];
                echo '</div>' . PHP_EOL;
                echo '<div class="subtotal"><p> Subtotal: &euro;'
                    . $product['subtotal'] . '</p></div><br>';
                echo '</div>';
                $this->addAction(
                    'shoppingcart',
                    '+',
                    'updateShoppingCart',
                    $product['productId'],
                    $product['name'],
                    1
                );
                $this->addAction(
                    'shoppingcart',
                    '-',
                    'updateShoppingCart',
                    $product['productId'],
                    $product['name'],
                    -1
                );
            }
            echo '<div class="total">';
            echo '<p>Total: &euro;' . $data['total'] .  '</p>';
            //addAction('home', 'ORDER', 'order');
            echo '</div> ' . PHP_EOL;
        } else {
            echo '<p>' . $data['genericErr'] . '</p>';
            echo '<p>No products in shopping cart</p>';
        }
    }
}
