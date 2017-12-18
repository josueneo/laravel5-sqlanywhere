<?php
namespace josueneo\laravel5sqlanywhere;

use Illuminate\Database\Connection;
use josueneo\laravel5sqlanywhere\SQLAnywhereQueryGrammar as QueryGrammar;
use josueneo\laravel5sqlanywhere\SQLAnywhereProcessor as Processor;

class SQLAnywhereConnection extends Connection{
    protected function getDefaultQueryGrammar() {
        return $this->withTablePrefix(new SQLAnywhereQueryGrammar);
    }
    protected function getDefaultSchemaGrammar() {
        return $this->withTablePrefix(new SQLAnywhereSchemaGrammar);
    }
    protected function getDefaultPostProcessor() {
        return new Processor();
    }
}