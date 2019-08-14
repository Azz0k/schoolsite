<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<a href="?addjoke">Add your joke</a>
<p>All jokes in base:</p>
    <?php foreach ($result as $i):?>
    <blockquote>
        <p><?php echo htmlOut($i['joketext']); ?> </p>
        <form action="?" method="post">
            <input type="hidden" name="deljoke" value="<?php htmlOut($i['id']);?>">
            <input type="submit" value="Удалить">
        </form>
        <p>Автор: <a href="mailto:<?php htmlOut($i['email']);?>"> <?php htmlOut($i['name']);?></a></p>


    </blockquote>
    <?php endforeach; ?>


</body>

</html>