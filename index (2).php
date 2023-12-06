<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List tv</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        *{
            box-sizing: border-box;
            margin: 0px;
            padding: 0px;

        }

        a{
            text-decoration: none;
            color: #000;
        }

        h3{color: #fff;}

        .grid{
            grid-template-columns: 100%;
            grid-template-areas:
            "header"
            "main"
            "footer";
        }

        header{
        grid-area: header;
        }

        nav{
        grid-area: nav;
        }

        main{
        grid-area: main;
        }

        aside{
        grid-area: aside;
        }

        footer{
        grid-area: footer;
        }

       
        main .search{
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }


        main .search input{
            width: 80%;
            height: 40px;
            margin-bottom: 20px;
        }

        main .container aside{
            width: 100%;
            margin-bottom: 20px;
        }

        main .container aside a{
            width: 100%;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        main .marque{
            overflow: hidden;
            text-align: center;

            margin-bottom: 20px;
            padding: 10px;
            display: flex;
        }

        main .marque a{
           text-decoration: none;
           width: 50%;

        }
       




        @media only screen and (min-width: 968px) {

            .grid{
            grid-template-columns: 1fr 3fr;
            grid-template-areas:
            "header header"
            "nav main"
            "aside aside"
            "footer footer";
        }

        main .search{
            background-color:bisque;
            width: 100%;
            display: flex;
            flex-wrap: nowrap;
            flex-direction: row;
            justify-content: center;
            
        }

        main .search div{
        
        }

        main .search:last-of-type{
            justify-content: flex-end;
            text-align: right;
        }

        main header, footer{
            text-align: center;
        }

        
        .container{
            display: flex;
            flex-wrap: nowrap;
            flex-direction: row;
        }

        main .container aside{
            width: 30%;
            padding: 20px;
        }

        main .container aside a{
            text-decoration: none;
            width: 100%;
            display: inline-block;
            color: #000;
            margin-bottom: 20px;
        }

        main .container section{
            background-color:darkseagreen;
            width: 70%;
            padding: 20px;
        }

        

        }

    </style>
</head>

<body class="grid">
    <main>
        <header>
            <p>Header</p>
        </header>

        <div class="search">
            <div>
                <h3>Recherchez un téléviseur</h3>
            </div>

            <div>
                <form action="">
                    <input type="text" placeholder="Entez votre mot clé">
                </form>
            </div>

            <div>
                <a href="">Mon profil</a>
                <a href="">Déconnexion</a>
            </div>

        </div>

        <div class="marque">
            <a href="">Sony</a>
            <a href="">Philips</a>
            <a href="">Samsung</a>
            <a href="">Lg</a>
            <a href="">Toshiba</a>
        </div>

        <div class="container">
            <aside>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Categorie
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <a href="">Modèle</a>
                        <a href="">Taille</a>
                        <a href="">Résolution</a>
                        <a href="">Fréquence</a>
                        <a href="">Type d'écran</a>
                        <a href="">HDR</a>
                        <a href="">Smart</a>
                        <a href="">Système d'exploitation</a>
                        <a href="">Port</a>
                        <a href="">Garantie</a>
                    </div>
                </div>
            </div>
            
                        

            </aside>

            <section>

            </section>
        </div>

       

        <footer>
            <p>Footer</p>
        </footer>
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>