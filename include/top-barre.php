

<nav class="navbar navbar-default"> 
	<div class="container-fluid"> <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span> 
			<span class="icon-bar"></span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> 
		</button>
		<a class="navbar-brand" href="#">Gestime</a>
	</div>
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-7">
		<ul class="nav navbar-nav">
			<li><a href="#" id="arriver" class="esbutton">arriver</a></li>
			<li><a href="#" id="sortir" class="esbutton">Sortir</a></li>
			<li><a href="include/exel.php" >ma fiche de temps</a></li>
			<li><a href="include/ajax.php?action=disconnect" id="diconnect" name="disconnect"> deconnection</a>
			<?php
				if(check_admin()){
					echo '<li><a href="admin.php" id >panneau d\'administration</a></li>';
				}
			?>
			
		</ul>
		
	</div>
</nav>
<div id="retourtop"></div>