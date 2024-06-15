<?php

function determinarNivelDetritos($distancia) {
    $profundidade = 50; // Profundidade máxima do bueiro
        $zonaMorta = 30; // Distância mínima para considerar a zona morta

        $percentual = (($profundidade-$distancia)/($profundidade-$zonaMorta))*100;
    if ($percentual > 75) {
        return 'Entupido';
    } elseif ($percentual >= 40 && $percentual <= 75) {
        return 'Precisa de Atenção';
    } elseif ($percentual < 40) {
        return 'Vazio';
    }
}


?>
