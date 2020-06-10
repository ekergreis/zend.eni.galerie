<?php
namespace Custom\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

abstract class EntityManager extends AbstractTableGateway
{

    protected $entity;

    public function __construct(
        Adapter $adapter,
        Entity $entity
    ) {
        // Composition avec l'adaptateur
        $this->adapter = $adapter;

        // Composition avec l'entité
        $this->entity = $entity;

        // Utilisation du patron de conception Prototype
        // pour la création des objets ResultSet
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(
            $entity
        );

        // Initialisation du gestionnaire
        $this->initialize();
    }

    public function all()
    {
        return $this->select();
    }

    public function one($primary_array=array())
    {
        if (!count($primary_array)) {
            $row = null;
        } else {
            $valid = true;
            foreach($primary_array as $p) {
                if ($p === null) {
                    $row = null;
                    $valid = false;
                    break;
                }
            }
            if ($valid) {
                $row = $this->select($primary_array)->current();
            }
        }
        if (!$row) {
            $keys = array();
            foreach($primary_array as $k => $v) {
                $keys[] = "{$k}: {$v}";
            }
            $keys = implode(', ', $keys);
            throw new \Exception("cannot get row {{$keys}} in table 'galerie'");
        }
        return $row;
    }

    public function any($primary_array)
    {
        if (!count($primary_array)) {
            $row = null;
        } else {
            $valid = true;
            foreach($primary_array as $p) {
                if ($p === null) {
                    $row = null;
                    $valid = false;
                    break;
                }
            }
            if ($valid) {
                $row = $this->select($primary_array)->current();
            }
        }
        return $row;
    }

    protected abstract function is_new(Entity $entity);
    protected abstract function extract_primary(Entity $entity);
 
    public function save(Entity $entity)
    {
        if ($this->is_new($entity)) {
            $this->insert(
                $entity->toUpdatableArray()
            );
        } elseif ($this->any($this->extract_primary($entity))) {
            $this->update(
                $entity->toUpdatableArray(),
                $entity->toPrimaryArray()
            );
            die("update");
        } else {
            $keys = array();
            foreach($this->extract_primary($entity) as $k => $v) {
                $keys[] = "{$k}: {$v}";
            }
            $keys = implode(', ', $keys);
            throw new \Exception("cannot update row {{$keys}} in table 'galerie'");
        }
    }

    // La fonction delete du père suffit à notre besoin.

}
