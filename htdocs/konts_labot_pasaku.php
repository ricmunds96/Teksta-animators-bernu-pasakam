<?php

session_start();

// datubāzes konekcija
include('db.php');

$nosaukums = "";
$apraksts = "";
$pasakas_teksts = "";
$e_pasts    = "";
$kludas = array();

if(isset($_POST['saglabat_pasaku'])){
    if(isset($_GET['id'])){
        $ID_pasaka = $_GET['id'];
        // pasakas labošana
        $pieprasijums = "SELECT ID_pasaka, ID_konts FROM pasaka WHERE ID_pasaka='$ID_pasaka'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $pasaka = mysqli_fetch_assoc($rezultats);
        if($pasaka){
            $e_pasts = $_SESSION['e_pasts'];
            $pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$e_pasts'";
            $rezultats = mysqli_query($datu_baze, $pieprasijums);
            $lietotajs = mysqli_fetch_assoc($rezultats);
            if($lietotajs){
                if($lietotajs['ID_konts'] == $pasaka['ID_konts']){
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
                    
                    $ID_pasaka=$pasaka['ID_pasaka'];
                    // paņem visus datus no lietotāja izmantojot vairākas funkcijas, lai pasargātu no ļaunprātīgiem ierakstiem
                    $nosaukums = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nosaukums'])));
                    $apraksts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['apraksts'])));
                    $pasakas_teksts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['pasaka'])));
                    
                    // pasakas datu pārbaude
                    if(empty($nosaukums)){ $kludas[]="Nepieciešams pasakas nosaukums"; }
                    if(strlen($nosaukums) > '100'){ $kludas[]="Pasakas nosaukums garāks par 100 simboliem"; }
                    if(empty($apraksts)){ $kludas[]="Nepieciešams apraksts"; }
                    if(strlen($apraksts) > '500'){ $kludas[]="Araksts ir garāks par 500 simboliem"; }
                    if(empty($pasakas_teksts)){ $kludas[]="Nepieciešams pasakas teksts"; }
                
                    // vārda pieejamības pārbaude
                    $pieprasijums = "SELECT * FROM pasaka WHERE nosaukums='$nosaukums' AND ID_pasaka != $ID_pasaka";
                    $rezultats = mysqli_query($datu_baze, $pieprasijums);
                    $pasaka = mysqli_fetch_assoc($rezultats);
                    if($pasaka){
                        if ($pasaka['Nosaukums'] === $nosaukums){
                            $kludas[]="Cita pasaka jau eksistē ar šo nosaukumu";
                        }
                    }
                    
                    // ja nav kļūdu tad saglabā izmaiņas pasakā
                    if (count($kludas) == 0) {
                        if(!empty($_FILES["attels"]["name"])){
                            if (!move_uploaded_file($_FILES["attels"]["tmp_name"], "atteli/" . $attela_fails)) {
                                $kludas[]="Neizdevās saglabāt attēlu";
                            }
                        }
                        if (count($kludas) == 0) {
                            $lietotajs = $lietotajs['ID_konts'];
                            
                            if(!empty($_FILES["attels"]["name"])){
                                $atjaunojamais = "UPDATE pasaka SET nosaukums=?, apraksts=?, pasaka=?, attels=? WHERE ID_konts=? AND ID_pasaka=?";
                                $stmt = mysqli_prepare($datu_baze, $atjaunojamais);
                                mysqli_stmt_bind_param($stmt, 'ssssii', $nosaukums, $apraksts, $pasakas_teksts, $attela_fails, $lietotajs, $ID_pasaka);
                            }else{
                                $atjaunojamais = "UPDATE pasaka SET nosaukums=?, apraksts=?, pasaka=? WHERE ID_konts=? AND ID_pasaka=?";
                                $stmt = mysqli_prepare($datu_baze, $atjaunojamais);
                                mysqli_stmt_bind_param($stmt, 'sssii', $nosaukums, $apraksts, $pasakas_teksts, $lietotajs, $ID_pasaka);
                            }
                            $labosana = mysqli_stmt_execute($stmt);
                            if(!$labosana){
                                $kludas[]="Neizdevās labot pasaku";
                            }else{
                                header('location: konts_pasakas.php');
                            }
                        }
                    }
                }else{
                    $kludas[]="Pasaka nepieder šim lietotājam";
                }
            }else{
                $kludas[]="Neatrada lietotāju";
            }
        }
    }else{
        $kludas[]="Pasakas izmaiņas neizdevās saglabāt";
    }
    
    
    
}else if(isset($_POST['dzest_pasaku'])){
    if(isset($_GET['id'])){
        $ID_pasaka = $_GET['id'];
        $e_pasts = $_SESSION['e_pasts'];
        $pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$e_pasts'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $lietotajs = mysqli_fetch_assoc($rezultats);
        if($lietotajs){
            $ID_konts = $lietotajs['ID_konts'];
            $pieprasijums = "DELETE FROM pasaka WHERE ID_pasaka=$ID_pasaka AND ID_konts = $ID_konts";
            $rezultats = mysqli_query($datu_baze, $pieprasijums);
            if($rezultats){
                header('location: konts_pasakas.php');
            }else{
                echo "Pasaku neizdevās izdzēst";
            }
        }else{
            $kludas[]="Neatrada lietotāju";
        }
    }else{
        $kludas[]="Neatrada pasaku ko izdzēst";
    }
}


// pasakas datu ielāde
if(isset($_GET['id'])){
    $ID_pasaka = $_GET['id'];
    $pieprasijums = "SELECT * FROM pasaka WHERE ID_pasaka='$ID_pasaka'";
    $rezultats = mysqli_query($datu_baze, $pieprasijums);
    $pasaka = mysqli_fetch_assoc($rezultats);
    if($pasaka){
        $e_pasts = $_SESSION['e_pasts'];
        $pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$e_pasts'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $lietotajs = mysqli_fetch_assoc($rezultats);
        if($lietotajs){
            if($lietotajs['ID_konts'] == $pasaka['ID_konts']){
                $nosaukums = $pasaka['nosaukums'];
                $apraksts = $pasaka['apraksts'];
                $pasakas_teksts = $pasaka['pasaka'];
            }else{
                $kludas[]="Pasaka nepieder jums";
            }
        }   
    }else{
         $kludas[]="Pasaku neizdevās atrast";
    }
}else{
    $kludas[]="Pasaku neizdevās atrast";
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
        <div class="vidus_mazais">
            


            <h3 class="atstarpe_auksa">Pasakas labošana</h3>
            <?php if(count($kludas)>0){
            foreach ($kludas as $kluda){
                  echo "<p class='kluda'>$kluda</p>";
            }
            } ?>
            <form enctype="multipart/form-data" method="post">
                <h2>Nosaukums</h2>
                <input value="<?php echo $nosaukums; ?>" type="text" name="nosaukums" class="ievade_ievads" placeholder="Nosaukums" autofocus required>
                <h2>Apraksts</h2>
                <textarea type="text" name="apraksts" class="ievade_videjs ievade_ievads" placeholder="Apraksts" required><?php echo $apraksts;?></textarea>
                <h2>Pasaka</h2>
                <textarea type="textarea" name="pasaka" class="ievade_gars ievade_ievads" placeholder="Pasaka" required><?php echo $pasakas_teksts;?></textarea>
                <h2>Mainīt titullapas attēlu:</h2>
                <input type="file" class="ievade_attels" name="attels">
                
                <button type="submit" name="saglabat_pasaku" class="liela_poga">Labot pasaku</button>
                <button onclick="return confirm('Dzēst pasaku?');" type="submit" name="dzest_pasaku" class="liela_poga">Dzēst pasaku</button>
            </form>


        </div>
    </div>  
        
</body>
    
</html>