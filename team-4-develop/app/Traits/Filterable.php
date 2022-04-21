<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Filterable
{
    public function scopeFilter($query, $param)
    {
        foreach ($param as $field => $value) {
            $method = 'filter' . Str::studly($field);
    
            if ($value != '') {
                if (method_exists($this, $method)) {
                    $this->{$method}($query, $value);
                } else {
                    if (!empty($this->filterable) && is_array($this->filterable)) {
                        if (in_array($field, $this->filterable)) {
                            $query->where($this->table . '.' . $field, $value);
                        } elseif (key_exists($field, $this->filterable)) {
                            $query->where($this->table . '.'
                                . $this->filterable[$field], $value);
                        }
                    }
                }
            }
        }
    
        return $query;
    }
}
