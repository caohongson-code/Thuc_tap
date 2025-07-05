<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->matkhau)) {
        Auth::login($user);

        if ($user->vai_tro == 'admin') {
            return redirect('/admin/products');
        }
        return redirect('/');
    }

    return back()->with('modal', 'login')->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng.',
    ]);
}


   public function register(Request $request)
{
    $request->validate([
        'ho' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'matkhau' => 'required|confirmed|min:6',
        'dien_thoai' => 'required|string',
        'dia_chi' => 'required|string',
        'thanhpho' => 'required|string',
    ]);

User::create([
    'ten' => $request->ten ?? 'mặc định',
    'ho' => $request->ho,
    'email' => $request->email,
    'matkhau' => Hash::make($request->matkhau),
    'dien_thoai' => $request->dien_thoai,
    'dia_chi' => $request->dia_chi,
    'thanhpho' => $request->thanhpho,
    'vai_tro' => 'user',
]);


    return back()->with('modal', 'login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
}


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
