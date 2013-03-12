<?php

namespace Application\Controllers;

use \Application\Entities\Turma as Turma;

/**
 * 
 * @author TreinaWeb
 *
 */
class TurmaController extends PageController
{
    public function indexAction()
    {
      $em = $GLOBALS['em'];
      $query = $em->createQuery("select a from Application\Entities\Turma a");
      $this->turmas = $query->getResult();    
    }

    public function editarAction()
    {
      $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

      $em = $GLOBALS['em'];

      $turma = $em->find('Application\\Entities\\Turma',$id);

      $turma = empty($turma) ? new Turma() : $turma;

      $this->turma = $turma;     
    }

  
    public function gravarAction()
    {
      $id = isset($_POST['id']) ? $_POST['id'] : 0;
      $nome = $_POST['nome'];

      $em = $GLOBALS['em'];

      $turma = $em->find('Application\\Entities\\Turma',$id);

      $turma = empty($turma) ? new Turma() : $turma;
      $turma->setNome($nome);    

      $em->persist($turma);

      $mensagem = 'Turma gravada com sucesso!';
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

      $turma = $em->find('Application\\Entities\\Turma',$id);

      $em->remove($turma);

      $mensagem = 'Turma excluída com sucesso!';
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

}
