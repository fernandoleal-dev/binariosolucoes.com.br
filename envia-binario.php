<?php 

header('Content-type: text/html; charset=ISO-8859-1');

$nome       = $_POST['nome'];
$tel        = $_POST['telefone'];
$cel        = $_POST['celular'];
$email      = trim($_POST['email']);
$message    = $_POST['message'];
$assunto    = $_POST['subject'];
$de = $email;

// Variável que junta os valores acima e monta o corpo do email

$Vai = "Nome: $nome\n\nE-mail: $email\n\nTelefone: $tel\n\nCelular: $cel\n\nMensagem: $message\n";

require_once("phpmailer/class.phpmailer.php");

define('GUSER', 'desenvolvimento@binariosolucoes.com.br');	// <-- Insira aqui o seu GMail
define('GPWD', 'desenvolvimento2018@');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $email, $nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.umbler.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = 'desenvolvimento@binariosolucoes.com.br';
	$mail->Password = 'desenvolvimento2018@';
	$mail->SetFrom($email, $nome);
	$mail->Subject = $_POST['subject'];
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		// $error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

 if (smtpmailer('contato@binariosolucoes.com.br', 'desenvolvimento@binariosolucoes.com.br', $nome, $assunto , $Vai)) {

	echo ("<script>
        window.alert('Obrigado '+'$nome'+'\\n \\nMensagen enviado com sucesso')
        window.location.href='index.html';
    </script>");

	//Header("location:http://www.binariosolucoes.com.br/sucesso.html");  Redireciona para uma página de obrigado.

}
if (!empty($error)) echo $error;
?>