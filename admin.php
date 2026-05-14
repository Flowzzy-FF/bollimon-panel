<?php
session_start();
if ($_SESSION['user'] != "ADMIN") header("Location: giris.php");

$veriler = json_decode(file_get_contents("veriler.json"), true) ?: [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="max-w">
        <h1>ADMİN PANELİ</h1>
        <div class="card">
            <canvas id="satisGrafik"></canvas>
        </div>
        
        <div class="card">
            <h3>Şube Durumları</h3>
            <table>
                <tr><th>Şube</th><th>Acısız</th><th>Acılı</th></tr>
                <?php foreach($veriler as $ad => $stok): ?>
                <tr>
                    <td><?php echo $ad; ?></td>
                    <td><?php echo $stok['acisiz']; ?> kg</td>
                    <td><?php echo $stok['acili']; ?> kg</td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <a href="giris.php">Güvenli Çıkış</a>
    </div>

    <script>
        const ctx = document.getElementById('satisGrafik');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($veriler)); ?>,
                datasets: [{
                    label: 'Toplam Stok (Kg)',
                    data: <?php echo json_encode(array_map(function($v){return $v['acisiz']+$v['acili'];}, $veriler)); ?>,
                    backgroundColor: '#fbbf24'
                }]
            }
        });
    </script>
</body>
</html>
