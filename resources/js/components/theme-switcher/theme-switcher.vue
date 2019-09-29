<template>
    <div class="theme-switcher flex items-center">
        <button :class="[theme, {'border border-accent': theme === selectedTheme}]"
                class="rounded-full w-4 h-4 mr-2 bg-page focus:outline-none" v-for="theme in themes"
                v-on:click="selectedTheme = theme"></button>
    </div>
</template>

<script>
  export default {
    data: () => ({
      themes: [
        'theme-dark',
        'theme-light'
      ],
      selectedTheme: document.body.className.match(/theme-\w+/)[0]
    }),
    created() {
      this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
    },
    watch: {
      selectedTheme() {
        localStorage.setItem('theme', this.selectedTheme);
        document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme)
      }
    }
  };
</script>
