<template>
  <div id="">
    <graph-bar
            :width="750"
            :height="350"
            :axis-min="0"
            :axis-max="30"
            :labels="labels"                
            :values="values">
        <note :text="'Check in por Modalidade'"></note>
        <tooltip :names="columns" :position="'left'"></tooltip>
        <legends :names="columns" :filter="true"></legends>
    </graph-bar>
  </div>
</template>

<script>

export default {
  data() {
    return {
        labels: [],
        values: [],
        columns: []
   
    };
  },
  created: function() {
      this.filter();
  },
  methods: {
      filter() {
          console.log('teste');
        let vThis = this;
        let url = '/report/bar';
        axios.post(url)
              .then(function (response) {
                    
                  if (response.data.status == 'success') {

                    
                    vThis.labels = response.data.labels;
                    
                    
                    vThis.values = response.data.values;                    
                    vThis.columns = response.data.columns;                    

                  } else {
                      console.log('erro');
                      $.each(response.data.errors, function(index, value) {
                          $('#'+index).addClass('is-invalid');
                      });
                  }                 
              })
      }
  }
};
</script>