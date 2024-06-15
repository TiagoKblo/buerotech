<?php

use PHPUnit\Framework\TestCase;

class DetritosTest extends TestCase
{
    /**
     * @dataProvider percentualProvider
     */
    public function testDeterminarNivelDetritos($distancia, $expected)
    {
        // Assegure-se de que a função está disponível
        require_once 'utils/utils.php'; // Ajuste o caminho conforme necessário

        // Chame a função e compare o resultado com o esperado
        $this->assertEquals($expected, determinarNivelDetritos($distancia));
    }

    public function percentualProvider()
    {
        return [
            [50, 'Vazio'],               // Teste quando percentual é maior que 75
            [30, 'Entupido'],            // Teste quando percentual é menor que 40
            [40, 'Precisa de Atenção'],  // Teste limite inferior
            [28, 'Entupido'],             // Teste percentual mínimo
            [45, 'Vazio'],              // Teste percentual máximo
        ];
    }
}


?>
