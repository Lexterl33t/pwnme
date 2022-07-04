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
      <a class="<?= $menu == 'preview' ? "active" : "" ?>" href="/?page=preview">Preview</a>
      <a class="<?= $menu == 'bikes' ? "active" : "" ?>" href="/?page=bikes">Shop</a>
      <a class="<?= $menu == 'about' ? "active" : "" ?>" href="/?page=about">About</a>
      <a class="<?= $menu == 'faq' ? "active" : "" ?>" href="/?page=faq">Q&A</a>
      <a class="<?= $menu == 'admin' ? "active" : "" ?>" href="/?page=admin">Admin</a>
      <div class="headerProfile">
        <a class="btn btn-outline-dark" href="#" onclick="destroy()" role="button"><?= $_SESSION['pseudo'] ?> Logout</a>
      </div>
    </div>
  </div>
</header>

<script>
  function destroy() {
    document.cookie = 'PHPSESSID=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
    document.location = '/'
  }
</script>
