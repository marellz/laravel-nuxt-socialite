<template>
  <button
    @click="$emit('click')"
    class="py-2 px-5 text-white inline-block font-medium rounded bg-blue-500"
  >
    <slot />
  </button>
</template>
