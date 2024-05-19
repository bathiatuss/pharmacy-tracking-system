<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy_database";

// Bağlantı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Eczane ID'sini sabit belirle (Örnek olarak 10)
$eczane_id = 10;

// Eczane bilgilerini almak için sorgu hazırla ve çalıştır
$eczane_sql = "SELECT * FROM eczaneler WHERE EczaneID = ?";
$stmt = $conn->prepare($eczane_sql);
$stmt->bind_param("i", $eczane_id);
$stmt->execute();
$eczane_result = $stmt->get_result();

// İlaç bilgilerini almak için sorgu hazırla ve çalıştır
$ilac_sql = "SELECT * FROM ilaclar WHERE EczaneID = ?";
$stmt = $conn->prepare($ilac_sql);
$stmt->bind_param("i", $eczane_id);
$stmt->execute();
$ilac_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eczane Detayları</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
.container {
    max-width: 70%;
    margin: 50px auto;
    padding: 20px;
    background: #f0f0f0;
    border-radius: 10px;
}

.card {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.card h3 {
    margin-top: 0;
}

.card p {
    color: #595959;
    margin-bottom: 8px;
}

.back-button {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
}

.back-button:hover {
    background: #0056b3;
}
    </style>
</head>
<body>
    <div class="container">
        <!-- Geri dön butonu -->
        <a href="javascript:history.back()" class="back-button"><i class="fas fa-arrow-left"></i> Geri</a>

        <!-- Eczane bilgileri -->
        <?php if ($eczane_result->num_rows > 0): ?>
            <?php while($eczane = $eczane_result->fetch_assoc()): ?>
                <div class="card">
                    <h3><?php echo $eczane['EczaneAdi']; ?></h3>
                    <p><strong>Şehir:</strong> <?php echo $eczane['Sehir']; ?></p>
                    <p><strong>Adres:</strong> <?php echo $eczane['Adres']; ?></p>
                    <p><strong>Telefon:</strong> <?php echo $eczane['Tel']; ?></p>
                    <p><strong>Açıklama:</strong> <?php echo $eczane['Aciklama']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Eczane bilgileri bulunamadı.</p>
        <?php endif; ?>

        <!-- İlaç bilgileri -->
        <h3>Bu Eczanedeki İlaçlar</h3>
        <?php if ($ilac_result->num_rows > 0): ?>
            <?php while($ilac = $ilac_result->fetch_assoc()): ?>
                <div class="card">
                    <p><strong>İlaç Adı:</strong> <?php echo $ilac['IlacAdi']; ?></p>
                    <p><strong>Barkod:</strong> <?php echo $ilac['Barkod']; ?></p>
                    <p><strong>Son Kullanma Tarihi:</strong> <?php echo $ilac['TETT']; ?></p>
                    <p><strong>ESTAS Kod:</strong> <?php echo $ilac['ESTASKod']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Bu eczanede kayıtlı ilaç bulunmamaktadır.</p>
        <?php endif; ?>

    </div>
</body>
</html>
