<?PHP

include_once "products_doc.php";


class TopFiveDoc extends ProductsDoc
{
    protected function showContent($data)
    {
        foreach ($data['products'] as $product) {
            echo '<div class="product"><a href="index.php?page=productdetail&id=' . $product['id'] . '">';
            echo '<h2>' . $product['name'] . '</h2>';
            echo '<img src="Images/' . $product['filename_img'] . '" alt="' . $product['name'] . '" width="60" height="80"></a>' . PHP_EOL;
            echo '<div class="text">';
            echo '</div></div>' . PHP_EOL;
        }
        echo '  <span class="error">' . $data['genericErr'] . '</span>';
    }
}
