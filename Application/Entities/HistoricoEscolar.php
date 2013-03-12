<?php

namespace Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="historico_escolar")
 *
 */
class HistoricoEscolar
{
  /**
   * @ORM\Id @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   **/
  private $id;
  /** @ORM\Column(type="text") **/
  private $observacoes;
  
  public function setObservacoes($observacoes)
  {
    $this->observacoes = $observacoes;
  }  
  
}
