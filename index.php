<?php
    $countriesList = json_decode(file_get_contents("http://localhost/sir2021/tp1-template/api/covid/getcountries.php"), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    
    <link href="./main.550dcf66.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    
    <link rel="icon" href="./assets//favicon.ico">
    <title>Tracking Covid-19 Ao Minuto</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="./main.0cf8b554.js"></script>
<body> 

    <header>
        <nav class="navbar navbar-default active">
            <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php" title="">
                <img src="./assets/ldpi.png" class="navbar-logo-img" alt="">
                Tracking Covid-19</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                <li><a onClick="document.getElementById('statsStop').scrollIntoView();">Estatísticas</a></li>
                <li>
                    <p>
                        <a onClick="document.getElementById('noticias').scrollIntoView();" class="btn btn-default navbar-btn" title="">Notícias</a>
                    </p>
                </li>
                </ul>
            </div> 
            </div>
        </nav>
    </header>

    <div class="hero-full-container background-image-container white-text-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Bem Vindo!</h2>
                    <p>Este site tem como propósito apresentar estatísticas e notícias sobre o coronavírus SARS-CoV-2.</p>
                    <br>
                    <a onClick="document.getElementById('statsStop').scrollIntoView();" class="btn btn-default btn-lg" title="">Prosseguir</a>
                </div>
            </div>
        </div>
    </div>
    <a id="statsStop" style="margin-top:20px;"></a>
    <div class="select">
        <select id="selectCountries" onChange="selectPais()">
            <option>Global</option>
            <?php 
                foreach($countriesList as $c){
                    echo "<option> $c </option>";
                }
            ?>
        </select>
    </div>
    <h2 class="stats-title">Estatísticas</h2>
    <div class = cards>
        <div class="card-deck">
            <div class="card">
                <div class="ativosCard">
                    <h5>Casos Ativos</h5>
                    <p id="numAtivos"></p>
                </div>
            </div>
            <div class="card"> 
                <div class="confirmadosCard">
                    <h5>Casos Confirmados</h5>
                    <p id="numConfirmados"></p>
                </div>
            </div>
            <div class="card">
                <div class="recuperadosCard">
                    <h5>Casos Recuperados</h5>
                    <p id="numRecuperados"></p>
                </div>
            </div>
            <div class="card">
                <div class="mortosCard">
                    <h5>Mortos</h5>
                    <p id="numMortos"></p>
                </div>
            </div>
        </div>
    </div>

    <p class="updateTime" id="horaUpdate"></p>

    <div id="grafico" class="graficoDiv">
        <iframe src="https://public.domo.com/cards/aKg4r" width="100%" height="600" marginheight="0" marginwidth="0" frameborder="0"></iframe>
    </div>

    <section id="noticias" class="newsArticles">
        <div class="container">
            <h2 class="news-title">Notícias</h2>
            <div id="artigosDiv" class="row">
                <!-- artigos -->
            </div>
    </section>



    <footer class="footer-container white-text-container">
    <div class="container">
        <div class="row">
        <div class="col-xs-12">
            <h3>Tracking de Covid-19 Ao Minuto!</h3>
            <div class="row">
            <div class="col-xs-12 col-sm-7">
                <p><small>Website criado por Marcelo Silva, EI nº20799 para a disciplina SIR - 2020/2021.</small></p>
            </div>
            <div class="col-xs-12 col-sm-5">
                <p class="text-right">
                <a target = "_blank" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="social-round-icon white-round-icon fa-icon">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a target = "_blank" href="https://twitter.com/" class="social-round-icon white-round-icon fa-icon">
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a target = "_blank" href="https://github.com/marcelo99silva/" class="social-round-icon white-round-icon fa-icon">
                    <i class="fa fa-github" aria-hidden="true"></i>
                </a>
                </p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </footer>

    <script>
    document.addEventListener("DOMContentLoaded", function (event) {
        navbarFixedTopAnimation();
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function (event) {
        navActivePage();
        scrollRevelation('.reveal');
    });
    </script>
</body>

<script>
    getDadosCovidPais("Global");
    getNews("Global");
    
    function selectPais(){
        var pais = document.getElementById("selectCountries").value;
        var countriesList = <?php echo json_encode($countriesList); ?> ;
        var key;

        if(pais == "Global"){
            key = "Global";
        }else{
            key = Object.keys(countriesList)[Object.values(countriesList).indexOf(pais)];
        }

        getDadosCovidPais(key);
        getNews(key);
    }

    function getDadosCovidPais(pais){
        var resposta;
        $.ajax({
            url: 'http://localhost/sir2021/tp1-template/api/covid/getdatacountry.php?country=' + pais,
            method: "GET",
            dataType: 'json',
            success: function (response){
                resposta = response;
            },
            error: function (error){
                console.log(error);
            },
            complete: function (){
                document.getElementById("numAtivos").innerHTML = resposta.ativos.toLocaleString('en');
                document.getElementById("numConfirmados").innerHTML = resposta.confirmados.toLocaleString('en');
                document.getElementById("numRecuperados").innerHTML = resposta.recuperados.toLocaleString('en');
                document.getElementById("numMortos").innerHTML = resposta.mortos.toLocaleString('en');
                document.getElementById("horaUpdate").innerHTML = "Última atualização: " + resposta.lastUpdate;
            },
        })
    }

    function getNews(pais){
        var resposta;
        $.ajax({
            url: 'http://localhost/sir2021/tp1-template/api/news/getNews.php?country=' + pais,
            method: "GET",
            dataType: 'json',
            success: function (response){
                resposta = response;
            },
            error: function (error){
                console.log("news" + error);
            },
            complete: function (){
                document.getElementById("artigosDiv").innerHTML = "";

                if(Array.isArray(resposta) && resposta.length){

                    resposta.forEach(function(artigo){
                        var divArticle = document.createElement('div');
                        divArticle.className = "article col-sm-6 col-md-4";
                        var divInnerArticle = document.createElement('div');
                        divInnerArticle.className = "inner";
                        var divInnerArticleImage = document.createElement('div');
                        divInnerArticleImage.className = "article-image";
                        var aImg = document.createElement('a');
                        aImg.target = "_blank";
                        var image = document.createElement('img');
                        var divArticleContent = document.createElement('div');
                        divArticleContent.className = "article-content";
                        var divArticleDate = document.createElement('div');
                        divArticleDate.className = "article-date";
                        var spanMonth = document.createElement('span');
                        var strongDay = document.createElement('strong');
                        var spanYear = document.createElement('span');
                        var h2Description = document.createElement('h2');
                        h2Description.className = "article-header";

                        var mesNum = artigo.publishedAt.substr(5,2);
                        var dia = artigo.publishedAt.substr(8,2);
                        var ano = artigo.publishedAt.substr(0,4);
                        var mesesArray = [
                            "Janeiro", "fevereiro", "Março", "Abril", "Maio", "Junho",
                            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
                        ];
                        var mes = mesesArray[mesNum - 1];

                        aImg.href = artigo.url;
                        image.src = artigo.urlToImage;
                        h2Description.innerHTML = artigo.title;
                        
                        spanMonth.innerHTML = mes;
                        strongDay.innerHTML = dia;
                        spanYear.innerHTML = ano;

                        divArticleDate.appendChild(spanMonth);
                        divArticleDate.appendChild(strongDay);
                        divArticleDate.appendChild(spanYear);
                        divArticleContent.appendChild(divArticleDate);
                        divArticleContent.appendChild(h2Description);
                        aImg.appendChild(image);
                        divInnerArticleImage.appendChild(aImg);
                        divInnerArticle.appendChild(divInnerArticleImage);
                        divInnerArticle.appendChild(divArticleContent);
                        divArticle.appendChild(divInnerArticle);
                        document.getElementById("artigosDiv").appendChild(divArticle);
                    });

                }else{
                    document.getElementById("artigosDiv").innerHTML = "Não existem notícias específicas do país escolhido.";
                }
            },
        })
    }
</script>
</html>