<!DOCTYPE html>
<html>

<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
		<link rel="stylesheet" href="/include/css/bootstrap.min.css">

		<script src="/include/js/jquery.min.js"></script>
		<script src="/include/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="/include/css/style.css">
</head>

<body>
    <div class="text-center">
        <nav>
        <?php
        if(isset($_SESSION['user_id'])){
            include('view/user/menu.php');
        } else {
            include('view/guest/menu.php');
        }
        ?>
        </nav>
        <div class="body">
            <div class="content">
            <?= $content ?>
            </div>
        </div>
    </div>

		<div class="footer">
			<p>You gotta Pimp My Bicycle ! - &copy; 2022</p>
		</div>
</body>

</html>
