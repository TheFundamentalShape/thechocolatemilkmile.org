<div class="flex justify-center z-50">
    <div class="flex justify-between fixed top-0 w-full z-50 bg-brown text-white shadow-2xl">

        <div class="pl-8 py-4 my-auto hidden md:block">
            <h1 class="fat-font text-2xl md:text-3xl text-white relative"><span class="tilty absolute skippy-font text-3xl -mt-6 -ml-3 md:-mt-6 md:-ml-4 md:top-0 md:left-0">the</span> Chocolate Milk Mile</h1>
        </div>

        <div class="flex justify-center md:justify-between my-auto">
            <div class="my-auto hover:bg-dark-brown {{ Route::currentRouteNamed('landing.home') ? 'bg-dark-brown' : '' }} py-4"><a href="/" class="px-4 fat-font">Home</a></div>
            <div class="my-auto hover:bg-dark-brown {{ Route::currentRouteNamed('landing.about') ? 'bg-dark-brown' : '' }} py-4"><a href="/about" class="px-4 fat-font">About</a></div>
            <div class="my-auto hover:bg-dark-brown {{ Route::currentRouteNamed('landing.photos') ? 'bg-dark-brown' : '' }} py-4"><a href="/photos" class="px-4 fat-font">Photos</a></div>
            <div class="my-auto hover:bg-dark-brown {{ Route::currentRouteNamed('login') ? 'bg-dark-brown' : '' }} py-4"><a href="/login" class="px-4 fat-font">Login</a></div>
            <div class="my-auto hover:bg-dark-brown {{ Route::currentRouteNamed('register') ? 'bg-dark-brown' : '' }} py-4"><a href="/register" class="px-4 fat-font">Register</a></div>
        </div>

    </div>
</div>