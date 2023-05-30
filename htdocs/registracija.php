<?php

session_start();
$_SESSION['sadala']='registreties';
$vards = "";
$uzvards = "";
$e_pasts    = "";
$kludas = array();

// datubāzes konekcija
include('db.php');
// Lietotāja reģistrācija
if (isset($_POST['registret_lietotaju'])) {
    // paņem visus datus no lietotāja izmantjot vairākas funkcijas, lai pasargātu no ļaunprātīgiem ierakstiem
    $vards = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['vards'])));
    $uzvards = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['uzvards'])));
    $e_pasts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['e_pasts'])));
    $parole_1 = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['parole_1'])));
    $parole_2 = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['parole_2'])));

    // Lietotāja datu pārbaude
    if(empty($vards)){ $kludas[]="nepieciešams Vārds"; }
    if(strlen($vards) > '50'){ $kludas[]="vārds ir garāks par 50 simboliem"; }
    if(empty($uzvards)){ $kludas[]="nepieciešams Uzvārds"; }
    if(strlen($uzvards) > '50'){ $kludas[]="uzvārds ir garāks par 50 simboliem"; }
    if(empty($e_pasts)){ $kludas[]="nepieciešams E-Pasts"; }
    if(strlen($e_pasts) > '60'){ $kludas[]="E-Pasts ir garāks par 60 simboliem"; }
    if(empty($parole_1)){ $kludas[]="nepieciešama Parole";
        }else{
            if(strlen($parole_1) < '10'){ $kludas[]="parolei jābūt vismaz 10 simbolu garumā"; }
            if(strlen($parole_1) > '100'){ $kludas[]="parole ir garāka par 100 simboliem";
            }else{
                if(!preg_match("#[0-9]+#",$parole_1)){ $kludas[]="nepieciešams cipars parolē"; }
                if(!preg_match("#[A-Z]+#",$parole_1)){ $kludas[]="nepieciešams lielais burts parolē"; }
                if(!preg_match("#[a-z]+#",$parole_1)){ $kludas[]="nepieciešams mazais burts parolē"; }
            }
        }
    if($parole_1 != $parole_2){ $kludas[]= "Ievadītās paroles nesakrīt"; }

    // E-Pasta pieejamības pārbaude
    $pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$e_pasts'";
    $rezultats = mysqli_query($datu_baze, $pieprasijums);
    $lietotajs = mysqli_fetch_assoc($rezultats);
    if($lietotajs){
        if ($lietotajs['e_pasts'] === $e_pasts){
            $kludas[]="Lietotājs ar šādu E-Pastu jau ir reģistrēts";
        }
    }

    // ja nav kļūdu tad reģistrē lietotāju
    if (count($kludas) == 0) {
        mysqli_set_charset($datu_baze,"utf8");
        $parole = password_hash($parole_1, PASSWORD_DEFAULT);
        $ievietojamais = "INSERT INTO konts (vards, uzvards, e_pasts, parole)
            VALUES('$vards', '$uzvards', '$e_pasts', '$parole')";
        $registracija = mysqli_query($datu_baze, $ievietojamais);
        if($registracija) {
            $id_konts = $datu_baze->insert_id;
            $_SESSION['e_pasts'] = $e_pasts;
            $_SESSION['id_konts'] = (int) $id_konts;
            header('location: index.php');
        }else{
            $kludas[]="radās kļūda, mēģiniet vēlāk";
        }
    }
} ?>
<!DOCTYPE html>
<html>
<head>
    <?php include('header.php'); ?>
</head>


<body>
    <?php include('navigacija.php'); ?>
    <div class="atstarpe"></div>
    <div class="saturs">
        <div class="vidus_mazais">
            
            <?php if(isset($_SESSION['e_pasts'])) {
            echo "<h3 class='atstarpe_auksa'>Esat jau pieslēgušies kontam, ja vēlaties iziet no konta spiediet <a href='atslegties.php'>Atslēgties</a></h3>";
            
            
            }else { ?>
            <h3 class="atstarpe_auksa">Reģistrēšanās forma</h3>
            <?php if(count($kludas)>0) {
            foreach ($kludas as $kluda){
                  echo "<p class='kluda'>$kluda</p>";
            }
            } ?>
            <form method="post" action="registracija.php">
                <h2>Vārds</h2>
                <input value="<?php echo $vards ?>"
                       maxlength="50" 
                       type="text" name="vards"
                       pattern="(?=.*[a-z])(?=.*[A-Z]).{2,}"
                       oninvalid="setCustomValidity('Vārdam vajag 1 lielo un mazo burtu')" 
                       oninput="setCustomValidity('')"
                       title="Vārds" class="ievade_ievads"
                       placeholder="Vārds" autofocus required>
                <h2>Uzvārds</h2>
                <input value="<?php echo $uzvards ?>"
                       maxlength="50"
                       type="text" name="uzvards"
                       pattern="(?=.*[a-z])(?=.*[A-Z]).{2,}"
                       oninvalid="setCustomValidity('Uzvārdam vajag 1 lielo un mazo burtu')" 
                       oninput="setCustomValidity('')"
                       title="Uzvārds" class="ievade_ievads"
                       placeholder="Uzvārds" required>
                <h2>E-pasts</h2>
                <input value="<?php echo $e_pasts ?>"
                       maxlength="60"
                       type="email" name="e_pasts"
                       pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$"
                       oninvalid="setCustomValidity('E-Pastam nepieciešams @ simbols un adresse kura satur punktu')" 
                       oninput="setCustomValidity('')"
                       title="E-Pasts" class="ievade_ievads"
                       placeholder="E-pasta adrese" required>
                <h2>Parole</h2>
                <input type="password" name="parole_1"
                       maxlength="100"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}"
                       oninvalid="setCustomValidity('Parolei jābūt vismaz 10 simbolu garai ar 1 ciparu, 1 lielo un 1 mazo burtu')" 
                       oninput="setCustomValidity('')"
                       title="Parole" class="ievade_ievads"
                       placeholder="Parole" required>
                <h2>Atkārtotā parole</h2>
                <input type="password" name="parole_2"
                       maxlength="100"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}"
                       oninvalid="setCustomValidity('Parolei jābūt vismaz 10 simbolu garai ar 1 ciparu, 1 lielo un 1 mazo burtu')" 
                       oninput="setCustomValidity('')"
                       title="Atkārtotā parole" class="ievade_ievads"
                       placeholder="Atkārtotā parole" required>
                <button type="submit" name="registret_lietotaju" class="liela_poga">Izveidot kontu</button>
            </form>
            <span class="atstarpe_auksa"></span>
            <p>Jau reģistrēts? <a href="pieslegties.php">Pieslēdzies</a></p>
            <?php } ?>
        </div>
    </div>
</body>

</html>
