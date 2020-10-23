Vue.component('star-rating', {
    data () {
      return {
        rating: 0
      }
    },
    methods: {
      rate (i) { this.rating = i }
    },
    watch: {
      rating (val) {
        // prevent rating from going out of bounds by checking it to on every change
        if (val < 0) 
          this.rating = 0
        else if (val > 5) 
          this.rating = 5
  
        // ... some logic to save to localStorage or somewhere else
      }
    }
  })
  
  // make sure to initialize Vue after registering all components
  new Vue({
    el: document.getElementById('site-wrapper')
  })