<h2 class = "title">Изменение раздела</h2>
<div class = "navigation">
    <a href="<?=$data['back_url']?>" class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
    <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
</div>
<form class="form" method="POST" action="/alterFolder/">
    <label for="name">Название: 
        <input class="required_field" name="name" type="text" id="name" placeholder="Название" <?php if (!empty($data['cur_name'])) echo "value='". $data['cur_name'] ."'" ?>/>
    </label>
    <span class="error"><?php if (!empty($data['err'])) echo '* ' . $data['err']; ?></span>
    <label for="description">Описание: 
        <input name="description" type="text" id="description" placeholder="Описание" <?php if (!empty($data['cur_desc'])) echo "value='". $data['cur_desc'] ."'" ?>/>
    </label>
    <input name="parent_ID"  type="hidden" value="<?=$data['parent']?>"/>
    <input name="ID"  type="hidden" value="<?=$data['id']?>"/>
    <input type="submit" value="Изменить" />
</form>