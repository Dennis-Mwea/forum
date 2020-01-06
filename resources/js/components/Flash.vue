<template>
	<div class="alert alert-success alert-flash" role="alert" v-show="show">
		<strong>Success!</strong>
		{{ body }}
	</div>
</template>

<script>
export default {
	name: 'Flash',

	props: {
		message: {
			type: String,
			required: false
		}
	},

	data: function() {
		return {
			body: '',
			show: false
		}
	},

	created: function() {
		if (this.message) {
			this.flash(this.message)
		}

		window.events.$on('flash', message => this.flash(message))
	},

	mounted: function() {
		console.log('Component mounted.')
	},

	methods: {
		flash: function(message) {
			this.body = message
			this.show = true

			this.hide()
		},

		hide: function() {
			setTimeout(() => {
				this.show = false
			}, 3000)
		}
	}
}
</script>

<style lang="scss">
.alert-flash {
	position: fixed;
	right: 25px;
	bottom: 25px;
}
</style>