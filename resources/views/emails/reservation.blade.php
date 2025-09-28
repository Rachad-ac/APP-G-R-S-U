<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .card {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .card-header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .card-body {
            padding: 20px;
            color: #333333;
            font-size: 15px;
            line-height: 1.6;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            background: #6c757d;
            color: #ffffff;
            font-size: 13px;
        }
        .alert {
            margin-top: 20px;
            padding: 12px;
            background-color: #e9f2ff;
            border-left: 4px solid #0d6efd;
            color: #0d6efd;
            font-size: 14px;
        }
        .card-footer {
            padding: 12px;
            font-size: 12px;
            text-align: center;
            color: #777777;
            background: #f8f9fa;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="card">
        <div class="card-header">
            📌 Demande de Réservation
        </div>
        <div class="card-body">
            
            @if($reservation->user->id_role === 2)
                <p>
                    👨‍🎓 <strong>Étudiant :</strong> {{ $reservation->user->prenom }} {{ $reservation->user->nom }}
                </p>
            @else
                <p>
                    👨‍🏫 <strong>Enseignant :</strong> {{ $reservation->user->prenom }} {{ $reservation->user->nom }}
                </p>
            @endif

            <p>
                a fait une demande de réservation pour la salle  
                <span class="badge">{{ $reservation->salle->nom }}</span> 
                le <strong>{{ $reservation->date_reservation }}</strong> 
                de <strong>{{ $reservation->date_debut }}</strong> à <strong>{{ $reservation->date_fin }}</strong>.
            </p>

            <div class="alert">
                Connectez-vous au système pour <strong>valider</strong> ou <strong>refuser</strong> cette demande.
            </div>
        </div>
        <div class="card-footer">
            📧 Notification automatique – Merci de ne pas répondre à cet email
        </div>
    </div>

</body>
</html>
