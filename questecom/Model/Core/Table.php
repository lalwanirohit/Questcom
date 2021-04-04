<?php

namespace Model\Core;

class Table
{

    public function __construct()
    {

    }
    protected $tableName = null;
    protected $primaryKey = null;
    // protected $originalData = [];
    public $data = [];
    protected $adapter = null;

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
    public function getTableName()
    {
        return $this->tableName;
    }

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }
    public function __get($value)
    {
        // if (array_key_exists($value, $this->data)) {
        //     return $this->data[$value];
        // }

        // if (array_key_exists($value, $this->originalData)) {
        //     return $this->originalData[$value];
        // }
        // return null;
        if (!array_key_exists($value, $this->data)) {
            return null;
        }
        return $this->data[$value];
    }

    // public function setOriginalData($originalData)
    // {
    //     $this->originalData = $originalData;
    //     return $this;
    // }

    // public function getOriginalData()
    // {
    //     return $this->originalData;
    // }

    public function setData(array $data)
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }
    public function getData($key = null, $optional = null)
    {
        return $this->data;
    }

    public function setAdapter()
    {
        $this->adapter = \Mage::getModel('Model\Core\Adapter');
    }
    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->setAdapter();
        }
        return $this->adapter;
    }

    //save() for save data in database
    public function save()
    {
        // if (array_key_exists($this->getPrimaryKey(), $this->data)) {
        //     unset($this->data[$this->getPrimaryKey()]);
        // }

        $id = $this->{$this->getPrimaryKey()};

        // if (!$this->data) {
        //     return false;
        // }

        if ($id) {
            $filed = array_keys($this->data);
            $value = array_values($this->data);
            $final = null;
            $id = '';
            for ($i = 0; $i < count($filed); $i++) {
                if ($filed[$i] == $this->getPrimaryKey()) {
                    $id = $value[$i];
                    continue;
                }
                $final = $final . "`" . $filed[$i] . "`='" . $value[$i] . "',";
            }
            $final = rtrim($final, ",");
            $query = "UPDATE `{$this->getTableName()}` SET {$final} WHERE `{$this->getPrimaryKey()}` = '{$id}'";
            $adapter = $this->getAdapter();
            $adapter->update($query);
            // if (!$adapter->update($query)) {
            //     return false;
            // }

        } else {
            $values = null;
            $filedName = null;
            foreach (array_keys($this->data) as $value) {
                $filedName = $filedName . "`$value`,";
            }
            foreach (array_values($this->data) as $value) {
                $values = $values . "'$value',";
            }
            $filedName = rtrim($filedName, ",");
            $values = rtrim($values, ",");
            $query = "INSERT INTO `{$this->getTableName()}`({$filedName}) VALUES ({$values})";
            $adapter = $this->getAdapter();
            $id = $adapter->insert($query);
            // if (!$id) {
            //     return false;
            // }
        }
        $this->load($id);
        return $this;
    }

    //for fatch specific row
    public function load($value)
    {
        $query = "SELECT * FROM `{$this->getTableName()}` WHERE `{$this->getPrimaryKey()}` = '$value'";
        $row = $this->getAdapter()->fetchRow($query);

        if (!$row) {
            return false;
        }
        $this->data = $row;
        // $this->setOriginalData($row);
        // $this->resetData();
        return $this;
    }

    //----------------------------------------------------

    public function loadRow($query)
    {
        $row = $this->getAdapter()->fetchRow($query);

        if (!$row) {
            return false;
        }
        $this->data = $row;
        // $this->setOriginalData($row);
        // $this->resetData();
        return $this;
    }

    //----------------------------------------------------

    //for fatch a all records
    public function all($query = null)
    {
        if (!$query) {
            $query = "SELECT * FROM `{$this->getTableName()}`";
        }
        $rows = $this->getAdapter()->fetchAll($query);
        if (!$rows) {
            return false;
        }
        foreach ($rows as $key => $value) {
            // echo "<pre>";
            // print_r($key);
            // print_r($value);

            // $key->setData($value);

            $key = new $this;
            $key->setData($value);
            // $key->setOriginalData($value);
            $rowArray[] = $key;
        }
        // die;

        // echo "<pre>";
        // print_r($rowArray);
        // die;
        $collectionClassName = get_class($this) . '\collection';
        $collection = \Mage::getModel($collectionClassName);
        $collection->setData($rowArray);
        unset($rowarray);
        return $collection;
    }

    //for delete the data from database
    public function delete($value, $query = null)
    {
        if (!$query) {
            $query = "DELETE FROM `{$this->getTableName()}` WHERE `{$this->getPrimaryKey()}` = '$value'";
            $this->getAdapter()->delete($query);
        } else {
            $this->getAdapter()->delete($query);
        }
        return $this;
    }

    // public function loadImages($value,$query=null)
    //    {
    //     if(!$query) {
    //         $query = "SELECT * FROM `{$this->getTableName()}` WHERE `productId` = '$value'";
    //         $rows = $this->getAdapter()->fetchAll($query);
    //     }
    //     else {
    //         $rows = $this->getAdapter()->fetchAll($query);
    //     }
    //        if(!$rows){
    //            return false;
    //        }
    //        foreach($rows as $key=>$value) {
    //         $key = new $this;
    //         $key->setData($value);
    //         $rowArray[]=$key;
    //     }
    //     $collectionClassName = get_class($this).'\collection';
    //        $collection = \Mage::getModel($collectionClassName);
    //     $collection->setData($rowArray);
    //     unset($rowarray);
    //        return $collection;
    //    }

    public function updateImage($query)
    {
        $adapter = $this->getAdapter();
        $adapter->update($query);
        return $this;
    }

    public function loadAddress($customerId, $type)
    {
        $query = "SELECT * FROM `{$this->getTableName()}` WHERE `customerId` = '$customerId' AND `addressType` = '$type'";
        $row = $this->getAdapter()->fetchRow($query);

        if (!$row) {
            return false;
        }
        $this->data = $row;
        // $this->setOriginalData($row);
        return $this;
    }

    public function resetData()
    {
        $this->data = [];
        return $this;
    }

}
