<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Blog</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5em;
            color: #2c3e50;
            margin: 0;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.2em;
            margin: 10px 0;
        }

        .nav {
            margin: 20px 0;
        }

        .nav-link {
            text-decoration: none;
            color: #2980b9;
            margin: 0 10px;
            transition: color 0.3s;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #1f618d;
        }

        .header-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .search-bar {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .sort-dropdown {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .news-item {
            background: #fff;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .news-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .news-image {
            margin: 10px;
            width: 100px;
            height: 100px;
            max-width: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .news-content {
            padding: 20px;
            flex: 1;
        }

        .news-title {
            color: #2c3e50;
            margin: 0;
            padding: 0;
            font-weight: 700;
        }

        .news-description {
            color: #7f8c8d;
            margin: 10px 0;
        }

        .news-author {
            color: #34495e;
            margin: 10px 0;
        }

        .news-meta {
            color: #95a5a6;
            font-size: 0.9em;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .news-link {
            display: inline-block;
            text-decoration: none;
            color: #2980b9;
            border: 1px solid #2980b9;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .news-link:hover {
            background: #2980b9;
            color: #fff;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>News Blog</h1>
        <p class="subtitle">Stay updated with the latest news</p>
        <nav class="nav">
            <a href="#home" class="nav-link">Home</a>
            <a href="#about" class="nav-link">About</a>
            <a href="#contact" class="nav-link">Contact</a>
        </nav>
        <div class="header-controls">
            <input type="text" placeholder="Search..." class="search-bar">
            <select class="sort-dropdown">
                <option value="latest">Sort by Latest</option>
                <option value="oldest">Sort by Oldest</option>
            </select>
        </div>
    </header>
    <div class="container" id="callingData">
        <!-- News items will be dynamically inserted here -->
    </div>

    <script>
        $(document).ready(function() {
            function strip_tags(input) {
                return input.replace(/<\/?[^>]+(>|$)/g, "");
            }

            function fetchNewsData() {
                $.ajax({
                    type: "GET",
                    url: "/get-data",
                    success: function(response) {
                        let newsContainer = $("#callingData");
                        newsContainer.empty();

                        let newsItems = response.data.channel.item;
                        newsItems.forEach(item => {
                            let author = item["dc:creator"] ? item["dc:creator"]["#text"] :
                                "Unknown";
                            let image = item.enclosure ? item.enclosure["@url"] :
                                "https://via.placeholder.com/150";
                            let pubDate = new Date(item.pubDate);
                            let formattedDate = pubDate.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric'
                            });

                            let description = item.description ? strip_tags(item.description) :
                                "No description available";

                            let newsHTML = `
                                <div class="news-item">
                                    <img src="${image}" alt="News Image" class="news-image">
                                    <div class="news-content">
                                        <h2 class="news-title">${item.title}</h2>
                                        <p class="news-description">${description}</p>
                                        <div class="news-meta">
                                            <div>
                                                <p class="news-author">By ${author}</p>
                                                <span class="news-date">${formattedDate}</span>
                                            </div>
                                            <a href="${item.link}" class="news-link" target="_blank">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            newsContainer.append(newsHTML);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching news data:', error);
                    }
                });
            }
            fetchNewsData();
        });
    </script>
</body>

</html>
