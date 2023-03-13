<?PHP

include_once "products_doc.php";


class WebshopDoc extends ProductsDoc
{
    protected function showContent($data)
    {
        foreach ($data['products'] as $product) {
            echo '<div class="product"><a href="index.php?page=productdetail&id=' . $product['id'] . '">';
            echo '<h2>' . $product['name'] . '</h2>';
            echo '<img src="Images/' . $product['filename_img'] . '" alt="' . $product['name'] . '" width="60" height="80"></a>' . PHP_EOL;
            echo '<div class="text">';
            echo '<div class="id"><p>Id: ' . $product['id'] . '</p></div>' . PHP_EOL;
            echo '<div class="price"><p>Price: &euro;' . $product['price'] . '</p></div><br>';
            echo '<div class="">';
            $this->addAction(
                'webshop',
                'Add to Shopping Cart',
                'updateShoppingCart',
                $product['id'],
                $product['name'],
                1
            );
            echo '</div></div></div>' . PHP_EOL;
        }
        // if (isUserLoggedIn() && isAdministrator(getLoggedInUserId()) == 'true') {
        //     echo '<a href="index.php?page=addnewproduct"><input type="button" value="add new product">
        //     </a>';
        // }
        echo '  <span class="error">' . $data['genericErr'] . '</span>';
    }
}
