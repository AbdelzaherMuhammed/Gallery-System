<?php


class DbObject
{

    public static function findAll()
    {
        return static::FindByQuery("SELECT * FROM " . static::$dbTable);
    }


    public static function findById($id)
    {
        $the_result_array = static::FindByQuery("SELECT * FROM " . static::$dbTable . " WHERE id= " . $id . ' LIMIT 1');

        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function FindByQuery($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = [];
        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiation($row);
        }
        return $the_object_array;

    }

    public static function instantiation($the_record)
    {
        $callingClass = get_called_class();

        $the_object = new $callingClass;

        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->hasTheAttribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }

        return $the_object;
    }

    private function hasTheAttribute($the_attribute)
    {
        $object_properties = get_object_vars($this);

        return array_key_exists($the_attribute, $object_properties);
    }


    public function properties()
    {
//        return get_object_vars($this);

        $properties = [];

        foreach (static::$dbTableFields as $dbTableField) {
            if (property_exists($this, $dbTableField)) {
                $properties[$dbTableField] = $this->$dbTableField;
            }
        }
        return $properties;
    }


    public function cleanProperties()
    {
        global $database;

        $cleanProperties = [];
        foreach ($this->properties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value);
        }
        return $cleanProperties;
    }


    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }


    public function create()
    {
        global $database;
        $properties = $this->cleanProperties();


        $sql = "INSERT INTO " . static::$dbTable . "( " . implode(',', array_keys($properties)) . " )";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";


        $this->id = $database->theInsertId();

        if ($database->query($sql)) {
            return true;
        } else {
            return false;
        }

    } // End Create Method


    public function update()
    {
        global $database;

        $properties = $this->cleanProperties();
        $propertiesPairs = [];

        foreach ($properties as $key => $value) {
            $propertiesPairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$dbTable . " SET ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " WHERE id= " . $database->escapeString($this->id);


        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    } //End Of Update Method


    public function delete()
    {
        global $database;

        $sql = "DELETE FROM " . static::$dbTable . " ";
        $sql .= "WHERE id= " . $database->escapeString($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }


    public static function countAll()
    {
        global $database;

        $sql = "SELECT COUNT(*) FROM ". static::$dbTable ;
        $resultSet = $database->query($sql);
        $row  = mysqli_fetch_array($resultSet);
        return array_shift($row);
    }
    

}