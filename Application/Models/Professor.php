<?php

namespace Application\Models;

use TreinaWeb\Model,
 Application\Entities\Professor as ProfessorEntity;
        
class Professor extends Model
{
    const ENTITY = 'Application\Entities\Professor';
    
    public function getMultiOptionsTurma(ProfessorEntity $professor)
    {
      
      $query = $this->getEntityManager()->createQuery("select t from Application\Entities\Turma t");
      $turmas = $query->getResult();

      $html = '';

      $turmasProfessor = $professor->getTurmas();
      $turmasProfessor = empty($turmasProfessor) ? array() : $turmasProfessor;

      foreach($turmas as $turma)
      {
        $selected = '';
        foreach($turmasProfessor as $turmaProfessor)
        {
          if ($turmaProfessor->getId() == $turma->getId())
          {
            $selected = ' selected ';
            break;
          }
        }
        $html .= '<option value="' . $turma->getId() . '"' . $selected .  '>' . $turma->getNome() . '</option>';
      }

      return $html;
    }
    
    
    public function getOptionsTurma(ProfessorEntity $professor)
    {
      $html = '';

      foreach($professor->getTurmas() as $turma)
      {
        $html .= '<option value="' . $turma->getId() . '">' . $turma->getNome() . '</option>';
      }
      return $html;
    }
}
