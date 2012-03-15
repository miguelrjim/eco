<html>
<head> <title>Página Principal</title>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $('#a-login').click(function(e) {
        $('#login').show();
		$('#signin').hide();
    });
	$('#a-signin').click(function(e) {
        $('#login').hide();
		$('#signin').show();
    });
});
</script>
</head>
<body>
<style type="text/css">
    h1{
	color: black;
	text-align:left;
	font-family: "Arial";
	font-size: 22pt;
	}
	h2
	{
	font-size: 20pt;
	text-align: center;
	font-family: "Times New Roman";
	color: black; 
	}
	
	.polig1{
     width:200px;
     height:140px;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:#6495ED;
	 border-style:solid;
	 border-color:black;
    }
	
	.polig2{
     width:150px;
     height:37px;
	 top:50px;
	 text-align:center;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:white;
	 border-style:solid;
	 border-color:black;
    }
	
	.polig3{
     width:220px;
     height:37px;
	 top:192px;
	 text-align:center;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:white;
	 border-style:solid;
	 border-color:gray;
    }
	
	.polig4{
     width:280px;
     height:360px;
	 top:250px;
	 left:20px;
	 text-align:justify;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:white;
	 border-style:solid;
	 border-color:black;
    }
	
	.polig5{
     width:280px;
     height:360px;
	 top:250px;
	 left:700px;
	 text-align:center;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:white;
	 border-style:solid;
	 border-color:black;
    }
	
	.polig6{
     width:280px;
     height:360px;
	 top:250px;
	 left:360px;
	 text-align:center;
     background:#6495ED;
     font-family:arial;
     font-weight:bold;
     color:white;
	 border-style:solid;
	 border-color:black;
    }


	</style>
	
	<!--Formas del Layout-->
	<DIV STYLE ="position: absolute; width: 1000px; top: 90px; left: 20px" class="polig1"> 
    </DIV>
	
	<DIV STYLE ="position: absolute; left: 650px" class="polig2"> 
	<p> <a href="#" id="a-login">LOG IN</a></p>
    </DIV>
	
	<DIV STYLE ="position: absolute; left: 810px" class="polig2"> 
	<p> <a href="#" id="a-signin">SIGN IN</a> </p>
    </DIV>
	
	<DIV STYLE ="position: absolute; left: 325px" class="polig3"> 
	<p> Comunidades </p>
    </DIV>
	
	<DIV STYLE ="position: absolute; left: 555px" class="polig3"> 
	<p> Noticias Destacadas </p>
    </DIV>
	
	<DIV STYLE ="position: absolute; left: 785px" class="polig3"> 
	<p> Favoritos </p>
    </DIV>
	
	<DIV STYLE ="position: absolute;" class="polig4"> 
	<p> ¿Qué es proyecto beta? </p>
	<p> Proyecto de la clase de ambientes de desarrollo Proyecto de la clase de ambientes de desarrollo Proyecto de la clase de ambientes de desarrollo Proyecto de la clase de ambientes de desarrollo
Proyecto de la clase de ambientes de desarrollo Proyecto de la clase de ambientes de desarrollo Proyecto de la clase de ambientes de desarrollo	</p>
    </DIV>
	
    <DIV id="signin" STYLE ="position: absolute;" class="polig6"> 
	<p> Registrate </p>
    <form action="registro.php" method="post">
    Email: <input type="text" name="email"><br />
    Password: <input type="password" name="password"><br />
    Nombre: <input type="text" name="nombre"><br />
    Apellido: <input type="text" name="apellido"><br />
    Escuela: <input type="text" name="escuela">
    <input type="submit" value="Sign In" />
    </form>
    </DIV>
    
    <DIV id="login" STYLE ="position: absolute;display:none" class="polig6"> 
	<p> Login </p>
    <form action="login.php" method="post">
    Email: <input type="text" name="email"><br />
    Password: <input type="password" name="password"><br />
    <input type="submit" value="Login" />
    </form>
    </DIV>
    
	<DIV STYLE ="position: absolute;" class="polig5"> 
	<p> Noticias Destacadas </p>
    </DIV>
	
	<!--Formas del Layout-->
	
	<!-- Titulo -->
	<DIV Style="width:240px; position:absolute; left:35px; top:90px">
	<h1> Proyecto </h1></DIV>
	<DIV Style="width:240px; position:absolute; left:15px; top:110px">
	<h2> Beta </h2>
	</DIV>
	<!-- Titulo -->
	
	
	

</body>
<html>