<a class="logout-btn" href='logout.php'>Logout</a>
<h1>Welkom op het netland beheerderspaneel</h1>

<style>
    .logout-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        padding: 10px;
        background-color: #5ca7e0;
    }
</style>

<?php

if(!isset($_COOKIE["loggedInUser"])) {
    header("Location: login.php");
}

$host = '127.0.0.1';
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt;
    if(isset($_GET["sort"])) {
        if($_GET["sort"] == "title") {
            $stmt = $pdo->query('SELECT type, title, rating FROM media ORDER BY title ASC');
        } else if($_GET["sort"] == "rating") {
            $stmt = $pdo->query('SELECT type, title, rating FROM media ORDER BY rating DESC');
        }
    } else {
        $stmt = $pdo->query('SELECT type, title, rating FROM media');
    }
    ?>
    <h2>Series</h2>
    <a href='toevoegen.php?type=serie'>Serie toevoegen</a>
    <?php
    if(isset($_GET["sortFilms"])) {  
        ?>
        <table>
            <tr>
                <th>
                    <a href='?sort=title&sortFilms=<?php echo $_GET["sortFilms"]; ?>' >Titel</a>
                </th>
                <th>
                    <a href='?sort=rating&sortFilms=<?php echo $_GET["sortFilms"]; ?>'>Rating</a>
                </th>
                <th>
                    Details
                </th>
            </tr>
        <?php
    } else {
        ?>
        <table>
            <tr>
                <th>
                    <a href='?sort=title' >Titel</a>
                </th>
                <th>
                    <a href='?sort=rating' >Rating</a>
                </th>
                <th>
                    Details
                </th>
            </tr>
        <?php
    }

    while($row = $stmt->fetch()) {
        if($row["type"] == "serie") {
            ?>
            <tr>
                <td>
                    <?php echo $row['title']; ?>
                </td>
                <td>
                    <?php echo $row['rating']; ?>
                </td>
                <td>
                    <a href='series.php?title=<?php echo $row['title']; ?>'>Meer Details</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <?php

    $stmt;
    if(isset($_GET["sortFilms"])) {
        if($_GET["sortFilms"] == "title") {
            $stmt = $pdo->query('SELECT type, title, duur FROM media ORDER BY title ASC');
        } else if($_GET["sortFilms"] == "duur") {
            $stmt = $pdo->query('SELECT type, title, duur FROM media ORDER BY duur DESC');
        }
    }else {
        $stmt = $pdo->query('SELECT type, title, duur FROM media');
    }

    ?>
    <h2>Films</h2>
    <a href='toevoegen.php?type=film'>Film toevoegen</a>
    <?php

    if(isset($_GET["sort"])) {
        ?>
        <table>
            <tr>
                <th>
                    <a href='?sort=<?php echo $_GET["sort"]; ?>&sortFilms=title' >Titel</a>
                </th>
                <th>
                    <a href='?sort=<?php echo $_GET["sort"]; ?>&sortFilms=duur' >Duur</a>
                </th>
                <th>
                    Details
                </th>
            </tr>
        <?php
    } else {
        ?>
        <table>
            <tr>
                <th>
                    <a href='?sortFilms=title' >Titel</a>
                </th>
                <th>
                    <a href='?sortFilms=duur' >Duur</a>
                </th>
                <th>
                    Details
                </th>
            </tr>
        <?php
    }

    while($row = $stmt->fetch()) {
        if($row["type"] == "film") {
            ?>
            <tr>
                <td>
                    <?php echo $row['title']; ?>
                </td>
                <td>
                    <?php echo $row['duur']; ?>
                </td>
                <td>
                    <a href='films.php?title=<?php echo $row['title']; ?>'>Meer Details</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
    </table>
    <?php
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>