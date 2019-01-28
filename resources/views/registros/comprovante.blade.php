<!DOCTYPE html>
<html>
    <head>
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
        <title>Registro de pré-matricula</title>
        <style>
            body{
                width: 740px;
                height: 1000px;
            }
            .img-header{
                width: 100%;
            }
            .first-paragraph{
                padding-top: 15px;
            }
            .disciplinas{
                margin-top: 5px;
            }
            .second-paragraph{
                padding-top: 15px;
            }
            .data-local{
                margin-top: 50px;
            }
            .data-local  p{
                padding-left: 65%;
            }
            .footer{
                padding-top: 80px;
                width: 100%;
            }
            .assinaturas-left{
                width: 49%;
                float: left;
            }
            .assinaturas-right{
                width: 49%;
                float: right;
            }
            .nome-servidor{
                width: 80%;
                border-top: 1px solid black;
                padding-left: 15px;
            }
            .nome-responsavel{
                width: 80%;
                border-top: 1px solid black;
                padding-left: 15px;
            }
            .rodape{
                /* width: 100%;*/
                position: absolute;
                bottom: 0;
            }
            .img-rodape{
                width: 100% ;
            }
        </style>
    </head>
    <body>
        <center>
            <img class='img-header' src="{{ public_path() }}/img/comprovante/header.jpg">
            <h2>REGISTRO DE PRÉ-MATRÍCULA</h2>
        </center>
        <div class='first-paragraph'>
            <p>O registro de intenção de matrícula do(a) estudante {{ $aluno->nomeFormatado }}, curso {{ $aluno->curso->nome }}, foi realizado com sucesso, conforme informações abaixo:</p>
        </div>
        <div class="disciplinas">
            <ul>
                @foreach ($registros as $registro)
                <li>{{ $registro->disciplinas->nomeFormatado }}</li>
                @endforeach
            </ul>

        </div>
        <div class="second-paragraph">
            <p>O responsável está ciente que deverá comparecer nesta instituição, no período de 07/02/2019 a 08/02/2019, para confirmação da matrícula do estudante e em caso de não comparecimento, a presente pré-matrícula será cancelada automaticamente.</p>
        </div>
        <div class="data-local">
            <p>Campo Grande, MS - {{ date( 'd/m/Y' , strtotime(now()))}}.
        </div>
        <div class="footer">
            <div class="assinaturas-left">
                <p class="nome-servidor">{{ Auth::user()->name }}</p>
            </div>
            <div class="assinaturas-right">
                <p class="nome-responsavel">Assinatura do Responsável</p>
            </div>
        </div>
        <div class="rodape">
            <img class="img-rodape" src="{{ public_path() }}/img/comprovante/footer.jpg">
        </div>
    </body>
</html>
