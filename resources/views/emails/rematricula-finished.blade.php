<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
</head>
<body>
<p>Prezado {{ $matricula->student->name }},</p>

<p>
    Informamos que todas as análises da rematrícula desse semestre foram finalizadas e aproveitamos para encaminhar seu horário para o semestre que se inicia.
</p>

<p>
    Caso identifique algum erro, favor procurar a CEREL para ajuste. Caso queira incluir ou excluir disciplinas, o período será de 29/07/2019 à 31/07/2019, através de requerimento
    protocolado na CEREL.
</p>

<p><u><b>Importante:</b> Em anexo enviamos seu quadro de horários que também pode ser acessado <a href="{{ $urlSiga }}">clicando aqui</a>.</u></p>

<p>
    Por fim, pedimos que participe de nossa <u>pesquisa de satisfação</u> através desse link: <a href="https://forms.gle/8UaWCfDVvzbChd1t6">https://forms.gle/8UaWCfDVvzbChd1t6</a>
</p>

<p>
    Qualquer dúvida, encontramo-nos a disposição.
</p>

<p>Atenciosamente,</p>

<div style="color: #274e13; font-family: Verdana, sans-serif; font-size: small; margin-top:0px;line-height:5px">
    <p>
        SIGEA - Sistema de Gestão Acadêmica
    </p>
    <p>
        <b>Coordenação de Gestão Acadêmica do <i>Campus</i> Campo Grande</b>
    </p>
    <p>
        Rua Taquari nº 831, Santo Antônio, Campo Grande/MS 79100-510
    </p>
    <p>
        (67) 3357-8501 •
        <a href="http://www.ifms.edu.br/" target="_blank">Site</a> •
        <a href="http://facebook.com/ifms.cg" target="_blank">Facebook</a> •
        <a href="http://youtube.com/ifmscomunica" target="_blank">Youtube</a>
    </p>
</div>
</body>
</html>