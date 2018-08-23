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

        $query = new Passivo();

        if ($search) {
            $query = $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('curso', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
        }
        if ($sort) {
            $query = $query->orderBy($sort, $request->get('order'));
        }

        $total = $query->count();

        $passivo = $query->offset($offset)->limit($limit)->orderBy('id', 'DESC')->get();

        $resposta = array(
            'total' => $total,
            'count' => $passivo->count(),
            'rows' => $passivo,
        );
        return $resposta;
    }

    public function store(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::store($request);
        }

        $request->validate([
            'nome' => 'required',
            'curso' => 'required'
        ]);

        if (Passivo::create($request->all())) {
            return [
                'error' => false,
                'message' => 'Alterações salvas com sucesso'
            ];
        }
        return [
            'error' => true,
            'message' => 'Não foi possível cadastrar a pasta!'
        ];
    }

    public function verificaNome(Request $request)
    {
        $passivo = Passivo::where('nome', $request->nome)->get();
        $count = $passivo->count();
        $igual = false;
        $message = '';
        if ($count > 0) {
            $igual = true;
            if ($count == 1) {
                $message = "Foi encontrado a seguinte pasta com o nome {$passivo[0]->nome} : n. {$passivo[0]->id}";
            }else{
                $message = "Foram encontradas as seguintes pastas com o nome {$passivo[0]->nome} : ";
                foreach ($passivo as $value) {
                    $message .= " n. {$value->id}";
                }
            }
        }
        return [
            'error' => false,
            'igual' => $igual,
            'message' => $message
        ];
    }

    public function update(Request $request, $id)
    {
        if ($this->isBackend($request)) {
            return parent::update($request, $id);
        }

        $request->validate([
            'nome' => 'required'
        ]);

        if (Passivo::find($id)->update($request->all())) {
            return [
                'error' => false,
                'message' => 'Alterações salvas com sucesso'
            ];
        } else {
            return [
                'error' => true,
                'message' => 'Número de pasta inexistente'
            ];
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($this->isBackend($request)) {
            return parent::destroy($request, $id);
        }

        $pasta = Passivo::find($id);

        if ($pasta->update($request->all())) {
            $pasta->delete();
            return [
                'error' => false,
                'message' => 'Pasta retirada da lista do arquivo passivo!'
            ];
        } else {
            return [
                'error' => true,
                'message' => 'Número de pasta inexistente'
            ];
        }

        return $request;
    }

    public function isBackend(Request $request)
    {
        return in_array('backend', explode('/', $request->url()));
    }
}
