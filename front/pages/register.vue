<template>
  <div>
    <div class="flex justify-center mt-10">
      <div class="w-1/2" style="max-width: 350px">
        <h1 class="text-3xl font-semibold mb-10">Register</h1>
        <form @submit.prevent="register">
          <form-input required label="Name" v-model="user.name" />
          <form-input
            required
            label="Email"
            type="Email"
            v-model="user.email"
          />
          <form-input
            required
            label="Password"
            type="password"
            v-model="user.password"
          />
          <form-input
            required
            label="Confirm password"
            type="password"
            v-model="user.password_confirmation"
          />

          <custom-button class="w-full">Register</custom-button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Register",
  data() {
    return {
      user: {
        name: "Dave Test 3",
        email: "dave@eventso.buzz",
        password: "secret123",
        password_confirmation: "secret123",
      },
    };
  },
  methods: {
    async register() {
      let api = process.env.API_URL;
      try {
        const response = await this.$axios.post(
          `${api}/api/register`,
          this.user,
          {
            headers: {
              Accept: "application/json",
            },
          }
        );

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
