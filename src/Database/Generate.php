<?php
namespace JI\Database;
use PDO;
/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class Generate {
  private AbstractDatabase $db;
  private string $name;
  private string $dir;
  private string $namespace;
  private bool $forced = false;

  private const TAB = '  ';


  public function __construct(AbstractDatabase $db, string $name, string $dir, string $namespace, bool $forced = false) {
    $this->db   = $db;
    $this->dir  = $dir;
    $this->namespace  = $namespace;
    $this->name = $name;
    $this->forced = $forced;
  }

  public static function create(AbstractDatabase $db, string $name, string $dir, string $namespace, bool $forced = false): self {
    return new self($db, $name, $dir, $namespace, $forced);
  }

  private function fetch(string $query): array {
    return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function process(): self {
    return $this->tables();
  }

  private function tables(): self {
    $tables = $this->fetch("SHOW TABLES FROM {$this->name}");
    $tables = array_map('array_values', $tables);
    foreach ($tables as $table) {
      [$table] = $table;
      $this->prepare($table);
    }
    return $this;
  }

  private function camelize(string $str) {
    return implode('', array_map('ucfirst', explode('_', $str)));
  }

  private function prepare(string $table_name) {
    $rows = $this->fetch("SHOW COLUMNS FROM {$table_name}");
    $fields = [];
    foreach ($rows as $row) {
      $type = $row['Type'];
      if (str_starts_with($type, 'varchar') || $type === 'text') {
        $type = 'string';
      } elseif ($type === 'bigint') {
        $type = 'int';
      } elseif ($type === 'json') {
        $type = 'array';
      }
      $fields[$row['Field']] = [
        'type' => $type,
        'ai' => str_contains($row['Extra'], 'auto_increment'),
      ];
    }
    $rows = $this->fetch("SHOW KEYS FROM {$table_name}");
    $indexes = [];
    foreach ($rows as $row) {
      $name = $row['Key_name'];
      if (!array_key_exists($name, $indexes)) {
        $indexes[$name] = [
          'keys' => [],
          'type' => $row['Index_type'],
        ];
      }
      $indexes[$name]['keys'][] = $row['Column_name'];
    }
    $this->generate($table_name, $fields, $indexes);
  }

  private function createDirectories(string $dir): bool {
    if (is_dir($dir)) {
      return true;
    }
    return mkdir($dir, 0777, true);
  }

  private function createFile(string $namespace, string $name, string $content): bool {
    $dir = $this->dir.'/'.implode('/', explode('\\', $this->namespace)).'/'.$namespace;
    if (!$this->createDirectories($dir)) {
      return false;
    }
    $file_name = "{$dir}/{$name}.php";
    if (!$this->forced && file_exists($file_name)) {
      return false;
    }
    return (bool)file_put_contents($file_name, $content);
  }


  private function generate(string $table_name, array $fields, array $indexes) {
    $class_name = $this->camelize($table_name);
    $object_class_name = $class_name;
    if (str_ends_with($object_class_name, 's')) {
      $object_class_name = substr($object_class_name, 0, strlen($object_class_name) - 1);
    }

    $namespace = 'namespace '.$this->namespace.'\\'.$class_name.';';

    $properties = [];
    $constants = [];
    $functions = [];
    foreach ($fields as $name => $field) {
      $type = $field['type'];
      $properties[] = 'private ?'.$type. ' $'.$name. ' = null;';
      $constants[] = 'public const FIELD_'.strtoupper($name). " = '".$name."';";
      $func_name = $this->camelize($name);
      if ($type === 'array') {
        $functions[] = <<<PHP
  public function get{$func_name}Value(string \$name): mixed {
    \$values = \$this->get{$func_name}();
    if (!\$values) {
      return null;
    }
    if (!array_key_exists(\$name, \$values)) {
      return null;
    }
    return \$values[\$name];
  }
  public function set{$func_name}Value(string \$name, mixed \$value): self {
    \$values = \$this->{$name};
    if (\$values === null) {
      \$values = [];
    }
    if (\$value === null) {
      unset(\$values[\$name]);
    } else {
      \$values[\$name] = \$value;
    }
    return \$this->set{$func_name}(\$values);
  }
PHP;

      }


      $functions[] = <<<PHP
  public function set{$func_name}(?{$type} \${$name}): self {
    \$this->{$name} = \${$name};
    return \$this;
  }

  public function get{$func_name}(): ?{$type} {
    return \$this->{$name};
  }
PHP;
    }


    $constants = self::TAB.implode(PHP_EOL.self::TAB, $constants);
    $properties = self::TAB.implode(PHP_EOL.self::TAB, $properties);
    $functions = implode(PHP_EOL.PHP_EOL, $functions);
    $item = <<<PHP
<?php

{$namespace}

use JI\Database\Utils\AbstractItem;

class {$object_class_name} extends AbstractItem {

{$constants}

{$properties}

{$functions}
}
PHP;
    $this->createFile($class_name, $object_class_name, $item);

    $db = $this->db::class;

    $loaders = '';

    $insert_type = 'bool';
    $insert_func = 'insertItem';
    $sort_field_ai = '';
    foreach ($indexes as $name => $index) {
      $type = $index['type'];
      if ($name === 'PRIMARY') {
        foreach ($index['keys'] as $key) {
          if ($fields[$key]['ai']) {
            $insert_type = 'int';
            $insert_func = 'insertItemWithId';
            $sort_field_ai = $key;
            break;
          }
        }
        if (count($index['keys']) === 1 && $sort_field_ai) {
          continue;
        }
      }
      if ($type === 'FULLTEXT') {
        $params = '?string $query';
        $params_props = '$query';
        $columns = array_map(fn ($key) => self::TAB.self::TAB.self::TAB.self::TAB.self::TAB.self::TAB."{$object_class_name}::FIELD_".strtoupper($key), $index['keys']);
        $columns = implode(','. PHP_EOL, $columns);
        $where_full = <<<PHP
 \$where = [];
    if (\$query) {
      \$where = [
        'MATCH'       => [
          'columns' => [
{$columns}            
          ],
          'keyword' => \$query,
          'mode'    => 'boolean',
        ],
      ];
    }
PHP;
        $sort_field = $sort_field_ai;
      } else {
        if ($name === 'PRIMARY') {

          if (!$sort_field_ai && count($index['keys']) > 1) {
            $sort_field_ai = $index['keys'][count($index['keys']) - 1];
          }
          [$name] = $index['keys'];
          $index['keys'] = array_slice($index['keys'], 0, 1);
        }
        $params = array_map(fn($key) => $fields[$key]['type'].' $'.$key, $index['keys']);
        $params = implode(', ', $params);
        $params_props = array_map(fn($key) => '$'.$key, $index['keys']);
        $params_props = implode(', ', $params_props);
        $props = array_map(fn($key) =>  self::TAB.self::TAB.self::TAB."{$object_class_name}::FIELD_".strtoupper($key).' => $'.$key, $index['keys']);
        $props = implode(','.PHP_EOL, $props);
        if ($sort_field_ai) {
          $sort_field = $sort_field_ai;
        } else {
          $sort_field = $index['keys'][0];
        }

        $where_full = <<<PHP
\$where = [
{$props}
    ];
PHP;
      }
      $sort_field =  "{$object_class_name}::FIELD_".strtoupper($sort_field);;
      $load_func_name = $this->camelize($name);
      $loaders .= <<<PHP
  
  public static function loadMany{$load_func_name}({$params}, Limits \$limits): ItemsList {
    {$where_full}
    \$row = self::db()->loadMany(self::TABLE, '*', \$where, \$limits, {$sort_field});
    if (\$row->getItems()) {
      \$row->setItems({$object_class_name}::fromArrayArray(\$row->getItems()));
    }
    return \$row;
  }

  public static function loadOne{$load_func_name}({$params}): ?{$object_class_name} {
    return self::loadMany{$load_func_name}({$params_props}, Limits::create()->setCount(1))->getLastItem();
  }

PHP;

    }



    $primary = array_map(fn($index) => $object_class_name.'::FIELD_'.strtoupper($index), $indexes['PRIMARY']['keys']);
    $primary = implode(', '.PHP_EOL.self::TAB.self::TAB, $primary);

    $storage_class_name = "{$class_name}Storage";
    $storage = <<<PHP
<?php

{$namespace}

use JI\Database\Utils\FullID;
use JI\Database\Utils\ItemsList;
use JI\Database\Utils\Limits;
use JI\Database\Utils\LoaderTrait;
use {$db} as DB;

class {$storage_class_name} {
  private const TABLE = '{$table_name}';
  
  use LoaderTrait;
  
  private const PRIMARY = [
    {$primary}
  ];
  
  private static function db(): DB {
    return DB::getInstance();
  }
  
  protected static function skeleton(FullID \$item_id, mixed \$item): array {
    return \$item_id->toColumns(self::PRIMARY) + [
    
    ];
  }
  
  private static function fromArray(array \$item): {$object_class_name} {
    return {$object_class_name}::fromArray(\$item);
  }

  /**
   * @param FullID[] \$item_ids
   * @return array
   */
  public static function loadItems(array \$item_ids): array {
    return self::db()->loadItems(self::TABLE, \$item_ids, '*', self::PRIMARY);
  }

  public static function delete(FullID \$item_id): bool {
    return self::db()->deleteItem(self::TABLE, \$item_id, self::PRIMARY);
  }

  public static function update(FullID \$item_id, {$object_class_name} \$update): bool {
    return self::db()->updateItem(self::TABLE, \$update, \$item_id, self::PRIMARY);
  }

  public static function insert({$object_class_name} \$insert): ?{$insert_type} {
    return self::db()->{$insert_func}(self::TABLE, \$insert);
  }
  {$loaders}
}

PHP;

    $this->createFile($class_name, $storage_class_name, $storage);
  }

}
