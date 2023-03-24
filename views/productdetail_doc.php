<?php

require_once "products_doc.php";


class ProductDetailDoc extends ProductsDoc
{
    protected function showContent()
    {
        if ($this->model->product) {
            echo '<div>';
            echo '<h2>' . $this->model->product->name  . '</h2>';
            echo '<img src="Images/' . $this->model->product->filename_img .
                '" alt="' . $this->model->product->name  . '" width="150 height="300"><br><br>';
            echo '<p>Description: ' . $this->model->product->description . '</p><br><br>';
            echo '<p>Price: &euro;' . $this->model->product->price . '</p></a>';
            $this->addAction(
                'shoppingcart',
                'Add to Shopping Cart',
                'updateShoppingCart',
                $this->model->product->id,
                $this->model->product->name,
                1
            );
            echo '</div>';
        }
    }
}
