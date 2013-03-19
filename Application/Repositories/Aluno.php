<?php

namespace Application\Repositories;

use TreinaWeb\Repository,
    Application\Entities\HistoricoEscolar;

class Aluno extends Repository
{
    
    public function save($data)
    {
        $id = (int) $data['id'];
        $matricula = $data['matricula'];
        $nome = $data['nome'];
        $dataDeNascimento = $data['data_de_nascimento'];
        $idTurma = (int) $data['turma'];       

        $aluno = $this->findOrNew($id);       
        $aluno->setMatricula($matricula);
        $aluno->setNome($nome);
        $aluno->setDataDeNascimento($dataDeNascimento);

        $turma = $this->getEntityManager()->find('Application\Entities\Turma', $idTurma);

        $aluno->setTurma($turma);

        if (empty($id))
        {
          $historico = new HistoricoEscolar();
          $historico->setObservacoes('');
          $this->getEntityManager()->persist($historico);
          $aluno->setHistorico($historico);
        }

        $this->getEntityManager()->persist($aluno);
        $this->getEntityManager()->flush();
    }
    
}