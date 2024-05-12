<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTAS</title>
    <style>
        /* Header */
        .header {
            height: 40px;
            background-color: #007bff;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            margin: 0;
        }

        .right-section {
            display: flex;
            align-items: center;
        }

        .profile-icon {
            margin-right: 10px;
            /* Profil ikonunun stilleri buraya eklenebilir */
        }

        .btn {
            background-color: #fff;
            color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
        }

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
            text-align: center;
        }

        .card {
            width: calc(25% - 10px); /* -50px ekranda 4 sütun oluşturur. */
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative; /* İkonu yerleştirmek için */
        }

        .card .location-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #007bff;
            cursor: pointer;
        }

        .card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            margin-top: 0;
        }

        .card p {
            margin-bottom: 8px;
            overflow: hidden; /* Paragraf içeriğini gizle */
            text-overflow: ellipsis; /* Uzun içerikleri kısalt */
            white-space: nowrap; /* Uzun satırları kısalt */
        }

/* modal */

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 500px;
    height: 300px;
    position: relative; /* Modal content'in konumunu ayarlamak için */
}

.close {
    color: #aaa;
    position: absolute;
    top: 0px;
    right: 6px;
    font-size: 22px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
    </style>
</head>
<body>

    <div class="container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Eczane/İlaç Ara...">
        <!--    <button id="searchButton">Ara</button>  -->
        </div>
        
        <div class="tabs">
            <div class="tab active" data-tab="pharmacies">Eczaneler</div>
            <div class="tab" data-tab="medicines">İlaçlar</div>
            <div class="tab" data-tab="workInProgress">Work in Progress</div>
        </div>

        <div class="card-container" id="cardContainer">
            <!-- Cardlar burada dinamik olarak oluşturulacak -->
        </div>

            <!-- Harita modalı -->
        <div id="mapModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeMapModal()">&times;</span>
                <iframe id="mapFrame" src="" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const tabs = document.querySelectorAll('.tab');
    const cardContainer = document.getElementById('cardContainer');
    let activeTab = 'pharmacies'; // Varsayılan olarak eczaneler sekmesi seçili

    // Tab değiştirme işlevi
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeTab = this.getAttribute('data-tab');
            // Arama yap
            search();
        });
    });

    // Arama işlevi
    function search() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const data = (activeTab === 'pharmacies') ? pharmacyData : medicineData;

        // Arama işlemi için gerekli verilerin varlığını kontrol et
        if (!searchInput || !data) return;

        // Arama terimine göre filtreleme yap
        const filteredData = data.filter(item => {
            // Verinin varlığını kontrol et
            if (activeTab === 'pharmacies' && item.EczaneAdi) {
                return item.EczaneAdi.toLowerCase().includes(searchTerm);
            } else if (activeTab === 'medicines' && item.IlacAdi) {
                return item.IlacAdi.toLowerCase().includes(searchTerm);
            }
        });

        // Kartları oluştur ve ekrana yazdır
        renderCards(filteredData);
    }

// Kartları oluşturma işlevi
function renderCards(data) {
    cardContainer.innerHTML = ''; // Önceki kartları temizle
    if (!data || data.length === 0) {
        cardContainer.innerHTML = '<p>Aradığınız kriterlere uygun veri bulunamadı.</p>';
        return;
    }
    data.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('card');
        card.innerHTML = `
            <img src="${item.GorselPath}">
            <h3>${(activeTab === 'pharmacies' && item.EczaneAdi) ? item.EczaneAdi : ((activeTab === 'medicines' && item.IlacAdi) ? item.IlacAdi : 'Bilgi Yok')}</h3>
            <p><strong>${(activeTab === 'pharmacies') ? 'Şehir:' : 'Eczane:'}</strong> ${(activeTab === 'pharmacies' && item.Sehir) ? item.Sehir : ((activeTab === 'medicines' && item.EczaneID) ? item.EczaneID : 'Bilgi Yok')}</p>
            ${(activeTab === 'pharmacies' || activeTab === 'medicines') ? `<button onclick="openMapModal('${item.gm_url}')">Göster</button>` : ''}
            ${(activeTab === 'pharmacies') ? `<p><strong>İlçe:</strong> ${(item.Ilce) ? item.Ilce : 'Bilgi Yok'}</p>` : ''}
            <p><strong>${(activeTab === 'pharmacies') ? 'Açıklama:' : 'TETT:'}</strong> ${(activeTab === 'pharmacies' && item.Aciklama) ? item.Aciklama : ((activeTab === 'medicines' && item.TETT) ? item.TETT : 'Bilgi Yok')}</p>
            ${(activeTab === 'medicines' && item.ESTASKod) ? `<p><strong>ESTAS Kod:</strong> ${item.ESTASKod}</p>` : ''}
        `;
        cardContainer.appendChild(card);
    });
}

        // Harita modalını aç
        window.openMapModal = function (mapUrl) {
            var modal = document.getElementById('mapModal');
            var mapFrame = document.getElementById('mapFrame');
            mapFrame.src = mapUrl;
            modal.style.display = "block";
        };

        // Harita modalını kapat
        window.closeMapModal = function () {
            var modal = document.getElementById('mapModal');
            modal.style.display = "none";
        };

    // Arama butonuna tıklama işlevi ekle
    if (searchInput) {
        searchInput.addEventListener('input', search);
    }

    // Verileri PHP'den al
    // PHP'den oluşturulan pharmacyData ve medicineData değişkenleri burada kullanılıyor.
});

    </script>

    <?php
    // Veritabanı bağlantısı ve verilerin alınması
    $servername = "localhost"; // Sunucu adı
    $username = "root"; // Veritabanı kullanıcı adı
    $password = ""; // Veritabanı şifre
    $dbname = "pharmacy_database"; // Veritabanı adı

    // Veritabanına bağlan
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Eczaneleri getir
    $sql_pharmacies = "SELECT * FROM eczaneler";
    $result_pharmacies = $conn->query($sql_pharmacies);

    $pharmacies = array();
    if ($result_pharmacies->num_rows > 0) {
        while ($row = $result_pharmacies->fetch_assoc()) {
            $pharmacies[] = $row;
        }
    }

    // İlaçları getir
    $sql_medicines = "SELECT * FROM ilaclar";
    $result_medicines = $conn->query($sql_medicines);

    $medicines = array();
    if ($result_medicines->num_rows > 0) {
        while ($row = $result_medicines->fetch_assoc()) {
            $medicines[] = $row;
        }
    }

    // Verileri JSON olarak döndür
    echo '<script>';
    echo 'var pharmacyData = ' . json_encode($pharmacies) . ';';
    echo 'var medicineData = ' . json_encode($medicines) . ';';
    echo '</script>';

    // Bağlantıyı kapat
    $conn->close();
    ?>

</body>
</html>