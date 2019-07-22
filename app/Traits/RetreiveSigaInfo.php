<?php
/**
 * Trait used to Retreive Informations from the Siga.
 * User: Braiani
 * Date: 07/02/19
 * Time: 21:49
 */

namespace App\Traits;


trait RetreiveSigaInfo
{
    public function getAllMatriculaInfo($matricula)
    {
        $token = sha1('IFMS' . $matricula);
        $url = "https://academico.ifms.edu.br/administrativo/historico_escolar/integralizacao_publica/{$matricula}/?token={$token}";
        $streamSSL = stream_context_create(array(
            "ssl"=>array(
                "verify_peer"=> false,
                "verify_peer_name"=> false
            )
        ));

        return file_get_contents($url, false, $streamSSL);
    }

    public function getIntegralizacaoCollect($matricula)
    {
        $response = $this->getAllMatriculaInfo($matricula);
        return collect(json_decode($response, true)['Integralizacao']);
    }
}