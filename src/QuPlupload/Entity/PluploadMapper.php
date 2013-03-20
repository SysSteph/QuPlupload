<?php
/**
 * @Author: Cel Ticó Petit
 * @Contact: cel@cenics.net
 * @Company: Cencis s.c.p.
 */

namespace QuPlupload\Entity;

use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use QuPlupload\Entity\PluploadMapperInterface;


class PluploadMapper extends AbstractDbMapper implements PluploadMapperInterface
{
    protected $tableName;

    /**
     * @param $id
     * @return null|object
     */
    public function find($id)
    {
        $select    = $this->getSelect()->where(array('id' => $id));
        $resultSet = $this->select($select);
        if ($resultSet->count()) {
            $entity = $resultSet->current();
            $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
            return  $entity;
        }
        return null;
    }

    /**
     * @param $id
     * @return null|object
     */
    public function findByParent($id)
    {
        $select    = $this->getSelect()->where(array('id_parent' => $id));
        $entity    = $this->select($select);
        if ($entity->count()) {
            $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
            return  $entity;
        }
        return null;
    }


    /**
     * @param array|object $entity
     * @param null $tableName
     * @param HydratorInterface $hydrator
     * @return mixed|null|\Zend\Db\Adapter\Driver\ResultInterface
     */
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setIdPlupload($result->getGeneratedValue());
        return $result->getGeneratedValue();
    }

    /**
     * @param array|object $entity
     * @param null $where
     * @param null $tableName
     * @param HydratorInterface $hydrator
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'id = ' . $entity->getIdPlupload();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }

    /**
     * @param $id
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function remove($id)
    {
        return $this->delete(array('id'=>$id));
    }

    /**
     * @param $tableName
     * @return $this
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

}