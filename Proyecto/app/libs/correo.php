<?php
function EnviarCorreo($asAsunto, $asContenido, $asFrom, $asFromName){
	$config = Config::GetInstance();
	require ($config->get('Ruta')."app/libs/class.phpmailer.php");
	require ($config->get('Ruta')."app/libs/class.smtp.php");
		
	$mail = new PHPMailer();

	$body = $asContenido;

	$mail->IsSMTP();
	/* Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP*/
	$mail->Host = $config->get('CorreoHost');
	/* Codificacion utf8*/
	$mail->CharSet = 'UTF-8';
	/* Sustituye  ( CuentaDeEnvio )  por la cuenta desde la que deseas enviar por ejem. prueba@domitienda.com  */
	$mail->From = $config->get('CorreoFrom');
	/* Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. admin@domitienda.com  */
	
	$mail->FromName = "No contestar";
	$mail->Subject = $asAsunto;
	$mail->AltBody = $asAsunto;
	$mail->MsgHTML($body);

	$mail->AddAddress($asFrom, $asFromName);
	$mail->SMTPAuth = true;
	
	/* Sustituye (CuentaDeEnvio )  por la misma cuenta que usaste en la parte superior en este caso  prueba@domitienda.com  y sustituye (ContraseñaDeEnvio)  por la contraseña que tenga dicha cuenta */
	$mail->Username = $config->get('CorreoUser');
	$mail->Password = $config->get('CorreoPass');

	$lres = "";
	if(!$mail->Send()) {
		$lres = "Mailer Error:".$mail->ErrorInfo;
	} else {
		$lres = "Message sent!";
	}
	return $lres;
}
?>