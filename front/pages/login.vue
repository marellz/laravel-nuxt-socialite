<template>
  <div>
    <div class="flex justify-center mt-10">
      <div class="w-1/2" style="max-width: 350px">
        <h1 class="text-3xl font-semibold mb-10">Login</h1>
        <form @submit.prevent="login">
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

          <custom-button class="w-full">Submit</custom-button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "Login",
  data() {
    return {
      user: {
        email: "dave@eventso.buzz",
        password: "secret123",
      },
    };
  },
  methods: {
    async login() {
      let api = process.env.API_URL;
      try {
        const response = await this.$axios.post(`${api}/api/login`, this.user);

        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
