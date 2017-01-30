<?php

namespace josueneo\laravel5sqlanywhere;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;

class SQLAnywhereQueryGrammar extends Grammar {
    protected $selectComponents = [		
        'limit',
        'offset',
        'aggregate',		
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',		
        'unions',
        'lock',
    ];
    public function compileSelect(Builder $query) {
        if (is_null($query->columns)) $query->columns = array('*');
        return 'select ' . trim($this->concatenate($this->compileComponents($query)));
    }
    protected function compileAggregate(Builder $query, $aggregate) {
        $column = $this->columnize($aggregate['columns']);
        
        if ($query->distinct && $column !== '*')
        {
                $column = 'distinct '.$column;
        }
        return $aggregate['function'].'('.$column.') as aggregate';
    }
    protected function compileColumns(Builder $query, $columns) {
        if ( ! is_null($query->aggregate)) return;
        $select = $query->distinct ? 'distinct' : '';
        return $select.$this->columnize($columns);
    }
    protected function compileLimit(Builder $query, $limit) {
        return 'top '.(int) $limit;
    }
    protected function compileOffset(Builder $query, $offset) {
        return 'start at '.((int) $offset + 1);
    }
}
