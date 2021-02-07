<footer class="page-footer teal lighten-3">
    <?php if(!isset($_COOKIE["app_token"])){
        ?>
        <div class="container">
            <div class="row">
                <div class="col s12 center">
                    <p class="grey-text text-lighten-4">Für das Projekt genutzte Bibliotheken:
                        <a class="white-text underline" href="https://materializecss.com/" target="_blank" ><b>Materialize CSS</b></a>,
                        <a class="white-text underline" href="https://github.com/PHPMailer/PHPMailer" target="_blank" ><b>PHPMailer</b></a>,
                        <a class="white-text underline" href="https://github.com/jcampbell1/simple-file-manager" target="_blank" ><b>simple-file-manager</b></a>
                    </p>


                    <p class="grey-text text-lighten-4">
                        <a class="white-text underline modal-trigger" data-target="modalDS" href="../php/datenschutz.php"><b>Datenschutz</b></a>
                        <br>
                        <a class="white-text underline modal-trigger" data-target="modalIMP" href="../php/impressum.php"><b>Impressum</b></a>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }?>
    <div class="footer-copyright teal">
        <div class="container">
            <div class="row">
                <?php if(isset($_COOKIE["app_token"])){
                    ?>
                    <div class="col s12 center">
                        <p class="grey-text text-lighten-4">
                            <a class="white-text underline modal-trigger" data-target="modalDS" href="../php/datenschutz.php"><b>Datenschutz</b></a>
                            <br>
                            <a class="white-text underline modal-trigger" data-target="modalIMP" href="../php/impressum.php"><b>Impressum</b></a>
                        </p>
                    </div>
                    <?php
                }?>
                <div class="col s12 m12 l12 center">
                    <a class="grey-text text-lighten-2">© <?php echo date("Y");?> Sinan Riedel. Alle Rechte vorbehalten.</a>
                </div>
                <div class="col l12 m12 s12 center">
                    <a><a class="grey-text text-lighten-2 underline" href="mailto:sinanpaul@hotmail.com">Webdesign: Sinan Riedel</a> | <a class="grey-text text-lighten-2 underline" href="https://www.niarts.de/">Logo: Martin Dühning</a></a>
                </div>
            </div>


        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>

<script>
    $(document).ready(function() {
        $(".modal").modal({startingTop: "4%", endingTop: "10%"});
    });
</script>


<!-- ----------- -->
<!-- DATENSCHUTZ -->
<!-- ----------- -->
<div id="modalDS" class="modal" style="width: 75% !important; height: 75% !important;">
    <div class="modal-content">
        <h5><a class="material-icons black-text">policy</a> Datenschutz <a class="material-icons black-text modal-close right">close</a></h5>
        <p class="blocksatz"><?php include_once "../php/datenschutz.php"; ?></p>
    </div>
</div>

<!-- ------------------- -->
<!-- NUTZUNGSBEDINGUNGEN -->
<!-- ------------------- -->
<div id="modalNB" class="modal" style="width: 75% !important; height: 75% !important;">
    <div class="modal-content">
        <h5><a class="material-icons black-text">new_releases</a> Nutzungsbedingungen <a class="material-icons black-text modal-close right">close</a></h5>
        <p class="blocksatz"><?php include_once "../php/nutzungsbedingungen.php"; ?></p>
    </div>
</div>

<!-- --------- -->
<!-- IMPRESSUM -->
<!-- --------- -->
<div id="modalIMP" class="modal" style="width: 75% !important; height: 75% !important;">
    <div class="modal-content">
        <h5><a class="material-icons black-text">policy</a> Impressum <a class="material-icons black-text modal-close right">close</a></h5>
        <p class="blocksatz"><?php include_once "../php/impressum.php"; ?></p>
    </div>
</div>