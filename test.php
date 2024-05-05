<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eczane Kartları</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-container {
          position: relative;
          width: 300px; /* Arama çubuğunun genişliği */
          margin: 0 auto; /* Sayfanın ortasında hizalama */
          padding: 10px;
        }

        .search-bar {
          width: 100%;
          padding: 8px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }

        .close-icon {
          position: absolute;
          top: 50%;
          right: 0;
          transform: translateY(-50%);
          cursor: pointer;
        }


        .card {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="search-container">
        
          <input type="text" placeholder="Ara" class="search-bar" id="searchInput">
          <span class="close-icon" >&times;</span>
    
        </div>
        
        <div class="card-container" id="cardContainer">
            <!-- Cardlar burada dinamik olarak oluşturulacak -->
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const closeIcon = document.querySelector(".close-icon");
            const cardContainer = document.getElementById("cardContainer");

            // Input alanını temizleme fonksiyonu
            function clearInput() {
                searchInput.value = "";
                searchInput.focus(); // Input alanına odaklan
            }

            // Arama fonksiyonu
            function performSearch() {
                const searchTerm = searchInput.value.toLowerCase();
                fetch("fetch_eczaneler.php?search=" + searchTerm)
                    .then(response => response.json())
                    .then(data => {
                        cardContainer.innerHTML = "";
                        data.forEach(pharmacy => {
                            const card = `
                                <div class="card">
                                    <img src="${pharmacy.GorselPath}" alt="${pharmacy.EczaneAdi}">
                                    <h3>${pharmacy.EczaneAdi}</h3>
                                    <p><strong>Şehir:</strong> ${pharmacy.Sehir}</p>
                                    <p><strong>İlçe:</strong> ${pharmacy.Ilce}</p>
                                    <p><strong>Açıklama:</strong> ${pharmacy.Aciklama}</p>
                                </div>
                            `;
                            cardContainer.innerHTML += card;
                        });
                    })
                    .catch(error => console.error("Hata:", error));
            }

            // Arama çubuğuna yazı yazıldığında veya silindiğinde arama yap
            searchInput.addEventListener("input", performSearch);

            // Kapatma butonuna tıklandığında input alanını temizle ve arama yap
            closeIcon.addEventListener("click", function() {
                clearInput();
                performSearch();
            });
        });
    </script>

</body>
</html>
