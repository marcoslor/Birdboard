<template>
    <v-popover class="my-auto" offset="10px">
        <button class="tooltip-target flex material-icons m-auto outline-none" style="font-size: 41px; color: #47cdff">
            add_circle
        </button>
        <template slot="popover">
            <div class="card tooltip-content">
                <input class="outline-none" name="email" placeholder="Email" type="email" v-model="emailToInvite"/>
                <button class="button rounded-full material-icons outline-none" v-on:click="invite">send</button>
            </div>
        </template>
    </v-popover>
</template>

<script>
  export default {
    data() {
      return {
        emailToInvite: ''
      }
    },
    methods: {
      invite: function () {
        try {
          axios.post(window.location.pathname + '/invitations', {
            withCredentials: true,
            'email': this.emailToInvite,
          }).then(response => {
            this.$root.$toasted.show('Success', {
              theme: "outline",
              position: "bottom-right",
              duration: 4000,
              icon: 'check'
            });
          }).catch(error => {
            this.$toasted.show(error.response.data.errors.email, {
              theme: "bubble",
              position: "bottom-right",
              duration: 4000,
              icon: 'error'
            });
          });
        } catch (error) {
          console.log(error)
        }
      }
    }
  };
</script>

<style>
    .v-popover.open {
        transition: .2s ease;
        margin-right: 0px;
    }
</style>
