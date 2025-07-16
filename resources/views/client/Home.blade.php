@extends('client.layouts.main')

@section('content')
<br>
@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<div class="container">
<form action="{{ route('home') }}" method="GET" class="mb-4">
    <div class="input-group shadow-sm rounded" style="max-width: 500px; margin: 0 auto;">
        <input type="text" name="search" class="form-control border-success" 
               placeholder="🔍 Tìm kiếm sản phẩm..." 
               value="{{ request('search') }}"
               style="border-right: 0; border-radius: 30px 0 0 30px;">
        
        <button type="submit" class="btn btn-success px-4" style="border-radius: 0 30px 30px 0;">
            Tìm kiếm
        </button>
    </div>
</form>



    @if(request()->get('page', 1) == 1 && !request()->filled('search'))
    <h1>Sản phẩm hot</h1>
    <div class="row">
        @foreach($latestProducts as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="product">
                <a href="{{ route('client.show', $product->id) }}" class="img-prod">
                    <img class="img-fluid" src="{{ asset('/' . $product->hinhanh) }}" alt="{{ $product->ten_san_pham }}">
                </a>
                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#">{{ $product->ten_san_pham }}</a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price"><span>{{ number_format($product->gia_coso, 0, ',', '.') }}₫</span></p>
                        </div>
                    </div>
                    <div class="bottom-area d-flex px-3">
                        <div class="m-auto d-flex">
                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                <span><i class="ion-ios-menu"></i></span>
                            </a>
                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                            <a href="#" class="heart d-flex justify-content-center align-items-center">
                                <span><i class="ion-ios-heart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

    @if(!request()->filled('search'))
<h1>sản phẩm bán chạy</h1>
    @endif


    <div class="row">
        @foreach($products as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="product">
                <a href="{{ route('client.show', $product->id) }}" class="img-prod">
                    <img class="img-fluid" src="{{ asset('/' . $product->hinhanh) }}" alt="{{ $product->ten_san_pham }}">
 </a>
                    
               

                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#">{{ $product->ten_san_pham }}</a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price"><span>{{ number_format($product->gia_coso, 0, ',', '.') }}₫</span></p>
                        </div>
                    </div>
                    <div class="bottom-area d-flex px-3">
                        <div class="m-auto d-flex">
                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                <span><i class="ion-ios-menu"></i></span>
                            </a>
                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                            <a href="#" class="heart d-flex justify-content-center align-items-center">
                                <span><i class="ion-ios-heart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
</div>        <div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>
<br>

<!-- Chat Box AI OpenAI GPT -->
<div id="ai-chatbox" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999;">
    <div id="ai-chat-window" style="display: none; width: 350px; height: 420px; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.18); overflow: hidden; display: flex; flex-direction: column;">
        <div style="background: #1b1b18; color: #fff; padding: 12px 16px; font-weight: bold;">AI Chatbot <span style="float:right; cursor:pointer;" onclick="document.getElementById('ai-chat-window').style.display='none'">&times;</span></div>
        <div id="ai-chat-messages" style="flex: 1; padding: 16px; overflow-y: auto; background: #f9f9f9;"></div>
        <form id="ai-chat-form" style="display: flex; border-top: 1px solid #eee;">
            <input id="ai-chat-input" type="text" placeholder="Nhập tin nhắn..." style="flex:1; border:none; padding: 12px; outline:none;">
            <button type="submit" style="background: #1b1b18; color: #fff; border:none; padding: 0 20px; cursor:pointer;">Gửi</button>
        </form>
    </div>
    <button id="ai-chat-toggle" style="width: 56px; height: 56px; border-radius: 50%; background: #1b1b18; color: #fff; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.18); font-size: 28px; cursor: pointer;">💬</button>
</div>

<script>
    const chatToggle = document.getElementById('ai-chat-toggle');
    const chatWindow = document.getElementById('ai-chat-window');
    const chatForm = document.getElementById('ai-chat-form');
    const chatInput = document.getElementById('ai-chat-input');
    const chatMessages = document.getElementById('ai-chat-messages');

    chatToggle.onclick = function() {
        chatWindow.style.display = 'flex';
        chatInput.focus();
    };

    chatForm.onsubmit = async function(e) {
        e.preventDefault();
        const userMsg = chatInput.value.trim();
        if (!userMsg) return;
        appendMessage('Bạn', userMsg, true);
        chatInput.value = '';
        chatInput.disabled = true;
        // Gửi lên server
        try {
            const res = await fetch('/ai-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: userMsg })
            });
            const data = await res.json();
            let aiText = "Không có phản hồi";
            if (data.candidates && data.candidates[0] && data.candidates[0].content && data.candidates[0].content.parts && data.candidates[0].content.parts[0].text) {
                aiText = data.candidates[0].content.parts[0].text;
            }
            appendMessage('AI', aiText, false);
        } catch (err) {
            appendMessage('AI', 'Lỗi kết nối server!', false);
        }
        chatInput.disabled = false;
        chatInput.focus();
    };

    function appendMessage(sender, text, isUser) {
        const msg = document.createElement('div');
        msg.style.margin = '8px 0';
        msg.style.display = 'flex';
        msg.style.justifyContent = isUser ? 'flex-end' : 'flex-start';
        msg.innerHTML = `<div style="max-width: 70%; padding: 10px 16px; border-radius: 16px; background: ${isUser ? '#1b1b18' : '#eee'}; color: ${isUser ? '#fff' : '#222'}; font-size: 15px;">${text}</div>`;
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Đảm bảo chat window luôn ẩn khi load lại trang
    window.onload = function() {
        chatWindow.style.display = 'none';
    };
</script>
@endsection
