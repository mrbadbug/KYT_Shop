<?php
session_start();
include 'db.php';        
include 'session.php';   

if(!isset($_SESSION['user'])){
    header("Location: store.php");
    exit;
}

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['add_to_cart'])){
    $id = intval($_POST['product_id']);
    $qty = intval($_POST['quantity']);

    foreach($products as $p){
        if($p['id'] == $id){
            $found = false;
            foreach($_SESSION['cart'] as &$item){
                if($item['id'] == $id){
                    $item['quantity'] += $qty;
                    $found = true;
                    break;
                }
            }
            if(!$found){
                $_SESSION['cart'][] = [
                    "id"=>$p['id'],
                    "name"=>$p['name'],
                    "price"=>$p['price'],
                    "quantity"=>$qty,
                    "image_url"=>$p['image_url']
                ];
            }
            break;
        }
    }
    header("Location: buy.php");
    exit;
}

if(isset($_POST['checkout'])){
    $_SESSION['cart'] = [];
    $message = "Order placed successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KYT Helmet Shop - Buy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
<style>
.card-container{display:flex;flex-wrap:wrap;gap:20px;padding:30px;justify-content:center;}
.product-card{background:#111;color:#fff;border-radius:12px;overflow:hidden;width:250px;transition:0.3s;}
.product-card:hover{transform:translateY(-5px);}
.product-card img{width:100%;height:180px;object-fit:cover;}
.card-content{padding:15px;-webkit-text-fill-color:white;}
.card-content h3{font-size:18px;margin-bottom:8px;}
.card-content p{margin-bottom:8px;font-size:15px;}
.checkout-btn{background:green;color:white;padding:8px 12px;border:none;border-radius:6px;width:100%;cursor:pointer;transition:0.2s;}
.checkout-btn:hover{background:#059669;}
</style>
</head>
<body class="bg-black">

<header class="w-full bg-black text-white p-4 flex justify-between items-center sticky top-0 z-[999]">
    <h1 class="text-2xl font-bold">KYT Helmet Shop</h1>
    <div class="flex items-center space-x-4">
        <a href="store.php" class="px-3 py-1 rounded hover:bg-blue-400">Back to Store</a>
        <a href="logout.php" class="px-3 py-1 rounded bg-purple-600 hover:bg-purple-700">Logout</a>
        <button id="open-cart" class="bg-green-500 px-3 py-1 rounded hover:bg-green-600">
            🛒 <span id="cart-count"><?php echo cartCount(); ?></span>
        </button>
    </div>
</header>

<?php if(isset($message)) echo "<p class='text-center text-green-600 font-bold my-2'>$message</p>"; ?>

<div class="card-container">
<?php foreach ($products as $p): ?>
<div class="product-card">
    <img src="static/images/<?php echo $p['image_url']; ?>" alt="<?php echo $p['name']; ?>">
    <div class="card-content">
        <h3><?php echo $p['name']; ?></h3>
        <p><?php echo $p['description']; ?></p>
        <p class="font-bold">$<?php echo $p['price']; ?></p>
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            <input type="number" name="quantity" value="1" min="1" class="border rounded px-2 py-1 w-16 mb-2" style="-webkit-text-fill-color:black;">
            <button type="submit" name="add_to_cart" class="checkout-btn">Add to Cart</button>
        </form>
    </div>
</div>
<?php endforeach; ?>
</div>

<div id="cart-sidebar" class="fixed top-0 right-0 h-full w-80 bg-black shadow-lg transform translate-x-full transition-transform duration-300 z-50 flex flex-col">
    <div class="flex justify-between items-center p-4 border-b">
        <h2 class="text-xl font-bold text-white">Your Cart</h2>
        <button id="close-cart" class="text-red-600 font-bold text-xl">&times;</button>
    </div>

    <div id="cart-items" class="flex-1 overflow-y-auto p-4 space-y-4 text-white">
        <?php foreach($_SESSION['cart'] as $item): ?>
        <div class="flex justify-between items-center p-2 border rounded shadow-sm">
            <div>
                <h3 class="font-bold"><?php echo $item['name']; ?></h3>
                <p>$<?php echo $item['price']; ?></p>
                <p>Qty: <?php echo $item['quantity']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="p-4 border-t text-white">
        <p class="font-bold text-lg">Total: $<?php echo cartTotal(); ?></p>
        <form method="POST">
            <button type="submit" name="checkout" class="checkout-btn w-full mt-2">Checkout</button>
        </form>
    </div>
</div>

<script>
const openCartBtn = document.getElementById("open-cart");
const closeCartBtn = document.getElementById("close-cart");
const cartSidebar = document.getElementById("cart-sidebar");
    
openCartBtn.addEventListener("click", () => {
    cartSidebar.classList.remove("translate-x-full");
    cartSidebar.classList.add("translate-x-0");
});
closeCartBtn.addEventListener("click", () => {
    cartSidebar.classList.remove("translate-x-0");
    cartSidebar.classList.add("translate-x-full");
});

document.addEventListener("click", (e) => {
    if (!cartSidebar.contains(e.target) && !openCartBtn.contains(e.target)) {
        cartSidebar.classList.add("translate-x-full");
        cartSidebar.classList.remove("translate-x-0");
    }
});

openCartBtn.addEventListener("click",()=>{cartSidebar.classList.remove("translate-x-full");cartSidebar.classList.add("translate-x-0");});
closeCartBtn.addEventListener("click",()=>{cartSidebar.classList.remove("translate-x-0");cartSidebar.classList.add("translate-x-full");});
</script>

</body>
</html>
