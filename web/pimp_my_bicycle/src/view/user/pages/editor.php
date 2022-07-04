<?php $title = 'Preview'; $menu = 'preview'; ?>
<?php ob_start(); ?>

<style>
    #view {
        position: relative;
        width: 600px;
        max-width: 600px;
        height: 400px;
        max-height: 400px;
    }

    #editor {
      display: flex;
      justify-content: center;
      margin: auto;
      margin-top: 50px;
    }

    .container {
      position: relative;
      margin: 0;
      width: 30%;
      max-width: 40%;
    }

    .selectZone {
        position: absolute;
    }

    #menu{
        min-width: 300px;
    }

    .selectZone:hover {
        cursor: pointer;
        background-color: rgb(255, 255, 255);
        opacity: 0.01;
    }

    #shape {
        max-height: 253px;
        overflow-y: scroll;
    }

    .shape:hover {
        background-color: rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }
</style>

<div>
    <h1>Here, you can create the bike of your dream !</h1>
    <ul style="text-align: left">
        <li>Click on the part you want to modify on the bike</li>
        <li>Chose a shape, and pickup some colors</li>
        <li>Once you're satisfied with your bike, you can save it and send it to production by clicking on the button at the bottom of the page</li>
        <li>An admin will review it, and if your bike is validated, it will appear on the Shop page !</li>
        <li>Otherwise, admin will just leave you a message, with the reason why your bike isn't validate :(</li>
        <li>(The admin spends all his days in front of PimpMyBicycle.. Review will arrive fast !)</li>
    </ul>
</div>

<div id="editor">
    <!-- Va contenir l'éditeur (sans tous les menus, juste l'affichage) -->
    <div class="" id="view" style="background-image: url('../include/images/background3.png'); background-color: beige;">

        <div id="draw"></div>

        <!-- Contient les hitboxs pour les clics sur les parties du vélo -->
        <div class="selectZone" style="top: 275px; left: 145px; min-width: 100px; min-height: 100px;" onclick="onSlot(0)">
        </div>
        <div class="selectZone" style="top: 275px; left: 360px; min-width: 100px; min-height: 100px;" onclick="onSlot(1)">
        </div>
        <div class="selectZone" style="top: 145px; left: 415px; min-width: 80px; min-height: 80px;" onclick="onSlot(2)">
        </div>
        <div class="selectZone" style="top: 140px; left: 230px; min-width: 80px; min-height: 80px;" onclick="onSlot(3)">
        </div>
        <div class="selectZone" style="top: 208px; left: 245px; min-width: 120px; min-height: 120px;"
            onclick="onSlot(4)">
        </div>

    </div>

    <!-- Va contenir les menus -->
    <div id="menu" style="background-color: rgb(220, 245, 226);">
        <button id="saveBtn" class="btn btn-success m-2" onclick="onSave()">Save</button>
        <button id="createBtn" class="btn btn-danger m-2" onclick="onCreate()">Save as new</button>
        <button id="createBtn" class="btn btn-info m-2" onclick="onRandom()">Random!</button>
        <div>
            <p id="shapeName">Selected shape: none</p>
            <button id="shapeBtn" class="btn btn-info m-2" style="display:none" onclick="onShape()">Change
                shape</button>
            <div id="shape">

            </div>
        </div>
        <div id="pickers">

        </div>
    </div>

    <!-- User bikes list -->
    <div class="container" id="userBuilds">
        <h2>Saved bikes:</h2>
        <?php foreach($userBikes as $bike){ ?>
        <a class="btn btn-warning" href="/?page=preview&id=<?= $bike->id ?>">Bike #<?= $bike->id ?> </a>
        <?php } ?>
    </div>

</div>

<div id="sendtoprod">
    <p id="result"></p>
</div>

<script src="/include/js/editor.js"></script>

<script>
    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get('id')

    if(id){
        $("#sendtoprod").append(`
        <a href="/?page=preview&id=${id}&action=viewBike">Bike Preview (admin will see this page !)</a>
        <button type="button" class="btn btn-warning shopButton" onclick="sendToProduction()">
            SEND BIKE TO PRODUCTION
        </button>
        `)
    }   

    async function sendToProduction(){
        $("#result").html('Send bike to review... (please wait few seconds!)')
        let res = await $.post('/?page=sendBike', {id})
        $("#result").html(res)
    }
</script>


<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>
