<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
{
    // Spatie Permission paketi tarafından fırlatılan UnauthorizedException kontrolü
    if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
        // Burada 403.blade.php sayfanıza yönlendirme yapılıyor
        return response()->view('errors.403', [], 403);
    }

    return parent::render($request, $exception);
}
}
