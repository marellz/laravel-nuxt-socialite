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

          <custom-button class="w-full">Login</custom-button>
        </form>
        <hr class="my-10" />

        <div class="space-y-3">
          <custom-button
            class="w-full"
            v-for="provider in providers"
            :key="provider.name"
            @click="loginWith(provider.name)"
          >
            Login with {{ provider.label }}
          </custom-button>
        </div>
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
      providers: [
        { label: "Google", name: "google" },
        { label: "Facebook", name: "facebook" },
        { label: "Github", name: "github" },
      ],
    };
  },
  mounted() {
    if (this.$route.query.provider) {
      this.completeLoginWith(this.$route.query.provider);
    }
  },
  watch: {
    $route(from, to) {
      if (to.query.provider) {
        this.completeLoginWith(to.query.provider);
      }
    },
  },
  methods: {
    async login() {
      let api = process.env.API_URL;
      try {
        const response = await this.$axios.post(`${api}/api/login`, this.user, {
          headers: {
            Accept: "application/json",
          },
        });
        console.log(response);
      } catch (error) {
        console.log(error);
      }
    },
    async loginWith(provider) {
      let api = process.env.API_URL;
      try {
        const { data } = await this.$axios.post(
          `${api}/api/auth/redirect/${provider}`,
          {},
          {
            headers: {
              Accept: "application/json",
            },
          }
        );

        let url = data.url;

        if (url) {
          window.location = url;
        }
      } catch (error) {
        console.log(error);
      }
    },

    async completeLoginWith(provider) {
      let api = process.env.API_URL,
        code = this.$route.query.code;
      try {
        const { data } = await this.$axios.post(
          `${api}/api/auth/callback/${provider}`,
          {
            code,
          },
          {
            headers: {
              Accept: "application/json",
            },
          }
        );

        let success = data.success;

        if (success) {
          alert("Login successful");
        } else {
          console.log(data);
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
