<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<p>Olá {{ $candidato->nome }},</p>
	
	<p>
		Recebemos seus documentos na Central de Relacionamento do <i>campus</i> Campo Grande e estamos processando sua matrícula!
	</p>
	
	<p>
		Considerando sua cota exigir a análise da renda familiar, os documentos foram encaminhados ao setor responsável.
	</p>

	<p>
		Assim, informamos que tão logo tenhamos alguma atualização no status da sua matrícula, entraremos em contato!
	</p>
	
	@foreach ($candidato->pendencias as $pendencia)
	@if ($loop->first)
		<p><b>Não se esqueça de levar o quanto antes os documentos faltantes:</b></p>
		<ul>
	@endif
		<li><b>{{ $pendencia->descricao }}</b></li>
	@if ($loop->last)
		</ul>
	@endif
	@endforeach

	<p>
		Por fim, ressaltamos que essa é uma mensagem automática e não substitui qualquer informação repassada no momento da matrícula, em especial quanto
		ao deferimento ou não da matrícula do(a) candidato(a) <u>{{ $candidato->nome }}</u>.
	</p>
	
	<p>Atenciosamente,</p>
	
	<div style="color: #274e13; font-family: Verdana, sans-serif; font-size: small; margin-top:0px;line-height:15px">
		<p>
			{{ setting("admin.title") }} - {{ setting("admin.description") }}
		</p>
		<p>
			<b>Coordenação de Gestão Acadêmica <i>Campus</i> Campo Grande</b>
		</p>
		<p>
			Rua Taquari nº 831, Santo Antônio, Campo Grande/MS 79100-510
		</p>
		<p>
			(67) 3357-8501 • 
			<a href="http://www.ifms.edu.br/" target="_blank" >Site</a> •
			<a href="http://facebook.com/ifms.cg" target="_blank" >Facebook</a> •
			<a href="http://youtube.com/ifmscomunica" target="_blank">Youtube</a>
		</p>
	</div>
</body>
</html>