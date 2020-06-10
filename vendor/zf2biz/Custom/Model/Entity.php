<?php

namespace Custom\Model;


use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class Entity implements InputFilterAwareInterface
{

    protected $inputFilter;

    public function exchangeArray($data, $overwrite=false)
    {
        foreach($this->columns as $col) {
            if (array_key_exists($col, $data)) {
                $this->$col = $data[$col];
            } elseif ($overwrite) {
                $this->$col = null;
            }
        }
    }

    public function toArray() {
        $result = array();
        foreach($this->columns as $col) {
            $result[$col] = $this->$col;
        }
        return $result;
    }

    public function getArrayCopy() {
        $result = array();
        foreach($this->columns as $col) {
            $result[$col] = $this->$col;
        }
        return $result;
    }

    public function toUpdatableArray() {
        $result = array();
        foreach($this->updatable_columns as $col) {
            $result[$col] = $this->$col;
        }
        return $result;
    }

    public function toPrimaryArray() {
        $result = array();
        foreach($this->primary_columns as $col) {
            $result[$col] = $this->$col;
        }
        return $result;
    }



    public function setInputFilter(InputFilterInterface $inputfilter)
    {
        $this->inputFilter = $inputFilter;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->setDefaultInputFilter();
        }
        return $this->inputFilter;
    }

    protected function setDefaultInputFilter()
    {
        $inputFilter = new InputFilter;
        $factory = new InputFactory;

        foreach ($this->getDefaultInputFilterArrays() as $params) {
            $inputFilter->add($factory->createInput($params));
        }
        $this->inputFilter = $inputFilter;

        return $this->inputFilter;

    }

    protected function getDefaultInputFilterArrays()
    {
        return array();
    }

}
