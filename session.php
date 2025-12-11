<?php
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cart helpers
function cartCount() {
    $count = 0;
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $item) $count += $item['quantity'];
    }
    return $count;
}

function cartTotal() {
    $total = 0;
    if(isset($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $item) $total += $item['price'] * $item['quantity'];
    }
    return $total;
}
?>
