<hr>

<center>
    <a href="index.php"><button href="index.php" class="btnmenu btn-primary">Főoldal</button></a>
    <?php if(!IsUserLoggedIn()) : ?>
    		<span>&nbsp; | &nbsp; </span>
    		<a href="index.php?P=login"><button class="btnmenu btn-primary">Bejelentkezés</button></a>
    		<span>&nbsp; | &nbsp; </span>
    		<a href="index.php?P=register"><button href="index.php?P=register" class="btnmenu btn-primary">Regisztráció</button></a>
    <?php else : ?>
    	<?php if(IsUserLoggedIn()) : ?>
    		<span>&nbsp; | &nbsp; </span>
    		<a href="index.php?P=settings"><button class="btnmenu btn-primary">Beállítások</button></a>
    	<?php endif; ?>
    	<span>&nbsp; | &nbsp; </span>
        <a href="index.php?P=logout"><button href="index.php?P=logout" class="btnmenu btn-primary">Kijelentkezés</button></a>
    <?php endif; ?>
</center>

<hr>