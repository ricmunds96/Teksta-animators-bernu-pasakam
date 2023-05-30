<?php
session_start();
$_SESSION['sadala']='pasakas';

// datubāzes konekcija
include('db.php');

if(isset($_POST['meklet_pasaku'])){
    // paņem visus datus no lietotāja izmantojot vairākas funkcijas, lai pasargātu no ļaunprātīgiem ierakstiem
    $nosaukums = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nosaukums'])));
    $pieprasijums = "SELECT * FROM pasaka WHERE Nosaukums LIKE CONCAT('%',?,'%') ORDER BY ID_pasaka LIMIT 30";
    $stmt = mysqli_prepare($datu_baze, $pieprasijums);
    mysqli_stmt_bind_param($stmt, "s", $nosaukums);
    mysqli_stmt_execute($stmt);
    $rezultats = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
}else{
    mysqli_set_charset($datu_baze,"utf8");
    $pieprasijums = "SELECT * FROM pasaka ORDER BY ID_pasaka LIMIT 30";
    $rezultats = mysqli_query($datu_baze, $pieprasijums);
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
        <div class="vidus">
            <h1>Pasaku katalogs</h1>
            <form id="meklet_pasaku" action="" method="POST">
                <h3>Meklēt pasaku:</h3><input type="text" name="nosaukums">
                <button type="submit" name="meklet_pasaku" class="meklet_poga">Meklēt</button>
            </form>
        </div>
        
        <?php
        $i=0;
        while($pasaka = mysqli_fetch_assoc($rezultats)){
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
