<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="css/feuilleDeMatch.css">
</head>
<body>

<div class="container">
    <div class="left-panel">
        <h2>Joueurs actifs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille</th>
                    <th>Poids</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['Nom']) ?></td>
                    <td><?= htmlspecialchars($p['Prenom']) ?></td>
                    <td><?= htmlspecialchars($p['Taille_cm']) ?> cm</td>
                    <td><?= htmlspecialchars($p['Poids_kg']) ?> kg</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="right-panel">
    <h2>Feuille de match</h2>
    <form method="POST">
        
        <div class="court">
            <?php 
            // Map the codes used in your DB to the labels shown in the View
            $posMapping = [
                'PG' => 'Meneur (PG)', 
                'SG' => 'Arrière (SG)', 
                'SF' => 'Ailier (SF)', 
                'PF' => 'Ailier Fort (PF)', 
                'C'  => 'Pivot (C)'
            ];

            foreach($posMapping as $code => $posName): 
                // Get the saved Licence number for this specific position from the controller data
                $savedLicence = $currentSelection['titulars'][$code] ?? '';
            ?>
                <div class="position-group">
                    <label><strong><?= $posName ?></strong></label>
                    <select name="titular_<?= $code ?>" required>
                        <option value="">Choisir Joueur</option>
                        <?php foreach($players as $p): ?>
                            <option value="<?= $p['NumeroLicence'] ?>" 
                                <?= ($p['NumeroLicence'] == $savedLicence) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['Nom'].' '.$p['Prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>

        <hr>

        <h3>Remplaçants (Max 7)</h3>
        <div class="substitutes-grid">
            <?php for($i=0; $i < 7; $i++): 
                // Get saved substitute info for this row
                $savedSubLicence = $currentSelection['subs'][$i]['licence'] ?? '';
                $savedSubPos = $currentSelection['subs'][$i]['pos'] ?? '';
            ?>
                <div class="sub-entry" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <p>Remplaçant n°<?= $i + 1 ?></p>
                    
                    <select name="sub_target_pos[]">
                        <option value="">Position ?</option>
                        <?php foreach($posMapping as $code => $name): ?>
                            <option value="<?= $name ?>" <?= ($name == $savedSubPos) ? 'selected' : '' ?>>
                                <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="substitute_player[]">
                        <option value="">Choisir Joueur</option>
                        <?php foreach($players as $p): ?>
                            <option value="<?= $p['NumeroLicence'] ?>" 
                                <?= ($p['NumeroLicence'] == $savedSubLicence) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['Nom'].' '.$p['Prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endfor; ?>
        </div>

        <button type="submit" style="margin-top: 20px;">Enregistrer la feuille</button>
    </form>

    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    </div>
</div>

</body>
</html>