<?php

include_once "basic_doc.php";


abstract class ProductsDoc extends BasicDoc implements FormsDoc
{
    protected function addAction($nextpage, $button, $action, $productId = NULL, $name = NULL, $addquantity = 0)
    {
        if (true) {
            showFormStart();
            echo '<input type="hidden" name="action" value="' . $action . '">' . PHP_EOL;
            if ($productId) {
                echo '<input type="hidden" name="id" value="' . $productId . '">' . PHP_EOL;
            }
            if ($name) {
                echo '<input type="hidden" name="name" value="' . $name . '">' . PHP_EOL;
            }
            echo '<input type="hidden" name="page" value="' . $nextpage . '">' . PHP_EOL;
            if ($addquantity !== 0) {
                $cart = getShoppingcart();
                $quantity = ((float) $addquantity + getArrayVar($cart, $productId, 0));
                echo '<input type="hidden" name="quantity" value="' . $quantity . '">' . PHP_EOL;
                if ($quantity == 0) {
                    echo '<input type="hidden" name="action" value="removeFromShoppingcart">' . PHP_EOL;
                }
            }

            showFormEnd($button, $nextpage);
        }
    }
}
