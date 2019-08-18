<?php include 'panelheader.html.php';?>

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Тут что-то прикрутим попозже</h1>
    </div>
    <div id="menu"></div>
    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-sm-24" id="root">
                <h2>тут контейнер</h2>
            </div>
        </div>
    </div>

<script type="text/babel">
    ReactDOM.render(<Navbar/>, document.getElementById('menu'));
</script>

<script src="../includes/html/panel.js"></script>
<?php include 'footer.html.php';?>
