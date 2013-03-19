<?php

namespace Application\Repositories;

use TreinaWeb\Repository;

class Professor extends Repository
{
    
    public function save($data)
    {
        $id = isset($data['id']) ? $data['id'] : 0;
        $matricula = $data['matricula'];
        $nome = $data['nome'];
        $turmas = $data['turmas'];            
        
        $professor = $this->findOrNew($id);

        $professor->setMatricula($matricula); 
        $professor->setNome($nome);

        foreach($turmas as $index => $turma)
        {
          $turma = $this->getEntityManager()->find('Application\\Entities\\Turma',$turma);
          if (!$professor->getTurmas()->contains($turma))
          {
            $professor->getTurmas()->add($turma);
          }
          if (!$turma->getProfessores()->contains($professor))
          {
            $turma->getProfessores()->add($professor);
          }
        }

        $this->getEntityManager()->persist($professor);      
        $this->getEntityManager()->flush();
    }
    
    public function excluirTurma($data)
    {
        $idProfessor = $data['professor'];
        $idTurma = $data['turma'];       

        $professor = $this->find($idProfessor);
        $turma = $this->getEntityManager()->find('Application\\Entities\\Turma',$idTurma);

        $turma->getProfessores()->removeElement($professor);
        $professor->getTurmas()->removeElement($turma);

        $this->getEntityManager()->persist($turma);
        $this->getEntityManager()->flush();
        return $professor;
    }
    
}