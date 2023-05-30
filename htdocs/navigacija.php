<div id="nav_turetajs">
    <?php if(isset($pasaka["labosana"])){ if( $pasaka["labosana"]){  ?> <button id="labot_pasaku_iespejas" onclick="location.href='pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>'">Beigt</button> <?php }else{ ?> <button id="labot_pasaku_iespejas" onclick="location.href='pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>&labot'" >Labot</button> <?php }} ?>
    <h1 class="logo">Pasaciņa</h1>
    <input type="checkbox" id="nav_poga" class="nav_poga">
    <div class="nav">
        <ul>
            <a <?php if($_SESSION['sadala']=='sakums'){ echo "class='nav_Izvelets'";} ?> href="index.php"><li>Sākums</li></a>
            <a <?php if($_SESSION['sadala']=='pasakas'){ echo "class='nav_Izvelets'";} ?> href="pasakas.php"><li>Pasakas</li></a>
            <?php
                if(isset($_SESSION['e_pasts'])){
                    
                    ?>
            <a id="navigacija_konts" <?php if ($_SESSION['sadala'] == 'konts') { echo "class='nav_Izvelets'"; } ?> href='konts_pasakas.php'>
                <li>
                    Konts<img src="images/bulta_leja.png" />
                </li>
            </a>
                    <div class="konts_sadalas">
                        <a href="konts_pasakas.php">Pasakas</a>
                        <a href="konts_iestatijumi.php">Labot kontu</a>
                    </div>
                    <a href='atslegties.php'><li>Atslēgties</li></a>
                    <?php
                }else{
                    echo "
                    <a ".(($_SESSION['sadala']=='pieslegties')?'class="nav_Izvelets"':"")." href='pieslegties.php'><li>Pieslēgties</li></a>
                    <a ".(($_SESSION['sadala']=='registreties')?'class="nav_Izvelets"':"")." href='registracija.php'><li>Reģistrēties</li></a>";
                }
            ?>
        </ul>
    </div>
    <label for="nav_poga">
        <span></span>
    </label>
</div>