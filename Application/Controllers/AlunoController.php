<?php

namespace Application\Controllers;

use \Application\Entities\Aluno as Aluno,
  \Application\Entities\Turma as Turma,
  \Application\Entities\HistoricoEscolar as HistoricoEscolar;


/**
 * 
 * @author TreinaWeb
 *
 */
class AlunoController extends PageController
{
    
    protected $model = 'Application\Models\Aluno';
    
    public function indexAction()
    {               
        $this->alunos = $this->model->getRepository()->getAll(); 
    }

    public function editarAction()
    {
      $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

      $this->aluno = $this->model->getRepository()
                        ->findOrNew($id);

      $this->optionsTurma = $this->getOptionsTurma($this->aluno);
    }

  
    public function gravarAction()
    {     
      $mensagem = 'Aluno gravado com sucesso!';
      try 
      {
        $this->model->getRepository()->save($_POST);    
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

      $mensagem = 'Aluno excluído com sucesso!';
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


    private function getOptionsTurma(Aluno $aluno)
    {
      $em = $GLOBALS['em'];

      $query = $em->createQuery("select t from Application\Entities\Turma t");
      $turmas = $query->getResult();

      $html = '';

      foreach($turmas as $turma)
      {
        $id = ($aluno->getTurma() == null) ? 0 : $aluno->getTurma()->getId();
        $selected = ($turma->getId() == $id) ? ' selected ' : '';
        $html .= '<option value="' . $turma->getId() . '"' . $selected .  '>' . $turma->getNome() . '</option>';
      }

      return $html;
    }


}
