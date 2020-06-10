<?php
namespace Custom\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PairManager extends AbstractTableGateway
{

    protected $pair;

    protected $result;

    public function __construct(
        Adapter $adapter,
        $table,
        Pair $pair = null
    ) {
        // Composition avec l'adaptateur
        $this->adapter = $adapter;

        // Détermination de la table principale à requêter
        $this->table = $table;

        // Composition avec l'entité
        if ($pair === null) {
            $this->pair = new Pair;
        } else {
            $this->pair = $pair;
        }

        // Utilisation du patron de conception Prototype
        // pour la création des objets ResultSet
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(
            $this->pair
        );

        // Initialisation du gestionnaire
        $this->initialize();
        $this->featureSet->addFeature(new PairFeature);
    }

    public function all()
    {
        $this->select();
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

}
