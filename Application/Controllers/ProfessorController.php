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
    
    /**
     *
     * @var Application\Models\Professor
     */
    protected $model = 'Application\Models\Professor';
    
    public function indexAction()
    {        
        $this->professores = $this->model->getRepository()
                                        ->getAll();
                                
    }
  
   public function editarAction()
   {
        $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;
       
        $this->professor = $this->model->getRepository()
                                    ->findOrNew($id);

        $this->optionsTurma = $this->model->getMultiOptionsTurma($this->professor);
   }

  
    public function gravarAction()
    {
      

      $mensagem = 'Professor gravado com sucesso!';
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
    
    public function getOptionsTurma(Professor $professor)
    {
        return $this->model->getOptionsTurma($professor);
    }

    public function excluirAction()
    {
        $id = (int) $_GET['id'];

        $mensagem = 'Professor excluído com sucesso!';
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
    
    public function excluirTurmaAction()
    {
      

      $this->mensagem = 'Turma removida';
      try
      {
        $this->professor = $this->model->getRepository()
                ->excluirTurma($_POST);
      }
      catch (Exception $e)
      {
         $this->mensagem = 'Ocorreu um erro: ' . $e->getMessage();
      }       
    }

    
    
    


}
