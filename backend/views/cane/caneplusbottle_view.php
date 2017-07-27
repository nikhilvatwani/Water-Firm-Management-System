<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php


use kartik\tabs\TabsX;

$this->title = 'Stock';

echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' => [
        [
            'label' => 'Canes',
            'content' => $this->render('index',['searchModel'=>$searchModel,'dataProvider'=>$dataProvider]),
            'active' => true
        ],
        [
            'label' => 'Bottles',
            'content' => $this->render('//bottle/index',['searchModel'=>$searchModelBottle,'dataProvider'=>$dataProviderBottle]),
        ],
    ],
]);
?>