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

// Arama terimini ve tab adını al
if(isset($_GET['search']) && isset($_GET['tab'])){
    $searchTerm = $_GET['search'];
    $tabName = $_GET['tab'];

    // SQL sorgusunu hazırla ve yürüt
    $sql = "";
    if ($tabName === 'pharmacies') {
        $sql = "SELECT * FROM eczaneler WHERE EczaneAdi LIKE '%$searchTerm%' OR Sehir LIKE '%$searchTerm%' OR Ilce LIKE '%$searchTerm%'";
    } elseif ($tabName === 'medicines') {
        $sql = "SELECT * FROM ilaclar WHERE IlacAdi LIKE '%$searchTerm%' OR TedaviAmaci LIKE '%$searchTerm%'";
    } elseif ($tabName === 'workInProgress') {
        // İleride kullanılacak tablo buraya eklenebilir
    } else {
        die("Geçersiz tab adı.");
    }

    $result = $conn->query($sql);

    if ($result === false) {
        die("Sorgu hatası: " . $conn->error);
    }

    $data = array();

    if ($result->num_rows > 0) {
        // Her bir sonuç satırını al
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
} else {
    // Hata durumunda JSON formatında bir hata iletisi döndür
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Veri bulunamadı."));
}

    // JSON formatında verileri döndür
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "Arama terimi veya tab adı belirtilmedi.";
}

// Bağlantıyı kapat
$conn->close();
?>
