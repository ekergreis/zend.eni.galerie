<?php

namespace Galerie\Model;

use Custom\Model\Entity;

class Galerie extends Entity
{
    public $id;
    public $id_user;
    public $name;
    public $description;
    public $created;
    public $updated;


    protected $columns = array(
        'id',
        'id_user',
        'name',
        'description',
        'created',
        'updated',
    );

    protected $updatable_columns = array(
        'id_user',
        'name',
        'description',
    );

    protected $primary_columns = array(
        'id',
    );


    public function getDefaultInputFilterArrays()
    {
        return include __DIR__ . '/galerie.defaultinputfilter.config.php';
    }

}
