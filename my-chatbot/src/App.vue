<template>
  <img class="logo" src="../src/assets/logo/sneakme_logo.png" alt="SneakMe Logo" />
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">Credits</router-link>
  </nav>
  <router-view />
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 20px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #0033cc;
}

.sneaker-image {
  max-width: 100%;
  height: auto;
  border-radius: 5px;
  margin-top: 1rem;
}
</style>
