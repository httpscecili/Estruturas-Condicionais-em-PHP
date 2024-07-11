<?php
$alunos = [];

function menu() {
    echo "Sistema de Gestão de Notas de Alunos\n";
    echo "1. Cadastrar Alunos\n";
    echo "2. Atribuir Notas\n";
    echo "3. Exibir Resultados\n";
    echo "4. Editar Resultados\n";
    echo "5. Sair\n";
    echo "Escolha uma opção: ";
}

function opcao_invalida() {
    echo "Opção inválida! Tente novamente.\n";
}

function cadastrar_alunos() {
    global $alunos;
    for ($i = 0; $i < 5; $i++) {
        echo "Digite o nome do aluno " . ($i + 1) . ": ";
        $nome = trim(fgets(STDIN));
        $alunos[] = ['nome' => $nome, 'notas' => [], 'media' => 0, 'resultado' => ''];
    }
    echo "Cadastro de alunos concluído.\n";
}

function atribuir_notas() {
    global $alunos;
    foreach ($alunos as $index => $aluno) {
        echo "Atribuindo notas para " . $aluno['nome'] . ":\n";
        $notas = [];
        for ($j = 0; $j < 4; $j++) {
            do {
                echo "Digite a nota " . ($j + 1) . " (0 a 10): ";
                $nota = floatval(trim(fgets(STDIN)));
                if ($nota < 0 || $nota > 10) {
                    echo "Nota inválida! Tente novamente.\n";
                }
            } while ($nota < 0 || $nota > 10);
            $notas[] = $nota;
        }
        $alunos[$index]['notas'] = $notas;
        calcular_resultado($alunos[$index]);
    }
    echo "Notas atribuídas.\n";
}

function calcular_resultado(&$aluno) {
    $soma = array_sum($aluno['notas']);
    $media = $soma / count($aluno['notas']);
    $aluno['media'] = $media;

    if ($media < 4) {
        $aluno['resultado'] = 'Reprovado';
    } elseif ($media >= 4 && $media <= 6) {
        $aluno['resultado'] = 'Recuperação';
    } else {
        $aluno['resultado'] = 'Aprovado';
    }
}

function exibir_resultados() {
    global $alunos;
    echo "Resultados dos Alunos:\n";
    foreach ($alunos as $aluno) {
        echo "Nome: " . $aluno['nome'] . "\n";
        echo "Notas: " . implode(", ", $aluno['notas']) . "\n";
        echo "Média: " . $aluno['media'] . "\n";
        echo "Resultado: " . $aluno['resultado'] . "\n";
        echo "------------------------\n";
    }
}

function editar_resultados() {
    global $alunos;
    echo "Digite o nome do aluno que deseja editar: ";
    $nome = trim(fgets(STDIN));
    foreach ($alunos as $index => $aluno) {
        if ($aluno['nome'] === $nome) {
            echo "Aluno encontrado. Digite as novas notas:\n";
            $notas = [];
            for ($j = 0; $j < 4; $j++) {
                do {
                    echo "Digite a nota " . ($j + 1) . " (0 a 10): ";
                    $nota = floatval(trim(fgets(STDIN)));
                    if ($nota < 0 || $nota > 10) {
                        echo "Nota inválida! Tente novamente.\n";
                    }
                } while ($nota < 0 || $nota > 10);
                $notas[] = $nota;
            }
            $alunos[$index]['notas'] = $notas;
            calcular_resultado($alunos[$index]);
            echo "Notas do aluno " . $aluno['nome'] . " atualizadas.\n";
            return;
        }
    }
    echo "Aluno não encontrado.\n";
}

function principal() {
    global $alunos;
    do {
        menu();
        $opcao = intval(trim(fgets(STDIN)));
        switch ($opcao) {
            case 1:
                cadastrar_alunos();
                break;
            case 2:
                atribuir_notas();
                break;
            case 3:
                exibir_resultados();
                break;
            case 4:
                editar_resultados();
                break;
            case 5:
                echo "Saindo...\n";
                break;
            default:
                opcao_invalida();
        }
    } while ($opcao != 5);
}

principal();
