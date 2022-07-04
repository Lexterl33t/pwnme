<?php $title = 'FAQ'; $menu = 'faq'; ?>
<?php ob_start(); ?>

<div class="faq">
<h2>Frequently asked questions :</h2>
  <div class="card">
    <div class="card-header0">
      How to ride ?
    </div>
    <div class="card-body">
      <p class="card-text">Put your ass on the bike and you're good to go !</p>
    </div>
  </div>

  <div class="card">
    <div class="card-header1">
      Is the paint edible ?
    </div>
    <div class="card-body">
      <p class="card-text">Why don't you try and then tell me ?</p>
    </div>
  </div>

  <div class="card">
    <div class="card-header2">
      Will my bike go faster thanks to PimpMyBicycle ?
    </div>
    <div class="card-body">
      <p class="card-text">No.</p>
    </div>
  </div>

  <div class="card">
    <div class="card-header1">
    Would I have more success with the opposite sex with PimpMyBicycle ?
    </div>
    <div class="card-body">
      <p class="card-text">Depends on your face</p>
    </div>
  </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>
