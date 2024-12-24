@extends('layouts.main')

@section('css')
    <style>
        .chat-card {
            transition: background-color 0.2s;
        }

        .chat-card:hover {
            cursor: pointer;
            background-color: #ebebeb;
        }

        .chat-card .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11">
            <h1 class="pb-2 border-bottom">{{ $title }}</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-11">

            @if ($chats->count() > 0)
                @foreach ($chats as $chat)
                    {{-- Determine the recipient --}}
                    @php
                        $recipient = auth()->id() === $chat->seller_id ? $chat->buyer : $chat->seller;
                    @endphp

                    <div class="card chat-card d-flex flex-row justify-content-between p-3 mb-3" style="height: 120px;"
                        onclick="event.stopPropagation(); window.location.href='{{ route('chats.show', ['chats' => $chat->id]) }}'">

                        {{-- Recipient Profile Picture --}}
                        <div class="col-2 col-lg-1 overflow-hidden" style="height:100%;">
                            @if ($recipient->image)
                                <img src="{{ secure_asset('storage/' . $recipient->image) }}" alt="{{ $recipient->name }}"
                                    class="rounded-circle profile-img">
                            @else
                                <img src="{{ secure_asset('img/' . $recipient->gender . ' icon.png') }}"
                                    alt="{{ $recipient->name }}" class="rounded-circle profile-img">
                            @endif
                        </div>

                        {{-- Chat Information --}}
                        <div class="col-10 col-lg-11 d-flex flex-column">
                            {{-- Recipient Name --}}
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold">{{ $recipient->name }}</h5>
                                <p>
                                    {{ $chat->messages->last() ? $chat->messages->last()->created_at->diffForHumans() : 'No messages' }}
                                </p>
                            </div>
                            {{-- Latest Message from the chat --}}
                            <div>
                                @php
                                    $latestMessage = $chat->messages->last();
                                @endphp
                                <p class="text-start">{{ $latestMessage ? $latestMessage->message_text : 'No messages' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No chats yet</p>
            @endif

        </div>
    </div>

@endsection
