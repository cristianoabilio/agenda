<template>
  <div id="">
    <graph-line
            :width="550"
            :height="350"
            :shape="'normal'"
            :axis-min="0"
            :axis-max="20"
            :axis-full-mode="true"
            :labels="labels"
            :names="names"
            :values="values">
        <note :text="'Planos Vendidos'"></note>
        <tooltip :names="names" :position="'right'"></tooltip>
        <legends :names="names"></legends>
        <guideline :tooltip-y="true"></guideline>
    </graph-line>
  </div>
</template>

<script>

export default {
  data() {
    return {
        labels: [],
        names: [],
        values: []  
   
    };
  },
  created: function() {
     this.filter();
  },
  methods: {
      filter() {
          console.log('teste');
        let vThis = this;
        let url = '/report/line';
        axios.post(url)
              .then(function (response) {
                    
                  if (response.data.status == 'success') {

                    vThis.names = response.data.plans;                    
                    vThis.labels = response.data.labels;  
                    vThis.values = response.data.values; 

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