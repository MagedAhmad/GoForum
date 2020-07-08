<template>
  <div class="group text-white flex" v-if="notifications.length" style="position:relative;z-index: 5;">
    <button class="outline-none focus:outline-none py-1 rounded-sm flex items-center mr-4">

      <span class="hidden md:inline-block pr-1 font-semibold flex-1 -mt-1"><i class="fa fa-bell"></i></span>
      <span class="md:hidden font-semibold">Notifications</span>
    </button>
    <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute 
    transition duration-150 ease-in-out origin-top min-w-32 mt-8 md:-ml-16">
      <li class="rounded-sm px-3 py-1 hover:bg-gray-100" v-for="notification in notifications">
          <a class="dropdown-item" 
            :href="notification.data.link" 
            @click="markAsRead(notification)"
            v-text="notification.data.message">
          </a></li>
      
    </ul>
  </div>
</template>


<script>
  export default {
    data() {
      return {
        notifications : [],
      }
    },


    methods: {
      markAsRead(notification) {
        axios.post('/profiles/' + window.App.user.name + '/notifications/' + notification.id, {
          _method: 'delete'
        });

      }
    },


    created() {
      axios.get('/profiles/' + window.App.user.name + '/notifications')
        .then(response => this.notifications = response.data);  

    }
  }
</script>

<style>
  /* since nested groupes are not supported we have to use 
     regular css for the nested dropdowns 
  */
  li>ul                 { transform: translatex(100%) scale(0) }
  li:hover>ul           { transform: translatex(101%) scale(1) }
  li > button svg       { transform: rotate(-90deg) }
  li:hover > button svg { transform: rotate(-270deg) }

  /* Below styles fake what can be achieved with the tailwind config
     you need to add the group-hover variant to scale and define your custom
     min width style.
  	 See https://codesandbox.io/s/tailwindcss-multilevel-dropdown-y91j7?file=/index.html
  	 for implementation with config file
  */
  .group:hover .group-hover\:scale-100 { transform: scale(1) }
  .group:hover .group-hover\:-rotate-180 { transform: rotate(180deg) }
  .scale-0 { transform: scale(0) }
  .min-w-32 { min-width: 8rem }
</style>