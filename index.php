<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php 
        require 'menu.php';
        echo renderMenu();
        ?>
    </header>
    
    <main style="padding: 20px;">
        <?php
        $page = isset($_GET['p']) ? $_GET['p'] : 'viewer';
        $allowed_pages = ['viewer', 'add', 'edit', 'delete'];
        
        if (in_array($page, $allowed_pages)) {
            if ($page == 'viewer') {
                include 'viewer.php';
                $sort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
                $page_num = isset($_GET['pg']) ? max(0, intval($_GET['pg'])) : 0;
                echo getContactsList($sort, $page_num);
            } else {
                include $page . '.php';
            }
        } else {
            include 'viewer.php';
            echo getContactsList('byid', 0);
        }
        ?>
    </main>
    
    <footer style="width: 100%; height: 50px; background-color: rgb(92, 103, 168); position: fixed; bottom: 0; left: 0;">
    </footer>
</body>
</html>