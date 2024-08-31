<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Constants\Constants;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use App;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

    public function report(Throwable $exception)
    {
        if (App::environment(['production','development'])) {
            //code goes here 
            Bugsnag::notifyException($exception);
        }
        parent::report($exception);
    }
    
    public function render($request, Throwable $exception)
    {
        $response = [];
        $response['status'] = false;
        $code = $exception->getCode() ?? Constants::INTERNAL_SERVER_ERROR;
        $line  = $exception->line ?? null;
        $message  = $exception->getMessage() ?? 'Please contact developer!';

        if (!$code) {
            $code = Constants::INTERNAL_SERVER_ERROR;
        }
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

            $response['status_code'] = $code;
            $response['message'] = 'Model Not Found!';
            $response['line_no'] = $line;
            return response()->json($response, $code);
        } else if ($exception instanceof AuthenticationException) {
            
            $response['status_code'] = $code;
            $response['message'] = 'Unauthenticated.';
            $response['line_no'] = $line;
            return response()->json($response, 401);
        } else {
            $response['status_code'] = $code;
            $response['message'] = $message;
            $response['line_no'] = $line;
            return response()->json($response, $code);
        }
        return parent::render($request, $exception);
    }
    // public function register()
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //return parent::render(null,$e);
    //          throw new CustomErrorException($e);
    //     });
    // }

    protected function unauthenticated($request, AuthenticationException $exception)
    {

        return ApiResponse::failureResponse('Unauthenticated.', null, 401);
        // return $request->expectsJson() ? response()->json($response) : redirect()->guest('login');
    }
}
