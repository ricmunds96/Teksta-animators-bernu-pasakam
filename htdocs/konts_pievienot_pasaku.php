<?php

session_start();

// datubāzes konekcija
include('db.php');

$nosaukums = "";
$apraksts = "";
$pasaka = "";
$e_pasts = "";
$attela_fails = "";
$kludas = array();

// datubāzes konekcija
include('db.php');

// pasakas izveidošana
if (isset($_POST['izveidot_pasaku'])) {
    if(!empty($_FILES["attels"]["name"])){
        $attelu_mape = "atteli/";
        $attels = $attelu_mape . basename($_FILES["attels"]["name"]);

        // pārbauda vai dotais fails ir attēls
        $faila_tips = mime_content_type ($_FILES["attels"]["tmp_name"]);
        $atlautie_formati = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/bmp', 'image/webp'];
        if(!in_array($faila_tips, $atlautie_formati)) {
            $kludas[]="Fails nav attēls";
        }

        // pārbauda vai attēla izmērs nav lielāks par 1mb
        if ($_FILES["attels"]["size"] > 1000000) {
          $kludas[]="Attēls nevar pārsniegt 1mb izmēru";
        }

        if (count($kludas) == 0) {
            $sadalits_attela_nosaukums = explode(".", $attels);
            $attela_vards = explode("/", $sadalits_attela_nosaukums[0]);
            $attela_vards = $attela_vards[1];
            $attela_fails = round(microtime(true)). $attela_vards .'.' . end($sadalits_attela_nosaukums);
        }
    }



    // paņem visus datus no lietotāja izmantjot vairākas funkcijas, lai pasargātu no ļaunprātīgiem ierakstiem
    $nosaukums = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nosaukums'])));
    $apraksts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['apraksts'])));
    $pasaka = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['pasaka'])));

    // pasakas datu pārbaude
    if(empty($nosaukums)){ $kludas[]="Nepieciešams pasakas nosaukums"; }
    if(strlen($nosaukums) > '100'){ $kludas[]="Pasakas nosaukums garāks par 100 simboliem"; }
    if(empty($apraksts)){ $kludas[]="Nepieciešams apraksts"; }
    if(strlen($apraksts) > '500'){ $kludas[]="Araksts ir garāks par 500 simboliem"; }
    if(empty($pasaka)){ $kludas[]="Nepieciešams pasakas teksts"; }

    //pasakas formatējums
    $pasakas_teksts = $pasaka;
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\ \n.?!][«»]/', '', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[\t\n\r]/m', ' ', $pasakas_teksts);
    $teikumi = preg_split('/([^.!?]+[.!?]+)/', $pasakas_teksts, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $pasakas_teksts = preg_replace('/[?!]/', '.', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\«» .]/', '', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\ .][«»]/', ' ', $pasakas_teksts);
    $pasaka = $pasakas_teksts;

    // pasakas vārda pieejamības pārbaude
    $pieprasijums = "SELECT * FROM pasaka WHERE nosaukums='$nosaukums'";
    $rezultats = mysqli_query($datu_baze, $pieprasijums);
    $eksistejosa_pasaka = mysqli_fetch_assoc($rezultats);
    if($eksistejosa_pasaka){
        if ($eksistejosa_pasaka['nosaukums'] === $nosaukums){
            $kludas[]="Pasaka ar šādu nosaukumu jau eksistē";
        }
    }

    // ja nav kļūdu tad saglabā pasaku
    if (count($kludas) == 0) {
        $e_pasts = $_SESSION['e_pasts'];
        $pieprasijums = "SELECT ID_konts FROM konts WHERE e_pasts='$e_pasts'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $lietotajs = mysqli_fetch_assoc($rezultats);
        if($lietotajs){
            if(!empty($_FILES["attels"]["name"])){
                if (!move_uploaded_file($_FILES["attels"]["tmp_name"], "atteli/" . $attela_fails)) {
                    $kludas[]="Neizdevās saglabāt attēlu";
                }
            }
            if (count($kludas) == 0) {
                $lietotajs = $lietotajs['ID_konts'];
                if (!empty($_FILES["attels"]["name"])) {
                    $ievietojamais = "INSERT INTO pasaka (nosaukums, apraksts, pasaka, ID_konts, attels) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($datu_baze, $ievietojamais);
                    mysqli_stmt_bind_param($stmt, 'sssis', $nosaukums, $apraksts, $pasaka, $lietotajs, $attela_fails);
                }else{
                    $ievietojamais = "INSERT INTO pasaka (nosaukums, apraksts, pasaka, ID_konts) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($datu_baze, $ievietojamais);
                    mysqli_stmt_bind_param($stmt, 'sssi', $nosaukums, $apraksts, $pasaka, $lietotajs);
                }
                $izveidosana = mysqli_stmt_execute($stmt);
                if(!$izveidosana){
                    $kludas[]="Neizdevās pievienot pasaku";
                }else{
                    header('location: konts_pasakas.php');
                }
            }
        }else{
            $kludas[]="Neizdevās iegūt lietotāja ID, mēģiniet iziet un ieiet savā kontā";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include('header.php'); ?>
</head>

<body>
    <?php include('navigacija.php'); ?>
    <div class='atstarpe'></div>
    <div class='saturs'>
        <div class="vidus">
            


            <h3 class="atstarpe_auksa">Pasakas izveidošana</h3>
            <?php if(count($kludas)>0){
            foreach ($kludas as $kluda){
                  echo "<p class='kluda'>$kluda</p>";
            }
            } ?>
            <form enctype="multipart/form-data" method="post">
                <h2>Nosaukums</h2>
                <input maxlength="100" value="<?php echo $nosaukums ?>" type="text" name="nosaukums" class="ievade_ievads" placeholder="Nosaukums" autofocus required>
                <h2>Apraksts</h2>
                <textarea maxlength="500" value="<?php echo $apraksts ?>" type="text" name="apraksts" class="ievade_videjs ievade_ievads" placeholder="Apraksts"></textarea>
                <h2>Teksts</h2>
                <textarea value="<?php echo $pasaka ?>" type="textarea" name="pasaka" class="ievade_gars ievade_ievads" placeholder="Pasaka" required></textarea>
                
                <h2>Titullapas attēls:</h2>
                <input type="file" class="ievade_attels" name="attels">
                <button type="submit" name="izveidot_pasaku" class="liela_poga">Izveidot pasaku</button>
            </form>

        </div>
    </div>  
        
</body>
    
</html>