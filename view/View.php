<?php

namespace mimilun\view;

class View
{
    protected array $arrVar = [];

    public function setValue($name, $value): void
    {
        $this->arrVar[$name] = $value;
    }

    public function renderHtml(string $templateName, array $var = [], int $code = 200): void
    {
        http_response_code($code);
        $templatesPath = __DIR__ . '/../templates/';

        extract($this->arrVar);
        extract($var);

        ob_start();
        include $templatesPath . $templateName;
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}