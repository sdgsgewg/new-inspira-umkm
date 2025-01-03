@extends('layouts.main')

@section('css')
    <style>
        .chat-card {
            transition: background-color 0.2s;
        }

        .chat-card:hover {
            cursor: pointer;
            background-color: #909090;
        }

        .chat-card .profile-img {
            width: 5.5rem;
            height: 5.5rem;
        }
    </style>
@endsection

@section('container')

    <div class="row justify-content-center mt-5">
        <div class="col-11 col-lg-10 col-xl-8">
            <h1 class="pb-2 border-bottom">{{ $title }}</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-11 col-lg-10 col-xl-8">

            @if ($chats->count() > 0)
                @foreach ($chats as $chat)
                    {{-- Determine the recipient --}}
                    @php
                        $recipient = auth()->id() === $chat->seller_id ? $chat->buyer : $chat->seller;
                    @endphp

                    <div class="card chat-card col-12 d-flex flex-row justify-content-between p-3 mb-3" style="height: 120px;"
                        onclick="event.stopPropagation(); window.location.href='{{ route('chats.show', ['chats' => $chat->id]) }}'">

                        {{-- Recipient Profile Picture --}}
                        <div class="col-8 col-lg-8 d-flex flex-row" style="height:100%;">
                            {{-- Recipient Image --}}
                            <div class="col-4 col-md-3 overflow-hidden">
                                <img src="{{ $recipient->image ? $recipient->image : secure_asset('img/' . $recipient->gender . '.png') }}"
                                    alt="{{ $recipient->name }}" class="rounded-circle object-cover profile-img">
                            </div>
                            {{-- Recipient Name --}}
                            <div class="col-8 col-md-9 d-flex flex-column justify-content-between">
                                <h5 class="fw-bold">{{ $recipient->name }}</h5>
                                <div>
                                    @php
                                        $latestMessage = $chat->messages->last();
                                    @endphp
                                    <p class="text-start">
                                        {{ $latestMessage ? $latestMessage->message_text : 'No messages' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Chat Information --}}
                        <div class="col-4 col-lg-4 d-flex flex-column">
                            {{-- Latest Message from the chat --}}
                            <p class="text-end">
                                {{ $chat->messages->last() ? $chat->messages->last()->created_at->diffForHumans() : 'No messages' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No chats yet</p>
            @endif

        </div>
    </div>

@endsection
