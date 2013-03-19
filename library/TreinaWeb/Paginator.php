<?php

namespace TreinaWeb;

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\Pagination\Paginator as PaginatorDoctrine;

class Paginator
{
    protected $qtdeRegistros;
    protected $page;
    protected $dql;
    protected $em;
    
    /**
     * 
     * @param string $dql
     * @param \Doctrine\ORM\EntityManager $em
     * @param integer $qtdeRegistros [optional=10]
     * @param string $page [optional='page']
     */
    public function __construct($dql, EntityManager $em, $qtdeRegistros = 10, $page = 'page') 
    {
        $this->dql = $dql;
        $this->em = $em;
        $this->qtdeRegistros = $qtdeRegistros;
        $this->page = $page;
    }
    /**
     * 
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginatorDoctrine()
    {
        $page = isset($_GET[$this->page]) ? ceil(($_GET[$this->page] - 1) * $this->qtdeRegistros) : 0;
        $query = $this->em
                ->createQuery($this->dql)
                ->setFirstResult($page)
                ->setMaxResults($this->qtdeRegistros);
        $paginator = new PaginatorDoctrine($query);
        return $paginator;
    }
}
