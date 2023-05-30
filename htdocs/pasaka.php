<?php
include('cVards.php');
session_start();
$_SESSION['sadala']='pasaka';
$kludas = array();

// datubāzes konekcija
include('db.php');
$radit_titullapu=false; $uz_sakumu=false;
function ieladet_pasaku($datu_baze){
    $pieprasijums = "SELECT * FROM pasaka WHERE ID_pasaka =".$_GET["id"];
    $rezultats = mysqli_query($datu_baze, $pieprasijums);
    $pasaka = mysqli_fetch_assoc($rezultats);
    if (isset($pasaka["ID_konts"]) and isset($_SESSION["e_pasts"]) and isset($_GET["lapa"]) ) {
        $pieprasijums = "SELECT 1 FROM konts WHERE ID_konts =" . $pasaka["ID_konts"] . " AND e_pasts ='" . $_SESSION["e_pasts"] . "'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $konts = mysqli_fetch_assoc($rezultats);
        if (isset($konts)) {
            if (isset($_GET["labot"])) {
                $pasaka["labosana"] = true;
            } else {
                $pasaka["labosana"] = false;
            }
        }
    }
    $pasakas_teksts = $pasaka["pasaka"];
    // īpašo apastrofu izdzēšana
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\ \n.?!][«»]/', '', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[\t\n\r]/m', ' ', $pasakas_teksts);
    $teikumi = preg_split('/([^.!?]+[.!?]+)/', $pasakas_teksts, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $pasakas_teksts = preg_replace('/[?!]/', '.', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\«» .]/', '', $pasakas_teksts);
    $pasakas_teksts = preg_replace('/[^A-Za-z0-9āĀčČēĒīĪķĶļĻņŅšŠūŪžŽ\ .][«»]/', ' ', $pasakas_teksts);
    $teikumu_vardi = preg_split('/[.]/', $pasakas_teksts, -1, PREG_SPLIT_NO_EMPTY);
    $lapas=[];
    foreach ( $teikumi as $i => $teikums ) {
        $teikumi[$i] = trim($teikums);
        $teikumu_vardi[$i] = trim($teikumu_vardi[$i]);
        $lapa = [];
        $teikuma_dalas =  preg_split('/[ ]/', $teikumi[$i], -1, PREG_SPLIT_NO_EMPTY);
        $teikums_labot="";
        foreach($teikuma_dalas as $vards){
            $teikums_labot.="<span>".$vards."</span> ";
        }
        if(isset($pasaka["labosana"]) and $pasaka["labosana"]){
            $lapa["teikums"] = $teikums_labot;
        }else{
            $lapa["teikums"] = $teikumi[$i];
        }
        $lapa["vardi"] = [];
        foreach( explode( " ", $teikumu_vardi[$i] ) as $vards){
            $lapa["vardi"][] = $vards;
        }
        $lapas[] = $lapa;
    }
    $_SESSION["lapas"] = $lapas;
    return $pasaka;
}


if(isset($_POST["varda_definesana"])){
    //varda definesana ar attēlu
    if(isset($_SESSION["lapas"][$_GET["lapa"]]["vardi"][$_POST['uzspiestais_vards']])){
        $vards = $_SESSION["lapas"][$_GET["lapa"]]["vardi"][$_POST['uzspiestais_vards']];
    }else{
        $kludas[] = "Neizdevās definēt vārda attēlu ";
    }
    if ( count($kludas) == 0 and !empty($_FILES["attels"]["name"])) {
        $attelu_mape = "atteli/";
        $attels = $attelu_mape . basename($_FILES["attels"]["name"]);

        // pārbauda vai dotais fails ir attēls
        $faila_tips = mime_content_type($_FILES["attels"]["tmp_name"]);
        $atlautie_formati = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/bmp', 'image/webp'];
        if (!in_array($faila_tips, $atlautie_formati)) {
            $kludas[] = "Fails nav attēls";
        }

        // pārbauda vai attēla izmērs nav lielāks par 1mb
        if ($_FILES["attels"]["size"] > 1000000) {
            $kludas[] = "Attēls nevar pārsniegt 1mb izmēru";
        }

        if (count($kludas) == 0) {
            $sadalits_attela_nosaukums = explode(".", $attels);
            $attela_vards = explode("/", $sadalits_attela_nosaukums[0]);
            $attela_vards = $attela_vards[1];
            $attela_fails = round(microtime(true)) . $attela_vards . '.' . end($sadalits_attela_nosaukums);
        }
    }



    //vārda locījumu iegūšana
    $vards_nom = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nominativs'])));
    $dzimte = (int) trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['dzimte'])));

    if(isset($vards_nom) and isset($dzimte)){
        $locijumi = new cVards($vards_nom, $dzimte);
        if( ($locijumi->galotne) !== 0){
            $locijumi->locit();
            $locijumi = $locijumi->locijumi[0];
        }else{
            $locijumi = [];
            $locijumi[0] = $locijumi[1] = $locijumi[2] = $locijumi[3] = $locijumi[4] = $locijumi[5] = $locijumi[6] = $vards;
        }
    }else{
        $kludas[] = "Ievadiet vārda nominatīva formu un dzimti";
    }

    if (count($kludas) == 0) {
        if (!empty($_FILES["attels"]["name"])) {
            if (!move_uploaded_file($_FILES["attels"]["tmp_name"], "atteli/" . $attela_fails)) {
                $kludas[] = "Neizdevās saglabāt attēlu";
            }
        }
        if (count($kludas) == 0) {
            $ievietojamais = "INSERT INTO vards (ID_Konts, nom, gen, dat, aku, lok, vok, attels) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($datu_baze, $ievietojamais);
            mysqli_stmt_bind_param($stmt, 'isssssss', $_SESSION['id_konts'], $locijumi[0], $locijumi[1], $locijumi[2], $locijumi[3], $locijumi[5], $locijumi[6], $attela_fails);
            $izveidosana = mysqli_stmt_execute($stmt);
            if (!$izveidosana) {
                $kludas[] = "Neizdevās pievienot vārdam attēlu";
            }else{
                $id_vards = $datu_baze->insert_id;
                $ievietojamais = "INSERT INTO pasaka_vards (ID_Pasaka, ID_Vards) VALUES (?, ?)";
                $stmt = mysqli_prepare($datu_baze, $ievietojamais);
                mysqli_stmt_bind_param($stmt, 'ii', $_GET["id"], $id_vards);
                $izveidosana = mysqli_stmt_execute($stmt);
            }
        }
    }
}
if (isset($_POST["fona_pievienosana"])) {
    //fona pievienošana
    if (!empty($_FILES["attels"]["name"])) {
        $attelu_mape = "atteli/";
        $attels = $attelu_mape . basename($_FILES["attels"]["name"]);

        // pārbauda vai dotais fails ir attēls
        $faila_tips = mime_content_type($_FILES["attels"]["tmp_name"]);
        $atlautie_formati = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/bmp', 'image/webp'];
        if (!in_array($faila_tips, $atlautie_formati)) {
            $kludas[] = "Fails nav attēls";
        }

        // pārbauda vai attēla izmērs nav lielāks par 1mb
        if ($_FILES["attels"]["size"] > 1000000) {
            $kludas[] = "Attēls nevar pārsniegt 1mb izmēru";
        }

        if (count($kludas) == 0) {
            $sadalits_attela_nosaukums = explode(".", $attels);
            $attela_vards = explode("/", $sadalits_attela_nosaukums[0]);
            $attela_vards = $attela_vards[1];
            $attela_fails = round(microtime(true)) . $attela_vards . '.' . end($sadalits_attela_nosaukums);
        }
    }



    //fona nosaukuma iegūšana
    $nosaukums = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['nosaukums'])));

    if (!isset($nosaukums)) {
        $kludas[] = "Ievadiet vārda nominatīva formu un dzimti";
    }

    if (count($kludas) == 0) {
        if (!empty($_FILES["attels"]["name"])) {
            if (!move_uploaded_file($_FILES["attels"]["tmp_name"], "atteli/" . $attela_fails)) {
                $kludas[] = "Neizdevās saglabāt attēlu";
            }
        }
        if (count($kludas) == 0) {
            $ievietojamais = "INSERT INTO fons (ID_Konts, nosaukums, attels) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($datu_baze, $ievietojamais);
            mysqli_stmt_bind_param($stmt, 'iss', $_SESSION['id_konts'], $nosaukums, $attela_fails);
            $izveidosana = mysqli_stmt_execute($stmt);
            if (!$izveidosana) {
                $kludas[] = "Neizdevās pievienot vārdam attēlu";
            } else {
                $id_fons = $datu_baze->insert_id;
                $ievietojamais = "INSERT INTO pasaka_fons (ID_Pasaka, ID_Fons) VALUES (?, ?)";
                $stmt = mysqli_prepare($datu_baze, $ievietojamais);
                mysqli_stmt_bind_param($stmt, 'ii', $_GET["id"], $id_fons);
                $izveidosana = mysqli_stmt_execute($stmt);
            }
        }
    }
}

if ( isset($_GET["id"]) AND isset($_POST["dzest_attelu"])) {
    //attēla dzēšana
    $id_pasaka = $_GET["id"];
    $id_vards = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['id_vards'])));

    $dzesana = "DELETE pv FROM pasaka_vards AS pv INNER JOIN vards AS v ON pv.ID_Vards = v.ID_Vards WHERE ID_Konts = ? AND ID_Pasaka = ? AND pv.ID_Vards = ?";
    $stmt = mysqli_prepare($datu_baze, $dzesana);
    mysqli_stmt_bind_param($stmt, 'iii', $_SESSION['id_konts'], $id_pasaka, $id_vards);
    $izdzesana = mysqli_stmt_execute($stmt);
    if (!$izdzesana) {
        $kludas[] = "Neizdevās izdzēst vārdu";
    }
}
if (isset($_GET["id"]) and isset($_POST["dzest_fonu"])) {
    //fona dzēšana
    $id_pasaka = $_GET["id"];
    $id_fons = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['id_fons'])));

    $dzesana = "DELETE pf FROM pasaka_fons AS pf INNER JOIN fons AS f ON pf.ID_Fons = f.ID_Fons WHERE ID_Konts = ? AND ID_Pasaka = ? AND pf.ID_Fons = ?";
    $stmt = mysqli_prepare($datu_baze, $dzesana);
    mysqli_stmt_bind_param($stmt, 'iii', $_SESSION['id_konts'], $id_pasaka, $id_fons);
    $izdzesana = mysqli_stmt_execute($stmt);
    if (!$izdzesana) {
        $kludas[] = "Neizdevās izdzēst fonu";
    }
}


if ( isset( $_GET["id"] ) ) {
    // ielādē pasaku
    $pasaka = ieladet_pasaku($datu_baze);
} else {
    $radit_titullapu=true;
    $neatrada_pasaku=true;
}


if ( isset( $_GET["lapa"] ) ) {
    if ( !isset( $_SESSION["lapas"] ) ) {
        // ja nav ielādēts pasakas teksts ielādēt to
        $pasaka = ieladet_pasaku($datu_baze);
        // parbauda vai tika ielādēta pasaka
        if ( !isset( $_SESSION["lapas"] ) ) {
            $radit_titullapu=true;
            $neatrada_pasaku=true;
        }
    }
    if(!$radit_titullapu){
        $pasakas_id = $_GET["id"];
        if(!isset($_SESSION["lapas"][$_GET["lapa"]+1])){
            //ja pasaka beidzās vajag parādīt "uz sākumu" pogu
            $uz_sakumu=true;
        }
        $teikums_obj = $_SESSION["lapas"][$_GET["lapa"]];
        $teikums = $teikums_obj["teikums"];
        $vardi = $teikums_obj["vardi"];
        $i=0;
        $atteli=[];
        foreach ( $vardi as $vards ) {
            if ( empty($vards) ) {
                // tukšos teikumus izdzēš
                array_splice($vardi,$i,1);
                $i--;
            }else {
                $pieprasijums = "SELECT v.ID_Vards, attels FROM vards as v INNER JOIN pasaka_vards AS pa ON ID_Pasaka = '" . $pasakas_id . "' AND pa.ID_Vards = v.ID_Vards  WHERE '".$vards."' IN ( nom, gen, dat, aku, lok, vok )";
                $rezultats = mysqli_query($datu_baze, $pieprasijums);
                $db_attels = mysqli_fetch_assoc($rezultats);
                if ( isset( $db_attels ) ) {
                    $attels = [];
                    $attels["id"] = $db_attels["ID_Vards"];
                    $attels["attels"]=$db_attels["attels"];
                    $atteli[] = $attels;
                }
            }
            $i++;
        }

        $pieprasijums = "SELECT * FROM fons
                        LEFT JOIN pasaka_fons ON fons.ID_Fons = pasaka_fons.ID_Fons
                        WHERE pasaka_fons.ID_pasaka = $pasakas_id";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $foni = mysqli_fetch_all($rezultats,MYSQLI_ASSOC);
    }
}else{
    $radit_titullapu=true;
}



?>
<!DOCTYPE html>
<html>
<head>
    <?php include('header.php'); ?>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="js/interact.js"></script>
    <script src="js/js.js"></script>
</head>


<body>
    <?php include('navigacija.php'); ?>
    <div class="atstarpe"></div>
    
    <?php
        if(isset($radit_titullapu) and $radit_titullapu){
            include('pasaka_titullapa.php');
        }else{
            include('pasaka_lapa.php');
        }
    ?>
    
<script src="js/wow.min.js"></script>
<script>
    new WOW().init();
</script>
</body>
    
</html>