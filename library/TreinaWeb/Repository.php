<?php

namespace TreinaWeb;

use Doctrine\ORM\EntityRepository;

abstract class Repository extends EntityRepository
{
    
    public function getAll()
    {
        $dql = "SELECT a FROM {$this->getClassName()} a";
        $paginator = new Paginator($dql, $this->getEntityManager());
        return $paginator->paginatorDoctrine();
    }
    
    
    public function findOrNew($id)
    {
        $entity = $this->find($id);
        if (empty($entity)) {
            $nameEntity = $this->getClassName();
            $entity = new $nameEntity();
        }
        
        return $entity;
    }
    
    public function delete($id)
    {
        $entity = $this->find($id);
        if (!empty($entity)) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }
    
    abstract public function save($data);
    
}
