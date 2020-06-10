<?php

namespace Custom\Model;

use Zend\Db\TableGateway\Feature\AbstractFeature;

use Zend\Db\Adapter\Driver\StatementInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSetInterface;


class PairFeature extends AbstractFeature
{
    public function postSelect(StatementInterface $statement, ResultInterface $result, ResultSetInterface $resultSet)
    {
        $result = array();
        foreach($resultSet as $res) {
            $r = $res->toArray();
            $result[$r['id']] = $r['name'];
        }
        $this->tableGateway->setResult($result);
    }

}
