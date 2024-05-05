
<?php
// MySQL bağlantısı oluştur
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adı
$password = ""; // Veritabanı şifresi
$dbname = "pharmacy_database"; // Veritabanı adı
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Arama terimini al
if(isset($_GET['search'])){
    $searchTerm = $_GET['search'];

    // SQL sorgusunu hazırla ve yürüt
    $sql = "SELECT * FROM eczaneler WHERE EczaneAdi LIKE '%$searchTerm%' OR Sehir LIKE '%$searchTerm%' OR Ilce LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Sorgu hatası: " . $conn->error);
    }

    $pharmacies = array();

    if ($result->num_rows > 0) {
        // Her bir sonuç satırını al
        while($row = $result->fetch_assoc()) {
            $pharmacies[] = $row;
        }
    } else {
        echo "Eczane bulunamadı.";
    }

    // JSON formatında verileri döndür
    header('Content-Type: application/json');
    echo json_encode($pharmacies);
} else {
    echo "Arama terimi belirtilmedi.";
}

// Bağlantıyı kapat
$conn->close();
?>
