<style>
        body {
            background: #e3e3e3;
        }
        a {
            padding: 7px;
            /* margin: 5px 0; */
            background: #5f3482de;
            display: flex;
            flex-direction: column;
            color: white;
            font-weight: bold;
            text-decoration: none;
            text-transform: uppercase;
        }
        .active {
            background: #461e67de;
            color: yellow;
        }
</style>
<a class="<?php echo ($page == '1' ? "active" : "")?>" href="1.php">1 - Noms des pays européens</a>
<a class="<?php echo ($page == '2' ? "active" : "")?>" href="2.php">2 - Noms et superficie des pays africains triés par superficie de la 10ème à la 22ème position</a>
<a class="<?php echo ($page == '3' ? "active" : "")?>" href="3.php">3 - Toutes les infos disponibles sur un pays donné</a>
<a class="<?php echo ($page == '4' ? "active" : "")?>" href="4.php">4 - Noms des pays ayant le néerlandais parmi leurs langues officielles</a>
<a class="<?php echo ($page == '5' ? "active" : "")?>" href="5.php">5 - Noms des pays qui commencent par une lettre donnée</a>
<a class="<?php echo ($page == '6' ? "active" : "")?>" href="6.php">6 - Noms et superficie des pays ayant une superficie entre 400000 et 500000 km2</a>

