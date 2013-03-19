<?php

namespace Application\Entities;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Application\Repositories\Professor")
 * @ORM\Table(name="professores")
 * 
 */
class Professor
{
  /** 
   * @ORM\Id @ORM\Column(type="integer") 
   * @ORM\GeneratedValue(strategy="AUTO")
   **/
  private $id;
  /** @ORM\Column(type="integer") **/
  private $matricula;
  /** @ORM\Column(type="string") **/  
  private $nome;
  /** 
   * @ORM\ManyToMany(targetEntity="Turma", mappedBy="professores")
   **/
  private $turmas;

  public function __construct()
  {
    $this->turmas = new ArrayCollection();
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
  
  public function setTurmas($turmas)
  {
    $this->turmas = $turmas;
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
  
  public function getTurmas()
  {
    return $this->turmas;
  }
}
