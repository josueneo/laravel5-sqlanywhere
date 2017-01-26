<?php
namespace josueneo\sqlanywhere;

use Illuminate\Database\Connection;
use josueneo\sqlanywhere\SQLAnywhereQueryGrammar as QueryGrammar;

class SQLAnywhereConnection extends Connection{
    protected function getDefaultQueryGrammar() {
        return $this->withTablePrefix(new SQLAnywhereQueryGrammar);
    }
    protected function getDefaultSchemaGrammar() {
        return $this->withTablePrefix(new SQLAnywhereSchemaGrammar);
    }
}
