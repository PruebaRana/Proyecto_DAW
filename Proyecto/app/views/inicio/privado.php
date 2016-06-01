<?php ob_start() ?>

<h1 class="Tcen">Seccion privada</h1>
<br>

<?php
	echo "titulo: " . "ss";

	$lc1 = "U<b>\"san\"</b>do co'mill'as";
	$lc2 = "<script />esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";
	$lc3 = "<script onclick=\"ww\">esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";
	$lc4 = "<script onclick='ww'>esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";
	$lc5 = "<script onclick=ww>esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";
	$lc6 = "<script onclick=ww ss>esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";
	$lc7 = "<script onclick   =   'ww'>esto</script>Perfecto<span onblur=\"alert('sip');\" o='se'>SPAN</span>";

	$lr1 = sanitizar($lc1, true);
	$lr2 = sanitizar($lc2, true);
	$lr3 = sanitizar($lc3, true);
	$lr4 = sanitizar($lc4, true);
	$lr5 = sanitizar($lc5, true);
	$lr6 = sanitizar($lc6, true);
	$lr7 = sanitizar($lc7, true);
	/*
	$lr1 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc1);
	$lr2 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc2);
	$lr3 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc3);
	$lr4 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc4);
	$lr5 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc5);
	$lr6 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc6);
	$lr7 = preg_replace( "/onclick[ ]*=[ ]*(\"[^\"]+\"|\'[^\']+\'|[^ >]+[ >])/i", "FUCK" , $lc7);
	*/
	$lr0 = $lr1;
	$lr1 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr1));
	$lr2 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr2));
	$lr3 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr3));
	$lr4 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr4));
	$lr5 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr5));
	$lr6 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr6));
	$lr7 = str_replace(">", "->-" , str_replace("<", "-<-" , $lr7));
	
	
  echo "<br>";
  echo "1".$lr1."<br>";
  echo "1<pre>".$lr1."</pre><br>";
  echo "1<pre>".var_dump($lr1)."</pre><br>";
  
  echo "2".$lr2."<br>";
  echo "2<pre>".$lr2."</pre><br>";
	
	
  $ll = sanitizar($_GET["esto"], true);
  
  echo $ll;
  echo var_dump($ll);
	
	
	
  echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
  echo "<pre>";
  print_r($_SERVER);
  echo "</pre>";	
	
?>

<br>

<?php $seccionContenido = ob_get_clean() ?>

<?php include $config->get('Ruta').$config->get('viewsFolder').'plantilla.php' ?>




