<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Kurst Łowiecki - Witamy!';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Darz Bór!</h1>

        <p class="lead">Witaj na stronie pomagającej w kształceniu w obrębie kursu na kandydata na członka PZŁ!</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute(['study/']) ?>">Rozpocznij kurs!</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Zarejestruj się!</h2>

                <p>Zarejestrowanie się pozwoli Ci na wgląd w kursy, które już wykonałeś(-aś). W późniejszym czasie ew.
                    powiadomię Cię mailowo o dodatkowych elementach które wprowadzę na stronie. Nie zbieram na Twój
                    temat żadnych innych informacji poza loginem, e-mailem i hasłem. Dane te nie będą wykorzystane w żadnym celu
                    poza samą stroną Kursu Łowieckiego.</p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['user/register/']) ?>">Załóż konto!</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Studiuj!</h2>

                <p>Przechodź kursy jeden po drugim. Poza samym studiowaniem ma sz możiwosć wglądu w
                    <a href="<?= Url::toRoute(['questionlist/']) ?>">pełna listę pytań</a>. Same testy przygotowane są
                    tak,
                    że ich kolejnośc jest przypadkowa - moim celem jest to abyście poprzez rozwiązywanie testów
                    zarazem się uczyli!</a></p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['study/']) ?>">Rozpocznij kurs!</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Poprawiaj wyniki!</h2>

                <p>Każdy kolejny przechodzony test daje mozliwość utrwalania wiedzy. Dodatkowo gdy posiadasz konto masz
                    mozliwość wracania do poprzednich testów i sprawdzania gdzie popełniasz najwięcej błędów!</p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['study/']) ?>">Przeglądaj wyniki!</a>
                </p>
            </div>
        </div>

        <br>

        <div class="bg-info info"><p>Baza pytań, która się tu znalazła jest powrzechnie dostępna w internecie. Są to
                pytania które pozwalają lepiej przygotować się do egzaminu na człona PZŁ.</p>

            <p>Przy pełni zaangażowania, ale pewnego braku czasu, mogą się pojawić w całości jakieś luki/bugi. Jeżeli
                takie odkryjecie - proszę zgłaszajcie je tu: <a href="https://github.com/babejsza/kurslowiecki/issues">na
                    github'ie</a>.</p>

            <p>Całość jest na wolnej licencji więc jeżeli ktoś ma ochotę postawić sobie swój własny projekt to nie ma ku
                temu przeszkód :).</p>
        </div>

    </div>
</div>
