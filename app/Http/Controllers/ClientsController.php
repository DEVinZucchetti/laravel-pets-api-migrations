<?php

namespace App\Http\Controllers;

use App\Models\Client as ClientModel;
use App\Models\People as PeopleModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientsController extends Controller
{
   
    public function index()
    {
        try
        {
            $data = ClientModel::with(['people'])->get();
            $message = $data->count().($data->count() === 1 ? ' cliente encontrado' : ' clientes encontrados')." com sucesso.";
            return $this->response($message, $data);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = [
                'name' => 'required | string | min: 3',
                'cpf' => 'string | min: 11',
                'contact' => 'string | min: 11'
            ];

            $request->validate($validator);

            $peoplePayload = empty($request->input('contact'))
                ? $request->only('name', 'cpf')
                : $request->all();

            $people = PeopleModel::firstOrCreate($peoplePayload);
            $data = ClientModel::create(['people_id' => $people->id]);

            return $this->response("Cliente ".$data->people->name." cadastrado com sucesso.", $data);

        } catch (\Exception $e)
        {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show(string $id)
    {
        try
        {
            $data = ClientModel::with(['people'])->find($id);

            if(empty($data)) {
                return $this->response('Cliente não encontrado.', null, false, Response::HTTP_NOT_FOUND);
            }

            $message = "Cliente ".$data->people->name." encontrado com sucesso.";
            return $this->response($message, $data);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validator = [
                'name' => 'string | min: 3',
                'cpf' => 'string | min: 11',
                'contact' => 'string | min: 11'
            ];

            $request->validate($validator);

            $data = ClientModel::with(['people'])->find($id);

            if(empty($data)) {
                return $this->response('Cliente não encontrado.', null, false, Response::HTTP_NOT_FOUND);
            }

            $people = PeopleModel::find($data->people_id);
            $people->update($request->all());

            $data = ClientModel::with(['people'])->find($id);

            return $this->response("Cliente ".$data->people->name." atualizado com sucesso.", $data);

        } catch (\Exception $e)
        {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try
        {
            $data = ClientModel::with(['people'])->find($id);

            if(empty($data)) {
                return $this->response('Cliente não encontrado.', null, false, Response::HTTP_NOT_FOUND);
            }

            ClientModel::destroy($data->id);

            $message = "Cliente ".$data->people->name." deletado com sucesso.";
            return $this->response($message, $data);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
