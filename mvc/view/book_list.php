

<html>
    <head></head>
    <body>
        <table>
            <tbody>
                <tr>
                    <td>Tile</td>
                    <td>Author</td>
                    <td>Description</td>
                </tr>

                <?php
                foreach ($books as $book) {
                    echo '<tr><td><a href="index.php?book=' . $book->title . '">' . $book->title . '</a></td><td>' . $book->author . '</td><td>' . $book->desc . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
