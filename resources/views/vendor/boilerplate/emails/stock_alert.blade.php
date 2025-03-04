<!DOCTYPE html>
<html>
<head>
    <title>Alerte de Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .content {
            padding: 20px;
        }
        .alert {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Alerte de Stock</h2>
        </div>
        <div class="content">
            <div class="alert">
                <p><strong>Attention :</strong> Le niveau de stock d'une matière première est en dessous du seuil minimum.</p>
            </div>
            <p><strong>Matière première :</strong> {{ $nom }}</p>
            <p><strong>Quantité actuelle :</strong> {{ $quantite }} {{ $matiere->unite }}</p>
            <p><strong>Seuil minimum :</strong> {{ $stock_min }} {{ $matiere->unite }}</p>
            <p>Veuillez réapprovisionner cette matière première dès que possible.</p>
        </div>
        <div class="footer">
            <p>Ce message a été généré automatiquement par le système de gestion de stock PAP-FAMILY.</p>
        </div>
    </div>
</body>
</html>
