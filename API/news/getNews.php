<?php
    $country = urlencode($_GET['country']);
    $key = "c11cf9f14d3041d5b5482e6ff6ca6975";

    if( strcmp("Global", $country) ){
        $url = "https://newsapi.org/v2/top-headlines?apiKey=$key&q=covid&country=$country";
    }
    else{
        $url = "https://newsapi.org/v2/top-headlines?apiKey=$key&q=covid";
    }
    
    $json = file_get_contents($url);
    $fullData = json_decode($json);
    $articles = $fullData->articles;
    echo(json_encode($articles, JSON_UNESCAPED_UNICODE));


    // o código em baixo server para substituir o pedido à 
    // API para não esgotar os pedidos da conta grátis.
    // utilizando um ficheiro json com alguns artigos antigos
    /*
    $json = file_get_contents("artigosPT.json");
    echo $json;*/
?>