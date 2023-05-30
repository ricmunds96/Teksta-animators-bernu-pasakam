
<div id="kreisa_mala">
    <div class="attelu_turetajs">
        <?php
        foreach ( $atteli as $attels ) {
            ?>
        <div class="attela_opcijas" style="background:url('atteli/<?php echo $attels["attels"]; ?>');">

            <div class="attela_kontroles_pogas">
                <img class="attels_izdzest" src="images/aizvert.png" />
            </div>
            <img draggable="false" src="images/izmers_bulta.png" /><input class="attela_izmers sliders" type="range" min="1" max="100" value="50" />
            <img draggable="false" src="images/z-ass_bulta.png" /><input class="attela_attalums sliders" type="range" min="1" max="100" value="50" />
            <?php if(isset($pasaka["labosana"]) and $pasaka["labosana"] ){ ?>
            <form id="forma_dzest_attelu_fonu" action="pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>&labot" method="post">
                <input type="hidden" name="id_vards" value="<?php echo $attels["id"]; ?>" />
                <input class="dzest" type="submit" name="dzest_attelu" value="dzēst" onclick='return confirm("Vai tiešām dzēst vārda attēlu?")' />
            </form>
            <?php } ?>
        </div>

        <?php } ?>
    </div>
    <p id="fonu_virsraksts">
        FONI <?php if(isset($pasaka["labosana"]) and $pasaka["labosana"] ){ echo "<span id='fona_pievienosana'>+</span>";} ?>
    </p>
    <div class="fonu_turetajs">
        <?php
        foreach ( $foni as $fons ) { ?>
            <div class="fons_izvele" style="background:url('atteli/<?php echo $fons['attels']; ?>');">
                <?php if(isset($pasaka["labosana"]) and $pasaka["labosana"] ){ ?>
                    <form id="forma_dzest_attelu_fonu" action="pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>&labot" method="post">
                        <input type="hidden" name="id_fons" value="<?php echo $fons["ID_Fons"]; ?>" />
                        <input class="dzest" type="submit" name="dzest_fonu" value="dzēst" onclick='return confirm("Vai tiešām dzēst vārda attēlu?")' />
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="paralaks">
    <h1 id="pasakas_teikums"> <?php echo $teikums;
    foreach ($kludas as $kluda) {
        echo "<p class='kluda'>" . $kluda . "</p>";
    } ?> </h1>

    <div id="definesana">
        <img id="paslept_varda_definesana" src="images/aizvert.png" />
        <form id="forma_vards" action="pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>&labot" method="post" enctype="multipart/form-data">
            <h1 id="varda_definesana_vards"></h1>
            <label for="attels">Vārds nominatīvā</label>
            <input required type="text" id="nominativs" name="nominativs" />
            <label for="attels">Dzimte</label><br />
            <input class="dzimte_ievade" type="radio" value="1" checked="checked" name="dzimte" />
            <span>Vīriešu</span><br />
            <input class="dzimte_ievade" type="radio" value="2" name="dzimte" />
            <span>Sieviešu</span><br />
            <input class="dzimte_ievade" type="radio" value="3" name="dzimte" />
            <span>Kopdzimta</span><br /><br />
            <label for="attels">Izvēlies attēlu</label>
            <input required type="file" name="attels" id="attels" class="inputfile" />
            <input type="hidden" id="uzspiestais_vards" name="uzspiestais_vards" value="0" />
            <input type="submit" name="varda_definesana" value="Saglabāt" />
        </form>
        <form id="forma_fons" action="pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']?>&labot" method="post" enctype="multipart/form-data">
            <h1>Pievienot fonu</h1>
            <label for="attels">Nosaukums</label>
            <input required type="text" name="nosaukums" />
            <label for="attels">Izvēlies attēlu</label>
            <input required type="file" name="attels" id="attels" class="inputfile" />
            <input type="submit" name="fona_pievienosana" value="Saglabāt" />
        </form>
    </div>
    



       
    <div class="paralaks_grupa">
        <?php
        foreach ( $atteli as $attels ) {
            ?>
                <img class="paralaks_elements resize-drag" src="atteli/<?php echo $attels["attels"]; ?>" />
            <?php
        }
        ?>
    </div>
</div>
<?php
if($_GET['lapa']-1 >=0){
    ?>
    <button onclick="location.href='pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']-1?>'" id="pasaka_uz_atpakal"><img class="pasaka_bulta" src="images/bulta_uz_atpakal.png"><span>Atpakaļ</span></button>
    <?php
}
if($uz_sakumu){
    ?>
    <button onclick="location.href='pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>'" id="pasaka_uz_prieksu"><span>Uz sākumu</span><img class="pasaka_bulta" src="images/bulta_uz_prieksu.png"></button>
    <?php
}else{
    ?>
    <button onclick="location.href='pasaka.php?id=<?=$pasaka["ID_pasaka"] ?>&lapa=<?=$_GET['lapa']+1?>'" id="pasaka_uz_prieksu"><span>Turpināt</span><img class="pasaka_bulta" src="images/bulta_uz_prieksu.png"></button>
    <?php
}
?>