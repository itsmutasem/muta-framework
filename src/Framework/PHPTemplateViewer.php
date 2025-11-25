<?php

namespace Framework;

use Framework\Security\CsrfToken;

class PHPTemplateViewer implements TemplateViewerInterface
{
    public function __construct(private CsrfToken $csrfToken)
    {
    }

    public function render(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        $csrf_token = $this->csrfToken->generate();
        ob_start();
        require dirname(__DIR__, 2) . "/views/$template.php";
        return ob_get_clean();
    }
}
