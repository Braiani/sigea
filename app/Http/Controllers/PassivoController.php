<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Passivo;
use Dotenv\Validator;

class PassivoController extends VoyagerBaseController
{
    public function index(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::index($request);
        }

        $passivo_model = new Passivo();
        return view('passivo.index')->with(['passivo_model' => $passivo_model]);

    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search') ? $request->get('search') : false;
        $sort = $request->get('sort') ? $request->get('sort') : false;

        $total = Passivo::count();

        $query = new Passivo();

        if ($search) {
            $query = $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('curso', 'LIKE', "%{$search}%");
        }
        if ($sort) {
            $query = $query->orderBy($sort, $request->get('order'));
        }

        $passivo = $query->offset($offset)->limit($limit)->orderBy('id', 'DESC')->get();

        $resposta = array(
            'total' => $total,
            'count' => $passivo->count(),
            'rows' => $passivo,
        );
        return $resposta;
    }

    public function create(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::create($request);
        }

        return "Teste!";
    }

    public function update(Request $request, $id)
    {
        if ($this->isBackend($request)) {
            return parent::index($request);
        }

        $validacao = Validator($request->all(), [
            'nome' => 'required'
        ]);

        if (Passivo::find($id)->update($request->all())) {
            return [
                'error' => false,
                'message' => 'Alterações salvas com sucesso'
            ];
        }else{
            return [
                'error' => true,
                'message' => 'ID inexistente'
            ];
        }
    }


    public function isBackend(Request $request)
    {
        return in_array('backend', explode('/', $request->url()));
    }
}
