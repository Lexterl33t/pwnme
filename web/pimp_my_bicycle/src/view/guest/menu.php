<?php
if(!isset($menu)){
  $menu = "";
}
?>

<header>
  <div class="headerContainer">
    <div class="headerLeft">
    <a href="/">
      <img src="/include/images/logo.png" width="150" height="80" alt="">
    </a>
    </div>
    <div class="headerRight">
      <a class="<?= $menu == 'about' ? "active" : "" ?>" href="/?page=about">About</a>
      <a class="<?= $menu == 'faq' ? "active" : "" ?>" href="/?page=faq">Q&A</a>
      <div class="headerProfile">
        <a class="btn btn-outline-dark" href="/?page=login" role="button">Login</a>
      </div>
    </div>
  </div>
</header>
