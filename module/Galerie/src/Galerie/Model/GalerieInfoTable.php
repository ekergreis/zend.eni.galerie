<?php
namespace Galerie\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;

use Custom\Model\Entity;

class GalerieInfoTable implements TableGatewayInterface
{

    protected $adapter;
    protected $resultSetPrototype;
    protected $sql;

    public function __construct(Adapter $adapter) {
        // Gestion de l'adaptateur
        if (!$adapter instanceof Adapter) {
            throw new Exception\RuntimeException('GalerieInfoTable does not have an valid Adapter parameter');
        }
        $this->adapter = $adapter;

        // Utilisation du patron de conception Prototype
        // pour la création des objets ResultSet
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(
            new GalerieInfo()
        );

        // Initialisation de l'outil de création de requête
        $this->sql = new Sql($this->adapter, $this->getTable());
    }


    public function getTable()
    {
        return 'gallery'; // Table centrale de la requête
    }


    public function select($where = null, $order = null, $limit = null, $offset = null)
    {
        $select = $this->sql->select()
            ->columns(array('id', 'name', 'description'))
            ->join('user', 'gallery.id_user = user.id', array(
                'username' => new \Zend\Db\Sql\Expression("user.firstname || ' ' || user.lastname")
            ))
            ->join('photo', 'gallery.id = photo.id_gallery', array(
                'nb' => new \Zend\Db\Sql\Expression('count(photo.id)')
            ), Select::JOIN_LEFT)
            ->group(array(
                'user.lastname',
                'user.firstname',
                'gallery.name'
            ))
            ->order(array(
                'user.lastname',
                'user.firstname',
                'gallery.name'
            ));
        if ($where) {
            $select->where($where);
        }
        if ($order) {
            $select->order($order);
        }
        if ($limit) {
            $select->limit($limit);
        }
        if ($offset) {
            $select->offset($offset);
        }

        // prepare and execute
        // var_dump($select->getSqlString());
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        // build result set
        $resultSet = clone $this->resultSetPrototype;
        $resultSet->initialize($result);

        return $resultSet;
    }

    public function insert($set) {
        throw new \Exception('insert is not allowed');
    }

    public function update($set, $where = null) {
        throw new \Exception('update is not allowed');
    }

    public function delete($where) {
        throw new \Exception('delete is not allowed');
    }

    public function all()
    {
        return $this->select();
    }

    public function one($id)
    {
        if ($id === null) {
            $row = null;
        } else {
            $row = $this->select(array('gallery.id' => (int) $id))->current();
        }
        if (!$row) {
            throw new \Exception("cannot get row {id: {$id}} in table 'galerie'");
        }
        return $row;
    }

    public function any($id)
    {
        if ($id === null) {
            $row = null;
        } else {
            $row = $this->select(array('gallery.id' => (int) $id))->current();
        }
        return $row;
    }

    public function all_by_user($id_user)
    {
        return $this->select(array('gallery.id_user' => (int) $id_user));
    }




    public function count_all()
    {
        $select = $this->sql->select()->columns(array(
            'nb' => new \Zend\Db\Sql\Expression('count(gallery.id)')
        ));

        // prepare and execute
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();

        return $result['nb'];
    }

    public function getPartial($start, $length, $tri, $senstri, $filtre)
    {
        $where = new Where;
        $where->like('gallery.name', "%{$filtre}%");
	$where->or;
        $where->like('gallery.description', "%{$filtre}%"); 

        return $this->select($where, "{$tri} {$senstri}", $length, $start);
    }


    public function csvHeader()
    {
        return "Id;Nom;Description;Propriétaire;Nombre";
    }


}
