<?php

session_start();
$_SESSION['sadala']='pieslegties';
$e_pasts = "";
$parole    = "";
$kludas = array();

// datubāzes konekcija
include('db.php');

if(isset($_POST['pieslegt_lietotaju'])){
    $e_pasts = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['e_pasts'])));
    $parole = trim(htmlspecialchars(mysqli_real_escape_string($datu_baze, $_POST['parole'])));

    if(empty($e_pasts)){ $kludas[]="Ievadiet E-pastu"; }
    if(empty($parole)){ $kludas[]="Ievadiet Paroli"; }

    if(count($kludas) == 0){
        $pieprasijums = "SELECT * FROM konts WHERE e_pasts= BINARY '$e_pasts'";
        $rezultats = mysqli_query($datu_baze, $pieprasijums);
        if(mysqli_num_rows($rezultats) > 0){
            $konts = mysqli_fetch_array($rezultats);
            if(password_verify($parole, $konts["parole"])){
                $_SESSION['e_pasts'] = $e_pasts;
                $_SESSION['id_konts'] = (int)$konts['ID_konts'];
                header('location: index.php');
            }else{
                $kludas[]="Nepareizs E-pasts vai parole";
            }
        }else{
            $kludas[]="Nepareizs E-pasts vai parole";
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
        <div class='vidus_mazais'>
            <h3 class='atstarpe_auksa'>Pieslēgšanās forma</h3>
            <?php
            if(count($kludas)>0){
            foreach ($kludas as $kluda){
            echo "<p class='kluda'>$kluda</p>";
            }
            } ?>
            <form method='post' action=''>
                <h2>E-pasts</h2>
                    <input value="<?php echo $e_pasts ?>"
                       maxlength="60"
                       type="email" name="e_pasts"
                       pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$"
                       oninvalid="setCustomValidity('E-Pastam nepieciešams @ simbols un adresse kas satur punktu!')" 
                       oninput="setCustomValidity('')"
                       title="E-Pasts" class="ievade_ievads"
                       placeholder="E-pasta adrese" required autofocus>
                <h2>Parole</h2>
                    <input type="password" name="parole"
                       maxlength="100"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{10,}"
                       oninvalid="setCustomValidity('Parolei jābūt minimums 10 simbolu garai un tai jāsatur vismaz 1 cipars, 1 lielais un 1 mazais burts')" 
                       oninput="setCustomValidity('');"
                       title="Parole" class="ievade_ievads"
                       placeholder="Parole" required>
                <button type="submit" name="pieslegt_lietotaju" class="liela_poga">Pieslēgties</button>
            </form>
            <span class='atstarpe_auksa'></span>
            <p>Jauns lietotājs? <a href='registracija.php'>Reģistrējies</a></p>
        </div> 
    </div>  
        
</body>
    
</html>
