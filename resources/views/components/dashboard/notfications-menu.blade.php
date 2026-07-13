<li class="nav-item dropdown">

    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>

        @if($newCount > 0)
            <span class="badge badge-danger navbar-badge">
                {{ $newCount }}
            </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg{max-width: 300px; min-width: 300px;} dropdown-menu-right">

        <span class="dropdown-header">
            {{ $newCount }} New Notifications
        </span>

        <div class="dropdown-divider"></div>

        @forelse($notifications as $notification)

            <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}"
               class="dropdown-item @if($notification->unread()) text-bold @endif">

                <i class="fas fa-shopping-cart mr-2"></i>

                {{ $notification->data['body'] }}

                <span class="float-right text-muted text-sm">
                    {{ $notification->created_at->diffForHumans() }}
                </span>

            </a>

            <div class="dropdown-divider"></div>

        @empty

            <span class="dropdown-item text-center">
                No Notifications
            </span>

        @endforelse

        @if($newCount > 0)
            <a href="#" class="dropdown-item dropdown-footer">
                View All Notifications
            </a>
        @endif

    </div>

</li>
