<template>
  <div id="">
    <graph-bubble
            :width="450"
            :height="350"
            :axis-min="0"
            :axis-max="50"
            :axis-interval="1000 * 60 * 60 * 24"
            :axis-format="'dd/M'"
            :display="'max'"
            :active-event="'click'"
            :show-text="true"
            :labels="labelsBubble"                
            :values="valuesBubble">
        <note :text="'Check in por dia'" :align="'left'"></note>
        <legends :names="[ 'Date', 'Total' ]"></legends>
    </graph-bubble>
  </div>
</template>

<script>

export default {
  data() {
    return {
        labelsBubble: [],
        valuesBubble: []
   
    };
  },
  created: function() {
      this.filter();
  },
  methods: {
      filter() {
          console.log('teste');
        let vThis = this;
        let url = '/stats/bubble';
        axios.post(url)
              .then(function (response) {
                    
                  if (response.data.status == 'success') {

                    
                    vThis.labelsBubble = [new Date(response.data.start), new Date(response.data.end)];
                    
                    
                    
                    let items = [];
                    $.each(response.data.data, function(index, value) {
                      items.push([new Date(value[0]), value[1]]);
                    });

                    vThis.valuesBubble = items;                    

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