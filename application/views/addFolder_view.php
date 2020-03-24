<h2 class = "title">Создание раздела</h2>
<div class = "navigation">
    <a href="<?=$data['back_url']?>" class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
    <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
</div>
<form class="form" method="POST" action="/createFolder/">
    <label for="name">Название: <input class="required_field" name="name" type="text" id="name" placeholder="Название"/></label>
    <span class="error"><?php if (!empty($data['err'])) echo '* ' . $data['err']; ?></span>
    <label for="description">Описание: <input name="description" type="text" id="description" placeholder="Описание"/></label>
    <input name="parent_ID"  type="hidden" value="<?=$data['parent']?>"/>
    <input type="submit" value="Создать" />
</form>