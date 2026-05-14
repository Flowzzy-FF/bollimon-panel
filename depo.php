<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == "ADMIN") header("Location: giris.php");

$sube = $_SESSION['user'];
// Basit bir veri saklama simülasyonu
$dosya = "veriler.json";
$veriler = json_decode(file_get_contents($dosya), true) ?: [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $veriler[$sube] = [
        'acisiz' => $_POST['acisiz_stok'],
        'acili' => $_POST['acili_stok'],
        'son_guncelleme' => date("H:i:s")
    ];
    file_put_contents($dosya, json_encode($veriler));
    $mesaj = "Stoklar başarıyla güncellendi!";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $sube; ?> Depo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="max-w card">
        <h2><?php echo $sube; ?> Şubesi Paneli</h2>
        <form method="POST">
            <div class="grid">
                <label>Acısız (Kg)</label>
                <input type="number" name="acisiz_stok" value="<?php echo $veriler[$sube]['acisiz'] ?? 0; ?>">
                <label>Acılı (Kg)</label>
                <input type="number" name="acili_stok" value="<?php echo $veriler[$sube]['acili'] ?? 0; ?>">
            </div>
            <button type="submit" class="btn-yellow">KAYDET</button>
        </form>
        <a href="giris.php">Çıkış Yap</a>
    </div>
</body>
</html>
