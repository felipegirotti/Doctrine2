<?php

namespace Application\Controllers;

use \Application\Entities\Professor as Professor;

/**
 * 
 * @author TreinaWeb
 *
 */
class ProfessorController extends PageController
{
    
    public function indexAction()
    {
        $em = $GLOBALS['em'];
        $query = $em->createQuery("select p from Application\Entities\Professor p");
        $this->professores = $query->getResult();    
    }
  
   public function editarAction()
   {
        $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

        $em = $GLOBALS['em'];

        $professor = $em->find('Application\\Entities\\Professor',$id);

        $professor = empty($professor) ? new Professor() : $professor;

        $this->professor = $professor;

        $this->optionsTurma = $this->_getOptionsTurma($professor);
   }

  
    public function gravarAction()
    {
      $id = isset($_POST['id']) ? $_POST['id'] : 0;
      $matricula = $_POST['matricula'];
      $nome = $_POST['nome'];
      $turmas = $_POST['turmas'];    

      $em = $GLOBALS['em'];

      $professor = $em->find('Application\\Entities\\Professor',$id);

      $professor = empty($professor) ? new Professor() : $professor;
      $professor->setMatricula($matricula); $professor->setNome($nome);

      foreach($turmas as $index => $turma)
      {
        $turma = $em->find('Application\\Entities\\Turma',$turma);
        if (!$professor->getTurmas()->contains($turma))
        {
          $professor->getTurmas()->add($turma);
        }
        if (!$turma->getProfessores()->contains($professor))
        {
          $turma->getProfessores()->add($professor);
        }
      }

      $em->persist($professor);    

      $mensagem = 'Professor gravado com sucesso!';
      try
      {
        $em->flush();      
      }
      catch(Exception $e)
      {
        $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
      }
      $this->mensagem = $mensagem;
    }


    public function excluirAction()
    {
        $id = (int) $_GET['id'];

        $em = $GLOBALS['em'];

        $professor = $em->find('Application\\Entities\\Professor',$id);    

        $em->remove($professor);

        $mensagem = 'Professor excluído com sucesso!';
        try 
        {
          $em->flush();
        }
        catch (Exception $e) 
        {
          $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
        }
        $this->mensagem = $mensagem;        
    }  
    
    public function excluirTurmaAction()
    {
      $idProfessor = $_POST['professor'];
      $idTurma = $_POST['turma'];

      $em = $GLOBALS['em'];

      $professor = $em->find('Application\\Entities\\Professor',$idProfessor);
      $turma = $em->find('Application\\Entities\\Turma',$idTurma);

      $turma->getProfessores()->removeElement($professor);
      $professor->getTurmas()->removeElement($turma);

      $em->persist($turma);

      $this->mensagem = 'Turma removida';
      try
      {
        $em->flush();
      }
      catch (Exception $e)
      {
        $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
      }
      $this->professor = $professor;
    }

    
    private function _getOptionsTurma($professor)
    {
      $em = $GLOBALS['em'];

      $query = $em->createQuery("select t from Application\Entities\Turma t");
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
    
    public function getOptionsTurma($professor)
    {
      $html = '';

      foreach($professor->getTurmas() as $turma)
      {
        $html .= '<option value="' . $turma->getId() . '">' . $turma->getNome() . '</option>';
      }
      return $html;
    }


}
