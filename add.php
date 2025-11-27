<?php

if (isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {
    $mysqli = mysqli_connect('localhost', 'root', '', 'notebook');
    
    if (!mysqli_connect_errno()) {
        $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
        $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
        $date = mysqli_real_escape_string($mysqli, $_POST['date']);
        $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $location = mysqli_real_escape_string($mysqli, $_POST['location']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
        
        $sql = "INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) 
                VALUES ('$surname', '$name', '$lastname', '$gender', '$date', '$phone', '$location', '$email', '$comment')";
        
        if (mysqli_query($mysqli, $sql)) {
            echo '<div class="success">Запись добавлена</div>';
        } else {
            echo '<div class="error">Ошибка: запись не добавлена</div>';
        }
        
        mysqli_close($mysqli);
    } else {
        echo '<div class="error">Ошибка подключения к БД</div>';
    }
}
?>

<div style="max-width: 800px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h3 style="text-align: center; color: #5c67a8; margin-bottom: 30px;">Форма добавления новой записи</h3>
    
    <form name="form_add" method="post">
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Фамилия *</label>
                    <input type="text" name="surname" placeholder="Введите фамилию" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Имя *</label>
                    <input type="text" name="name" placeholder="Введите имя" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Отчество</label>
                    <input type="text" name="lastname" placeholder="Введите отчество" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Пол *</label>
                    <select name="gender" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;" required>
                        <option value="">Выберите пол</option>
                        <option value="мужской">мужской</option>
                        <option value="женский">женский</option>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Дата рождения</label>
                    <input type="date" name="date" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Телефон</label>
                    <input type="text" name="phone" placeholder="+7-999-123-45-67" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: bold;">Email</label>
                    <input type="email" name="email" placeholder="example@mail.ru" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">Адрес</label>
                <input type="text" name="location" placeholder="Город, улица, дом" 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">Комментарий</label>
                <textarea name="comment" placeholder="Введите дополнительную информацию" 
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; height: 120px; resize: vertical;"></textarea>
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" value="Добавить запись" name="button" 
                        style="background-color: #5c67a8; color: white; padding: 15px 40px; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s;"
                        onmouseover="this.style.backgroundColor='#4a5599'" 
                        onmouseout="this.style.backgroundColor='#5c67a8'">
                    Добавить запись
                </button>
            </div>
        </div>
    </form>
</div>