<?php
Error_reporting(E_ALL);
$dbh = new PDO("mysql:host=localhost;dbname=global", "root", "");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<html>
    <head>
    </head>
    <body>
        <h1>Библиотека успешного человека</h1>
        <form action="" method="get" enctype="multipart/form-data">
            <input type="text" name="isbn" placeholder="ISBN"/>
            <input type="text" name="name" placeholder="Название книги"/>
            <input type="text" name="author" placeholder="Автор"/>
            <input type="submit" value="Поиск" />
            <a href="?isbn=&name=&author=">По умолчанию</a>
        </form>
    </body>
</html>
<?php

$sth = $dbh->prepare("SELECT * FROM books WHERE author LIKE ? AND isbn LIKE ? AND name LIKE ?");

if (isset($_GET["isbn"])) {
    $isbn = '%' . htmlspecialchars($_GET["isbn"]) . '%';
} else {
    $isbn = '%';
}
if (isset($_GET["name"])) {
    $name = '%' . htmlspecialchars($_GET["name"]) . '%';
} else {
    $name = '%';
}
if (isset($_GET["author"])) {
    $author = '%' . htmlspecialchars($_GET["author"]) . '%';
} else {
    $author = '%';
}

$sth->execute(array($author, $isbn, $name));

echo '<table border="1">';
echo '<tr>';
echo '<td>№</td>' . "\n";
echo '<td>Имя</td>' . "\n";
echo '<td>Автор</td>' . "\n";
echo '<td>Год издания</td>' . "\n";
echo '<td>ISBN</td>' . "\n";
echo '<td>Жанр</td>' . "\n";
echo '</tr>';

foreach ($sth as $key => $value) {
    echo '<tr>';
    echo '<td>' . $value['id'] . '</td>' . "\n";
    echo '<td>' . $value['name'] . '</td>' . "\n";
    echo '<td>' . $value['author'] . '</td>' . "\n";
    echo '<td>' . $value['year'] . '</td>' . "\n";
    echo '<td>' . $value['isbn'] . '</td>' . "\n";
    echo '<td>' . $value['genre'] . '</td>' . "\n";
    echo '</tr>';
}
echo '</table>';
