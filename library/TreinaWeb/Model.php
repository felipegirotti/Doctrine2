<?php

namespace TreinaWeb;

use Doctrine\ORM\EntityManager;

abstract class Model
{
    
    const ENTITY = '';    
    protected $em;
    protected $repository;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(EntityManager $em ) 
    {
        $this->em = $em;
        $this->repository = $em->getRepository(static::ENTITY);
    }
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
    
    public function getRepository()
    {
        return $this->repository;
    }
    
    
}