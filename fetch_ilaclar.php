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

// İlaçlar tablosundan verileri çek
$sql = "SELECT * FROM ilaclar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $drugs = array();
    while ($row = $result->fetch_assoc()) {
        $drugs[] = $row;
    }
    // JSON formatında verileri döndür
    header('Content-Type: application/json');
    echo json_encode($drugs);
 } else {
    // Hata durumunda JSON formatında bir hata iletisi döndür
    header('Content-Type: application/json');
    echo json_encode(array("error" => "İlaç bulunamadı."));
}

// Bağlantıyı kapat
$conn->close();
?>
