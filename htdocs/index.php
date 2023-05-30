<?php

session_start();
$_SESSION['sadala']='sakums';

// datubāzes konekcija
include('db.php');

mysqli_set_charset($datu_baze,"utf8");
//parāda izvēlētās pasakas sākuma skatā
$pieprasijums = "SELECT * FROM pasaka WHERE ID_Pasaka IN (1, 6, 14, 24, 25)";
$rezultats = mysqli_query($datu_baze, $pieprasijums);

$pasaka="";
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('header.php'); ?>
</head>


<body>
    <?php include('navigacija.php'); ?>
    <div class="atstarpe"></div>
    <div class="saturs">
        <div class="vidus">
            <h1>Sveicināti Pasaciņā, digitālo pasaku pasaulē! izbaudiet pieejamās pasakas, vai arī veido savas!</h1>
        </div>
        <div class="vidus">
            <p>&emsp;Katras pasakas dziļumā ir iespējams atrast kādu metaforu. Pasakas spēj nodod zināšanas un sagatavot dzīvei. Tas ir veids kā jau agrīnā vecumā iepazīstināt cilvēku ar apkārtējās sabiedrības domāšanu un rīcības modeļiem, morāles normām un pasaules uzskatiem.</p>
            <br />
            <p>&emsp;Bērnam ļoti svarīgi ir mammas un tēta kopā būšanas laiks, ne tikai pasakas lasot, bet jebkādā veidā dzirdot vecāku balsis, tas veido savstarpējo saikni, bērns izjūt emocijas un seko līdzi reakcijām. Teksta animātors palīdz bērnam ne tikai klausīties pasakā, bet arī redzēt vizuāli pasakā attēloto fragmentu, tas palīdz vairāk iedziļināties un izjust stāstā iesaistītos personāžus. Lasot pasaku grāmatā, bērns redz tikai tekstu un bildi, bet ar teksta animātora palīdzību, tas iespējams padarīt animētu.</p>
        </div>
        <div class="vidus">
            <h1>Iepazīsti savādāku pasauli!</h1>
        </div>
        <?php
        $i=0;
        while($pasaka = $rezultats->fetch_assoc()){
            echo "
            <a href='pasaka.php?id=".$pasaka['ID_pasaka']."' class='pasakas_karts' style='background: url(\"atteli/".$pasaka['attels']."\");background-size: cover; background-repeat: no-repeat;'>
                <div>
                    <h3>" . $pasaka['nosaukums'] . "</h3>
                    <p>".$pasaka['apraksts']."</p>
                </div>
            </a>";
        }
        ?>
        </div>
</body>
    
</html>
