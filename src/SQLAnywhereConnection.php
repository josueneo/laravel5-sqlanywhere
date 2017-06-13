<?php
namespace josueneo\laravel5sqlanywhere;

use Illuminate\Database\Connection;
use josueneo\laravel5sqlanywhere\SQLAnywhereQueryGrammar as QueryGrammar;

class SQLAnywhereConnection extends Connection{
    protected function getDefaultQueryGrammar() {
        return $this->withTablePrefix(new SQLAnywhereQueryGrammar);
    }
    protected function getDefaultSchemaGrammar() {
        return $this->withTablePrefix(new SQLAnywhereSchemaGrammar);
    }
}