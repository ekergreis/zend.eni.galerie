<?php

namespace Galerie\Model;

use Custom\Model\Entity;

class GalerieInfoRss extends Entity
{
    public $id;
    public $name;
    public $description;
    public $username;
    public $nb;
    public $created;
    public $updated;


    protected $columns = array(
        'id',
        'name',
        'description',
        'username',
        'nb',
        'created',
        'updated',
    );

    protected $updatable_columns = array(
    );

    protected $primary_columns = array(
    );

    public function csvFormat()
    {
        return $this->id
            . ';' . $this->name
            . ';' . $this->description
            . ';' . $this->username
            . ';' . $this->nb
            . ';' . $this->created
            . ';' . $this->updated;
    }

}

