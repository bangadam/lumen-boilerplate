<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Lang;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if (env('APP_DEBUG')) {
            return parent::render($request, $exception);
        }
        else {
            if ($exception instanceof NotFoundHttpException) {
                $globalStatus = 404;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => 'Endpoint Tidak Ditemukan'
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = $exception->getFile();
                    $errors[0]['detail'] = $exception->getTraceAsString();
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
            else if ($exception instanceof MethodNotAllowedHttpException) {
                $globalStatus = Response::HTTP_METHOD_NOT_ALLOWED;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => 'Method Tidak Diperbolehkan'
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = $exception->getFile();
                    $errors[0]['detail'] = $exception->getTraceAsString();
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
            else if ($exception instanceof AuthorizationException) {
                $globalStatus = 403;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => $exception->getMessage(),
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = $exception->getFile();
                    $errors[0]['detail'] = $exception->getTraceAsString();
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
            else if ($exception instanceof AuthenticationException) {
                $globalStatus = 401;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => $exception->getMessage(),
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = $exception->getFile();
                    $errors[0]['detail'] = $exception->getTraceAsString();
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
            else if ($exception instanceof ValidationException) {
                $globalStatus = 422;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => 'Cek Kembali, data yang kamu berikan kurang lengkap atau kurang benar',
                    'detail' => $exception->validator->errors()
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = $exception->getFile();
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
            else {
                $globalStatus = 500;
                $errors[] = array(
                    'status' => $globalStatus,
                    'title' => 'Mohon Maaf, Terjadi Kesalahan Sistem'
                );
                if (!app()->environment('production')) {
                    $errors[0]['source'] = array(
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine()
                    );
                    $errors[0]['detail'] = $exception->getTraceAsString();
                }
                else{
                    log::critical(json_encode(
                        array(
                            'source' => array(
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine()
                            ),
                            'detail' => $exception->getTraceAsString()
                        )
                    ));
                }
                return response()->json([
                    "errors" => $errors
                ], $globalStatus);
            }
        }

    }
}
