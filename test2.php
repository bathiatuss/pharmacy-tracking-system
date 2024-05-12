<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTAS</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-bar {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            width: 70%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            width: 20%;
            padding: 8px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .tabs {
            text-align: center;
            padding-bottom: 30px;
        }

        .tab {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .tab.active {
            background-color: #007bff;
            color: #fff;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .card {
            width: calc(25% - 10px); /* Kartların genişliği 25% */
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
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Eczane/İlaç Ara...">
            <button id="searchButton">Ara</button>
        </div>
        
        <div class="tabs">
            <div class="tab active" data-tab="pharmacies">Eczaneler</div>
            <div class="tab" data-tab="medicines">İlaçlar</div>
            <div class="tab" data-tab="workInProgress">Work in Progress</div>
        </div>

        <div class="card-container" id="cardContainer">
            <!-- Cardlar burada dinamik olarak oluşturulacak -->
        </div>

    </div>

    <script>

        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("searchInput");
            const searchButton = document.getElementById("searchButton");
            const cardContainer = document.getElementById("cardContainer");
            const tabs = document.querySelectorAll(".tab");

            // Default olarak eczaneler sekmesini aktif yap
            showTab('pharmacies');

            // Sekme tıklama olayını dinle
            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    const tabName = this.getAttribute("data-tab");
                    showTab(tabName);
                });
            });

// Sekme içeriğini gösterme fonksiyonu
function showTab(tabName) {
    // Arama çubuğunu temizle
    searchInput.value = "";

    // Tüm sekmelerin aktiflik durumunu kaldır
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });

    // Tüm kartları temizle
    cardContainer.innerHTML = "";

    // Seçilen sekmenin aktiflik durumunu ekle
    document.querySelector(`.tab[data-tab="${tabName}"]`).classList.add('active');

    // Veritabanından verileri çek ve cardlara ekle
    if(tabName === 'pharmacies') {
        fetch("fetch_eczaneler.php?tab=" + tabName)
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    const card = `
                        <div class="card">
                            <img src="${item.GorselPath}">
                            <h3>${item.EczaneAdi}</h3>
                            <p><strong>Şehir:</strong> ${item.Sehir}</p>
                            <p><strong>İlçe:</strong> ${item.Ilce}</p>
                            <p><strong>Açıklama:</strong> ${item.Aciklama}</p>
                        </div>
                    `;
                    cardContainer.innerHTML += card;
                });
            })
            .catch(error => console.error("Hata:", error));
            
    } else if(tabName === 'medicines') {
        fetch("fetch_ilaclar.php?tab=" + tabName)
            .then(response => response.json())
            .then(data => {
                data.forEach(item => {
                    const card = `
                        <div class="card">
                            <img src="${item.GorselPath}">
                            <h3>${item.IlacAdi}</h3>
                            <p><strong>Eczane:</strong> ${item.EczaneID}</p>
                            <p><strong>Fiyat:</strong> ₺${item.Fiyat}</p>
                            <p><strong>TETT:</strong> ${item.TETT}</p>
                            <p><strong>ESTAS Kod:</strong> ${item.ESTASKod}</p>
                        </div>
                    `;
                    cardContainer.innerHTML += card;
                });
            })
            .catch(error => console.error("Hata:", error));
    }
}

            // Arama butonu tıklama olayını dinle
            searchButton.addEventListener("click", function() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeTab = document.querySelector('.tab.active');
                const activeTabName = activeTab.getAttribute('data-tab');
                fetch("fetch_eczaneler.php?search=" + searchTerm + "&tab=" + activeTabName)
                    .then(response => response.json())
                    .then(data => {
                        cardContainer.innerHTML = "";
                        data.forEach(item => {
                            const card = `
                                <div class="card">
                                    <img src="${item.GorselPath}" alt="${item.EczaneAdi}">
                                    <h3>${item.EczaneAdi}</h3>
                                    <p><strong>Şehir:</strong> ${item.Sehir}</p>
                                    <p><strong>İlçe:</strong> ${item.Ilce}</p>
                                    <p><strong>Açıklama:</strong> ${item.Aciklama}</p>
                                </div>
                            `;
                            cardContainer.innerHTML += card;
                        });
                    })
                    .catch(error => console.error("Hata:", error));
            });
        });
    </script>
</body>
</html>
