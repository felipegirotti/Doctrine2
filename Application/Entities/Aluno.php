<?php

namespace Application\Entities;

use Doctrine\ORM\Mapping as ORM;
use \Application\Entities\HistoricoEscolar as Historico;
use \Application\Entities\Turma as Turma;

/**
 * @ORM\Entity(repositoryClass="Application\Repositories\Aluno")
 * @ORM\Table(name="alunos")
 * 
 */
class Aluno
{
  /** 
   * @ORM\Id @ORM\Column(type="integer") 
   * @ORM\GeneratedValue(strategy="AUTO")
   **/
  private $id;
  /** @ORM\Column(type="integer")  **/  
  private $matricula;  
  /** @ORM\Column(type="string") **/
  private $nome;
  /** @ORM\Column(name="data_de_nascimento", type="date") **/
  private $dataDeNascimento;
  /** 
   * @ORM\OnetoOne(targetEntity="HistoricoEscolar")
   * @ORM\JoinColumn(name="id_historico", referencedColumnName="id")  
   **/
  private $historico;
  /**
   * @ORM\ManyToOne(targetEntity="Turma")
   * @ORM\JoinColumn(name="id_turma", referencedColumnName="id")
   */  
  private $turma;

  public function __construct()
  {
    $this->dataDeNascimento = \DateTime::createFromFormat('Y-m-d', date('Y-m-d'));    
  }  
  
  public function setId($id)
  {
    $this->id = $id;
  }
  
  public function setMatricula($matricula)
  {
    $this->matricula = $matricula;
  }
  
  public function setNome($nome)
  {
    $this->nome = $nome;
  }
  
  public function setDataDeNascimento($dataDeNascimento)
  {
    $data = \DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    
    // Formato do banco: yyyy-mm-dd
    if (preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $dataDeNascimento))
    {
      $data = \DateTime::createFromFormat('Y-m-d', $dataDeNascimento);
      echo 'entrou';
    }
    
    // A data veio apenas como número no formato ddmmyyyy
    if (is_numeric($dataDeNascimento) && strlen(trim($dataDeNascimento)) == 8)
    {
      $data = \DateTime::createFromFormat('dmY', $dataDeNascimento);
    }
    
    // a data veio com barras no formato dd/mm/yyyy
    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dataDeNascimento)) 
    {
      $data = \DateTime::createFromFormat('d/m/Y', $dataDeNascimento);
    }
    
    $this->dataDeNascimento = $data;
  }
  
  public function setHistorico(Historico $historico)
  {
    $this->historico = $historico;
  }
  
  public function setTurma(Turma $turma)
  {
    $this->turma = $turma;
  }
  
  public function getId()
  {
    return $this->id;
  }
  
  public function getMatricula()
  {
    return $this->matricula;
  }
  
  public function getNome()
  {
    return $this->nome;
  }
  
  public function getDataDeNascimento()
  {
    return $this->dataDeNascimento->format('d/m/Y');
  }
  
  public function getHistorico()
  {
    return $this->historico;
  }
  
  public function getTurma()
  {
    return $this->turma;
  }  
}
