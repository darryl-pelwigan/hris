<!-- javascripts -->
    <script src="<?=base_url()?>assets/NiceAdmin/js/jquery.js"></script>
    <script src="<?=base_url()?>assets/NiceAdmin/js/jquery-ui-1.10.4.min.js"></script>
    <script src="<?=base_url()?>assets/NiceAdmin/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/NiceAdmin/js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="<?=base_url()?>assets/NiceAdmin/js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="<?=base_url()?>assets/NiceAdmin/js/jquery.scrollTo.min.js"></script>
    <script src="<?=base_url()?>assets/NiceAdmin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="<?=base_url()?>assets/NiceAdmin/js/scripts.js"></script>
  <script>

      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
    $(function(){
      $('#map').vectorMap({
        map: 'world_mill_en',
        series: {
          regions: [{
            values: gdpData,
            scale: ['#000', '#000'],
            normalizeFunction: 'polynomial'
          }]
        },
        backgroundColor: '#eef3f7',
        onLabelShow: function(e, el, code){
          el.html(el.html()+' (GDP - '+gdpData[code]+')');
        }
      });
    });



  </script>

  </body>
</html>