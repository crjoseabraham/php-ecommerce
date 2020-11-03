@php
    // Get messages array
    $notifications = \App\Controller\Helper\Flash::getMessages();
@endphp

@if (!is_null($notifications))
<div class="notification-container">
    @foreach ($notifications as $notification)
    <div class="notification" data-type="{{ $notification['type'] }}">
        <!-- Notification title and icon -->
        <div class="notification__title notification__{{ $notification['type'] }}">
            <div class="notification__title-text">
            @switch($notification['type'])
                @case('danger')
                    <i class="fa fa-times-circle"></i>
                    <span>Error</span>
                    @break
                @case('info')
                    <i class="fa fa-exclamation-triangle"></i>
                    <span>Information</span>
                    @break
                @default
                    <i class="fa fa-check-circle"></i>
                    <span>Success</span>
            @endswitch
            </div>
            <div class="notification__title-close" id="close-notification"> Close </div>
        </div>

        <!-- Notification body -->
        <div class="notification__body">
            @if (is_iterable($notification['body']))
            <ul>
                @foreach ($notification['body'] as $item)
                    <li> {{ $item }} </li>
                @endforeach
            </ul>
            @else
            {{ $notification['body'] }}
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif