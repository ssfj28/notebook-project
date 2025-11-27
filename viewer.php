<?php
function getContactsList($type = 'byid', $page = 0) {
    $mysqli = mysqli_connect('localhost', 'root', '', 'notebook');
    
    if (mysqli_connect_errno()) {
        return '<div class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</div>';
    }
    
    $order_by = '';
    switch($type) {
        case 'surname': $order_by = 'ORDER BY surname, name'; break;
        case 'date': $order_by = 'ORDER BY date'; break;
        default: $order_by = 'ORDER BY id';
    }
    
    $count_result = mysqli_query($mysqli, 'SELECT COUNT(*) as total FROM contacts');
    $total_row = mysqli_fetch_assoc($count_result);
    $total = $total_row['total'];
    
    if ($total == 0) {
        mysqli_close($mysqli);
        return '<div class="error">В таблице нет данных</div>';
    }
    
    $per_page = 10;
    $total_pages = ceil($total / $per_page);
    $offset = $page * $per_page;
    
    $sql = "SELECT * FROM contacts $order_by LIMIT $offset, $per_page";
    $result = mysqli_query($mysqli, $sql);
    
    if (!$result) {
        mysqli_close($mysqli);
        return '<div class="error">Ошибка выполнения запроса</div>';
    }
    
    $output = '<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
    $output .= '<tr style="background-color: #5c67a8; color: white;">';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Фамилия</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Имя</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Отчество</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Пол</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Дата рождения</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Телефон</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Адрес</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Email</th>';
    $output .= '<th style="padding: 10px; border: 1px solid #ddd;">Комментарий</th>';
    $output .= '</tr>';
    
    $row_count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $bg_color = ($row_count % 2 == 0) ? '#f9f9f9' : '#ffffff';
        $output .= '<tr style="background-color: ' . $bg_color . ';">';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['surname']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['name']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['lastname']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['gender']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['date']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['phone']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['location']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['email']) . '</td>';
        $output .= '<td style="padding: 10px; border: 1px solid #ddd;">' . htmlspecialchars($row['comment']) . '</td>';
        $output .= '</tr>';
        $row_count++;
    }
    
    $output .= '</table>';
    
    if ($total_pages > 1) {
        $output .= '<div class="pagination" style="text-align: center; margin: 20px 0;">';
        $output .= '<span>Страницы: </span>';
        for ($i = 0; $i < $total_pages; $i++) {
            if ($i == $page) {
                $output .= '<span class="current-page" style="display: inline-block; padding: 5px 10px; margin: 0 2px; background-color: #5c67a8; color: white;">' . ($i + 1) . '</span>';
            } else {
                $output .= '<a href="?p=viewer&sort=' . $type . '&pg=' . $i . '" class="page-link" style="display: inline-block; padding: 5px 10px; margin: 0 2px; background-color: #f0f0f0; color: #333; text-decoration: none; border: 1px solid transparent;">' . ($i + 1) . '</a>';
            }
        }
        $output .= '</div>';
    }
    
    mysqli_close($mysqli);
    return $output;
}
?>