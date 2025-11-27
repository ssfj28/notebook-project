<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'notebook');

if (mysqli_connect_errno()) {
    echo '<div class="error">Ошибка подключения к БД</div>';
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $result = mysqli_query($mysqli, "SELECT surname, name, lastname FROM contacts WHERE id=$delete_id");
    $contact = mysqli_fetch_assoc($result);
    
    if ($contact) {
        $surname = $contact['surname'];
        $delete_result = mysqli_query($mysqli, "DELETE FROM contacts WHERE id=$delete_id");
        
        if ($delete_result) {
            echo '<div class="success" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">';
            echo 'Запись с фамилией ' . htmlspecialchars($surname) . ' удалена';
            echo '</div>';
        } else {
            echo '<div class="error">Ошибка удаления записи</div>';
        }
    }
}

$result = mysqli_query($mysqli, "SELECT id, surname, name, lastname FROM contacts ORDER BY surname, name");

echo '<div style="max-width: 600px; margin: 0 auto;">';
echo '<h3>Выберите запись для удаления:</h3>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $initials = $row['surname'];
        if (!empty($row['name'])) {
            $initials .= ' ' . mb_substr($row['name'], 0, 1) . '.';
        }
        if (!empty($row['lastname'])) {
            $initials .= mb_substr($row['lastname'], 0, 1) . '.';
        }
        
        echo '<a href="?p=delete&delete_id=' . $row['id'] . '" ';
        echo 'style="display: block; padding: 12px; margin: 8px 0; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; text-align: center;" ';
        echo 'onclick="return confirm(\'Вы действительно хотите удалить запись ' . htmlspecialchars($initials) . '?\')">';
        echo htmlspecialchars($initials);
        echo '</a>';
    }
} else {
    echo '<div class="error">Записей пока нет</div>';
}

echo '</div>';

mysqli_close($mysqli);
?>