<?php
    include '../api/apiheader.php';
    include '../classes/Product.php';

    $header = getallheaders();
    if (isset($_GET['command'])) {
        if ($_GET['command'] == 'getAllProduct') {
            $data = Product::getAllProduct($conn);
            successApi($data);
        }
        else failApi("No command found!");
    }
    else if (isset($_POST['command'])) {
        $productID = (isset($_POST['productID'])) ? $_POST['productID'] : '';
        $product = new Product($conn, $productID);
        $data = [];
        $data['type'] = isset($_POST['type']) ? $_POST['type']  :  "";
        $data['description'] = isset($_POST['description']) ? $_POST['description'] : "";
        $data['spec'] = isset($_POST['spec']) ? $_POST['spec'] : "";
        $data['name'] = isset($_POST['name']) ? $_POST['name'] : "";
        $data['price'] = isset($_POST['price']) ? $_POST['price'] : "";
        $data['rating'] = isset($_POST['rating']) ? $_POST['rating'] : "";
        $data['sold'] = isset($_POST['sold']) ? $_POST['sold'] : "";
        $data['img1'] = isset($_POST['img1']) ? $_POST['img1'] : "";
        $data['img2'] = isset($_POST['img2']) ? $_POST['img2'] : "";
        $data['img3'] = isset($_POST['img3']) ? $_POST['img3'] : "";
        $data['img4'] = isset($_POST['img4']) ? $_POST['img4'] : "";

         if($_POST['command'] == 'modify'){
            if($product->modifyProduct($data))
                successApi("A product is modified");
            else failApi("No product is modified");
        }
        else if($_POST['command'] == 'remove'){
            if($product->removeProduct())
                successApi("A product is removed");
            else failApi("No product is removed");
        }
        else failApi('No command found');
    }
    else failApi("No command found!");
?>