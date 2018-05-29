$(document).ready(function () {
    $('.btn-warning').on('click', async function(e) {
        e.preventDefault();
        if ($(this).closest('tr').hasClass('success')) {
            $url = $(this).attr('href');
            // alert($id);
            $ajax = await execAjax('GET', $url, null);
            if ($ajax) {
                //Fazer o toastr
                toastr["success"]("Mensagem marcada como não lida!");
                if ($(this).closest('tr').hasClass('success')) {
                    $(this).closest('tr').toggleClass('success');
                }
            }
        }
    });

    $('.btn-danger').on('click', async function(e) {
        e.preventDefault();
        var resultado = false;
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
        })

        await swalWithBootstrapButtons({
            title: 'Você tem certeza?',
            text: "Você deseja apagar essa mensagem?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, eu quero!',
            cancelButtonText: 'Não, cancelar!',
        }).then((result) => {
            if (result.value) {
                resultado = true;
            } else if ( result.dismiss === swal.DismissReason.cancel) {
                swalWithBootstrapButtons(
                    'Cancelado!',
                    'Sua mensagem não foi apagada!',
                    'error'
                )
                resultado = false;
            }
        });
        if (resultado) {
            $url = $(this).attr('href');
            // alert($id);
            $ajax = await execAjax('DELETE', $url, null);
            if ($ajax) {
                //Fazer o toastr
                toastr["success"]("Mensagem apagada com sucesso!");
                $(this).tooltip('dispose');
                $(this).closest('tr').remove();
            }
        }
    });

    $('#addMail').on('click', function() {
        window.location = '/admin/mensagens/create';
    });

    $('#sent').on('click', function() {
        window.location = '/admin/mensagens/saida';
    });

    $('#inbox').on('click', function() {
        window.location = '/admin/mensagens';
    });

    var textarea = document.querySelector('textarea');
    textarea.addEventListener('focus', autosize);

    $('#btnEnviar').on('click', async function(e) {
        e.preventDefault();

        data = {
            'to': $('#to').val(),
            'titulo': $('#titulo').val(),
            'mensagem': $('#mensagem').val()
        };

        url = $(this).closest('form').attr('action');

        $ajax = await execAjax('POST', url, data);

        if ($ajax) {
            $(this).closest('form').submit();
        }
    });
});

function autosize(){
    var el = this;
    setTimeout(function(){
        el.style.cssText = 'height:auto; padding:0';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
}

async function execAjax(type, url, data){
    var retorno = false;
    await $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: type,
        url: url,
        data: data,
        cache: false,
        success: function(response) {
            if (!response.error) {
                retorno = true;
            }else {
                swal(
                    "Erro!",
                    response.message,
                    "error"
                )
                retorno = false;
            }
        },
        error: function (response) {
            swal(
                "Erro interno!",
                "Oops, ocorreu um erro ao tentar salvar as alterações.", // had a missing comma
                "error"
            )
        }
    });
    return retorno;
}


//Funções para o FloatButton (ActionButton)

var x = $('.FAB__mini-action-button').find('.mini-action-button--hide').length * 60 + 60;

$('.FAB').hover(function(){
	$('.FAB').height(x);
}, function(){
	$('.mini-action-button--show').attr('class', 'mini-action-button--hide');
	$('.FAB').height(0);
});

$('.mini-action-button').hover(function(){
	$(this).find('.mini-action-button__text--hide').attr('class', 'mini-action-button__text--show');
}, function(){
	$(this).find('.mini-action-button__text--show').attr('class', 'mini-action-button__text--hide');
});

$('.FAB__action-button').hover(function(){
	$(this).find('.action-button__text--hide').attr('class', 'action-button__text--show');
	$('.mini-action-button--hide').attr('class', 'mini-action-button--show');
}, function(){
	$(this).find('.action-button__text--show').attr('class', 'action-button__text--hide');
});
