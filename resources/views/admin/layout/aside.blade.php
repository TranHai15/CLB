  <aside class="fixed inset-y-0 left-0 bg-gray-800 w-64 transition-all duration-300 transform z-30 lg:translate-x-0"
      id="sidebar">
      <div class="flex items-center justify-between p-4 border-b border-gray-700">
          <div class="flex items-center space-x-2">
              <span class="text-white text-xl font-bold">CLB Admin</span>
          </div>
          <button class="text-gray-300 hover:text-white lg:hidden" id="closeSidebar">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
          </button>
      </div>

      <nav class="mt-4 px-2 space-y-1">

          <a href="{{ route('admin.dashboard') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Dashboard
          </a>



          <a href="{{ route('admin.account.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.account.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.account.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
              Quản lý người dùng
          </a>


          <a href="{{ route('admin.member.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.member.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.member.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              Thành viên CLB
          </a>



          <a href="#"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.documents.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.documents.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Tài liệu học tập
          </a>

          <a href="{{ route('admin.transactions.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
              <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Quản lý quỹ
          </a>

          <a href="{{ route('admin.plans.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.plans.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.plans.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Kế hoạch
          </a>



          <a href="{{ route('admin.posts.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.posts.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
              </svg>
              Bài viết
          </a>



          <a href="{{ route('admin.comments.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.comments.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.comments.*') ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
              </svg>
              Bình luận
          </a>


          @if (auth()->user()->hasRole('admin'))
          <a href="{{ route('admin.roles.index') }}"
              class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.roles.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512" width="24" height="24">
                  <circle fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="5" cx="256" cy="56" r="40" />
                  <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"
                      d="M204.23 274.44c2.9-18.06 4.2-35.52-.5-47.59-4-10.38-12.7-16.19-23.2-20.15L88 176.76c-12-4-23.21-10.7-24-23.94-1-17 14-28 29-24 0 0 88 31.14 163 31.14s162-31 162-31c18-5 30 9 30 23.79 0 14.21-11 19.21-24 23.94l-88 31.91c-8 3-21 9-26 18.18-6 10.75-5 29.53-2.1 47.59l5.9 29.63 37.41 163.9c2.8 13.15-6.3 25.44-19.4 27.74S308 489 304.12 476.28l-37.56-115.93q-2.71-8.34-4.8-16.87L256 320l-5.3 21.65q-2.52 10.35-5.8 20.48L208 476.18c-4 12.85-14.5 21.75-27.6 19.46s-22.4-15.59-19.46-27.74l37.39-163.83z" />
              </svg>

              Phân Quyền
          </a>
          @endif
      </nav>

      <!-- Logout Button -->
      <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                  <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Đăng xuất
              </button>
          </form>
      </div>
  </aside>

  @push('scripts')
  <script>
      // Update page title based on active menu item
      document.addEventListener('DOMContentLoaded', function() {
          const activeLink = document.querySelector('a[href="' + window.location.pathname + '"]');
          if (activeLink) {
              const title = activeLink.textContent.trim();
              document.title = title + ' - CLB Admin';
          }
      });
  </script>
  @endpush