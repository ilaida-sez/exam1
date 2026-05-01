<h1>Админка</h1>

<table border=1>
<tr><th>Курс</th><th>Пользователь</th><th>Статус</th><th>Действия</th></tr>
<?php foreach($applications as $app): ?>
    <tr>
        <td><?= $app->coursename ?></td>
        <td><?= $app->user->username ?></td>
        <td><?= $app->status ?></td>
        <td>
            <a href="index.php?r=site/change-status?id=<?= $app->id ?>&status=new">Новое</a>
            <a href="index.php?r=site/change-status?id=<?= $app->id ?>&status=studying">Обучение</a>
            <a href="index.php?r=site/change-status?id=<?= $app->id ?>&status=completed">Завершено</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>