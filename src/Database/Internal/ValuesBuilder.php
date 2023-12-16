<?php
namespace JI\Database\Internal;

/**
 * @author Zhan Isaakian <jeanisahakyan@gmail.com>
 */
class ValuesBuilder extends AbstractBuilder {
  protected final function prepare(): void {
    $set = [];
    foreach ($this->raw as $name => $value) {
      $key = $this->getKey();
      if (is_array($value)) {
        $value = json_encode($value);
      }
      $this->bind[$key] = $value;
      $set[] = "`{$name}` = :{$key}";
    }
    $this->query[] = 'SET';
    $this->query[] = implode(', ', $set);
  }
}
