<template>
  <ul class="pagination">
  	<br>
    <li class="page-item" v-if="prevUrl">
      <a class="page-link" href="#" aria-label="Previous" @click.prevent="page--">
        <span aria-hidden="true">&laquo; Previous</span>
      </a>
    </li>
    <li class="page-item" v-if="nextUrl">
      <a class="page-link" href="#" aria-label="Next" @click.prevent="page++">
        <span aria-hidden="true"> Next &raquo;</span>
      </a>
    </li>
  </ul>
</template>


<script>
	export default {
		props: ['dataSet'],
		data() {
			return {
				page: 1,
				nextUrl: false,
				prevUrl: false,
			}
		},

		watch: {
			dataSet() {
				this.page = this.dataSet['current_page'];
				this.nextUrl = this.dataSet['next_page_url'];
				this.prevUrl = this.dataSet['prev_page_url'];
			},
			page() {
				this.broadcast();
			}
		},

		methods: {
			broadcast() {
				this.$emit('changed', this.page);
			}
		}

	}
</script>