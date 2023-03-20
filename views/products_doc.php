<?php

include_once "basic_doc.php";


abstract class ProductsDoc extends BasicDoc
{
    protected function addAction($nextpage, $button, $action, $productId = NULL, $name = NULL, $addquantity = 0)
    {
        if ($this->model->canOrder) {
            echo '<div class="form-style-3">
                <form method="post" action="index.php" enctype="multipart/form-data">';
            echo '<input type="hidden" name="action" value="' . $action . '">' . PHP_EOL;
            if (!empty($productId)) {
                echo '<input type="hidden" name="id" value="' . $productId . '">' . PHP_EOL;
            }
            if (!empty($name)) {
                echo '<input type="hidden" name="name" value="' . $name . '">' . PHP_EOL;
            }
            echo '<input type="hidden" name="page" value="' . $nextpage . '">' . PHP_EOL;
            if ($addquantity !== 0) {
                $quantity = ((float) $addquantity + (float) $this->model->getArrayVar($this->model->cart, $productId, 0));
                echo '<input type="hidden" name="quantity" value="' . $quantity . '">' . PHP_EOL;
                if ($quantity == 0) {
                    echo '<input type="hidden" name="action" value="removeFromShoppingcart">' . PHP_EOL;
                }
            }

            echo '<fieldset>              
              <label><input type="submit" value="' . $button . '" /></label>
              <input type="hidden" name="page" value="' . $nextpage . '">                                                
              </fieldset>
          </form>
        </div>';
        }
    }
}
