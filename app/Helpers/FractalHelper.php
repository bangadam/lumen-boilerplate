<?php
namespace App\Helpers;

// use Spatie\Fractalistic\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use App\Constants\ApiMetaConst;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Resource\Collection;

class FractalHelper {

    private function createInstanceFractal($request = null)
    {
        $manager = new Manager();
        $baseUrl = $request != null ? env('APP_URL').'/'.$request->segment(1).'/'.$request->segment(2) : env('APP_URL');
        return $manager->setSerializer(new JsonApiSerializer());
    }

    public function resolver($fractal)
    {
        return response(
            $fractal
            ->toJson() , 200)
        ->header('Content-Type', 'application/json');
    }

    public function jsonPaginate($paginator, $data, $transform , $type, $request)
    {
        $fractal = $this->createInstanceFractal($request);
        if ($request->get('include') != null) {
            $fractal->parseIncludes($request->get('include'));
        }
        $resource = new Collection($data, $transform, $type);
        $resource->setMeta(array(
            'api' =>  ApiMetaConst::$NameApi
        ));
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $fractal->createData($resource);
    }

    public function deletedJson($Message)
    {
        $message = [
            'data' => [],
            'meta' => [
                'message' => $Message,
                'Api' =>  ApiMetaConst::$NameApi
            ]
        ];
        return response($message, 202)
            ->header('Content-Type', 'application/json');
    }

    public function emptyJson($Message)
    {
        $message = [
            'data' => [],
            'meta' => [
                'message' => $Message,
                'Api' =>  ApiMetaConst::$NameApi
            ]
        ];
        return response($message, 200)
            ->header('Content-Type', 'application/json');
    }

    public function singleJson($data, $transform, $type, $request, $meta = null)
    {
        $fractal = $this->createInstanceFractal($request);
        if ($request->get('include') != null) {
            $fractal->parseIncludes($request->get('include'));
        }
        $resource = new Item($data, $transform, $type);
        if ($meta != null) {
            $meta['api'] = ApiMetaConst::$NameApi;
            $resource->setMeta(
                $meta
            );
        }
        else{
            $resource->setMeta(
                array(
                    'api' =>  ApiMetaConst::$NameApi
                )
            );
        }
        return $fractal->createData($resource);
    }

    public function validationRequest($request, $typeValid = null) {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'attributes' => 'required',
        ]);
        $validateInput = $validator->validate();
        return $request->all();
    }
}
