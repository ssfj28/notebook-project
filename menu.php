<?php
function renderMenu() {
    $current_page = isset($_GET['p']) ? $_GET['p'] : 'viewer';
    
    $menu = '<nav style="background-color: #5c67a8; padding: 10px; text-align: center;">';
    
    $menu_items = [
        'viewer' => 'Просмотр',
        'add' => 'Добавление записи', 
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    foreach ($menu_items as $key => $value) {
        $active = ($current_page == $key) ? 'style="background-color: red; color: white;"' : 'style="background-color: #5c67a8; color: white;"';
        $menu .= '<a href="?p=' . $key . '" ' . $active . ' class="menu-item">' . $value . '</a>';
    }
    
    $menu .= '</nav>';
    
    if ($current_page == 'viewer') {
        $current_sort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
        
        $menu .= '<div class="submenu" style="background-color: #5c67a8; padding: 5px; text-align: center; font-size: 14px;">';
        $sort_items = [
            'byid' => 'По-умолчанию',
            'surname' => 'По фамилии',
            'date' => 'По дате рождения'
        ];
        
        foreach ($sort_items as $key => $value) {
            $active = ($current_sort == $key) ? 'style="background-color: red; color: white;"' : 'style="background-color: #5c67a8; color: white;"';
            $menu .= '<a href="?p=viewer&sort=' . $key . '" ' . $active . ' class="submenu-item">' . $value . '</a>';
        }
        
        $menu .= '</div>';
    }
    
    return $menu;
}
?>