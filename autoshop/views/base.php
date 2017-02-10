<?php ?>
<div> Статус:
    <?php if (isset($result)):?>
        <?php if ($result['status'] == 'success'):?>
            <div>
             Данные введены
            </div>
        <?php else:?>
            <div color="red">
                Ошибка
            </div>
        <?php endif ?>
    <?php else:?>
        <div>
            Введите данные
        </div>
    <?php endif ?>
</div>
<br>
<div class="row">
    <div class="well col-md-8 col-md-offset-2">
        <form method="post" action="/base" name="base" id="base">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="form-group">
                        <label for="name">Наименование автомобиля:</label>
                        <input required name="name" type="text" class="form-control" id="name" placeholder="Введите название">
                    </div>
                    <div class="form-group">
                        <label for="category">Категория:</label>
                        <select name="category[]" id="category">
                            <option value="Седан">седан</option>
                            <option value="Хэтчбек">хэтчбек</option>
                            <option value="Купэ">купэ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Подкатегория:</label>
                        <div class="checkbox subcat">
                            <label>
                                <input class="check" name="subcategory[alloyWheels]" type="checkbox" value="1"> 17R Литые диски
                            </label>
                            <label>
                                <input class="check" name="subcategory[electricMirrors]" type="checkbox" value="1"> Электроподъемники всех стекол
                            </label>
                            <label>
                                <input class="check" name="subcategory[mats]" type="checkbox" value="1"> Коврики
                            </label>
                            <label>
                                <input class="check" name="subcategory[display]" type="checkbox" value="1"> Дисплей 8 дюймов
                            </label>
                            <label>
                                <input class="check" name="subcategory[autoPlay]" type="checkbox" value="1"> Автозапуск автомобиля
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 col-md-offset-5">
                    <button type="submit" class="submit-button btn-lg">
                        Добавить
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>