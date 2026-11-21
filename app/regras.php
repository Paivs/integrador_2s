<?php

/**
 * Regra dos 30 dias (RN-04): objeto Encontrado que ninguém retirou em 30 dias vira Doado.
 * A contagem começa em achado.dataAchado. Objetos cadastrados direto como Encontrado
 * (sem linha em achado) não expiram por enquanto: o grupo ainda vai decidir esse caso.
 * Devolve quantos objetos mudaram de status.
 *
 * Se o banco ainda não tiver a tabela achado ou o status Doado, a função NÃO derruba a página:
 * ela registra o erro no log do servidor e devolve 0.
 */
function atualizarDoados(PDO $pdo): int
{
    try {
        return (int) $pdo->exec("
            UPDATE objetos
            SET status_objeto = 'Doado'
            WHERE status_objeto = 'Encontrado'
              AND idObjeto IN (
                  SELECT idObjeto
                  FROM achado
                  WHERE dataRetirada IS NULL
                    AND dataAchado < NOW() - INTERVAL 30 DAY
              )
        ");
    } catch (PDOException $e) {
        error_log('Regra dos 30 dias: ' . $e->getMessage());
        return 0;
    }
}