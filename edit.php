<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'notebook');

if (mysqli_connect_errno()) {
    echo '<div class="error">Ошибка подключения к БД</div>';
    exit();
}

if (isset($_POST['button']) && $_POST['button'] == 'Изменить запись' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
    $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
    $date = mysqli_real_escape_string($mysqli, $_POST['date']);
    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
    $location = mysqli_real_escape_string($mysqli, $_POST['location']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
    
    $sql = "UPDATE contacts SET 
            surname='$surname', name='$name', lastname='$lastname', 
            gender='$gender', date='$date', phone='$phone', 
            location='$location', email='$email', comment='$comment' 
            WHERE id=$id";
    
    if (mysqli_query($mysqli, $sql)) {
        echo '<div class="success">Данные успешно изменены</div>';
        $current_id = $id;
    } else {
        echo '<div class="error">Ошибка изменения данных</div>';
    }
}

$current_id = null;
$current_row = [];

if (isset($_GET['id'])) {
    $current_id = intval($_GET['id']);
} elseif (isset($_POST['id'])) {
    $current_id = intval($_POST['id']);
}

if ($current_id) {
    $result = mysqli_query($mysqli, "SELECT * FROM contacts WHERE id=$current_id");
    $current_row = mysqli_fetch_assoc($result);
}

if (!$current_row) {
    $result = mysqli_query($mysqli, "SELECT * FROM contacts ORDER BY surname, name LIMIT 1");
    $current_row = mysqli_fetch_assoc($result);
    if ($current_row) {
        $current_id = $current_row['id'];
    }
}

$contacts_result = mysqli_query($mysqli, "SELECT id, surname, name FROM contacts ORDER BY surname, name");

if (mysqli_num_rows($contacts_result) > 0) {
    echo '<div style="margin-bottom: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">';
    echo '<h3>Список контактов (для выбора нажмите на фамилию):</h3>';
    
    while ($row = mysqli_fetch_assoc($contacts_result)) {
        $full_name = $row['surname'] . ' ' . $row['name'];
        $is_current = ($current_row && $row['id'] == $current_row['id']);
        
        if ($is_current) {
            echo '<div style="padding: 10px; margin: 5px 0; background-color: red; color: white; border-radius: 5px; font-weight: bold;">';
            echo '✓ ' . $full_name;
            echo '</div>';
        } else {
            echo '<a href="?p=edit&id=' . $row['id'] . '" ';
            echo 'style="display: block; padding: 10px; margin: 5px 0; background-color: #5c67a8; color: white; text-decoration: none; border-radius: 5px;">';
            echo $full_name;
            echo '</a>';
        }
    }
    echo '</div>';
} else {
    echo '<div class="error">Записей пока нет</div>';
}

if ($current_row) {
    ?>
    <div style="max-width: 800px; margin: 30px auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h3 style="text-align: center; color: #5c67a8; margin-bottom: 30px;">Форма редактирования записи</h3>
        <form name="form_edit" method="post">
            <input type="hidden" name="id" value="<?= $current_row['id'] ?>">
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Фамилия *</label>
                        <input type="text" name="surname" value="<?= htmlspecialchars($current_row['surname']) ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Имя *</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($current_row['name']) ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Отчество</label>
                        <input type="text" name="lastname" value="<?= htmlspecialchars($current_row['lastname']) ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Пол *</label>
                        <select name="gender" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                            <option value="мужской" <?= $current_row['gender'] == 'мужской' ? 'selected' : '' ?>>мужской</option>
                            <option value="женский" <?= $current_row['gender'] == 'женский' ? 'selected' : '' ?>>женский</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Дата рождения</label>
                        <input type="date" name="date" value="<?= $current_row['date'] ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Телефон</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($current_row['phone']) ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 8px; font-weight: bold;">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($current_row['email']) ?>" 
                               style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                    </div>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Адрес</label>
                    <input type="text" name="location" value="<?= htmlspecialchars($current_row['location']) ?>" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Комментарий</label>
                    <textarea name="comment" 
                              style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; height: 120px; resize: vertical;"><?= htmlspecialchars($current_row['comment']) ?></textarea>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" value="Изменить запись" name="button" 
                            style="background-color: #28a745; color: white; padding: 15px 40px; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s;"
                            onmouseover="this.style.backgroundColor='#218838'" 
                            onmouseout="this.style.backgroundColor='#28a745'">
                        Изменить запись
                    </button>
                </div>
            </div>
        </form>
    </div>
    <?php
}