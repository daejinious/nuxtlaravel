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
              <input v-model="form.name" id="name" type="text" class="form-control" placeholder="Name"/>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input v-model="form.email" id="email" type="email" class="form-control" placeholder="E-mail"/>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="form.password" id="password" type="password" class="form-control" placeholder="password"/>
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
        await this.$axios.post('/auth/register', this.form);
        this.$auth.login({data: this.form});
        this.$router.push({name: 'index'});
      }
    }
	}
</script>

<style scoped>

</style>
