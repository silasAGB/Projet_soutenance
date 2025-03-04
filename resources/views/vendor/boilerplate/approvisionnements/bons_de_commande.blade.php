<!DOCTYPE html>
<html>
<head>
    <title>Bons de Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
        }
        .company-info {
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 2px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    @foreach ($bonsDeCommande as $bon)
        <h1>Bon de Commande</h1>
        <div class="company-info">
            <p><strong>Nom de l'entreprise:</strong> PAP FAMILY</p>
            <p><strong>Numéro de téléphone:</strong> +229 01 123 456 79</p>
            <p><strong>Email:</strong> contact@papfamily.com</p>
            <p><strong>Adresse:</strong> 123 Rue .., Ville, Benin</p>
        </div>
        <h2>Fournisseur: {{ $bon['fournisseur']->nom_fournisseur }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Matière Première</th>
                    <th>Quantité</th>
                    <th>Montant (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMontant = 0;
                @endphp
                @foreach ($bon['matieres'] as $matiere)
                    <tr>
                        <td>{{ $matiere->nom_MP }}</td>
                        <td>{{ $matiere->pivot->qte_approvisionnement }} {{ $matiere->unite }}</td>
                        <td class="text-right">{{ number_format($matiere->pivot->montant, 2) }}</td>
                    </tr>
                    @php
                        $totalMontant += $matiere->pivot->montant;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <p class="total">Total: {{ number_format($totalMontant, 2) }} FCFA</p>
        <p><strong>Date limite de livraison : {{Carbon\Carbon::parse($bon['date_approvisionnement'])->format('d/m/Y')}} </p>
        <p class="footer">Date d'émission: {{ Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <div class="page-break"></div>
    @endforeach
</body>
</html>
