<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../css/feuilleDeMatch.css">
</head>
<body>

<div class="container">
    <!-- Liste des joueurs actifs -->
    <div class="left-panel">
        <h2>Joueurs actifs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['Nom']) ?></td>
                    <td><?= htmlspecialchars($p['Prenom']) ?></td>
                    <td><?= htmlspecialchars($p['Taille_cm']) ?> cm</td>
                    <td><?= htmlspecialchars($p['Poids_kg']) ?> kg</td>
                    <td><?= htmlspecialchars($p['Commentaire']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Right panel: court + selections -->
    <div class="right-panel">
    <h2>Feuille de match</h2>
    <form method="POST">
        
        <div class="court">
            <?php 
            $positions = ['Meneur (PG)', 'Arrière (SG)', 'Ailier (SF)', 'Ailier Fort (PF)', 'Pivot (C)'];
            foreach($positions as $index => $posName): 
            ?>
                <div class="position-group">
                    <label><strong><?= $posName ?></strong></label>
                    <select name="titular[]">
                        <option value="">Choisir Joueur</option>
                        <?php foreach($players as $p): ?>
                            <option value="<?= $p['NumeroLicence'] ?>"><?= $p['Nom'].' '.$p['Prenom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>

        <hr>

        <h3>Remplaçants</h3>
        <div class="substitutes-grid">
            <?php for($i=1; $i<=5; $i++): ?>
                <div class="sub-entry" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <p>Remplaçant n°<?= $i ?></p>
                    
                    <select name="sub_target_pos[]">
                        <option value="">Pour quelle position ?</option>
                        <?php foreach($positions as $posName): ?>
                            <option value="<?= $posName ?>"><?= $posName ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select name="substitute_player[]">
                        <option value="">Choisir Joueur</option>
                        <?php foreach($players as $p): ?>
                            <option value="<?= $p['NumeroLicence'] ?>"><?= $p['Nom'].' '.$p['Prenom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endfor; ?>
        </div>

        <button type="submit" style="margin-top: 20px;">Enregistrer la feuille</button>
    </form>
</div>

        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    </div>
</div>

</body>
</html>
