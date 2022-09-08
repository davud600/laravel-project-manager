<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center w-100 ps-3 pe-3 me-5">
            <img src="assets/img/logo.png" alt="" />
            <span class="d-none d-lg-block">PM</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <!-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
            <button type="submit" title="Search">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div> -->
    <!-- End Search Bar -->

    @if (auth()->user() !== null)
    @php
    $unreadMessages = getUnreadMessages();
    @endphp
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text ps-5"></i>
                    <span class="badge bg-success badge-number">{{ count($unreadMessages) == 0 ? null : count($unreadMessages) }}</span> </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have {{ count($unreadMessages) }} new messages
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    @foreach ($unreadMessages as $message)
                    <li class="message-item">
                        <a href="/requests/{{ $message->request->id }}">
                            <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle" />
                            <div>
                                <h4>{{ $message->user->name }}</h4>
                                <p>
                                    {{ $message->text }}
                                </p>
                                <p>{{ $message->created_at }}</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    @endforeach
                </ul>
                <!-- End Messages Dropdown Items -->
            </li>
            <!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span>
                            {{
                                auth()->user()->role == 0 ? 'Customer' : (auth()->user()->role == 1 ? 'Employee': 'Admin')
                            }}
                        </span>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/profile">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/profile">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/faq">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
    @endif
    <!-- End Icons Navigation -->
</header>