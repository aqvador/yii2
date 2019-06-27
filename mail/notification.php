<?php
/**
 * @var $model \app\models\uploadphoto\OrderPhoto
 */

?>

<style>
  table {
	  margin: 50px 0;
	  text-align: center;
	  border-collapse: separate;
	  border: 1px solid #ddd;
	  border-spacing: 10px;
	  border-radius: 3px;
	  background: #fdfdfd;
	  font-size: 14px;
	  width: auto;
  }

  td, th {
	  border: 1px solid #ddd;
	  padding: 5px;
	  border-radius: 3px;
  }

  th {
	  background: #E4E4E4;
  }

</style>
<h3>Ваш заказ:</h3>
	<table>
		<tr>
    		<th>Формат бумаги</th>
    		<th>Тип бумаги</th>
    		<th>Кол-во отпечатков</th>
    		<th>Цена 1 отпечатка</th>
			<th>Сумма</th>
  		</tr>
<?php foreach ($model->realPrice as $k => $product) : ?>

    <?php foreach ($product as $kp => $item) : ?>
		<tr>
    	<td><?= $k ?></td>
    	<td><?= ($kp == 'glossy') ? 'Глянцевая' : 'Матовая' ?></td>
    	<td><?= $item['pcs'] ?> шт.</td>
    	<td><?= $item['sum'] / $item['pcs'] ?> руб.</td>
		<td><?= $item['sum'] ?> руб.</td>
  	</tr>
    <?php endforeach; ?>

<?php endforeach; ?>
		<td></td>
    	<td></td>
    	<td></td>
    	<td>Итого:</td>
		<td><?= $model->totalPrice ?> руб</td>
</table>
<br>
<h3>Спасибо за Ваш заказ!</h3>
<h4>Наш менеджер в ближайшее время с Вами свяжется по телефону <?='8'.substr($model->phone,-10)?></h4>
