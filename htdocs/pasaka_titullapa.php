<div class="saturs">
    <div class="vidus pasakas_titullapa">
        <?php
        if(isset($neatrada_pasaku) and $neatrada_pasaku){
            echo("<h1 class='pasaka_neeksiste'>Pasaka neeksistē</h1>");
        }else{
            ?>
            <h1> <?php echo $pasaka["nosaukums"] ?> </h1>
            <?php
                if(!empty($pasaka["attels"])){
                    echo "<img src='atteli/".$pasaka["attels"]."'>";
                }
            ?>
            <p> <?php echo $pasaka["apraksts"] ?> </p>
            <button onclick="location.href='pasaka.php?id=<?php echo $pasaka["ID_pasaka"] ?>&lapa=0'" >Sākt pasaku</button>
            <?php
        }
        ?>
    </div>
</div>