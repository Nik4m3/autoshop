<?php
extract($tableBody);
$cleanData = [];
foreach ($tableBody as $value) {
    $tempArray = [];
    foreach ($value as $key => $meaning) {
        if (!is_int($key)) {
            $tempArray[$key] = $meaning;
        }
    }
    $cleanData[] = $tempArray;
}
?>

<div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <?php foreach ($tableHeaders as $value): ?>
                <th><?=$value?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <form action="/remove" method="post" name="remove" id="remove">
            <tbody>
            <?php foreach ($cleanData as $value): ?>
                <tr>
                    <?php foreach ($value as $key => $meaning): ?>
                        <?php if ($key == 'id'): ?>
                            <td><?=$meaning;?> <input type="checkbox" name="id[]" id="id" value="<?=$meaning?>"></input></td>
                        <?php elseif (!$meaning): ?>
                            <td></td>
                        <?php elseif ($key != 'id' && $meaning == '1'): ?>
                            <td><span class="glyphicon glyphicon-ok"></span></td>
                        <?php else: ?>
                            <td><?=$meaning?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <button type="submit" class="btn-primary sell-btn">
                <span class="glyphicon glyphicon-trash"></span> Удалить
            </button>
        </form>

    </table>
</div>