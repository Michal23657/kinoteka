
<?php
$host = 'localhost';
$user = 'root';
$passwd = '';
$database = 'kino';

$connect = new mysqli($host, $user, $passwd, $database);

if ($connect->connect_errno) {
    die("Nie udało się połączyć: " . $connect->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista aktorów | KinoTEKA</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header id="header1">
        <h2><a href="index.php">KinoTEKA</a></h2>
    </header>

    <header id="header2">
        <p><em>W naszej bazie znajdują się najlepsi aktorzy</em></p>
    </header>

    <main>
        <h1 id="h1">Najlepsi aktorzy tylko w naszym kinie</h1>

        <?php
        $sql = "SELECT * FROM aktorzy ORDER BY nazwisko, imie";
        $result = $connect->query($sql);
        ?>

        <div class="wszyscy-aktorzy">
            <?php while ($aktor = $result->fetch_assoc()) { ?>
                <a href="aktor.php?id=<?php echo $aktor['id_aktora']; ?>"
                   class="link-aktor">

                    <div class="pojedynczy-aktor">
                        <img
                            src="<?php echo htmlspecialchars($aktor['plik_awatara']); ?>"
                            alt="Awatar aktora"
                            title="<?php echo htmlspecialchars($aktor['imie'] . ' ' . $aktor['nazwisko']); ?>"
                        >

                        <p>
                            <?php
                            echo htmlspecialchars(
                                $aktor['imie'] . ' ' . $aktor['nazwisko']
                            );
                            ?>
                        </p>
                    </div>

                </a>
            <?php } ?>
        </div>
    </main>

    <footer>
        <p><b>Autor: Michał Świstak</b></p>
    </footer>
</body>
</html>

<?php
$connect->close();
?>
