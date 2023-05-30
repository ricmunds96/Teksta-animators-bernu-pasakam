
<?php
session_start();
$_SESSION['sadala']='konts';

// datubāzes konekcija
include('db.php');

$vards = "";
$uzvards = "";
$e_pasts    = "";
$kludas = array();
$vecais_e_pasts = $_SESSION['e_pasts'];

$pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$vecais_e_pasts'";
$rezultats = mysqli_query($datu_baze, $pieprasijums);
if(mysqli_num_rows($rezultats) > 0){
    $konts = mysqli_fetch_array($rezultats);
    $vards = $konts["vards"];
    $uzvards = $konts["uzvards"];
    $e_pasts = $konts["e_pasts"];
}else{
    $kludas[]="Radās kļūda meklējot jūsu datus";
}


// Lietotāja rediģēšana
if (isset($_POST['saglabat_izmainas'])){
    $vards = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['vards'])));
    $uzvards = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['uzvards'])));
    $e_pasts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['e_pasts'])));
    $parole_1 = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['parole_1'])));
    $parole_2 = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['parole_2'])));
    if(isset($_POST['labot_paroli'])) {
        $labot_paroli = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['labot_paroli'])));
    } else {
        $labot_paroli=false;
    }

    // Lietotāja datu pārbaude
    if(empty($vards)){ $kludas[]="nepieciešams Vārds"; }
    if(strlen($vards) > '50'){ $kludas[]="vārds ir garāks par 50 simboliem"; }
    if(empty($uzvards)){ $kludas[]="nepieciešams Uzvārds"; }
    if(strlen($uzvards) > '50'){ $kludas[]="uzvārds ir garāks par 50 simboliem"; }
    if(empty($e_pasts)){ $kludas[]="nepieciešams E-Pasts"; }
    if(strlen($e_pasts) > '60'){ $kludas[]="E-Pasts ir garāks par 60 simboliem"; }

    // E-pasta pieejamības pārbaude
    if($vecais_e_pasts != $e_pasts){
        $pieprasijums = "SELECT * FROM konts WHERE e_pasts='$e_pasts'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        $lietotajs = mysqli_fetch_assoc($rezultats);
        if($lietotajs){
            if ($lietotajs['e_pasts'] === $e_pasts){
                $kludas[]="E-pasts jau tiek izmantots citā kontā";
            }
        }
    }
    // Ja nav ievadīta jauna parole
    if( !$labot_paroli ){
        // ja nav kļūdu tad rediģē lietotāju
        if (count($kludas) == 0){
            $pieprasijums = "UPDATE konts set Vards='$vards', Uzvards='$uzvards', e_pasts='$e_pasts' where e_pasts='$vecais_e_pasts'";
            $rezultats = mysqli_query($datu_baze, $pieprasijums);
            if($rezultats){
                $_SESSION['e_pasts'] = $e_pasts;
                $kludas[]="Saglabātas konta izmaiņas!";
            }else{
                $kludas[]="Neizdevās konta rediģēšana";
            }
        }   
    //Ja ievadīta jauna parole
    }else if(!empty($parole_1) && !empty($parole_2) && $parole_1 == $parole_2){
        if(strlen($parole_1) < '10'){ $kludas[]="parolei jābūt vismaz 10 simbolu garumā"; }
        if(strlen($parole_1) > '100'){ $kludas[]="parole ir garāka par 100 simboliem"; 
        }else{
            if(!preg_match("#[0-9]+#",$parole_1)){ $kludas[]="nepieciešams cipars parolē"; }
            if(!preg_match("#[A-Z]+#",$parole_1)){ $kludas[]="nepieciešams lielais burts parolē"; }
            if(!preg_match("#[a-z]+#",$parole_1)){ $kludas[]="nepieciešams mazais burts parolē"; }
        }
        
        // ja nav kļūdu tad rediģē lietotāju
        if (count($kludas) == 0){
            $Parole = password_hash($parole_1, PASSWORD_DEFAULT);
            $pieprasijums = "UPDATE konts set Vards='$vards', Uzvards='$uzvards', e_pasts='$e_pasts', Parole='$Parole'  where e_pasts='$vecais_e_pasts'";
            $rezultats = mysqli_query($datu_baze, $pieprasijums);
            if($rezultats){
                $_SESSION['e_pasts'] = $e_pasts;
                $kludas[]="Saglabātas konta izmaiņas!";
            }else{
                $kludas[]="Neizdevās konta rediģēšana";
            }
        }
        
        
    }else{ $kludas[]="Ievadītās paroles nesakrīt"; }
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
            <h3 class="atstarpe_auksa">Labot kontu</h3>
            <?php if(count($kludas)>0){
            foreach ($kludas as $kluda){
                  echo "<p class='kluda'>$kluda</p>";
            }
            } ?>
            <form class="atstarpe_apaksa" method="post">
                <h2>Vārds</h2>
                <input value="<?php echo $vards ?>"
                       maxlength="50"
                       type="text" name="vards"
                       pattern="(?=.*[a-z])(?=.*[A-Z]).{2,}"
                       oninvalid="setCustomValidity('Vārdam nepieciešams 1 lielais un 1 mazais burts')" 
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
                
                <label class="ievade_paradit_poga">
                <input class="Paradit_Poga" type="checkbox" name="labot_paroli" value="1"><span class="ievade_paslepts"><p>Labot paroli</p>
                <h2 class="ievade_paslepts">Jaunā parole</h2>
                <input type="password" name="parole_1"
                       maxlength="100"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}"
                       oninvalid="setCustomValidity('Vismaz 10 simbolu parolei nepieciešams 1 cipars, 1 lielais un 1 mazais burts')" 
                       oninput="setCustomValidity('')"
                       title="Parole" class="ievade_ievads ievade_paslepts"
                       placeholder="Jaunā parole">
                <h2 class="ievade_paslepts">Atkārtotā parole</h2>
                <input type="password" name="parole_2"
                       maxlength="100"
                       title="Atkārtotā parole"
                       class="ievade_ievads ievade_paslepts"
                       placeholder="Atkārtota jaunā parole">
                    </span>
                    </label>
                <input type="submit" name="saglabat_izmainas" value="Saglabāt izmaiņas" class="ievade_poga">
            </form>
        
        </div>
    </div>  
        
</body>
    
</html>

