<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_sanpham' => 'required|exists:products,id',
            'noi_dung' => 'required|string|max:1000',
        ]);

        $userId = Auth::id();
        $productId = $request->id_sanpham;

        // Kiểm tra user đã từng đặt sản phẩm này và trạng thái là "giao hàng thành công"
        $daNhanHang = OrderItem::where('id_sanpham', $productId)
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('id_KH', $userId)
                      ->where('trangthai','thanhcong' ,'danhanhang');
            })
            ->exists();

        if (!$daNhanHang) {
            return back()->with('error', 'Bạn chỉ có thể bình luận khi đã nhận hàng.');
        }

        Comment::create([
            'id_sanpham' => $productId,
            'id_KH' => $userId,
            'noi_dung' => $request->noi_dung,
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi.');
    }
    public function destroy($id)
{
    $comment = Comment::findOrFail($id);

    // Chỉ cho phép xóa nếu là người tạo
    if (Auth::id() !== $comment->id_KH) {
        abort(403, 'Bạn không có quyền xóa bình luận này.');
    }

    $comment->delete();

    return redirect()->back()->with('success', 'Đã xoá bình luận thành công.');
}

}
