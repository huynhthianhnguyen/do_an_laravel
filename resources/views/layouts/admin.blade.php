<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white h-screen shadow-lg flex flex-col">
        <div class="p-4 text-center border-b">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="mx-auto h-12 w-auto">
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 text-gray-700">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard')}}"
               class="block px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                🏠 Bảng điều khiển
            </a>

            <!-- Dropdown: Sản phẩm -->
            <div x-data="{ open: {{ request()->is('admin/products*') || request()->is('admin/categories*') || request()->is('admin/collections*') || request()->is('admin/groups*') ? 'true' : 'false' }} }" class="relative">
                <button @click="open = !open"
                        class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-50 text-blue-600 font-semibold': open }">
                    <span>🛍️ Quản lý sản phẩm</span>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Danh mục con -->
                <div x-show="open" x-collapse class="mt-1 ml-6 text-sm space-y-1">
                    <a href="{{ route('admin.products.index') }}"
                       class="block py-1 px-2 rounded hover:text-blue-600 {{ request()->routeIs('admin.products.*') ? 'text-blue-600 font-semibold' : '' }}">
                        📦 Sản phẩm
                    </a>

                    <a href="{{ route('admin.groups.index') }}"
                       class="block py-1 px-2 rounded hover:text-blue-600 {{ request()->routeIs('admin.groups.*') ? 'text-blue-600 font-semibold' : '' }}">
                        🧩 Nhóm sản phẩm
                    </a>

                    <a href="{{ route('admin.collections.index') }}"
                       class="block py-1 px-2 rounded hover:text-blue-600 {{ request()->routeIs('admin.collections.*') ? 'text-blue-600 font-semibold' : '' }}">
                        🎨 Bộ sưu tập
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="block py-1 px-2 rounded hover:text-blue-600 {{ request()->routeIs('admin.categories.*') ? 'text-blue-600 font-semibold' : '' }}">
                        📁 Danh mục
                    </a>
                </div>
            </div>
            <!-- Đơn hàng -->
<div x-data="{ open: {{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
                        class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-blue-100"
                        :class="{ 'bg-blue-50 text-blue-600 font-semibold': open }">
                   <span>📦 Đơn hàng</span>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

    <div x-show="open" class="ml-6 mt-1 space-y-1">

        <a href="{{ route('admin.orders.index') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.orders.index') ? 'text-blue-600 font-semibold' : '' }}">
            Tất cả đơn hàng
        </a>

        <a href="{{ route('admin.orders.pending') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.orders.pending') ? 'text-blue-600 font-semibold' : '' }}">
           🕒 Chờ xử lý
        </a>

        <a href="{{ route('admin.orders.shipping') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.orders.shipping') ? 'text-blue-600 font-semibold' : '' }}">
            🚚 Đang giao
        </a>

        <a href="{{ route('admin.orders.completed') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.orders.completed') ? 'text-blue-600 font-semibold' : '' }}">
            ✔️ Hoàn thành
        </a>

        <a href="{{ route('admin.orders.cancelled') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.orders.cancelled') ? 'text-blue-600 font-semibold' : '' }}">
            ❌ Đã hủy
        </a>

    </div>
</div>
<!-- Feedback / Liên hệ & Đánh giá -->
<div x-data="{ open: {{ request()->is('admin/contacts*') || request()->is('admin/reviews*') ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="flex justify-between items-center w-full px-3 py-2 rounded hover:bg-blue-100"
            :class="{ 'bg-blue-50 text-blue-600 font-semibold': open }">
        <span>💬 Liên hệ & Đánh giá</span>
        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="open" class="ml-6 mt-1 space-y-1">
        <a href="{{ route('admin.contacts.index') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.contacts.*') ? 'text-blue-600 font-semibold' : '' }}">
            📩 Liên hệ
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="block px-3 py-1 rounded hover:bg-blue-100 
           {{ request()->routeIs('admin.reviews.*') ? 'text-blue-600 font-semibold' : '' }}">
            ⭐ Đánh giá
        </a>
    </div>
</div>

            <!-- Người dùng -->
            <a href="{{ route('admin.users.index') }}"
               class="block px-3 py-2 rounded hover:bg-blue-100 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                👥 Người dùng
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
            <input type="text" placeholder="Tìm kiếm..."
                   class="border rounded px-3 py-1 w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div class="flex items-center space-x-4">
                <button>🔔</button>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                    <span class="font-semibold">Quản trị viên</span>
                </div>
            </div>
        </header>

        <section class="p-6">
            @yield('content')
        </section>
    </main>

</body>
</html>
