<?php
/**
 * Trait used to store the reports created to the system.
 * User: Braiani
 * Date: 07/02/19
 * Time: 21:49
 */

namespace App\Traits;


use App\Models\Aluno;
use App\Models\Registro;
use League\Csv\Writer;

trait RelatoriosCoords
{
    public function alunoSituacao()
    {
        $alunos = Aluno::has('registros')->with('registros')->get();
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['Estudante', 'Semestre', 'Situação']);

        foreach ($alunos as $aluno) {
            $semestreAnterior = $aluno->registros->firstWhere('semestre', '20182');
            $semestreAtual = $aluno->registros->firstWhere('semestre', '20191');

            $csv->insertOne([
                $aluno->nome,
                '20181',
                $semestreAnterior === null ? '' : $semestreAnterior->situacoes->nome
            ]);
            $csv->insertOne([
                $aluno->nome,
                '20191',
                $semestreAtual === null ? '' : $semestreAtual->situacoes->nome
            ]);
        }

        return $csv->output('Relatório Alunos com situação.csv');
    }

    public function disciplinaRecusadas($semestre)
    {
        $registros = Registro::where(function ($query) use ($semestre) {
            return $query->where('semestre', $semestre)->where('avaliacao', 2);
        })->with('disciplinas')->get();

        $registrosGrouped = $registros->groupBy('id_disciplina_cursos');

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['Curso', 'Disciplina', 'Quantidade']);

        foreach ($registrosGrouped as $registro) {
            $csv->insertOne([
                $registro->first()->disciplinas->curso->nome,
                $registro->first()->disciplinas->nomeFormatado,
                $registro->count()
            ]);
        }

        return $csv->output('Relatório Disciplinas Recusadas.csv');

    }

}