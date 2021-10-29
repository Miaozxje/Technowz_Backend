<?php
	include './apiheader.php';
	include '../classes/Cart.php';

	$header = getallheaders();
	if(isset($header['Userid'])){
		$userID = $header['Userid'];
		$cart = new Cart($conn, $userID);

		if(isset($_POST['command'])){
			$productID = (isset($_POST['productID'])) ? $_POST['productID'] : '';
			if($_POST['command'] == 'add'){
				if($cart->addItemToCart($productID)) {
					$arr = [];
					$arr['totalQuantity'] = $cart->getTotalQuantity();
					successApi($arr, "Add product to cart successfully");
				}
				else failApi("Can not add product to cart");
			}
			else if($_POST['command'] == 'remove'){
				if($cart->removeItem($productID)) {
					$arr = [];
					$arr['totalQuantity'] = $cart->getTotalQuantity();
					successApi($arr,"Remove item from cart");
				}
				else failApi("Can not remove product from cart");
			}
			else if($_POST['command'] == 'increase'){
				if($cart->increaseQuantity($productID))
					successApi($cart->getTotalQuantity());
				else failApi("Can not increase product quantity");
			}
			else if($_POST['command'] == 'decrease'){
				if($cart->decreaseQuantity($productID))
					successApi($cart->getTotalQuantity());
				else failApi("Can not decrease product quantity");
			}
			else if($_POST['command'] == 'removeAll'){
				if($cart->removeAll())
					successApi('remove all success');
				else failApi("Can not remove all products in cart");
			}
			else failApi('No command found');
		}
		else if(isset($_GET['command'])){
			$productID = (isset($_GET['productID'])) ? $_GET['productID'] : '';
			if($_GET['command'] == 'getQuantity'){
				$data = $cart->getQuantity($productID);
				if($data >= 1)
					successApi($data);
				else failApi("Can not get product quantity");
			}
			else if($_GET['command'] == 'getCartList'){
				$arr = [];
				$arr['cartList'] = $cart->getCartList();
				$arr['totalPrice'] = $cart->getTotalPrice();
				$arr['totalQuantity'] = $cart->getTotalQuantity();
				successApi($arr);
			}
			else if($_GET['command'] == 'getTotalPrice'){
				$data = $cart->getTotalPrice();
				successApi($data);
			}
			else if($_GET['command'] == 'getTotalQuantity'){
				$data = $cart->getTotalQuantity();
				successApi($data);
			}
			else failApi('No command found');
		}
		else failApi('No command found');
	}
	else failApi('No userID found');
?>