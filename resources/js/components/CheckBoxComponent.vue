<template>
  <div class="">
    <b-form-group label="Selecione as aulas disponíveis">
      <b-form-checkbox-group
        v-model="selected"
        :options="options"
        style="column-count: 3;"
        size="lg"
        name="item[]"
        value-field="id"
        text-field="name"
         plain
        stacked
      ></b-form-checkbox-group>
    </b-form-group>
  </div>
</template>

<script>
  export default {
      props: {
          options: Array,
          selected: [], // Must be an array reference!
      },
    data() {
      return {
      }
    },
    methods: {
        save(id, url) {
            let vThis = this;
            let data = $("#"+id).serialize();

            this.$validator.validateAll(id).then(valid => {
            if (!valid) {
              vThis.$root.mensagem('error', 'Preencha todos os campos obrigatórios')


                $.each(response.data.errors, function(index, value) {
                    $('#'+index).addClass('is-invalid');
                });
                return false;
            } else {

              axios.post(url, data)
              .then(function (response) {
                  if (response.data.status == 'success') {

                    vThis.$root.mensagem('success', response.data.message)

                  } else {
                      
                      $.each(response.data.errors, function(index, value) {
                          $('#'+index).addClass('is-invalid');
                      });
                  }                 
              });
            }         
        });
        }
    }
  }
</script>