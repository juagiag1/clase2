<?php
if (!isset($_POST['conditions'])) {
	header("Location:index.php?envia=error_cond");
}else{
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
		$mail->IsSMTP();
		$mail->SMTPAuth = true; // Usar autentificación 
		$mail->Host = 'ssl://smtp.gmail.com';
		$mail->Port = 465;
		$mail->Username = 'ifabphpclass@gmail.com';
		$mail->Password = 'alumnOifab2020';
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$mail->setFrom('noreply@ifab.com', 'NoReply IFAB');//Aquí sustituimos la verdadera cuenta por la que queremos que aprezca, GMAIL lo sobreescribe con la cuenta verdadera desde donde se envía, por lo que no funciona.

		$mail->addReplyTo('noreply@ifab.com', 'NoReply IFAB');//Sin embargo, podemos poner este código para que cuando le de el usuario a responder le salga la cuenta que queremos y no la gmail.


		//Con estas pocas líneas iniciamos una conexión con el SMTP. Lo que ahora deberíamos hacer, es configurar el mensaje a enviar, el //From, etc.
		$mail->From = "noreply@ifab.com"; // Desde donde enviamos (Para mostrar)
		$mail->FromName = "IFAB"; // Nombre que aparecera en el correo.

		//Estas dos líneas, cumplirían la función de encabezado (En mail() usado de esta forma: “From: Nombre <correo@dominio.com>”) de //correo.
		$mail->AddAddress($_POST['email']); // Esta es la dirección a donde enviamos
		$mail->IsHTML(true); // El correo se envía como HTML
		$mail->Subject = "NoReply IFAB"; // Este es el titulo del email.
		$body .="<!DOCTYPE html><html lang='es'>"
		.'<head><title>IFAB</title></head>'
		.'<body>'
		."Recientemente ha solicitado información, nos pondremos en contacto a la mayor brevedad.\n\n"
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