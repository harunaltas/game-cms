<?php

namespace App\Http\Controllers;

use App\Models\Question;
Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        session()->regenerate();
        Log::channel('login_logout')->info('Kullanıcı giriş yaptı', ['user_id' => auth()->id()]);
        return redirect('/dashboard');

    }

    public function show(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        
    }

    public function update(){
        
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]); 
          
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        auth()->logout();
        Log::channel('login_logout')->info('Kullanıcı çıkış yaptı', ['user_id' => auth()->id()]);

        return redirect('/sign-in');
    }
    public function showPasswordResetForm(){
        $questions = Question::all(); // Tüm soruları çek

        return view('sessions.password-reset', compact('questions'));
    }
    public function passwordResetProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'security_question' => 'required',
            'security_answer' => 'required',
            'password' => 'required|confirmed',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'Belirtilen email adresi ile bir kullanıcı bulunamadı.']);
        }
    
        // Güvenlik sorusunun ID'si ve cevabını doğrudan kontrol et
        $securityQuestionValid = $user->security_question == $request->security_question;
        $securityAnswerValid = $request->security_answer === $user->security_answer;

        if ($securityQuestionValid && $securityAnswerValid) {
            // Kullanıcıyı bul ve şifreyi güncelle
            $user->password = $request->password;
            $user->save();
    
            // Başarılı işlem sonrası kullanıcıyı bilgilendir
            return redirect()->route('login')->with('success', 'Şifreniz başarıyla sıfırlandı.');
        } else {
            // Güvenlik sorusu/cevabı hatalıysa veya kullanıcı bulunamadıysa
            return back()->withErrors(['security_question' => 'Güvenlik sorusu veya cevabı hatalı.']);
        }
    }

}
