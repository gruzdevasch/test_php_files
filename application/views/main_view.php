<h2 class = "title">Файловый менеджер</h2>
<div class = "controls">
    <a class="control-icon icon-new-directory" href="/addDirectory/<?php echo $data['directory']?>" > <span class="tooltiptext">Добавить раздел</span></a>
    <a class="control-icon icon-new-element" href="/addElement/<?php echo $data['directory']?>" ><span class="tooltiptext">Добавить элемент</span></a>
    <a href="/" class = "control-icon icon-home"><span class="tooltiptext">В начало</span></a>
    <a href="<?php echo $data['back_url'] ?>" class = "control-icon icon-back"><span class="tooltiptext">Наверх</span></a>
</div>
<div class = "directories">
    <?php
    foreach ($data['directories'] as $row) {
        echo '<a href="' . $row['url'] . '" class = "directory" id=' . $row['id'] . '>';
        echo '<div class = "icon icon-directory"></div>';
        echo " <div class = 'icon-name'> " . $row['name'] . "</div>";
        echo "<div class = 'tooltiptext'>";
        echo "Номер раздела: " . $row['id'] . "<br/>";
        if ($row['description'])
            echo "Описание раздела: " . $row['description'] . "<br/>";
        echo "Дата создания: " . date('d.m.Y H:i', strtotime($row['creation_date'])) . "<br/>";
        echo "Дата изменения: " . date('d.m.Y H:i', strtotime($row['modification_date'])) . "<br/>";
        echo '</div>';

        echo '</a>';
    }
    foreach ($data['items'] as $row) {
        echo '<div class = "element" id=' . $row['id'] . '>';
        echo '<div class = "icon icon-element"></div>';
        /* echo " id = " . $row['id'] . "\n"; */
        echo " <div class = 'icon-name'> " . $row['name'] . "</div>";

        echo "<div class = 'tooltiptext'>";
        echo "Дата создания: " . date('d.m.Y H:i', strtotime($row['creation_date'])) . "<br/>";
        echo "Дата изменения: " . date('d.m.Y H:i', strtotime($row['modification_date'])) . "<br/>";
        echo "Тип: " . $row['type'] . "<br/>";
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>