<h2 class = "title">Изменение элемента</h2>
<div class = "navigation">
    <a href="<?= $data['back_url'] ?>" class= "control-icon icon-back"><span class="tooltiptext">Назад</span></a>
    <a href="/" class= "control-icon icon-home"><span class="tooltiptext">Главная</span></a>
</div>
<form class="form" method="POST" action="/alterElement/">
    <label for="name">Название: 
        <input class="required_field" id="name" name="name" type="text" placeholder="Название" 
            <?php if (!empty($data['cur_name'])) echo "value='". $data['cur_name'] ."'" ?>/> 
    </label>
    <div class="error"><?php if (!empty($data['err'])) echo '* ' . $data['err']; ?></div>
    <label for="type">Тип:
        <select name="type" id="type">
            <option value="News" <?= $data['cur_type'] == 'News' ? ' selected="selected"' : ''; ?>>Новость</option>
            <option value="Article" <?= $data['cur_type'] == 'Article' ? ' selected="selected"' : ''; ?>>Статья</option>
            <option value="Review" <?= $data['cur_type'] == 'Review' ? ' selected="selected"' : ''; ?>>Обзор</option>
            <option value="Comment" <?= $data['cur_type'] == 'Comment' ? ' selected="selected"' : ''; ?>>Комментарий</option>
        </select>
    </label>
    <label for="data">Содержимое:
        <textarea name="data" placeholder="Содержимое" id='data' ><?php if (!empty($data['cur_data'])) echo $data['cur_data']?></textarea>
    </label>
    <input name="folder_ID"  type="hidden" value="<?= $data['parent'] ?>"/>
    <input name="ID"  type="hidden" value="<?=$data['id']?>"/>
    <input type="submit" value="Изменить" />
</form>