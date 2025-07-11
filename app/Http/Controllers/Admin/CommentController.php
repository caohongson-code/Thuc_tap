<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'product']);
        if ($request->q) {
            $q = $request->q;
            $query->where(function($query) use ($q) {
                $query->where('noi_dung', 'like', "%$q%")
                      ->orWhereHas('user', function($sub) use ($q) {
                          $sub->where('ten', 'like', "%$q%")
                              ->orWhere('ho', 'like', "%$q%")
                              ->orWhereRaw("CONCAT(ho, ' ', ten) like ?", ["%$q%"])
                              ->orWhere('email', 'like', "%$q%")
                              ->orWhere('dien_thoai', 'like', "%$q%")
                              ->orWhere('dia_chi', 'like', "%$q%")
                              ;
                      })
                      ->orWhereHas('product', function($sub) use ($q) {
                          $sub->where('ten_san_pham', 'like', "%$q%")
                              ->orWhere('mota', 'like', "%$q%")
                              ;
                      });
            });
        }
        $comments = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Đã xóa bình luận thành công!');
    }
} 