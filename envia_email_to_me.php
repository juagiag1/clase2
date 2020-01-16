<?php
if (!isset($_POST['conditions'])) {
	header("Location:index.php?envia=error_cond");
}else{
	$email_to = "carlos@carlosgimeno.es";
// Aquí se deberían validar los datos ingresados por el usuario
	if($_POST['name'] == "" ||
	$_POST['phone'] == "" ||
	$_POST['email']== "" ||
	$_POST['message'] == "") {
		header("Location:index.php?envia=error");
	}else{
    	$email_to = $_POST['email'];
		require("PHPMailer/class.phpmailer.php");
		require("PHPMailer/class.smtp.php");
		$mail = new PHPMailer();

		//Luego tenemos que iniciar la validación por SMTP:
		$mail->IsSMTP(); //Usar SMTP
		$mail->SMTPAuth = true; // Usar autentificación 
		$mail->Host = "mail.carlosgimeno.es"; // SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "ifab@carlosgimeno.es"; // Correo completo a utilizar
		$mail->Password = "4Bies#51"; // Contraseña
		$mail->Port = 25; // Puerto a utilizar
		$mail->SMTPOptions = array(
		    'ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => true
		    )
		);

		//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
		$mail->From = $_POST['email']; // Desde donde enviamos (Para mostrar)
		$mail->FromName = ""; // Nombre que aparecera en el correo.

		//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
		$mail->AddAddress("tu@correo.com"); // Esta es la dirección a donde enviamos
		$mail->IsHTML(true); // El correo se envía como HTML
		$mail->Subject = "Consulta nombre de mi web"; // Este es el titulo del email.
		$body .="<!DOCTYPE html><html lang='es'>"
		.'<head><title>IFAB</title></head>'
		.'<body>'
		."Solicitud de informaci&oacute;n<br><br>"
		."Nombre: ".$_POST['name']."<br>"
		."Tel&eacute;fono: ".$_POST['phone']."<br>"
		."Email: ".$_POST['email']."<br>"
		."Consulta: ".$_POST['message']."<br>"
		.'</body>'
		."</html>";
		$mail->Body = $body; // Mensaje a enviar
		$exito = $mail->Send(); // Envía el correo.
		if ($exito) {
			header("Location:index.php?envia=ok");
		}else{
			header("Location:index.php?envia=ko");
		}
		
	}
}
?>