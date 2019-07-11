<template>
    <div class="card-body">
        <form @submit="formSubmit">
            <strong>Name:</strong>
            <input type="text" class="form-control" v-model="name">
            <strong>Description:</strong>
            <textarea class="form-control" v-model="description"></textarea>
            <button class="btn btn-success">Submit</button>
        </form>
        <strong>Output:</strong>
        <pre>{{output}}</pre>
    </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    },
    data() {
      return {
        name: '',
        description: '',
        output: ''
      };
    },
    methods: {
      formSubmit(e) {
        e.preventDefault();
        let currentObj = this;
        axios.post('/formSubmit', {
          name: this.name,
          description: this.description
        })
          .then(function (response) {
            currentObj.output = response.data;
          })
          .catch(function (error) {
            currentObj.output = error;
          });
      }
    }
  }
</script>