<?php
use dosamigos\datepicker\DateRangePicker;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
              // 'action' => ['index'],
              // 'method' => 'get',
              'id'=>$formName
          ]); ?>
       <?= DateRangePicker::widget([
    'name' => 'date_from',
    'value' => date("Y-m-d"),
    'nameTo' => 'name_to',
    'valueTo' =>  date("Y-m-d"),
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
    ]
]);?>    
<br>      <div class="text-center">      
          <button type="submit" id=<?=$button?> url=<?=$url ?> class="btn btn-success reportBtn"  formtarget="_blank">Submit</button>
          <button type="input" id=<?=$button."reset"?>  class="btn btn-warning reportBtn"  >Reset</button>
          </div>
      <?php ActiveForm::end(); ?>

<?php
$this->registerJs('
var button = "'.$button.'"; 
var resetButton = "'.$button."reset".'"; 
 

$(document).on("click",`#${button}`,function(){
  event.preventDefault();
  var form = "'.$formName.'";
  // var name= form.attr("name");
  form = $(`#${form}`);
  var url =$(this).attr("url");
  console.log(url);
  // return false;
  var endDate = $(`input[name="name_to"]`,form).val(); 
  var startDate = $(`input[name="date_from"]`,form).val(); 
  var div ="'.$div.'"; 

  
 
  // return false;
  if(!startDate || !endDate)
    return false;

  url = `${url}&startDate=${startDate}&endDate=${endDate}`;

  $(`#${div}`).load(url);
});
$(document).on("click",`#${resetButton}`,function(){
  console.log("1");
  event.preventDefault();
  var form = "'.$formName.'";
  form = $(`#${form}`);
  var date = "'.date("Y-m-d").'";
  var endDate = $(`input[name="name_to"]`,form).val(date); 
  var startDate = $(`input[name="date_from"]`,form).val(date); 
});


');