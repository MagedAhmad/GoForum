<template>
  <li class="nav-item dropdown" v-if="notifications.length">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
        Notifications
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li v-for="notification in notifications">
          <a class="dropdown-item" 
            :href="notification.data.link" 
            @click="markAsRead(notification)"
            v-text="notification.data.message">
          </a>
          
        </li>

      </div>
    
  </li>
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
        axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);

      }
    },


    created() {
      axios.get('/profiles/' + window.App.user.name + '/notifications')
        .then(response => this.notifications = response.data);  

    }
  }
</script>