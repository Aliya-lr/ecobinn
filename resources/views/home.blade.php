<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoBin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=K2D:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            @if ($isLoggedIn)
                <a href="{{ route('logout') }}" class="nav-link" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Выйти
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Вход</a>
                <a href="{{ route('register') }}" class="nav-link">Регистрация</a>
            @endif
            @if ($isAdmin)
            <a href="{{ route('articles.create') }}" class="nav-link">Создать статью</a>
            @endif
            <a href="{{ route('map') }}" class="nav-link">Карта</a>
        </nav>
    </header>

    <section class="promo-header">
        <div class="promo-wrapper">
            <div class="promo-content">
                <h1>EcoBin</h1>
                <p class="subtitle">Сортируй сегодня - чистая планета завтра!</p>
            </div>
            <div class="promo-image">
                <img src="{{ asset('static/h1.png') }}" alt="Promo">
            </div>
        </div>
    </section>

      <!-- Форма для отправки статьи -->
      <section class="submit-article">
        <h2>Напишите свою статью</h2>
        <form action="{{ route('articles.submit') }}" method="POST">
            @csrf
            <label for="title">Заголовок:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="content">Содержание:</label><br>
            <textarea id="content" name="content" rows="10" required></textarea><br><br>

            <button type="submit">Отправить</button>
        </form>
    </section>

    <!-- Отображение статей -->
    <section class="latest-articles">
        <h2>Последние статьи</h2>
        <?php
        // Обработка отправки статьи
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = htmlspecialchars($_POST['title']);
            $content = htmlspecialchars($_POST['content']);

            // Форматируем статью для записи в файл
            $article = "Заголовок: $title\nСодержание: $content\n\n";

            // Сохраняем статью в файл
            file_put_contents('articles.txt', $article, FILE_APPEND | LOCK_EX);

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Чтение статей из файла
        $articles = file_exists('articles.txt') ? file_get_contents('articles.txt') : "Нет статей на рассмотрении.";
        ?>

        <?php if ($articles): ?>
            <pre><?php echo nl2br(htmlspecialchars($articles)); ?></pre>
        <?php else: ?>
            <p>Нет статей на рассмотрении.</p>
        <?php endif; ?>
    </section>


    <section class="impact">
        <h2 class="section-title">Мусор оказывает значительное влияние на окружающую среду и здоровье человека</h2>
        <div class="cards-row">
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r11.png') }}" alt="Image 1">
                </div>
                <div class="divider"></div>
                <p>Площадь мусорных полтигонов в России превышает 4 миллиона гектаров, что сопоставимо с территорией Швейцарии</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r12.png') }}" alt="Image 2">
                </div>
                <div class="divider"></div>
                <p>100 000 морских животных и 1 000 000 птиц погибают от пластика каждый год</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r13.png') }}" alt="Image 3">
                </div>
                <div class="divider"></div>
                <p>Ежедневно покупая любимые напитки в бумажных стаканчиках, один человек производит 10 кг мусора в год</p>
            </div>
        </div>
    </section>

    <div class="section-title">
        <p>Переработка мусора - это не только способ помочь природе, но и шанс создать что-то новое из того, что казалось ненужным</p>
    </div>

    <section class="latest-articles">
    <h2>Последние статьи</h2>
    <div class="articles-grid">
        @foreach ($latestArticles as $article)
            <div class="article-card">
                <div class="article-poster">
                    @if($article->hasMedia('posters'))
                        <img src="{{ $article->getFirstMediaUrl('posters') }}" alt="{{ $article->title }}">
                    @endif
                </div>
                <h3><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h3>
            </div>
      
       
        @endforeach
       
        <a href="{{ route('articles.index') }}" class="btn btn-primary">Все статьи</a>
    </section>

    <section class="recycling-benefits">
        <h2 class="section-title">Переработка мусора помогает сэкономить ресурсы</h2>
        <div class="cards-row">
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r21.png') }}" alt="Image 1">
                </div>
                <div class="divider"></div>
                <p>60 кг сданной на переработку макулатуры заменяют одно дерево</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r22.png') }}" alt="Image 2">
                </div>
                <div class="divider"></div>
                <p>Переработка 125 алюминиевых банок экономит достаточно энергии, чтобы питать 1 дом целый день</p>
            </div>
            <div class="info-card">
                <div class="card-image">
                    <img src="{{ asset('static/r23.png') }}" alt="Image 3">
                </div>
                <div class="divider"></div>
                <p>Энергии, которая тратится на производство одной бутылки достаточно для переработки 10 бутылок</p>
            </div>
        </div>
    </section>

    <section class="myths">
        <h2 class="section-title">Мифы о переработке мусора</h2>
        <div class="myths-grid">
            <div class="myth-card">
                <p>Переработать можно только мусор из одного материала</p>
            </div>
            <div class="myth-card">
                <p>Переработать мусор можно только один раз</p>
            </div>
            <div class="myth-card">
                <p>Переработка отходов требует больше энергии, чем производство нового продукта из первичного сырья</p>
            </div>
            <div class="myth-card">
                <p>Изделия из вторичного сырья — некачественные</p>
            </div>
            <div class="myth-card">
                <p>Раздельный сбор отходов не имеет смысла</p>
            </div>
            <div class="myth-card">
                <p>Переработка мусора в России неэффективна, и все вторсырье отправляется на свалки<    /p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-logo">EcoBin</div>
    </footer>
</body>
</html>