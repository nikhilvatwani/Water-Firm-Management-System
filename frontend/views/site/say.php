<?php
use yii\helpers\Html;
use yii\web\View;
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css', ['position' => \yii\web\View::POS_HEAD]);
?>


<article>
            <div class="demo">
                <h2>Basic Example</h2>
                <p><input id="basicExample" type="text" class="time" /></p>
            </div>

            <script>
                $(function() {
                    $('#basicExample').timepicker();
                });
            </script>

            <pre class="code" data-language="javascript">$('#basicExample').timepicker();</pre>
</article>
<?php $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js'); ?>