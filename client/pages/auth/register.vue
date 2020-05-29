<template>
  <div class="container">
    <div class="col-md-6 offset-md-3">
      <div class="card mt-4">
        <div class="card-header">
          <p>Register</p>
        </div>
        <div class="card-body">
          <form @submit.prevent="register">
            <div class="form-group">
              <label for="name">name</label>
              <input v-model="form.name" id="name" type="text" class="form-control"
                     :class="{ 'is-invalid': errors.name }" placeholder="Name" />
              <div class="invalid-feedback" v-if="errors.name">
                {{ errors.name[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input v-model="form.email" id="email" type="email" class="form-control"
                     :class="{ 'is-invalid': errors.email }" placeholder="E-mail" />
              <div class="invalid-feedback" v-if="errors.email">
                {{ errors.email[0] }}
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="form.password" id="password" type="password" class="form-control"
                     :class="{ 'is-invalid': errors.password }" placeholder="password" />
              <div class="invalid-feedback" v-if="errors.password">
                {{ errors.password[0] }}
              </div>
            </div>
            <div class="form-group">
              <input type="submit" value="Register" class="btn btn-outline-info w-100">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "register",
    middleware: 'guest',
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: ''
        }
      }
    },
    methods: {
      async register() {
        await this.$axios.post('/auth/register', this.form)
        .then(data => {
          this.$auth.login({ data: this.form });
          this.$router.push({ name: 'index' })
        })
        .catch(() => {
        });
      }
    }
  }
</script>

