@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chat/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-lg-8">
            <div class="chat-box">
                {{-- Chat Header: Recipient Related Information --}}
                <div class="d-flex flex-row align-items-center mb-3">
                    <div class="col-1">
                        <a href="{{ route('chats.index') }}" class="color-inherit">
                            <i class="bi bi-arrow-left fs-3"></i>
                        </a>
                    </div>
                    <div class="col-1 overflow-hidden" style="width: 50px; height:50px;">
                        <img src="{{ $recipient->image ? asset('storage/' . $recipient->image) : asset('img/' . $recipient->gender . ' icon.png') }}"
                            alt="{{ $recipient->name }}" class="rounded-circle">
                    </div>
                    <div class="col-10 ps-3">
                        <h3 class="fw-bold m-0">{{ $recipient->name }}</h3>
                    </div>
                </div>

                <div class="chat-content" id="chat-messages">
                    @forelse ($chat->messages as $message)
                        {{-- Chat message will be loaded in the JS file --}}
                    @empty
                        <p class="text-center text-muted">No messages yet. Be the first to send a message!</p>
                    @endforelse
                </div>

                {{-- To store the chat message --}}
                <form id="chat-form" method="POST" action="{{ route('chats.store') }}" class="chat-form">
                    @csrf
                    <input type="hidden" name="chat" id="chat" value="{{ $chat->id }}">
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                        <button type="submit" class="btn btn-primary send-btn">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const chatId = @json($chat->id);
        const userId = @json(auth()->user()->id);
        const chatStoreUrl = "{{ route('chats.store') }}";
    </script>
    <script src="{{ asset('js/chat.js') }}?v={{ time() }}"></script>
@endsection
