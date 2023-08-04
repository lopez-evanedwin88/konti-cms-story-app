<template>
    <section class="section">
      <div class="container">
        <h2 class="title">My Profile</h2>
        <div class="content">
          <p>
            <strong>Username:</strong>
            {{ username }}
          </p>
          <p>
            <strong>Email:</strong>
            {{ email }}
          </p>
        </div>
      </div>
    </section>
  </template>
  
  <script>
//   import { mapGetters } from 'vuex'
  
  export default {
    // computed: {
    //   ...mapGetters(['loggedInUser'])
    // }
    data() {
      return {
        username: 'demodongski',
        email: 'demo@test.com',
        error: null
      }
    },
  }
  </script>