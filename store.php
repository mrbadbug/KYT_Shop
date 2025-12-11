<?php
include 'session.php';
if(!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KYT Helmet Shop - Store</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="style.css">
<header class="w-full bg-black text-white p-4 flex justify-between items-center sticky top-0 z-[999]">
    <h1 class="text-2xl font-bold" style="-webkit-text-fill-color: white;">KYT Helmet Shop</h1>
    <div class="flex items-center space-x-4">
        <a href="buy.php" class="px-3 py-1 rounded hover:bg-blue-400">Buy a Item</a>
        <a href="logout.php" class="px-3 py-1 rounded bg-purple-600 hover:bg-purple-700 text-white">Logout</a>
    </div>
</header>
<style>

.footer-marquee {position:fixed;bottom:0;left:0;width:100%;height:40px;overflow:hidden;background-color:#1f2937;display:flex;align-items:center;z-index:999;}
.marquee{display:inline-block;white-space:nowrap;animation:scroll-right 15s linear infinite;color:white;}
@keyframes scroll-right{0%{transform:translateX(-100%);}100%{transform:translateX(100%);}}
</style>
</head>
<body>
<div class="hero-section"></div>

<footer class="footer-marquee">
    <div class="marquee">Welcome to KYT Helmet Shop — High-quality helmets for maximum safety. Explore our latest collection now!</div>
</footer>
</body>
</html>

<html>
    <style>.hero-section{
  position: relative;
  width: 100%;
  height: 89vh;
  background-size: cover;
  background-position: center;
  animation: animate 50s infinite ease-in-out;
}
.hero-section::before{
  content:"";
  position:absolute;
  inset:0;
  background: rgba(0,0,0,0.4);
  z-index:1;
}
@keyframes animate{
  0%{ background-image: url(static/images/home-slider-2.jpg);}
  10%{ background-image: url(static/images/quartararos-test-the-m1-wearing-a-kyt-helmet-and-using-a-v0-gq7eooshbc3e1.jpg);}
  20%{ background-image: url(static/images/BJND3325_P_1.webp);}
  30%{ background-image: url(static/images/NZ-Race_featured_blake_davis.webp);}
  40%{ background-image: url(static/images/Cal-Crutchlow.jpg);}
  50%{ background-image: url(static/images/slider_01.webp);}
  60%{ background-image: url(static/images/kyt_banner.webp);}
  70%{ background-image: url(static/images/gez7u7.jpg);}
  80%{ background-image: url(static/images/Cascos-moto-KYT-Helmets-Ramirez.jpg);}
  90%{ background-image: url(static/images/slider_03.webp);}
  100%{ background-image: url(static/images/g8.jpg);}
}</style>
</html>
