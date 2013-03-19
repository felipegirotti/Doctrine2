<?php

namespace Application\Repositories;

use TreinaWeb\Repository;

class Turma extends Repository
{
    
    public function save($data)
    {
        $id = isset($data['id']) ? $data['id'] : 0;
        $nome = $data['nome'];
        
        $turma = $this->findOrNew($id);
        $turma->setNome($nome);    

        $this->getEntityManager()->persist($turma);
        $this->getEntityManager()->flush();
        return $turma;
    }
    
}