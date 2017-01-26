<?php
namespace josueneo\sqlanywhere;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

use Illuminate\Database\Schema\Grammars\Grammar;

class SQLAnywhereSchemaGrammar extends Grammar {
    
    protected $wrapper = '%s';

    protected $modifiers = array('Unsigned', 'Nullable', 'Default', 'Increment');

    public function compileTableExists()
    {
            return 'select * from sys.systab where table_type_str = ?';
    }

    public function compileCreate(Blueprint $blueprint, Fluent $command)
    {
            $columns = implode(', ', $this->getColumns($blueprint));
            return 'create table '.$this->wrapTable($blueprint)." ($columns)";
    }

    public function compileAdd(Blueprint $blueprint, Fluent $command)
    {
            $table = $this->wrapTable($blueprint);
            $columns = $this->prefixArray('add', $this->getColumns($blueprint));
            return 'alter table '.$table.' '.implode(', ', $columns);
    }

    public function compilePrimary(Blueprint $blueprint, Fluent $command)
    {
            $command->name(null);
            return $this->compileKey($blueprint, $command, 'primary key');
    }

    public function compileUnique(Blueprint $blueprint, Fluent $command)
    {
            return $this->compileKey($blueprint, $command, 'unique');
    }

    public function compileIndex(Blueprint $blueprint, Fluent $command)
    {
            return $this->compileKey($blueprint, $command, 'index');
    }

    protected function compileKey(Blueprint $blueprint, Fluent $command, $type)
    {
            $columns = $this->columnize($command->columns);
            $table = $this->wrapTable($blueprint);
            return "alter table {$table} add {$type} {$command->index}($columns)";
    }

    public function compileDrop(Blueprint $blueprint, Fluent $command)
    {
            return 'drop table '.$this->wrapTable($blueprint);
    }

    public function compileDropIfExists(Blueprint $blueprint, Fluent $command)
    {
            return 'drop table if exists '.$this->wrapTable($blueprint);
    }

    public function compileDropColumn(Blueprint $blueprint, Fluent $command)
    {
            $columns = $this->prefixArray('drop', $this->wrapArray($command->columns));
            $table = $this->wrapTable($blueprint);
            return 'alter table '.$table.' '.implode(', ', $columns);
    }

    public function compileDropPrimary(Blueprint $blueprint, Fluent $command)
    {
            return 'alter table '.$this->wrapTable($blueprint).' drop primary key';
    }

    public function compileDropUnique(Blueprint $blueprint, Fluent $command)
    {
            $table = $this->wrapTable($blueprint);
            return "alter table {$table} drop index {$command->index}";
    }

    public function compileDropIndex(Blueprint $blueprint, Fluent $command)
    {
            $table = $this->wrapTable($blueprint);
            return "alter table {$table} drop index {$command->index}";
    }

    public function compileDropForeign(Blueprint $blueprint, Fluent $command)
    {
            $table = $this->wrapTable($blueprint);
            return "alter table {$table} drop foreign key {$command->index}";
    }

    public function compileRename(Blueprint $blueprint, Fluent $command)
    {
            $from = $this->wrapTable($blueprint);
            return "rename table {$from} to ".$this->wrapTable($command->to);
    }

    protected function typeString(Fluent $column)
    {
            return "varchar({$column->length})";
    }

    protected function typeText(Fluent $column)
    {
            return 'text';
    }

    protected function typeInteger(Fluent $column)
    {
            return 'int';
    }

    protected function typeFloat(Fluent $column)
    {
            return "float({$column->total}, {$column->places})";
    }

    protected function typeDecimal(Fluent $column)
    {
            return "decimal({$column->total}, {$column->places})";
    }

    protected function typeBoolean(Fluent $column)
    {
            return 'tinyint';
    }

    protected function typeEnum(Fluent $column)
    {
            return "enum('".implode("', '", $column->allowed)."')";
    }
    
    protected function typeDate(Fluent $column)
    {
            return 'date';
    }

    protected function typeDateTime(Fluent $column)
    {
            return 'datetime';
    }

    protected function typeTime(Fluent $column)
    {
            return 'time';
    }

    protected function typeTimestamp(Fluent $column)
    {
            return 'timestamp default 0';
    }

    protected function typeBinary(Fluent $column)
    {
        return 'blob';
    }

    protected function modifyUnsigned(Blueprint $blueprint, Fluent $column)
    {
        if ($column->type == 'integer' and $column->unsigned)
        {
            return ' unsigned';
        }
    }

    protected function modifyNullable(Blueprint $blueprint, Fluent $column)
    {
        return $column->nullable ? ' null' : ' not null';
    }

    protected function modifyDefault(Blueprint $blueprint, Fluent $column)
    {
        if ( ! is_null($column->default))
        {
            return " default '".$this->getDefaultValue($column->default)."'";
        }
    }

    protected function modifyIncrement(Blueprint $blueprint, Fluent $column)
    {
        if ($column->type == 'integer' and $column->autoIncrement)
        {
            return ' auto_increment primary key';
        }
    }
}
