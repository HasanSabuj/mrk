    
    <script>
        var base_url="<?php echo base_url();?>";
    </script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>public/js/main.js"></script>
    <?php
        if(isset($page_script)){
            echo $page_script;
        }
    ?>
    <script src="<?php echo base_url();?>public/js/custom.js"></script>

    <script type="text/javascript">
        var months = [
            'January', 'February', 'March', 'April', 'May',
            'June', 'July', 'August', 'September',
            'October', 'November', 'December'
            ];

        function monthNumToName(monthnum) {
            return months[monthnum - 1] || '';
        }
        function monthNameToNum(monthname) {
            var month = months.indexOf(monthname);
            return month ? month + 1 : 0;
        }

        function buildRequestStringData(form) {
            var select = form.find('select'),
                input = form.find('input'),
                requestString = '[';
            for (var i = 0; i < select.length; i++) {
                requestString += '"' + $(select[i]).attr('name') + '": "' +$(select[i]).val() + '",';
            }
            if (select.length > 0) {
                requestString = requestString.substring(0, requestString.length - 1);
            }
            for (var i = 0; i < input.length; i++) {
                if ($(input[i]).attr('type') !== 'checkbox') {
                    var value=$(input[i]).val();
                    value=value.replace(/^"|"$/g, '');;
                    requestString += '{"label":"' + $(input[i]).attr('name') + '","value":"' + value + '","required":"'+$(input[i]).attr('data-required')+'"},';
                } else {
                    if ($(input[i]).attr('checked')) {
                        requestString += '"' + $(input[i]).attr('name') +'":"' + $(input[i]).val() +'",';
                    }
                }
            }
            if (input.length > 0) {
                requestString = requestString.substring(0, requestString.length - 1);
            }
            requestString += ']';
            return requestString;
        }
    </script>
    <?php
        if(isset($last_script)){
            echo $last_script;
        }
    ?>