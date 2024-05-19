<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTAS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        body {
          --sb-track-color: #d4d4d4;
          --sb-thumb-color: #96bdb2;
          --sb-size: 14px;
        }

        body::-webkit-scrollbar {
          width: var(--sb-size)
        }

        body::-webkit-scrollbar-track {
          background: var(--sb-track-color);
          border-radius: 2px;
        }

        body::-webkit-scrollbar-thumb {
          background: var(--sb-thumb-color);
          border-radius: 2px;
          
        }

        @supports not selector(::-webkit-scrollbar) {
          body {
            scrollbar-color: var(--sb-thumb-color)
                             var(--sb-track-color);
          }
        }

        /* Header */
        .header {
            background: linear-gradient(90deg, #829da6,#d9e3d4,#d3dbcf,#849ea6);                                                
            color: #fff;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 98.5%;
            z-index: 1000;
            justify-content: space-between;
        }

        .logo {
            margin: 0;
            font-size: 24px;
            flex-shrink: 0;
        }

        #scrollTopButton {
            display: none; /* Başlangıçta görünmez */
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(144deg, #7ac1df, #c0f1b2); /* Hover rengi */
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            z-index: 1000;
            transition: opacity 0.3s, transform 0.3s ease-out;
        }

        #scrollTopButton:hover {
            background: linear-gradient(144deg, #7ac1df, #c0f1b2); /* Hover rengi */
            opacity: 70%;
        }

        /* Eklenen animasyon */
        #scrollTopButton.active {
            opacity: 1;
            transform: translateY(0);
        }

        .search-bar {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 240px;
        }

        .search-bar input[type="text"] {
            width: calc(100% - 20px); /* Etraftaki boşluklarla birlikte maksimum genişlik ayarı */
            max-width: 500px; /* Maksimum genişlik */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .data-not-found {
            margin-left: 115px;
        }

        .search-bar button {
            padding: 8px;
            border: none;
            border-radius: 5px;
            background-color: #fff;
            color: #007bff;
            cursor: pointer;
        }

        .login-button {
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-button:hover {
            background: linear-gradient(144deg, #7ac1df, #c0f1b2); /* Hover rengi */
            color: #fff; /* Metin rengi beyaz olacak */
        }

        .tabs {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-shrink: 0;
        }

        .tab {
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .tab:hover {
            background: linear-gradient(144deg, #7ac1df, #c0f1b2); /* Hover rengi */
            color: #fff; /* Metin rengi beyaz olacak */
        }

        .tab.active {
            background: linear-gradient(144deg, #7ac1df, #c0f1b2); /* Hover rengi */
            color: #fff;
            transform: translateY(0);
            opacity: 1;
        }

        .container {
            max-width: 70%;
            margin: 100px auto 0 auto; /* Header'ın yüksekliği kadar üst boşluk ekle */
            padding: 20px;
            /*background: linear-gradient(90deg, #f5d2a8,#dd94ff);        for gradient colors*/            
            min-width: ;                               
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            text-align: center;
        }

        .card {
            width: calc(25% - 80px); /* -50px ekranda 4 sütun oluşturur */
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 40px;
            position: relative; /* İkonu yerleştirmek için */
           /* background: linear-gradient(127deg, #9ee7ff,#e3fbd5); blue and green shades*/        
            background: -webkit-linear-gradient(137deg, #c8c6c6,#ffffff,#d9d9d9);
        }

        .card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            margin-top: 0;
            color: #595959; /* Metin rengi beyaz olacak */
        }

        .card p {
            color: #595959; /* Metin rengi beyaz olacak */
            margin-bottom: 8px;
            overflow: hidden; /* Paragraf içeriğini gizle */
            text-overflow: ellipsis; /* Uzun içerikleri kısalt */
            white-space: nowrap; /* Uzun satırları kısalt */
        }

        .card p strong {
            color: #595959; /* Metin rengi beyaz olacak */
            display: inline-block;
            width: 80px; /* İhtiyaca göre ayarlayabilirsiniz */
            font-weight: bold;
        }

        .location-icon {
            display: inline-block;
            margin-left: 10px; /* İhtiyaca göre ayarlayabilirsiniz */
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
            border-radius: 4px;
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

        .login-register {
            display: flex;
            align-items: center;
        }

        .login-register button {
            margin-left: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .login-register button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

    <div class="header">
        <div class="logo">ESTAS</div>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Eczane/İlaç Ara...">
            <span class="close" onclick="clearButtonHandler()">Temizle</span>
        </div>
        <div class="tabs">
            <div class="tab active" data-tab="pharmacies">Eczaneler</div>
            <div class="tab" data-tab="medicines">İlaçlar</div>
            <div class="tab" data-tab="workInProgress">Work in Progress</div>
        </div>
        <div class="login-register" >
            <span class="login-button" onclick="openForm()">Login</span>
        </div>
    </div>

    <div id="scrollTopButton"><i class="fas fa-arrow-up"></i></div>

    <div class="container">
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

        <!-- Login/Register Modal -->
    <div id="loginRegisterModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('loginRegisterModal')">&times;</span>
            <h2>Login/Register</h2>
            <div class="tab">
                <button class="tablinks active" onclick="openForm(event, 'loginForm')">Login</button>
                <button class="tablinks" onclick="openForm(event, 'registerForm')">Register</button>
            </div>
            <!-- Login Form -->
            <form id="loginForm" class="tabcontent" style="display: block;">
                <input type="text" id="loginEmail" placeholder="Email" required>
                <input type="password" id="loginPassword" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <!-- Register Form -->
            <form id="registerForm" class="tabcontent">
                <input type="text" id="registerName" placeholder="Name" required>
                <input type="text" id="registerEmail" placeholder="Email" required>
                <input type="password" id="registerPassword" placeholder="Password" required>
                <input type="password" id="registerConfirmPassword" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
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

    // İlk yüklendiğinde eczaneleri göster
    search();

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

    function clearButtonHandler() {
        searchInput.value = "";
        search();
    }

    // Kartları oluşturma işlevi
    function renderCards(data) {
        cardContainer.innerHTML = ''; // Önceki kartları temizle
        if (!data || data.length === 0) {
            cardContainer.innerHTML = '<div class="data-not-found"><p>Aradığınız kriterlere uygun veri bulunamadı.</p></div>';
            return;
        }
        data.forEach(item => {
            const card = document.createElement('div');
            card.classList.add('card');
            card.innerHTML = `
                <img src="${item.GorselPath}">
                <h3>${(activeTab === 'pharmacies' && item.EczaneAdi) ? item.EczaneAdi : ((activeTab === 'medicines' && item.IlacAdi) ? item.IlacAdi : 'Bilgi Yok')}</h3>
                <p><strong>${(activeTab === 'pharmacies') ? 'Şehir:' : 'Eczane:'}</strong> ${(activeTab === 'pharmacies' && item.Sehir) ? item.Sehir : ((activeTab === 'medicines' && item.EczaneAdi) ? item.EczaneAdi : 'Bilgi Yok')}</p>
                <p><strong>${(activeTab === 'pharmacies') ? 'Adres:' : 'Barkod:'}</strong> ${(activeTab === 'pharmacies' && item.Adres) ? item.Adres : ((activeTab === 'medicines' && item.Barkod) ? item.Barkod : 'Bilgi Yok')}</p>
                ${(activeTab === 'pharmacies') ? `<p><strong>Tel:</strong> ${item.Tel || 'Bilgi Yok'}</p>` : ''}
                ${(activeTab === 'pharmacies' || activeTab === 'medicines') ? `<div class="location-icon" onclick="openMapModal('${item.gm_url}')"><i class="fas fa-map-marker-alt"></i></div>` : ''}
                <p><strong>${(activeTab === 'pharmacies') ? 'Açıklama:' : 'TETT:'}</strong> ${(activeTab === 'pharmacies' && item.Aciklama) ? item.Aciklama : ((activeTab === 'medicines' && item.TETT) ? item.TETT : 'Bilgi Yok')}</p>
                ${(activeTab === 'medicines' && item.ESTASKod) ? `<p><strong>ESTAS Kod: </strong> ${item.ESTASKod}</p>` : ''}
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

    // Arama inputuna dinleme işlevi ekle
    if (searchInput) {
        searchInput.addEventListener('input', search);
    }

    // Sayfa yüklendiğinde ve kullanıcı aşağı kaydırdığında yukarı okun görünürlüğünü kontrol et
    window.addEventListener('scroll', function () {
        var scrollTopButton = document.getElementById("scrollTopButton");
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollTopButton.style.display = "block";
        } else {
            scrollTopButton.style.display = "none";
        }
    });

    // Yukarı okun tıklanma işlemini yakala
    document.getElementById("scrollTopButton").addEventListener('click', function () {
        document.body.scrollTop = 0; // Safari için
        document.documentElement.scrollTop = 0; // Diğer tarayıcılar için
    });

    // Login butonuna tıklanınca modalı aç
    document.querySelector('.login-register button:nth-child(1)').addEventListener('click', function () {
        var modal = document.getElementById('loginRegisterModal');
        modal.style.display = "block";
    });

        // Login/Register Modalı kapat
    window.closeLoginRegisterModal = function () {
        var modal = document.getElementById('loginRegisterModal');
        modal.style.display = "none";
    };

    // Attach event listener to the close button inside the login/register modal
    document.getElementById('loginRegisterModal').querySelector('.close').addEventListener('click', function () {
        closeLoginRegisterModal();
    });


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