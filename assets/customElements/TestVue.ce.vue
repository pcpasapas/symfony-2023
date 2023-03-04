<template>
	<div>
		<h1>
			OK de vue js
			{{ count }}
		</h1>
		<button @click="increment">Incrémenter</button>
		<button @click="reset">Reset</button>
	</div>
</template>

<script>
export default {
	data() {
		return {
			count: 0,
		}
	},
	methods: {
		increment() {
			this.count = this.count + 1
		},
		reset() {
			this.count = 0
		},
	},
}
</script>
