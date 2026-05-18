<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ .'/../../vendor/autoload.php';

class EmailService
{
    private string $emailRemetente = "Suport.domusflow@gmail.com";
    private string $nomeRemetente  = "DomusFlow";
    private string $senha = "jikd fcnz qebx qbzo";

    private function configurar (): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->emailRemetente;
        $mail->Password   = $this->senha;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom($this->emailRemetente, $this->nomeRemetente);
        //$mail->SMTPDebug  = 2;
        return $mail;
    }

    public function enviar(string $destinatario, string $nome, string $assunto, string $corpo): bool{
        try{
            $mail = $this->configurar();
            $mail->addAddress($destinatario, $nome);
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $corpo;
            $mail->send();
            return true; 
        }catch (Exception $e) {
            error_log('EmailService erro: ' . $e->getMessage());
            return false;
        }
    }

    public function boasVindas(string $destinatario, string $nome): bool{
        $assunto      = 'Seja bem-vindo ao DomusFlow, seu sistema de gerenciamento de Condomio';
        $corpo        = "
            <h2>Olá, {$nome}, como vai, esperamos que bem!</h2>
                <p>Seu cadastro foi recebido e está <strong>Aguardando aprovação</strong> do síndico.</p>
                <p>Em breve você receberá um email confirmando que o acesso foi liberado.</p>
            <br>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
            return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function contaAprovada (string $destinatario, string $nome):bool{
        $assunto      = 'Obaa ! Sua conta foi aprovada!';
        $corpo        = "
            <h2>Noticia boa, {$nome}!</h2>
            <p>Sua conta acaba de ser <strong>aprovada</strong> pelo síndico.</p>
            <p>Você já pode acessar o sistema DomusFlow e aproveitar todo nosso suporte a sua moradia !.</p>
            <br>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
            return $this->enviar($destinatario, $nome, $assunto, $corpo);
    } 

    public function contaNegada (string $destinatario, string $nome):bool{
        $assunto      = 'Poxa, conta Negada!';
        $corpo        = "
            <h2>Ola, {$nome}, infelizmente não temos boas noticias!</h2>
            <p>Sua conta não foi <strong>aprovada</strong> pelo síndico.</p>
            <p>seu acesso não sera liberado, em caso de dúvida entre em contato com o Sindico</p>
            <p>posteriormente possa realizar um novo cadastro conosco !</p>
            <br>
            <hr>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow, até breve!</strong></p>
        ";
            return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }
    
    public function reservaPendente(string $destinatario, string $nome, string $local, string $data_reserva, string $hr_ini, string $hr_fim): bool
    {
        $assunto = 'Reserva feita!';
        $corpo   = "
            <h2>Olá, {$nome}!</h2>
            <p>Sua reserva foi feita com Sucesso e esta <strong>Aguardando</strong> a aprovação do Sindico!</p>
            <p>Não fique ansioso, logo menos voltaremos com informações sobre sua reserva !</p>
            <br>
            <hr>
            <p> Dados da Reserva :</p>
            <br> 
            <p>Local: <strong>{$local}</strong><br>Data: <strong>{$data_reserva}</strong><br>Hora Inicio: <strong>{$hr_ini}<br>Fim evento: <strong>{$hr_fim}</p>
            <br>
            <hr>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaConfirmada(string $destinatario, string $nome, string $local, string $data): bool
    {
        $assunto = 'Reserva confirmada!';
        $corpo   = "
            <h2>Olá, {$nome}!</h2>
            <p>Sua reserva foi <strong>aprovada</strong>!</p>
            <p>Local: <strong>{$local}</strong><br>Data: <strong>{$data}</strong></p>
            <br>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaNegada(string $destinatario, string $nome, string $local, string $data): bool
    {
        $assunto = 'Reserva Cancelada!';
        $corpo   = "
            <h2>Olá, {$nome}!</h2>
            <p>Sua reserva foi <strong>cancelada</strong>!</p>
            <p>Sintimos muito, mas não fique triste, entre no nosso sistema e reserva para um novo dia !</p>
            <hr>
            <p>Em caso de dúvidas pedimos que entre em contato com o Sindico para entender o motivo do cancelamente</p>
            <p>Até breve !</p>
            <hr>
            <p>Dados da reserva cancelada: </p>
            <p>Local: <strong>{$local}</strong><br>Data: <strong>{$data}</strong></p>
            <br>
            <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    Public function reservaNegadaConflito(string $destinatario, string $nome, string $local, string $data): bool {
        $assunto = 'Reserva não disponível';
        $corpo = "
        <h2>Olá, {$nome}!</h2>
            <p>Infelizmente sua reserva não pôde ser confirmada.</p>
            <p>O local <strong>{$local}</strong> já foi reservado por outro morador para o dia <strong>{$data}</strong>.</p>
            <p>Que tal escolher outro dia ou local? Acesse o sistema e faça uma nova reserva!</p>
            <br>
            <hr>
        <p>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }
}

?>