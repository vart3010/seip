<?php

namespace Tecnocreaciones\Bundle\TemplateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TecnocreacionesTemplateBundle extends Bundle
{
    public function getParent() {
        return 'TecnocreacionesVzlaGovernmentBundle';
    }
}
