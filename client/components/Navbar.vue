<template>
  <nav class="navbar is-light">
    <div class="container">
      <div class="navbar-brand">
        <nuxt-link class="navbar-item" to="/">Konti-CMS</nuxt-link>
      </div>
      <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start" v-if="false">
          <a class="navbar-item" to="/dashboard">Home</a>
        </div>
      </div>
      <div class="navbar-menu">
        <div class="navbar-end">
          <div class="navbar-item has-dropdown is-hoverable" v-if="false">
            <a class="navbar-link"> Account-test-123 </a>
            <div class="navbar-dropdown">
              <nuxt-link class="navbar-item" to="/profile"
                >My Profile</nuxt-link
              >
              <hr class="navbar-divider" />
              <a class="navbar-item">Logout</a>
            </div>
          </div>
          <template v-else>
            <nuxt-link class="navbar-item" to="/register">Register</nuxt-link>
            <nuxt-link class="navbar-item" to="/login">Log In</nuxt-link>
          </template>
        </div>
      </div>
    </div>
  </nav>
</template>
