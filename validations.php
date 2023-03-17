<?php


// function validateAddProduct()
// {
//     $data = array(
//         "name" => test_input(getPostVar("name")),
//         "description" => test_input(getPostVar("description")),
//         "price" => test_input(getPostVar("price")),
//         "filename_img" => test_input(getPostVar("filename_img")),
//         "nameErr" => "",
//         "descriptionErr" => "", "priceErr" => "",
//         "fileNameErr" => "", "genericErr" => "", "valid" => false
//     );

//     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//         if (empty($data['name'])) {
//             $data['nameErr'] = "Name of product is required";
//         }

//         if (empty($data['description'])) {
//             $data['descriptionErr'] = "Description of product is required";
//         }

//         if (empty($data['price'])) {
//             $data['priceErr'] = "Price of product is required";
//         } else if (preg_match("/^[a-zA-Z-' ]*$/", $data['price'])) {
//             $data['priceErr'] = "Only numbers allowed";
//         }

//         if (empty($data['filename_img'])) {
//             $data['fileNameErr'] = "Filename of image of product is required";
//         }

//         if (
//             $data['name'] !== "" && $data['description'] !== "" &&
//             $data['price'] !== "" && $data['filename_img'] !== "" &&
//             $data['nameErr'] === "" &&
//             $data['descriptionErr'] === "" &&
//             $data['priceErr'] === "" &&
//             $data['fileNameErr'] === "" &&
//             $data['genericErr'] === ""
//         ) {
//             $data['valid'] = true;
//         }
//     }

//     return $data;
// }
