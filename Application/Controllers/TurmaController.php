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
    /**
     *
     * @var Application\Models\Turma
     */
    protected $model = 'Application\Models\Turma';
    public function indexAction()
    {            
      $this->turmas = $this->model->getRepository()
                                ->getAll();    
    }

    public function editarAction()
    {
      $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

      $this->turma = $this->model->getRepository()->findOrNew($id);     
    }

  
    public function gravarAction()
    {
     

      $mensagem = 'Turma gravada com sucesso!';
      try 
      {
        $this->model->getRepository()
                    ->save($_POST);
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

      $mensagem = 'Turma excluída com sucesso!';
      try
      {
          $this->model->getRepository()
                        ->delete($id);
      }
      catch (Exception $e)
      {
        $mensagem = 'Ocorreu um erro: ' . $e->getMessage();
      }
      $this->mensagem = $mensagem;
    }

}
