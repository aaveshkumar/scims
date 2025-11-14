<?php

class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];
    protected $timestamps = true;

    protected $query;
    protected $bindings = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->resetQuery();
    }

    protected function resetQuery()
    {
        $this->query = [
            'select' => ['*'],
            'from' => $this->table,
            'joins' => [],
            'where' => [],
            'orderBy' => [],
            'limit' => null,
            'offset' => null,
        ];
        $this->bindings = [];
    }

    public function select(...$columns)
    {
        $this->query['select'] = $columns;
        return $this;
    }

    public function where($column, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->query['where'][] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];

        $this->bindings[] = $value;

        return $this;
    }

    public function orWhere($column, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->query['where'][] = [
            'type' => 'OR',
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];

        $this->bindings[] = $value;

        return $this;
    }

    public function whereIn($column, array $values)
    {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        
        $this->query['where'][] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => 'IN',
            'value' => "({$placeholders})",
            'raw' => true,
        ];

        $this->bindings = array_merge($this->bindings, $values);

        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->query['orderBy'][] = "{$column} {$direction}";
        return $this;
    }

    public function limit($limit)
    {
        $this->query['limit'] = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->query['offset'] = $offset;
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'INNER')
    {
        $this->query['joins'][] = "{$type} JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }

    public function leftJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function rightJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    protected function buildQuery()
    {
        $sql = 'SELECT ' . implode(', ', $this->query['select']);
        $sql .= ' FROM ' . $this->query['from'];

        if (!empty($this->query['joins'])) {
            $sql .= ' ' . implode(' ', $this->query['joins']);
        }

        if (!empty($this->query['where'])) {
            $whereClauses = [];
            foreach ($this->query['where'] as $index => $where) {
                $clause = ($index === 0) ? 'WHERE' : $where['type'];
                
                if (isset($where['raw']) && $where['raw']) {
                    $whereClauses[] = "{$clause} {$where['column']} {$where['operator']} {$where['value']}";
                } else {
                    $whereClauses[] = "{$clause} {$where['column']} {$where['operator']} ?";
                }
            }
            $sql .= ' ' . implode(' ', $whereClauses);
        }

        if (!empty($this->query['orderBy'])) {
            $sql .= ' ORDER BY ' . implode(', ', $this->query['orderBy']);
        }

        if ($this->query['limit'] !== null) {
            $sql .= ' LIMIT ' . $this->query['limit'];
        }

        if ($this->query['offset'] !== null) {
            $sql .= ' OFFSET ' . $this->query['offset'];
        }

        return $sql;
    }

    public function get()
    {
        $sql = $this->buildQuery();
        $result = $this->db->fetchAll($sql, $this->bindings);
        $this->resetQuery();
        return $result;
    }

    public function first()
    {
        $this->limit(1);
        $sql = $this->buildQuery();
        $result = $this->db->fetchOne($sql, $this->bindings);
        $this->resetQuery();
        return $result;
    }

    public function find($id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    public function all()
    {
        return $this->get();
    }

    public function count()
    {
        $originalSelect = $this->query['select'];
        $this->query['select'] = ['COUNT(*) as count'];
        
        $sql = $this->buildQuery();
        $result = $this->db->fetchOne($sql, $this->bindings);
        
        $this->query['select'] = $originalSelect;
        $this->resetQuery();
        
        return $result['count'] ?? 0;
    }

    public function create(array $data)
    {
        $data = $this->filterFillable($data);

        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $columns = array_keys($data);
        $placeholders = array_fill(0, count($data), '?');

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $columns) . ") 
                VALUES (" . implode(', ', $placeholders) . ")";

        $this->db->execute($sql, array_values($data));

        return $this->db->lastInsertId();
    }

    public function update($id, array $data)
    {
        $data = $this->filterFillable($data);

        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "{$column} = ?";
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . 
               " WHERE {$this->primaryKey} = ?";

        $bindings = array_values($data);
        $bindings[] = $id;

        return $this->db->execute($sql, $bindings);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function exists($id)
    {
        return $this->find($id) !== false;
    }

    protected function filterFillable(array $data)
    {
        if (!empty($this->fillable)) {
            return array_intersect_key($data, array_flip($this->fillable));
        }

        if (!empty($this->guarded)) {
            return array_diff_key($data, array_flip($this->guarded));
        }

        return $data;
    }

    public function raw($sql, $bindings = [])
    {
        return $this->db->fetchAll($sql, $bindings);
    }

    public function rawOne($sql, $bindings = [])
    {
        return $this->db->fetchOne($sql, $bindings);
    }

    public function execute($sql, $bindings = [])
    {
        return $this->db->execute($sql, $bindings);
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }

    public function rollback()
    {
        return $this->db->rollback();
    }
}
