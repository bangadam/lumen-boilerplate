<?php

namespace App\Utils;
use App\Helpers\FractalHelper;
use App\Utils\Messages\CRUDMessage;

trait FractalTrait
{
    protected function paginateResponse($request, $paginator, $type, $transform){
        $data = $paginator->getCollection();
        $fractal = new FractalHelper();
        $fractalPaginate = $fractal->jsonPaginate($paginator, $data, $transform, $type, $request);
        return $fractal->resolver($fractalPaginate);
    }
    protected function singleResponse($request, $data, $type, $transform){
        $fractal = new FractalHelper();
        $fractalSingle = $fractal->singleJson($data, $transform, $type, $request);
        return $fractal->resolver($fractalSingle);
    }

    protected function crateUpdateResponse($request, $data,
    $type, $transform, $additionalMessage = null,
    $itsNew = true, $injectMessage = null, $injectMeta = null){
        $fractal = new FractalHelper();
        if ($injectMessage == null) {
            $message = $itsNew ? CRUDMessage::CREATE.$additionalMessage : CRUDMessage::UPDATE.$additionalMessage;
            $meta['message'] = $message;
        }
        else{
            $message = $injectMessage;
            $meta['message'] = $message;
        }

        if ($injectMeta != null) {
            $collection = collect($injectMeta);
            $meta = $collection->merge($meta)->all();
        }
        $fractalSingle = $fractal->singleJson($data, $transform, $type, $request, $meta);
        return $fractal->resolver($fractalSingle);
    }
    protected function emptyResponse($injectMessage = null){
        $fractal = new FractalHelper();
        return $fractal->emptyJson($injectMessage);
    }
    protected function deleteResponse($additionalMessage = null, $injectMessage = null){
        $fractal = new FractalHelper();
        if ($injectMessage == null) {
            $Message = CRUDMessage::DELETE.$additionalMessage;
        }
        else{
            $Message = $injectMessage;
        }
       return $fractal->deletedJson($Message);
    }
    protected function resolveRequest($request){
        $fractal = new FractalHelper();
        $baseValidation = $fractal->validationRequest($request);
        if ($request->has('id')) {
            return (object) $baseValidation['attributes'];
        }
        return (object) $baseValidation['attributes'];
    }

}
