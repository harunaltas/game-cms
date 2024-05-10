<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{    
    public function __construct()
    {

        $this->middleware('permission:add users', ['only' => ['create', 'store']]);
        $this->middleware('permission:update users', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }
 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->select('users.*');
    
            return DataTables::of($users)
                ->addColumn('role', function (User $user) {
                    // Kullanıcının tüm rollerini virgülle ayrılmış bir string olarak döndür
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->addColumn('actions', function($row){
                    $userId = $row->id;
                    $editUrl = route('users.edit', $userId); // Kullanıcı düzenleme URL'si
                    $isFounder = $row->hasRole('Kurucu'); // Kullanıcının "Kurucu" rolü olup olmadığını kontrol et
    
                    $actions = ''; // Başlangıçta actions boş bir string
    
                    // "Kurucu" rolüne sahip olmayan kullanıcılar için düzenle butonunu ekle
      
                        $actions .= "<a href='{$editUrl}' class='btn btn-sm bg-gradient-dark'>Düzenle</a> ";
                        $actions .= "<button class='btn btn-sm bg-gradient-dark delete-user' data-id='{$userId}'>Sil</button>";
           
    
                    return $actions;
                 })
                ->rawColumns(['role','actions']) // HTML olarak render etmek istiyorsanız
                ->make(true);
        }
    
        return view('pages.users.users');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        $roles = Role::all();

        return view('pages.users.addUser',compact('questions','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        if($request->role_id == 0) {
            return redirect()->back()->with('error', 'Geçerli bir rol seçin');
        }

        $user = User::create([
            'name' => $request->name,
            'email' =>$request->email,
            'password' => $request->password,
            'security_question' => $request->security_question,
            'security_answer' =>$request->security_answer,
        ]);

        $role = Role::findById($request->role_id);
        // Kullanıcıya rol ataması yapıyoruz.
        $user->assignRole($role->name);
        // Başarılı kayıttan sonra kullanıcıyı yönlendir
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla kaydedildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $questions = Question::all();
        $roles = Role::all();
        return view('pages.users.updateUser', compact('user','questions','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if($request->role_id == 0) {
            return redirect()->back()->with('error', 'Geçerli bir rol seçin');
        }
        $user = User::findOrFail($id);
    
        // Validasyon kuralları
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'security_question' => 'required|string',
            'security_answer' => 'required|string',
        ]);
    
        // Şifre alanı kontrolü
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
    
        // Kullanıcı bilgilerini güncelle
        $user->name = $request->name;
        $user->email = $request->email;
        $user->security_question = $request->security_question;
        $user->security_answer = $request->security_answer;
        $user->save();
    
        // Kullanıcının mevcut rollerini temizle ve yeni rolü ata
        $user->roles()->detach();
        $user->assignRole(Role::findById($request->role_id)->name);
    
        return redirect()->back()->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'Kullanıcı bulunamadı.'], 404);
        }
    
        // Kullanıcının "Kurucu" rolüne sahip olup olmadığını kontrol et
        if ($user->hasRole('Kurucu')) {
            // Eğer kullanıcı "Kurucu" ise, silme işlemi gerçekleştirilmez
            return response()->json(['error' => 'Kurucu rolüne sahip kullanıcılar silinemez.'], 403);
        }
    
        $user->delete();
        return response()->json(['success' => 'Kullanıcı başarıyla silindi.']);
    }
}
