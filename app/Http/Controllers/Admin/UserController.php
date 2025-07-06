<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách user
    public function index()
    {
        $users = User::orderByDesc('id')->get();
        return view('admin.users.index', compact('users'));
    }

    // Hiển thị form tạo user
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu user mới
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'ho' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matkhau' => 'required|min:6',
            'dien_thoai' => 'required|string',
            'dia_chi' => 'required|string',
            'thanhpho' => 'required|string',
            'vai_tro' => 'required|in:user,admin',
        ]);
        User::create([
            'ten' => $request->ten,
            'ho' => $request->ho,
            'email' => $request->email,
            'matkhau' => Hash::make($request->matkhau),
            'dien_thoai' => $request->dien_thoai,
            'dia_chi' => $request->dia_chi,
            'thanhpho' => $request->thanhpho,
            'vai_tro' => $request->vai_tro,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    // Hiển thị form sửa user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'ten' => 'required|string|max:255',
            'ho' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'dien_thoai' => 'required|string',
            'dia_chi' => 'required|string',
            'thanhpho' => 'required|string',
            'vai_tro' => 'required|in:user,admin',
        ]);
        $data = $request->only(['ten','ho','email','dien_thoai','dia_chi','thanhpho','vai_tro']);
        if ($request->filled('matkhau')) {
            $data['matkhau'] = Hash::make($request->matkhau);
        }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    // Xóa user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công!');
    }
} 