<?php

function showContent($data)
{
    showFormStart();
    showFormFieldSetStart('Fill out this form to add a new product');
    showFormField('name', 'Name', 'text', $data);
    showFormField('description', 'Description', 'text', $data);
    showFormField('price', 'Price', 'text', $data);
    showFormField('filename_img', 'Image', 'file', $data);
    showFormFieldSetEnd();
    showFormEnd('Add to webshop', 'addnewproduct');
}
