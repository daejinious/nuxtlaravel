<template>
	<div class="container">
    <h1>Welcome to the Dashboard {{ user.name }}</h1>
    <h1>Hello</h1>
  </div>
</template>

<script>
	export default {
	  middleware: 'auth',
		name: 'dashboard'
	}
</script>
