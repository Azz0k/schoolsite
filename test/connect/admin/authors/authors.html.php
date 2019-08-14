<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style type="text/css">
        textarea {
            display: block;
            width: 30%;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>E-mail</th>
    </tr>
    <?php foreach ($result as $i){?>
    <tr>
        <td><?php htmlOut($i['id']);?></td>
        <td><?php htmlOut($i['name']);?></td>
        <td><?php htmlOut($i['email']);?></td>
    </tr>
    <?php };?>
</table>
<p>Add author:</p>
<form action="?" method="post">
    <div>
        <label for="name">Type name</label>
        <textarea id="name" name="name" ></textarea>
        <label for="email">Type email</label>
        <textarea id="email" name="email" ></textarea>
    </div>
    <input type="submit" value="Add">

</form>


</body>

</html>