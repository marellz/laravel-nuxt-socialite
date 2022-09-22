<template>
  <div class="h-full">
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto">
            <div class="flex">
              <nuxt-link to="/" class="font-medium">Socialite</nuxt-link>
              <div class="ml-auto space-x-4 flex items-center">
                <nuxt-link to="/login" class="">Login</nuxt-link>
                <span class="border-r h-5"></span>
                <nuxt-link to="/Register" class="">Register</nuxt-link>
              </div>
            </div>
        </div>
    </header>
    <main class="py-4">
        <div class="container mx-auto">
            <nuxt />
        </div>
    </main>
  </div>
</template>
<script>
name: "Layout";
</script>
