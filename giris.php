<?php
session_start();
// Şube listesini bir dosyadan veya diziden alabiliriz
$subeler = ["Sakarya", "İzmit", "Merkez"]; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secilen = $_POST['sube'];
    $sifre = $_POST['sifre'];

    if ($secilen == "ADMIN" && $sifre == "admin54") {
        $_SESSION['user'] = "ADMIN";
        header("Location: admin.php");
    } elseif (in_array($secilen, $subeler) && $sifre == "1234") {
        $_SESSION['user'] = $secilen;
        header("Location: depo.php");
    } else {
        $hata = "Hatalı şifre veya seçim!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bollimon Giriş</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="max-w card">
        <h1>BOLLİMON</h1>
        <?php if(isset($hata)) echo "<p style='color:red'>$hata</p>"; ?>
        <form method="POST">
            <select name="sube">
                <?php foreach($subeler as $s) echo "<option value='$s'>$s Şubesi</option>"; ?>
                <option value="ADMIN">⚠️ YÖNETİCİ</option>
            </select>
            <input type="password" name="sifre" placeholder="Şifre" required>
            <button type="submit">GİRİŞ YAP</button>
        </form>
    </div>
</body>
</html>
