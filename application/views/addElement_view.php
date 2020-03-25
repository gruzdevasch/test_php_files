<h2 class = "title">Создание элемента</h2>
<div class = "navigation">
    <a href="<?= $data['back_url'] ?>" class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
    <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
</div>
<form class="form" method="POST" action="/createElement/">
    <label for="name">Название: <input class="required_field" id="name" name="name" type="text" placeholder="Название"/> </label>
    <div class="error"><?php if (!empty($data['err'])) echo '* ' . $data['err']; ?></div>
    <label for="type">Тип:
        <select name="type" id="type">
            <option value="News" selected="selected">Новость</option>
            <option value="Article">Статья</option>
            <option value="Review">Обзор</option>
            <option value="Comment">Комментарий</option>
        </select>
    </label>
    <label for="data">Содержимое:
        <textarea name="data" placeholder="Содержимое" id='data'></textarea>
    </label>
    <input name="directory_ID"  type="hidden" value="<?= $data['parent'] ?>"/>
    <input type="submit" value="Создать" />
</form>