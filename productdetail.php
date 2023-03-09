<?php

function showContent($data)
{
    if ($data['product']) {
        echo '<div>';
        echo '<h2>' . $data['product']['name'] . '</h2>';
        echo '<img src="Images/' . $data['product']['filename_img'] .
            '" alt="' . $data['product']['name'] . '" width="150 height="300"><br><br>';
        echo '<p>Description: ' . $data['product']['description'] . '</p><br><br>';
        echo '<p>Price: &euro;' . $data['product']['price'] . '</p></a>';
        addAction(
            'shoppingcart',
            'Add to Shopping Cart',
            'updateShoppingCart',
            $data['product']['id'],
            $data['product']['name'],
            1
        );
        echo '</div>';
    }

    echo '  <span class="error">' . $data['genericErr'] . '</span>';
}
