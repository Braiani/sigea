<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<p>Olá {{ $candidato->nome }}.</p>
	
	<p>
		Recebemos seus documentos na Central de Relacionamento do <i>campus</i> Campo Grande e estamos processando sua matrícula!
	</p>
	
	<p>
		Gostaríamos de aproveitar a oportunidade e adiantarmos alguns documentos importantes:
	</p>
	
	<p>Aqui no Instituto Federal nós temos diversos regulamentos, os quais podemo ser acessados 
		<a href="http://www.ifms.edu.br/centrais-de-conteudo/documentos-institucionais/regulamentos">cliando aqui!</a>
	</p>
	<p>Os regulamentos mais importantes são: </p>
	<ul>
		<li>
			<a href="http://www.ifms.edu.br/centrais-de-conteudo/documentos-institucionais/regulamentos/regulamento-organizacao-didatico-pedagogica-curso-tecnico-integrado-resolucao-011-10-10-2010.pdf">
				Regulamento da Organização Didático-Pedagógica dos Cursos Técnicos Integrados
			</a>
		</li>
		<li>
			<a href="http://www.ifms.edu.br/centrais-de-conteudo/documentos-institucionais/regulamentos/regulamento-disciplinar-do-estudante.pdf">
				Regulamento Disciplinar do Estudante
			</a>
		</li>
	</ul>
	
	<p>
		Outro documento muito importante é o Calendário Acadêmico, o qual pode ser
			<a href="http://www.ifms.edu.br/centrais-de-conteudo/documentos-institucionais/calendarios/calendarios-2019/calendario-estudante-IFMS-cg-2019.pdf">
			acessado aqui
		</a>.
	</p>
	
	<p>
		Anexamos um guia com informações importantes sobre nosso sistema acadêmico, para acompanhamento de frequência e notas,
			os serviços de auxílio disponibilizados pelo Instituto, alem de informações sobre os e-mails das direções/coordenações e professores.
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