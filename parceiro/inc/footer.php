
    <!-- If you prefer jQuery these are the required scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="dist/js/vendor.js"></script>
    <script src="dist/js/adminx.js"></script>
    <script src="src/js/function.js?v=<?=filemtime('src/js/function.js')?>"></script>

        <script>

        $(document).ready(function() {
          var pagename = $("#pagename").attr('content');
          $("#li_"+pagename).addClass('active');
        });


        var options = {
            onKeyPress: function (cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('#cpf_cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('#cpf_cnpj').length > 11 ? $('#cpf_cnpj').mask('00.000.000/0000-00', options) : $('#cpf_cnpj').mask('000.000.000-00#', options);

          var choices = new Choices('.js-choice');

          var choices2 = new Choices('.js-choice-remove', {
            removeItemButton: true,
          });

          var cleave = new Cleave('.input-credit-card', {
            creditCard: true,
            onCreditCardTypeChanged: function (type) {
              // update UI ...
            }
          });

          var cleave2 = new Cleave('.input-date', {
            date: true,
            datePattern: ['Y', 'm', 'd']
          });

          var cleave3 = new Cleave('.input-numeral', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
          });

          var cleave = new Cleave('.input-prefix', {
              prefix: 'INVOICE-',
              uppercase: true
          });

          flatpickr(".date-default", {
            allowInput: true
          });
          flatpickr(".date-time", {
            allowInput: true,
            enableTime: true,
          });
          flatpickr(".date-human", {
            allowInput: true,
            altInput: true,
          });
          flatpickr(".date-inline", {
            allowInput: true,
            inline: true,
          });
        </script>

</html>
