<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class EmailService
{
    private function configurar(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USUARIO;
        $mail->Password   = SMTP_SENHA;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';
        $mail->setFrom(SMTP_USUARIO, SMTP_NOME_REMETENTE);
        return $mail;
    }

    public function enviar(string $destinatario, string $nome, string $assunto, string $corpo): bool
    {
        try {
            $mail = $this->configurar();
            $mail->addAddress($destinatario, $nome);
            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body    = $corpo;
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log('EmailService erro: ' . $e->getMessage());
            return false;
        }
    }

    private function template(string $titulo, string $corTitulo, string $icone, string $conteudo): string
    {
        return "
        <!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>
        <body style='margin:0;padding:0;background:#F5F7FA;font-family:Arial,Helvetica,sans-serif;'>
            <table width='100%' cellpadding='0' cellspacing='0' style='background:#F5F7FA;padding:40px 0;'>
                <tr>
                    <td align='center'>
                        <table width='600' cellpadding='0' cellspacing='0' style='background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);'>
                            
                            <!-- Header -->
                            <tr>
                                <td style='background:linear-gradient(135deg,#11446E,#0E9FD1);padding:32px 40px;text-align:center;'>
                                    <h1 style='margin:0;color:#ffffff;font-size:24px;font-weight:700;letter-spacing:-0.5px;'>DomusFlow</h1>
                                    <p style='margin:4px 0 0;color:rgba(255,255,255,0.8);font-size:13px;'>Sistema de Gerenciamento de Condomínio</p>
                                </td>
                            </tr>

                            <!-- Ícone e título -->
                            <tr>
                                <td style='padding:36px 40px 0;text-align:center;'>
                                    <div style='width:64px;height:64px;background:{$corTitulo}15;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;'>
                                        <span style='font-size:28px;'>{$icone}</span>
                                    </div>
                                    <h2 style='margin:0;color:#111827;font-size:20px;font-weight:700;'>{$titulo}</h2>
                                </td>
                            </tr>

                            <!-- Conteúdo -->
                            <tr>
                                <td style='padding:24px 40px 36px;color:#374151;font-size:14px;line-height:1.7;'>
                                    {$conteudo}
                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td style='background:#F9FAFB;border-top:1px solid #E5E7EB;padding:20px 40px;text-align:center;'>
                                    <p style='margin:0;font-size:12px;color:#9CA3AF;'>
                                        Este é um e-mail automático. Por favor, não responda.<br>
                                        &copy; " . date('Y') . " DomusFlow — Todos os direitos reservados.
                                    </p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";
    }

    private function caixaInfo(string $conteudo, string $cor = '#0E9FD1'): string
    {
        return "<div style='background:{$cor}10;border-left:4px solid {$cor};border-radius:6px;padding:14px 18px;margin:20px 0;font-size:13px;color:#374151;'>{$conteudo}</div>";
    }

    private function botao(string $texto, string $url, string $cor = '#0F80B6'): string
    {
        return "<div style='text-align:center;margin:28px 0;'>
            <a href='{$url}' style='background:{$cor};color:#ffffff;padding:12px 32px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;display:inline-block;'>
                {$texto}
            </a>
        </div>";
    }

    public function boasVindas(string $destinatario, string $nome): bool
    {
        $assunto  = '🏢 Bem-vindo ao DomusFlow!';
        $conteudo = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Seja bem-vindo ao <strong>DomusFlow</strong>, o sistema de gerenciamento do seu condomínio.</p>
            " . $this->caixaInfo("
                📋 <strong>Seu cadastro foi recebido com sucesso!</strong><br><br>
                Seu acesso está <strong>aguardando aprovação</strong> do síndico.<br>
                Em breve você receberá um e-mail confirmando a liberação.
            ", '#F59E0B') . "
            <p>Enquanto aguarda, fique tranquilo — assim que seu acesso for liberado você poderá desfrutar de todas as funcionalidades do sistema.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Cadastro Recebido!', '#F59E0B', '👋', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function contaAprovada(string $destinatario, string $nome): bool
    {
        $assunto  = '✅ Sua conta foi aprovada!';
        $conteudo = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Temos uma ótima notícia para você!</p>
            " . $this->caixaInfo("
                ✅ <strong>Sua conta foi aprovada pelo síndico!</strong><br><br>
                Você já pode acessar o sistema DomusFlow e aproveitar todas as funcionalidades disponíveis.
            ", '#22C55E') . "
            <p>Com o DomusFlow você pode:</p>
            <ul style='padding-left:20px;color:#374151;'>
                <li style='margin-bottom:6px;'>Reservar espaços comuns do condomínio</li>
                <li style='margin-bottom:6px;'>Registrar e acompanhar ocorrências</li>
                <li style='margin-bottom:6px;'>Visualizar avisos e assembleias</li>
                <li style='margin-bottom:6px;'>Gerenciar seus veículos</li>
                <li>Acompanhar seu histórico financeiro</li>
            </ul>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Conta Aprovada!', '#22C55E', '✅', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function contaNegada(string $destinatario, string $nome): bool
    {
        $assunto  = '❌ Atualização sobre seu cadastro';
        $conteudo = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Gostaríamos de informá-lo sobre o status do seu cadastro no DomusFlow.</p>
            " . $this->caixaInfo("
                ❌ <strong>Seu cadastro não foi aprovado pelo síndico.</strong><br><br>
                Infelizmente seu acesso ao sistema não será liberado neste momento.
            ", '#EF4444') . "
            <p>Em caso de dúvidas ou se acredita que houve algum engano, entre em contato diretamente com o síndico do condomínio.</p>
            <p>Após esclarecimentos, você poderá realizar um novo cadastro em nosso sistema.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Cadastro não Aprovado', '#EF4444', '📋', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaPendente(
        string $destinatario,
        string $nome,
        string $local,
        string $dataReserva,
        string $hrIni,
        string $hrFim
    ): bool {
        $dataFormatada = date('d/m/Y', strtotime($dataReserva));
        $assunto       = '📅 Reserva solicitada com sucesso!';
        $conteudo      = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Sua solicitação de reserva foi recebida e está sendo analisada pelo síndico.</p>
            " . $this->caixaInfo("
                📅 <strong>Dados da Reserva</strong><br><br>
                🏠 <strong>Local:</strong> {$local}<br>
                📆 <strong>Data:</strong> {$dataFormatada}<br>
                ⏰ <strong>Horário:</strong> {$hrIni} às {$hrFim}
            ", '#0E9FD1') . "
            <p>Você receberá uma notificação assim que a reserva for analisada pelo síndico.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Reserva em Análise', '#0E9FD1', '📅', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaConfirmada(string $destinatario, string $nome, string $local, string $data): bool
    {
        $dataFormatada = date('d/m/Y', strtotime($data));
        $assunto       = '🎉 Reserva confirmada!';
        $conteudo      = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Ótima notícia! Sua reserva foi analisada e aprovada pelo síndico.</p>
            " . $this->caixaInfo("
                ✅ <strong>Reserva Aprovada!</strong><br><br>
                🏠 <strong>Local:</strong> {$local}<br>
                📆 <strong>Data:</strong> {$dataFormatada}
            ", '#22C55E') . "
            <p>Lembre-se de respeitar os horários reservados e as regras do condomínio para o uso do espaço.</p>
            <p>Em caso de cancelamento, por favor avise com antecedência através do sistema.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Reserva Confirmada!', '#22C55E', '🎉', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaNegada(string $destinatario, string $nome, string $local, string $data): bool
    {
        $dataFormatada = date('d/m/Y', strtotime($data));
        $assunto       = '❌ Reserva não aprovada';
        $conteudo      = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Infelizmente sua solicitação de reserva não foi aprovada pelo síndico.</p>
            " . $this->caixaInfo("
                ❌ <strong>Reserva Negada</strong><br><br>
                🏠 <strong>Local:</strong> {$local}<br>
                📆 <strong>Data:</strong> {$dataFormatada}
            ", '#EF4444') . "
            <p>Em caso de dúvidas sobre o motivo da negativa, entre em contato com o síndico.</p>
            <p>Você pode realizar uma nova solicitação para outra data disponível através do sistema.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Reserva Não Aprovada', '#EF4444', '📋', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function reservaNegadaConflito(string $destinatario, string $nome, string $local, string $data): bool
    {
        $dataFormatada = date('d/m/Y', strtotime($data));
        $assunto       = '⚠️ Reserva cancelada por conflito de horário';
        $conteudo      = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Informamos que sua reserva foi automaticamente cancelada devido a um conflito de horário.</p>
            " . $this->caixaInfo("
                ⚠️ <strong>Reserva Cancelada por Conflito</strong><br><br>
                🏠 <strong>Local:</strong> {$local}<br>
                📆 <strong>Data:</strong> {$dataFormatada}<br><br>
                O local foi reservado por outro morador neste mesmo período.
            ", '#F59E0B') . "
            <p>Você pode realizar uma nova reserva para outro horário ou data disponível. Acesse o sistema e verifique as opções disponíveis.</p>
            <p>Pedimos desculpas pelo transtorno.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Reserva Cancelada por Conflito', '#F59E0B', '⚠️', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }

    public function cadastroAdmin(string $destinatario, string $nome, string $privilegio, string $nomeAdmin): bool
    {
        $assunto  = '🏢 Sua conta DomusFlow foi criada!';
        $conteudo = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Uma conta foi criada para você no sistema DomusFlow pelo administrador <strong>{$nomeAdmin}</strong>.</p>
            " . $this->caixaInfo("
                👤 <strong>Dados do seu acesso</strong><br><br>
                🏷️ <strong>Perfil:</strong> {$privilegio}<br>
                ✅ <strong>Status:</strong> Ativo — acesso liberado imediatamente
            ", '#0E9FD1') . "
            <p>Você já pode acessar o sistema com o e-mail e senha cadastrados pelo administrador.</p>
            <p>Recomendamos que altere sua senha no primeiro acesso através do menu <strong>Atualizar Dados</strong>.</p>
            <p>Caso não reconheça este cadastro, entre em contato imediatamente com o administrador do condomínio.</p>
            <p style='margin-top:24px;'>Atenciosamente,<br><strong>Equipe DomusFlow</strong></p>
        ";
        $corpo = $this->template('Conta Criada com Sucesso!', '#0E9FD1', '🏢', $conteudo);
        return $this->enviar($destinatario, $nome, $assunto, $corpo);
    }
}