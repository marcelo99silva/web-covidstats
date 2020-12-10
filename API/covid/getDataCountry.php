<?php 
    $country = urlencode($_GET['country']);
    if( strcmp("Global", $country) ){
        $url = "https://covid19.mathdro.id/api/countries/$country";
    }
    else{
        $url = "https://covid19.mathdro.id/api";
    }

    $json = file_get_contents($url);

    $fullData = json_decode($json);

    $ano = substr( ($fullData->lastUpdate), 0, 4 );
    $mes = substr( ($fullData->lastUpdate), 5, 2 );
    $dia = substr( ($fullData->lastUpdate), 8, 2 );
    $hora = substr( ($fullData->lastUpdate), 11, 8 );
    $date = ($hora . " UTC " . $dia . "-" . $mes . "-" . $ano);

    $data = [
        "ativos" => ($fullData->confirmed->value - $fullData->recovered->value - $fullData->deaths->value),
        "confirmados" => $fullData->confirmed->value,
        "recuperados" => $fullData->recovered->value,
        "mortos" => $fullData->deaths->value,
        "lastUpdate" => $date,
    ];
    echo(json_encode($data));
    
    
?>