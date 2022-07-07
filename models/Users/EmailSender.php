<?php
declare(strict_types=1);

namespace mimilun\models\Users;

class EmailSender
{
    public static function sendEmail(User $receiver, string $subject, string $templateName,
        array $templateVars = []): void
    {
        extract($templateVars);

        ob_start();
        require __DIR__ . '/../../templates/mail/' . $templateName;
        $body = ob_get_contents();
        ob_end_clean();

        mail($receiver->getEmail(), $subject, $body, 'Content-Type: text/html; charset=UTF-8');
    }
}