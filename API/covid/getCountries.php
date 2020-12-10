<?php

    $url = "https://covid19.mathdro.id/api/countries";
    
    $countriesInfoJSON = file_get_contents($url);
    $countriesInfo = json_decode($countriesInfoJSON);

    $countriesList = [];
    
    foreach($countriesInfo->countries as $c){
        if(isset($c->iso2)){
            $countriesList[$c->iso2] = $c->name;
        }
    }

    echo (json_encode($countriesList));
?>