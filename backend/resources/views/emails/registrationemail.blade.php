<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'inscription</title>
</head>
<body>
    <h1>Confirmation d'inscription</h1>
    <p>Merci pour votre inscription ! Votre compte a été créé avec succès.</p>
    <p>Voici vos informations d'inscription :</p>
    <ul>
        <li><strong>Nom :</strong> {{ $user->name }}</li>
        <li><strong>Email :</strong> {{ $user->email }}</li>
    </ul>
    <p>Vous pouvez maintenant vous connecter en utilisant votre adresse e-mail et votre mot de passe.</p>
    <p>Cordialement,<br>L'équipe de notre site</p>
</body>
</html>
