<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Dashboard</title>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
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
            margin: 0;
        }

        .nav {
            margin-top: 10px;
        }

        .nav a {
            color: #dcdcdc;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .nav a:hover {
            color: white;
            text-decoration: underline;
        }

        #newsTableContainer {
            margin: 20px auto;
            padding: 20px;
            max-width: 1200px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #343a40;
            font-weight: bold;
        }

        .news-image {
            max-width: 110px;
            height: auto;
            border-radius: 5px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            max-width: 300px;
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0;
        }
    </style>
</head>

<body>
    <header class="header">
        <h1>News Blog</h1>
    </header>

    <div id="newsTableContainer">
        <table id="callingData" class="display">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <!-- News items will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

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
                        let table = $("#callingData").DataTable();
                        table.clear();

                        let data = response.data.channel.item;
                        console.log(data);

                        data.forEach(item => {
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

                            table.row.add([
                                `<img src="${image}" alt="News Image" class="news-image">`,
                                item.title,
                                `<p>${description}</p>`,
                                author,
                                formattedDate,
                                `<a href="${item.link}" target="_blank">Read more</a>`
                            ]).draw(false);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching news data:', error);
                    }
                });
            }

            $('#callingData').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }]
            });

            fetchNewsData();
        });
    </script>

</body>

</html>
