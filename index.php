<?php
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.shopier.com/v1/products",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxMjY0MTk4ZDdkOGY1ZWM5NWZmOGFlNDVlYzljYjI3OCIsImp0aSI6IjhmMzI4ZmFlZmE1NjcwOGQ2ZjkwOTMzMGEwNTNhOWJjMDNjZjI3MTA1ZmIzNTliMjgwMTJhYWU2OGM0MGJmNTNhNmEyZDdhZGM4Yjc2ZTlhMDYzZGQyMjg4ODcxNDMwMzFhOTU1ZDk5YTIxNDUzY2FhYWRlZmIzYzQ0NjNkZDRkODEzNDBkZWRlODU3N2QyZjBiMDg0NmQ0OTg0YzRhZGIiLCJpYXQiOjE3NDE3Mjg5OTYsIm5iZiI6MTc0MTcyODk5NiwiZXhwIjoxODk5NTEzNzU2LCJzdWIiOiIyMDE5NDU3Iiwic2NvcGVzIjpbIm9yZGVyczpyZWFkIiwib3JkZXJzOndyaXRlIiwicHJvZHVjdHM6cmVhZCIsInByb2R1Y3RzOndyaXRlIiwic2hpcHBpbmdzOnJlYWQiLCJzaGlwcGluZ3M6d3JpdGUiLCJkaXNjb3VudHM6cmVhZCIsImRpc2NvdW50czp3cml0ZSIsInBheW91dHM6cmVhZCIsInJlZnVuZHM6cmVhZCIsInJlZnVuZHM6d3JpdGUiLCJzaG9wOnJlYWQiLCJzaG9wOndyaXRlIl19.QWUrEHJpi1c065vZ8bTTbmknmOR2XpULAIqL_5RarwYtejl2c8_zx4YMX2yu1EaMlLF9c2Br0cq4eOe7P_9VUX9BHYLZ1QQUycmqBnaD0EhnEn_UVJ54WfuDpMBiINbms_7BAfPMABaq8YCEXSgjEW4N9dl3ZbeGuUpDNqiiaVCXBhDMi6XjlLA_4REzigolZIVV7Xj6lX_ujC7Wg8C1EVv7AYfyTH8RviTDjGtZuzJyNDDjabB53wQmSuEMlqwMP8WXnvCqlj4hCTfd4-icHt8f6-EV_lDZjJ2m2EXKP-5JYRau0f7GQsY-PbqUcUPsMhwM4dCNUsAS6y7GLuT7yA"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // JSON verisini decode et
    $data = json_decode($response, true);
}
?>
<!DOCTYPE html>
<html lang="TR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunestia</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/lunestia.ico">
</head>
<body>
<header>
        <input type="checkbox" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>
        <img src="img/lunestia.png" alt="lunestia">
        <a href="#" class="logo">Lunestia</a>
        <nav class="navbar">
            <a href="" class="dark" id="menuDarkModeToggle" onclick="smalldarkmode">Dark Mode</a>
        </nav>
        <div class="search">
            <form class="search" onsubmit="event.preventDefault(); searchProducts();">
                <input type="text" id="searchInput" placeholder="Ürün ara..." onkeyup="searchProducts()">
                <button type="submit">Ara</button>
            </form>
        </div>
        <!-- Dark Mode Butonu -->
        <div class="dark-mode-toggle">
        <button class="aabb" id="darkModeToggle" onclick="toggleDarkMode()">Dark Mode</button>
        </div>   
        <script>
        // Dark Mode Toggle Function
        document.addEventListener("DOMContentLoaded", function () {
    let darkModeToggle = document.getElementById("darkModeToggle"); // Masaüstü Butonu
    let menuDarkModeToggle = document.getElementById("menuDarkModeToggle"); // Mobil Menü Butonu
    let body = document.body;

    // Dark mode'u yerel depolamadan (localStorage) kontrol et
    if (localStorage.getItem("darkMode") === "enabled") {
        body.classList.add("dark-mode");
    }

    function toggleDarkMode() {
        body.classList.toggle("dark-mode");
        // Dark mode açık mı kontrol et ve localStorage'e kaydet
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("darkMode", "enabled");
        } else {
            localStorage.setItem("darkMode", "disabled");
        }
    }

    // Masaüstü butonuna tıklanınca dark mode aç/kapa
    if (darkModeToggle) {
        darkModeToggle.addEventListener("click", toggleDarkMode);
    }

    // Menüdeki butona tıklanınca dark mode aç/kapa
    if (menuDarkModeToggle) {
        menuDarkModeToggle.addEventListener("click", toggleDarkMode);
    }
});

    </script>   
</header>
    <div class="container" id="productList">
        <?php
        if (isset($data[0])) {
            foreach ($data as $product) {
              $product_id = $product['id'];
              $product_name = $product['title'];
              $product_description = substr($product['description'], 0, 10000) . '...'; // Açıklamadan ilk 100 karakteri al
              $product_price = $product['priceData']['price'] . ' ' . $product['priceData']['currency'];
              $stock_status = $product['stockStatus'];
        
              $image_url = $product['media'][0]['url'];
              $url = $product['url'];

              // Tabloya satır ekle
            echo "<div class='card'>
            <img src='{$image_url}' alt='{$product_name}'>
            <div class='card-content'>
            <h3 class'product-name'>{$product_name}</h3>
            <p class='price'>{$product_price}₺</p>
            <a href='{$url}' target='_blank' class='btn'>Satın Al</a>
            </div>
            </div>";
            }
        } else {
        echo "<tr><td colspan='5'>Ürün bulunamadı.</td></tr>";
        }
        ?>
    </div>
    <!--<script>
        function searchProducts() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let products = document.querySelectorAll(".card");

            products.forEach(product => {
                let productName = product.querySelector(".product-name").innerText.toLowerCase();
                if (productName.includes(input)) {
                    product.style.display = "block";
                } else {
                    product.style.display = "none";
                }
            });
        }
    </script>-->
    <script>
        // PHP'den gelen JSON verisini JavaScript'e aktarma
        const products = <?php echo json_encode($data); ?>;

        // Ürünleri sayfada göstermek için fonksiyon
        function displayProducts(products) {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';  // Her seferinde önce temizle

            products.forEach(product => {
                const productName = product.title;
                const productPrice = product.priceData.price + ' ' + product.priceData.currency;
                const imageUrl = product.media[0].url;
                const url = product.url;

                // Ürün kartı oluşturuluyor
                const card = document.createElement('div');
                card.classList.add('card');
                card.innerHTML = `
                    <img src="${imageUrl}" alt="${productName}">
                    <div class="card-content">
                        <h3 class="product-name">${productName}</h3>
                        <p class="price">${productPrice}</p>
                        <a href="${url}" target="_blank" class="btn">Satın Al</a>
                    </div>
                `;
                productList.appendChild(card);
            });
        }

        // Arama fonksiyonu
        function searchProducts() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const filteredProducts = products.filter(product => {
                return product.title.toLowerCase().includes(input);
            });
            displayProducts(filteredProducts);
        }

        // Sayfa yüklendiğinde tüm ürünleri göster
        displayProducts(products);
    </script>

    <footer>
        <input type="checkbox" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>
        <a href="#" class="logo">Lunestia</a>
        <nav class="navbar">
            <a href="https://www.shopier.com/s/store/Lunestia_Dukkan">Magaza Sayfasi</a>
        </nav>
    </footer>
    
</body>
</html>