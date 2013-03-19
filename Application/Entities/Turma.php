<?php

namespace Application\Entities;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Application\Repositories\Turma")
 * @ORM\Table(name="turmas")
 * 
 */
class Turma
{
  /** 
   * @ORM\Id @ORM\Column(type="integer") 
   * @ORM\GeneratedValue(strategy="AUTO")
   **/
  private $id;
  /** @ORM\Column(type="string") **/
  private $nome;
  /** @ORM\OneToMany(targetEntity="Aluno", mappedBy="turma")  **/
  private $alunos;
  /** 
   * @ORM\ManyToMany(targetEntity="Professor")
   * @ORM\JoinTable(name="professores_turma",
   * joinColumns={@ORM\JoinColumn(name="id_turma",referencedColumnName="id")},
   * inverseJoinColumns={@ORM\JoinColumn(name="id_professor",referencedColumnName="id")}
   * ) 
   **/
  private $professores;

  public function __construct()
  {
    $this->professores = new ArrayCollection();
  }
  
  public function setId($id)
  {
    $this->id = $id;
  }
  
  public function setNome($nome)
  {
    $this->nome = $nome;
  }
  
  public function setAlunos($alunos)
  {
    $this->alunos = $alunos;
  }
  
  public function setProfessores($professores)
  {
    $this->professores = $professores;
  }
  
  public function getId()
  {
    return $this->id;
  }
  
  public function getNome()
  {
    return $this->nome;
  }
  
  public function getAlunos()
  {
    return $this->alunos;
  }
  
  public function getProfessores()
  {
    return $this->professores;
  }  
}
