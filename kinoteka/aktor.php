<?php
$host = 'localhost';
$user = 'root';
$passwd = '';
$database = 'kino';

$connect = new mysqli($host, $user, $passwd, $database);

if ($connect->connect_errno) {
    die("nie udało się połączyć: ". $connect->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Informacje o aktorze | KinoTEKA</title>
</head>
<body>
    <header id="header1">
        <h2><a href="index.php">KinoTEKA</a></h2>
    </header>
    <header id="header2">
        <p><em>W naszej bazie znajdują się najelpsi aktorzy</em></p>
    </header>
    <main>


<div class="wszyscy-aktorzy">
    <?php
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $sql = "SELECT imie, nazwisko, plik_awatara
                FROM aktorzy
                WHERE id_aktora = ?";

        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $aktor = $result->fetch_assoc();

        if ($aktor) {
            $imie = $aktor['imie'];
            $nazwisko = $aktor['nazwisko'];

            echo "<div class='pojedynczy-aktor'>";
            echo "<img src='" . htmlspecialchars($aktor['plik_awatara']) .
                 "' alt='" . htmlspecialchars("$imie $nazwisko") .
                 "' title='" . htmlspecialchars("$imie $nazwisko") . "'>";
            echo "<h1>" . htmlspecialchars("$imie $nazwisko") . "</h1>";
            echo "</div>";
        }

        $stmt->close();
    }
    ?>
</div>
<?php
if (isset($_GET['id']) && isset($imie)) {
    $sql = "SELECT f.id_filmu, f.tytul, f.rok_produkcji
            FROM filmy f
            JOIN filmy_aktorzy fa ON f.id_filmu = fa.id_filmu
            WHERE fa.id_aktora = ?";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $liczba = $result->num_rows;

    if ($liczba == 0) {
        echo "<p>" . htmlspecialchars($imie) .
             " nie znajduje się na listach obsady znanych nam produkcji.</p>";
    } else {
        echo "<p>" . htmlspecialchars($imie) .
             " znajduje się na listach obsady " . $liczba .
             " znanych nam produkcji.</p>";
    }

    $stmt->close();
}
?>
    </main>
    <footer>
        <p><b>Autor:Michał Świstak</b></p>
    </footer>

</body>
</html>

<?php 
    $connect->close();
?>