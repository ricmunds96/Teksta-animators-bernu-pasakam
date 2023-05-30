<?php

session_start();
$_SESSION['sadala']='konts';

// datubāzes konekcija
include('db.php');

$e_pasts = $_SESSION['e_pasts'];
$pieprasijums = "SELECT ID_konts FROM konts WHERE e_pasts='$e_pasts'";
$rezultats = mysqli_query($datu_baze, $pieprasijums);
$lietotajs = mysqli_fetch_assoc($rezultats);
$id_konts = $lietotajs["ID_konts"];
    
if(isset($_POST['meklet_pasaku'])){
    if($lietotajs){
        // paņem visus datus no lietotāja izmantojot vairākas funkcijas, lai pasargātu no ļaunprātīgiem ierakstiem
        $nosaukums = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nosaukums'])));
        $pieprasijums = "SELECT * FROM pasaka WHERE Nosaukums LIKE CONCAT('%',?,'%') AND ID_konts=? ORDER BY ID_pasaka LIMIT 30";
        $stmt = mysqli_prepare($datu_baze, $pieprasijums);
        mysqli_stmt_bind_param($stmt, "si", $nosaukums,$id_konts);
        mysqli_stmt_execute($stmt);
        $rezultats = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }else{
        
    }
}else{
    mysqli_set_charset($datu_baze,"utf8");
    $pieprasijums = "SELECT * FROM pasaka WHERE ID_konts=? ORDER BY ID_pasaka LIMIT 30";
    $stmt = mysqli_prepare($datu_baze, $pieprasijums);
    mysqli_stmt_bind_param($stmt, "i", $id_konts);
    mysqli_stmt_execute($stmt);
    $rezultats = mysqli_stmt_get_result($stmt);
}
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
        <button id="pievienot_pasaku" onclick="location.href='konts_pievienot_pasaku.php';" >Pievienot pasaku</button>
        <div class="vidus">
            <h1>Jūsu veidotās pasakas</h1>
            <form id="meklet_pasaku" action="" method="POST">
                <h3>Meklēt pasaku:</h3><input type="text" name="nosaukums">
                <button class="meklet_poga" type="submit" name="meklet_pasaku">Meklēt</button>
            </form>
        </div>
        
        <?php
        $i=0;
        while($pasaka = mysqli_fetch_assoc($rezultats)){
            echo "
            <div class='pasakas_karts' style='background: url(\"atteli/".$pasaka['attels']."\");background-size: cover; background-repeat: no-repeat; background-position: center;'>
                <div>
                    <h3>" . $pasaka['nosaukums'] . "</h3>
                    <p>".$pasaka['apraksts']."</p>
                    <span class='pasakas_karts_pogu_atstarpe'></span>
                    <button class='sakt_pasaku' onclick=\"location.href='pasaka.php?id=".$pasaka['ID_pasaka']."&lapa=0'\" >Sākt pasaku</button>
                    <button class='labot_pasaku' onclick=\"location.href='konts_labot_pasaku.php?id= ".$pasaka["ID_pasaka"]." '\" >Labot pasaku</button>
                </div>
            </div>"
            ;
        }
        ?>
    </div>
</body>
    
</html>
