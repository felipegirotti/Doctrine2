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
    public function indexAction()
    {
        $em = $GLOBALS['em'];
        $query = $em->createQuery("select a from Application\Entities\Aluno a");
        $this->alunos = $query->getResult(); 
    }

    public function editarAction()
    {
      $id = (int) isset($_GET['id']) ? $_GET['id'] : 0;

      $em = $GLOBALS['em'];

      $aluno = $em->find('Application\\Entities\\Aluno',$id);

      $aluno = empty($aluno) ? new Aluno() : $aluno;

      $this->aluno = $aluno;

      $this->optionsTurma = $this->getOptionsTurma($aluno);
    }

  
    public function gravarAction()
    {
      $id = (int) $_POST['id'];
      $matricula = $_POST['matricula'];
      $nome = $_POST['nome'];
      $dataDeNascimento = $_POST['data_de_nascimento'];
      $idTurma = (int) $_POST['turma'];

      $em = $GLOBALS['em'];

      $aluno = $em->find('Application\Entities\Aluno',$id);

      if (empty($aluno))
      {
        $aluno = new Aluno();
      }
      $aluno->setMatricula($matricula);
      $aluno->setNome($nome);
      $aluno->setDataDeNascimento($dataDeNascimento);

      $turma = $em->find('Application\Entities\Turma',$idTurma);

      $aluno->setTurma($turma);

      if (empty($id))
      {
        $historico = new HistoricoEscolar();
        $historico->setObservacoes('');
        $em->persist($historico);
        $aluno->setHistorico($historico);
      }

      $em->persist($aluno);

      $mensagem = 'Aluno gravado com sucesso!';
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

      $aluno = $em->find('Application\\Entities\\Aluno',$id);

      $em->remove($aluno);

      $mensagem = 'Aluno excluído com sucesso!';
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
